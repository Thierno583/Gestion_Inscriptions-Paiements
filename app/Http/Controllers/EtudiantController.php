<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\GenerateApiResponse;
use App\Models\Etudiant;
use App\Models\Classe;
use Exception;
use Illuminate\Support\Facades\Hash;

class EtudiantController extends Controller
{
    use GenerateApiResponse;

    public function dashboard(Request $request)
    {
        try {
            $user = $request->user();
            $data = [
                'inscriptions' => $user->etudiant->inscriptions,
                'paiements' => $user->etudiant->paiements
            ];
            return view('etudiant.dashboard', $data);
        } catch (Exception $e) {
            return $this->errorResponse('Erreur du dashboard', 500, $e->getMessage());
        }
    }

   public function inscriptions(Request $request)
{
    try {
        $user = $request->user();
        $etudiant = $user->etudiant;

        $inscriptions = $etudiant->inscriptions()->with('classe')->orderBy('created_at', 'desc')->get();

        // Variable d'autorisation à false par défaut si non définie dans le modèle
        $autoriseNouvelleInscription = $etudiant->autorise_nouvelle_inscription ?? false;

        // Trouver id de la dernière classe validée
        $lastClasseId = $inscriptions->where('statut', 'validée')->max('classe_id') ?? 0;

        // Sélectionner les classes dont l'id est > lastClasseId
        $classesDisponibles = \App\Models\Classe::where('id', '>', $lastClasseId)->get();

        return view('etudiant.inscription', [
            'inscriptions' => $inscriptions,
            'autoriseNouvelleInscription' => $autoriseNouvelleInscription,
            'classesDisponibles' => $classesDisponibles,
        ]);
    } catch (Exception $e) {
        return $this->errorResponse('Erreur de récupération', 500, $e->getMessage());
    }
}


   public function paiements(Request $request)
{
    try {
        $user = $request->user();

        // Récupérer l'étudiant via la relation personne → etudiant
        $etudiant = $user->personne?->etudiant;

        if (!$etudiant) {
            throw new \Exception("Aucun profil étudiant associé à cet utilisateur.");
        }

        // Historique des paiements (toujours visibles)
        $paiements = $etudiant
            ->paiements()
            ->with('inscription.classe')
            ->latest()
            ->get();

        // Récupérer TOUTES les inscriptions validées (avec les deux statuts possibles)
        $inscriptions = $etudiant
            ->inscriptions()
            ->with('classe')
            ->whereIn('statut', ['valide', 'validée']) // Accepter les deux statuts
            ->get();

        // Préparer les frais par classe
        $fraisParClasse = [];
        foreach ($inscriptions as $inscription) {
            $classe = $inscription->classe;
            if ($classe) {
                $fraisParClasse[$classe->id] = [
                    'inscription' => $classe->frais_inscription ?? 0,
                    'mensualite'  => $classe->frais_mensualite ?? 0,
                    'soutenance'  => $classe->frais_soutenance ?? 0,
                ];
            }
        }

        // Vérifier s'il y a au moins une inscription validée
        $aUneInscriptionValidee = $inscriptions->isNotEmpty();

        return view('etudiant.paiement', [
            'paiements'              => $paiements,
            'inscriptions'           => $inscriptions,
            'fraisParClasse'         => $fraisParClasse,
            'aUneInscriptionValidee' => $aUneInscriptionValidee,
        ]);

    } catch (\Exception $e) {
        return $this->errorResponse(
            'Erreur de récupération',
            500,
            $e->getMessage()
        );
    }
}



    // ... méthodes API

    public function index()
    {
        $etudiant = Auth::user()->etudiant;
        $inscriptions = $etudiant->inscriptions()->with('classe')->orderBy('created_at', 'desc')->get();

        $autoriseNouvelleInscription = $etudiant->autorise_nouvelle_inscription;

        $lastClasseId = $inscriptions->where('statut', 'validée')->max('classe_id');
        $classesDisponibles = Classe::where('id', '>', $lastClasseId)->get();

        return view('etudiants.inscriptions', compact('inscriptions', 'autoriseNouvelleInscription', 'classesDisponibles'));
    }


    public function editProfil()
    {
        $user = Auth::user(); // étudiant connecté
        return view('etudiant.profil.edit', compact('user'));
    }

    public function updateProfil(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|confirmed|min:6',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save(); // Plus de soulignement rouge

    return redirect()->route('etudiant.profil.edit')->with('success', 'Profil mis à jour avec succès !');
}

}
