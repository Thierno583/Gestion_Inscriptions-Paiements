<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GenerateApiResponse;
use App\Models\Personne;

use Exception;


class PersonneController extends Controller
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
            $data = Personne::all();
            return $this->successResponse($data, 'Récupération réussie');
        } catch (Exception $e) {
            return $this->errorResponse('Récupération échouée', 500, $e->getMessage());
        }
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $personne = new Personne();
            $personne->nom = $request->nom;
            $personne->prenom = $request->prenom;
            $personne->email = $request->email;
            $personne->telephone = $request->telephone;
            $personne->date_de_naissance = $request->date_de_naissance;
            $personne->adresse = $request->adresse;
            $personne->nom_d_utilisateur = $request->nom_d_utilisateur;
            $personne->photo = $request->photo;
            $personne->save();
                return $this->successResponse($personne, 'Récupération réussie');

        } catch (Exception $e) {
            return $this->errorResponse('Insertion échouée', 500, $e->getMessage());
        }
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
        try {
            $personne = Personne::findOrFail($id);
            $personne->nom = $request->nom;
            $personne->prenom = $request->prenom;
            $personne->email = $request->email;
            $personne->telephone = $request->telephone;
            $personne->date_de_naissance = $request->date_de_naissance;
            $personne->adresse = $request->adresse;
            $personne->nom_d_utilisateur = $request->nom_d_utilisateur;
            $personne->photo = $request->photo;
            $personne->save();
                return $this->successResponse($personne, 'Mise à jour réussie');
        } catch (Exception $e) {
            return $this->errorResponse('Mise à jour échouée', 500, $e->getMessage());
        }
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
            $personne = Personne::findOrFail($id);
            $personne->delete();
                return $this->successResponse($personne, 'Suppression réussie');
        } catch (Exception $e) {
            return $this->errorResponse('Suppression échouée', 500, $e->getMessage());
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
            $personne = Personne::findOrFail($id);
             return $this->successResponse($personne, 'Ressource trouvée');
        } catch (Exception $e) {
            return $this->errorResponse('Ressource non trouvée', 404, $e->getMessage());
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