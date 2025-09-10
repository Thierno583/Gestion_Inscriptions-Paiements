<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GenerateApiResponse;
use App\Models\Classe;

use Exception;


class ClasseController extends Controller
{
    use GenerateApiResponse;

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
{
    try {
        // Charger classes avec inscriptions pour la vue
        $classes = Classe::with('inscriptions')->get();
        return view('administration.classes.index', compact('classes'));
    } catch (Exception $e) {
        // En cas d’erreur, tu peux afficher une page d’erreur ou rediriger
        return redirect()->back()->withErrors(['error' => 'Récupération échouée : ' . $e->getMessage()]);
    }
}



    public function create()
    {
        return view('administration.classes.create');
    }

    // Enregistrer la nouvelle classe
    public function store(Request $request)
{
    // Validation avec les nouveaux champs
    $validated = $request->validate([
        'libelle' => 'required|string|max:255',
        'description' => 'nullable|string',
        'frais_inscription' => 'nullable|numeric|min:0',
        'frais_mensualite' => 'nullable|numeric|min:0',
        'frais_soutenance' => 'nullable|numeric|min:0',
    ]);

    // Création de la classe avec tous les champs validés
    Classe::create($validated);

    // Redirection vers la page de création avec message de succès
    return redirect()->route('administration.classes.create')->with('success', 'Classe créée avec succès !');
}

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
    public function store(Request $request)
{
    $validated = $request->validate([
        'libelle' => 'required|string|max:255',
        'description' => 'nullable|string',
        'frais_inscription' => 'nullable|numeric|min:0',
        'frais_mensualite' => 'nullable|numeric|min:0',
        'frais_soutenance' => 'nullable|numeric|min:0',
    ]);

    Classe::create([
        'libelle' => $validated['libelle'],
        'description' => $validated['description'] ?? null,
        'frais_inscription' => $validated['frais_inscription'] ?? 0,
        'frais_mensualite' => $validated['frais_mensualite'] ?? 0,
        'frais_soutenance' => $validated['frais_soutenance'] ?? 0,
    ]);

    return redirect()->route('administration.classes.index')->with('success', 'Classe créée avec succès.');
}

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'libelle' => 'required|string|max:255',
        'description' => 'nullable|string',
        'frais_inscription' => 'nullable|numeric|min:0',
        'frais_mensualite' => 'nullable|numeric|min:0',
        'frais_soutenance' => 'nullable|numeric|min:0',
    ]);

    $classe = Classe::findOrFail($id);
    $classe->update($validated);

    return redirect()->route('administration.classes.index')->with('success', 'Classe mise à jour avec succès.');
}


public function edit(Classe $class)
    {
        return view('administration.classes.edit', ['classe' => $class]);
    }




        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
{
    try {
        $classe = Classe::findOrFail($id);
        $classe->delete();
        return redirect()->route('administration.classes.index')->with('success', 'Classe supprimée avec succès.');
    } catch (Exception $e) {
        return redirect()->route('administration.classes.index')->withErrors('Erreur lors de la suppression : ' . $e->getMessage());
    }
}


        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
{
    try {
        $classe = Classe::findOrFail($id);
        // Affiche une vue avec les données de la classe
        return view('administration.classes.show', compact('classe'));
    } catch (Exception $e) {
        // Par exemple rediriger avec un message d'erreur
        return redirect()->route('administration.classes.index')
                         ->withErrors('Classe non trouvée');
    }
}


        /**
     * Get related form details for foreign keys.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getformdetails()
    {
        try {

            return $this->successResponse([

            ], 'Données du formulaire récupérées avec succès');
        } catch (Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des données du formulaire', 500, $e->getMessage());
        }
    }


}
