<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Personne;
class AdministrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // La clé étrangère sera gérée automatiquement
        ];
    }

    /**
     * Configure the factory to always have une Personne associée
     */
    public function configure()
    {
        return $this->afterMaking(function ($admin) {
            if (!$admin->personne) {
                $admin->personne()->associate(Personne::factory()->create());
            }
        });
    }

    /**
     * States personnalisés
     */
    public function withPersonne(array $personneAttributes = [])
    {
        return $this->state([
            'personne_id' => Personne::factory()->create($personneAttributes)->id
        ]);
    }

    public function withExistingPersonne(Personne $personne)
    {
        return $this->state([
            'personne_id' => $personne->id
        ]);
    }

    public function asComptable()
    {
        return $this->afterCreating(function ($admin) {
            $admin->personne->update([
                'nom_d_utilisateur' => 'comptable_' . $admin->personne->id,
                'email' => 'comptable' . $admin->personne->id . '@ecole.edu'
            ]);
        });
    }

    public function asDirecteurEtudes()
    {
        return $this->afterCreating(function ($admin) {
            $admin->personne->update([
                'nom_d_utilisateur' => 'directeur_' . $admin->personne->id,
                'email' => 'directeur.etudes' . $admin->personne->id . '@ecole.edu'
            ]);
        });
    }
}
