<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\Administration;
use App\Models\Etudiant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class InscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $currentYear = Carbon::now()->year;

        return [
            'annee_academique' => $currentYear . '-' . ($currentYear + 1),
            'date_inscription' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'confirmation_envoyee' => $this->faker->boolean(70), // 70% de confirmation envoyée
        ];
    }

    /**
     * Configure la factory pour créer automatiquement les relations
     */
    public function configure()
    {
        return $this->afterMaking(function ($inscription) {
            if (!$inscription->etudiant) {
                $inscription->etudiant()->associate(Etudiant::factory()->create());
            }
            if (!$inscription->classe) {
                $inscription->classe()->associate(Classe::factory()->create());
            }
        });
    }

    /**
     * States personnalisés
     */
    public function confirmee()
    {
        return $this->state([
            'confirmation_envoyee' => true,
        ]);
    }

    public function nonConfirmee()
    {
        return $this->state([
            'confirmation_envoyee' => false,
        ]);
    }

    public function pourAnnee(string $annee)
    {
        return $this->state([
            'annee_academique' => $annee,
        ]);
    }

    public function avecAdministrateur()
    {
        return $this->afterMaking(function ($inscription) {
            $inscription->administration()->associate(Administration::factory()->create());
        });
    }

    public function forEtudiant(Etudiant $etudiant)
    {
        return $this->state([
            'etudiant_id' => $etudiant->id,
        ]);
    }

    public function forClasse(Classe $classe)
    {
        return $this->state([
            'classe_id' => $classe->id,
        ]);
    }
}
