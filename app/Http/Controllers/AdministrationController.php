<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GenerateApiResponse;
use App\Models\Administration;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Inscription;
use App\Models\Classe;
use Exception;

class AdministrationController extends Controller
{
    use GenerateApiResponse;

    /**
     * Dashboard administrateur
     */
  public function dashboard(Request $request)
{
    $usersCount = User::count();
    $etudiantsCount = Etudiant::count();
    $inscriptionsCount = Inscription::where('statut', 'en_attente')->count();

    $recentActivities = collect([
        (object)[
            'icon' => 'user',
            'description' => 'Nouvel utilisateur créé',
            'created_at' => now()->subMinutes(5),
        ],
        (object)[
            'icon' => 'book',
            'description' => 'Nouvelle classe ajoutée',
            'created_at' => now()->subHours(1),
        ],
    ]);

    return view('administration.dashboard', compact(
        'usersCount',
        'etudiantsCount',
        'inscriptionsCount',
        'recentActivities'
    ));
}




    /**
     * Gestion des utilisateurs
     */
    public function utilisateurs()
{
    try {
        $users = User::with(['etudiant', 'administration', 'comptable'])->get();
        return view('administration.utilisateurs.index', compact('users'));
    } catch (Exception $e) {
        return $this->errorResponse('Erreur de récupération', 500, $e->getMessage());
    }
}


    /**
     * Validation des inscriptions
     */
    public function inscriptions(Request $request)
    {
        try {
            // Récupérer les paramètres de filtre
            $statut = $request->input('statut');
            $classeId = $request->input('classe_id');
            $anneeAcademique = $request->input('annee_academique');
            $search = $request->input('search');

            // Requête de base avec les relations
            $query = Inscription::with(['etudiant.personne', 'classe', 'administration.personne']);
            // Application des filtres
            if ($statut) {
                $query->where('statut', $statut);
            } else {
                $query->where('statut', 'en_attente');
            }

            if ($classeId) {
                $query->where('classe_id', $classeId);
            }

            if ($anneeAcademique) {
                $query->where('annee_academique', $anneeAcademique);
            }

            if ($search) {
                $query->whereHas('etudiant.personne', function($q) use ($search) {
                    $q->where('nom', 'like', "%$search%")
                      ->orWhere('prenom', 'like', "%$search%");
                });
            }

            // Récupération des données avec pagination
            $inscriptions = $query->latest()->paginate(10);

            // Récupération des données pour les filtres
            $classes = Classe::orderBy('libelle')->get();
            $anneesAcademiques = Inscription::select('annee_academique')
                ->distinct()
                ->orderBy('annee_academique', 'desc')
                ->pluck('annee_academique');

            // Calcul des statistiques
            $statistiques = [
                'total' => Inscription::count(),
                'validees' => Inscription::where('statut', 'valide')->count(),
                'en_attente' => Inscription::where('statut', 'en_attente')->count(),
                'rejetees' => Inscription::where('statut', 'rejeté')->count(),
            ];

            $statistiques['taux_validation'] = $statistiques['total'] > 0
                ? round(($statistiques['validees'] / $statistiques['total']) * 100, 2)
                : 0;

            // Pourcentage d'évolution (exemple: par rapport au mois précédent)
            $statistiques['evolution'] = 0; // À implémenter si nécessaire

            return view('administration.inscriptions.index', compact(
                'inscriptions',
                'statistiques',
                'classes',
                'anneesAcademiques',
                'statut',
                'classeId',
                'anneeAcademique',
                'search'
            ));

        } catch (Exception $e) {
            return $this->errorResponse('Erreur de récupération', 500, $e->getMessage());
        }
    }

    /**
     * Gestion des classes
     */
    public function classes()
    {
        try {
            $classes = Classe::all();
            return view('administration.classes.index', compact('classes'));
        } catch (Exception $e) {
            return $this->errorResponse('Erreur de récupération', 500, $e->getMessage());
        }
    }

public function createUtilisateur()
{
    // Affiche le formulaire pour créer un utilisateur
    return view('administration.utilisateurs.create');
}

public function createClasse()
{
    // Affiche le formulaire pour créer une classe
    return view('administration.classes.create');
}


 /**
     * Afficher le formulaire de création d'une nouvelle classe
     */
    public function createClass()
    {
        return view('administration.classes.create');
    }

    /**
     * Enregistrer une nouvelle classe
     */
    public function storeClass(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:100',
            'frais_inscription' => 'required|numeric|min:0',
            'frais_mensualite' => 'required|numeric|min:0',
            'frais_soutenance' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        Classe::create([
            'libelle' => $request->libelle,
            'frais_inscription' => $request->frais_inscription,
            'frais_mensualite' => $request->frais_mensualite,
            'frais_soutenance' => $request->frais_soutenance,
            'description' => $request->description
        ]);

        return redirect()->route('administration.classes.index')
                        ->with('success', 'Classe créée avec succès!');
    }

    /**
     * Afficher une classe spécifique
     */
    public function showClass(Classe $classe)
    {
        return view('administration.classes.show', compact('classe'));
    }

    /**
     * Afficher le formulaire d'édition d'une classe
     */
    public function editClass(Classe $classe)
    {
        return view('administration.classes.edit', compact('classe'));
    }

    /**
     * Mettre à jour une classe
     */
    public function updateClass(Request $request, Classe $classe)
    {
        $request->validate([
            'libelle' => 'required|string|max:100',
            'frais_inscription' => 'required|numeric|min:0',
            'frais_mensualite' => 'required|numeric|min:0',
            'frais_soutenance' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        $classe->update([
            'libelle' => $request->libelle,
            'frais_inscription' => $request->frais_inscription,
            'frais_mensualite' => $request->frais_mensualite,
            'frais_soutenance' => $request->frais_soutenance,
            'description' => $request->description
        ]);

        return redirect()->route('administration.classes.index')
                        ->with('success', 'Classe modifiée avec succès!');
    }

    /**
     * Supprimer une classe
     */
    public function destroyClass(Classe $classe)
    {
        // Vérifier si la classe a des inscriptions
        if ($classe->inscriptions()->count() > 0) {
            return redirect()->route('administration.classes.index')
                            ->with('error', 'Impossible de supprimer cette classe car elle contient des inscriptions.');
        }

        $classe->delete();

        return redirect()->route('administration.classes.index')
                        ->with('success', 'Classe supprimée avec succès!');
    }

    // ... (Méthodes API existantes: index, store, update, destroy, show, getformdetails)
}
