<?php

namespace Database\Factories;

use App\Models\Inscription;
use App\Models\Administration;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaiementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date_paiement' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'montant' => $this->faker->randomFloat(2, 50000, 400000), // Montant entre 50,000 et 300,000
            'reference_transaction' => 'PAY-' . $this->faker->unique()->bothify('????##-####'),
            'mode_paiement' => $this->faker->randomElement(['espece', 'virement', 'wave', 'orange_money']),
            'statut' => 'en_attente',
            'validation_email_envoye' => false,
        ];
    }

    /**
     * Configure la factory pour créer automatiquement les relations
     */
    public function configure()
    {
        return $this->afterMaking(function ($paiement) {
            if (!$paiement->inscription) {
                $paiement->inscription()->associate(Inscription::factory()->create());
            }
        });
    }

    /**
     * States personnalisés
     */
    public function valide()
    {
        return $this->state([
            'statut' => 'valide',
            'validation_email_envoye' => true,
        ]);
    }

    public function rejete()
    {
        return $this->state([
            'statut' => 'rejete',
            'validation_email_envoye' => true,
        ]);
    }

    public function avecComptable()
    {
        return $this->afterMaking(function ($paiement) {
            $paiement->comptable()->associate(
                Administration::factory()->create([
                    'role' => 'comptable'
                ])
            );
        });
    }

    public function forInscription(Inscription $inscription)
    {
        return $this->state([
            'inscription_id' => $inscription->id,
        ]);
    }

    public function parOrangeMoney()
    {
        return $this->state([
            'mode_paiement' => 'orange_money',
        ]);
    }

    public function avecReference(string $reference)
    {
        return $this->state([
            'reference_transaction' => $reference,
        ]);
    }
}
