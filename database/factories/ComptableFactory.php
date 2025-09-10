<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Personne;
class ComptableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // Aucun champ supplémentaire dans la table
        ];
    }

    /**
     * Configure la factory pour créer automatiquement une Personne associée
     */
    public function configure()
    {
        return $this->afterMaking(function ($comptable) {
            if (!$comptable->personne) {
                $comptable->personne()->associate(
                    Personne::factory()->create([
                        'nom_d_utilisateur' => 'comptable_' . $this->faker->unique()->userName,
                        'email' => $this->faker->unique()->safeEmail()
                    ])
                );
            }
        });
    }

    /**
     * States personnalisés
     */
    public function withPersonne(array $attributes = [])
    {
        return $this->state([
            'personne_id' => Personne::factory()->create($attributes)->id
        ]);
    }

    public function withExistingPersonne(Personne $personne)
    {
        return $this->state([
            'personne_id' => $personne->id
        ]);
    }

    public function withCredentials()
    {
        return $this->afterCreating(function ($comptable) {
            $comptable->personne->update([
                'nom_d_utilisateur' => 'comptable_' . $comptable->id,
                'email' => 'compta' . $comptable->id . '@ecole.edu'
            ]);
        });
    }

    public function withResponsabilites(array $responsabilites = [])
    {
        return $this->afterCreating(function ($comptable) use ($responsabilites) {
            $comptable->update([
                'responsabilites' => $responsabilites ?: [
                    'gestion_paiements',
                    'facturation',
                    'rapports_financiers'
                ]
            ]);
        });
    }
}
