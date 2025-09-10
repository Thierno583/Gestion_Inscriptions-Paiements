<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Traits\GenerateApiResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Paiement;
use App\Models\User; // Import du modèle User
use Illuminate\Support\Facades\Mail;
use App\Mail\PaiementValideMail;
use Exception;

class ComptableController extends Controller
{
    use GenerateApiResponse;

    public function dashboard()
    {
        try {
            $paiementsEnAttente = Paiement::where('statut', 'en_attente')->count();
            $paiementsValides   = Paiement::where('statut', 'validé')->count();
            $paiementsRejetes   = Paiement::where('statut', 'rejeté')->count();
            $montantTotal       = Paiement::where('statut', 'validé')->sum('montant');
            $montantCeMois      = Paiement::where('statut', 'validé')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('montant');

            $paiementsRecents = Paiement::with(['etudiant.personne', 'inscription.classe'])
                ->where('statut', 'en_attente')
                ->latest()
                ->limit(5)
                ->get();

            return view('comptable.dashboard', compact(
                'paiementsEnAttente',
                'paiementsValides',
                'paiementsRejetes',
                'montantTotal',
                'montantCeMois',
                'paiementsRecents'
            ));
        } catch (Exception $e) {
            return $this->errorResponse('Erreur du dashboard', 500, $e->getMessage());
        }
    }

    public function paiements()
    {
        try {
            $paiements = Paiement::with(['etudiant.personne', 'inscription.classe'])
                ->where('statut', 'en_attente')
                ->latest()
                ->get();
            return view('comptable.paiements.index', compact('paiements'));
        } catch (Exception $e) {
            return $this->errorResponse('Erreur de récupération', 500, $e->getMessage());
        }
    }

    public function historique()
    {
        try {
            $paiements = Paiement::with(['etudiant.personne', 'inscription.classe', 'comptable.personne'])
                ->latest()
                ->get();
            return view('comptable.historique.index', compact('paiements'));
        } catch (Exception $e) {
            return $this->errorResponse('Erreur de récupération', 500, $e->getMessage());
        }
    }

    public function validerPaiement(Request $request, Paiement $paiement)
{
    try {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            throw new Exception("Utilisateur non authentifié");
        }

        // Vérification simple du rôle
        if ($user->role !== 'comptable') {
            throw new Exception("Accès réservé aux comptables");
        }

        // Récupérer l'ID du comptable via la relation
        $user->load(['personne.comptable']);
        $comptableId = $user->personne?->comptable?->id ?? null;

        $paiement->update([
            'statut'                 => 'validé',
            'comptable_id'           => $comptableId,
            'date_validation'        => now(),
            'commentaire_validation' => $request->input('commentaire', '')
        ]);

        // Envoyer l'email de validation à l'étudiant
        $paiement->load('inscription.etudiant.personne.user');
        $etudiantUser = $paiement->inscription?->etudiant?->personne?->user;

        $emailSent = false;
        try {
            if ($etudiantUser && $etudiantUser->email) {
                Mail::to($etudiantUser->email)->send(new PaiementValideMail($paiement));
                $emailSent = true;
            }
        } catch (Exception $emailException) {
            // Log l'erreur mais continue la validation
            Log::error('Erreur envoi email validation paiement: ' . $emailException->getMessage());
            $emailSent = false;
        }

        return redirect()->route('comptable.dashboard')
            ->with('success', 'Paiement validé avec succès.' . ($emailSent ? ' Email envoyé à l\'étudiant.' : ' (Erreur envoi email - vérifier configuration SMTP)'))
            ->with('recu_url', route('paiements.recu', $paiement));

    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la validation: ' . $e->getMessage()
        ], 500);
    }
}


    public function rejeterPaiement(Request $request, Paiement $paiement)
    {
        try {
            /** @var User $user */
            $user = Auth::user();

            if (!$user?->comptable) {
                throw new Exception("Accès réservé aux comptables");
            }

            $paiement->update([
                'statut'                => 'rejeté',
                'comptable_id'          => $user->comptable->id,
                'date_validation'       => now(),
                'commentaire_validation'=> $request->commentaire ?? 'Paiement rejeté'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Paiement rejeté avec succès'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du rejet: ' . $e->getMessage()
            ], 500);
        }
    }
}
