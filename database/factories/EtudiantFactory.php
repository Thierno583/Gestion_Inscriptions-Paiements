<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Personne;
class EtudiantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'matricule' => 'ET-' . now()->format('Y') . '-' . $this->faker->unique()->numberBetween(1000, 9999),
            'accepte_email' => $this->faker->boolean(80), // 80% de chance d'accepter les emails
        ];
    }

    /**
     * Configure la factory pour créer automatiquement une Personne associée
     */
    public function configure()
    {
        return $this->afterMaking(function ($etudiant) {
            if (!$etudiant->personne) {
                $etudiant->personne()->associate(
                    Personne::factory()->create([
                        'nom_d_utilisateur' => 'etud_' . $this->faker->unique()->userName,
                        'email' => $this->faker->unique()->safeEmail()
                    ])
                );
            }
        });
    }

    /**
     * States personnalisés
     */
    public function accepteEmail()
    {
        return $this->state([
            'accepte_email' => true,
        ]);
    }

    public function refuseEmail()
    {
        return $this->state([
            'accepte_email' => false,
        ]);
    }

    public function withMatricule(string $matricule)
    {
        return $this->state([
            'matricule' => $matricule,
        ]);
    }

    public function forPersonne(Personne $personne)
    {
        return $this->state([
            'personne_id' => $personne->id,
        ]);
    }

    public function withPersonneData(array $attributes = [])
    {
        return $this->afterCreating(function ($etudiant) use ($attributes) {
            $etudiant->personne->update($attributes);
        });
    }
}
