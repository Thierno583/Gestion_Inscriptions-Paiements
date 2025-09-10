<?php

namespace Database\Factories;

use App\Models\Classe;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClasseFactory extends Factory
{
    protected $model = Classe::class;

    // Liste de tous les libellés possibles pour éviter les doublons
    private static $allLibelles = [];
    private static $usedLibelles = [];

    public function definition()
    {
        return [
            'libelle' => $this->generateUniqueLibelle(),
            'description' => $this->faker->optional(70)->paragraph(),
        ];
    }

    protected function generateUniqueLibelle(): string
    {
        // Génère toutes les combinaisons possibles une seule fois
        if (empty(self::$allLibelles)) {
            $niveaux = ['Licence 1', 'Licence 2', 'Licence 3', 'Master 1', 'Master 2'];
            $groupes = ['A', 'B', 'C'];

            foreach ($niveaux as $niveau) {
                foreach ($groupes as $groupe) {
                    self::$allLibelles[] = "$niveau Groupe $groupe";
                }
            }
            shuffle(self::$allLibelles); // Mélange pour varier l'ordre
        }

        // Prend le prochain libellé disponible
        if (!empty(self::$allLibelles)) {
            $libelle = array_pop(self::$allLibelles);
            self::$usedLibelles[] = $libelle;
            return $libelle;
        }

        // Solution de secours si on a épuisé toutes les combinaisons
        return 'Classe Spéciale ' . uniqid();
    }

    // States personnalisés (version sécurisée)
    public function licence1()
    {
        return $this->state(function (array $attributes) {
            return [
                'libelle' => $this->getUniqueStateLibelle('Licence 1', ['A', 'B', 'C'])
            ];
        });
    }

    public function licence2()
    {
        return $this->state(function (array $attributes) {
            return [
                'libelle' => $this->getUniqueStateLibelle('Licence 2', ['A', 'B', 'C'])
            ];
        });
    }

    public function master1()
    {
        return $this->state(function (array $attributes) {
            return [
                'libelle' => $this->getUniqueStateLibelle('Master 1', ['A', 'B'])
            ];
        });
    }

    protected function getUniqueStateLibelle(string $niveau, array $groupes): string
    {
        do {
            $libelle = "$niveau Groupe " . $this->faker->randomElement($groupes);
        } while (in_array($libelle, self::$usedLibelles));

        self::$usedLibelles[] = $libelle;
        return $libelle;
    }

    public function avecDescription()
    {
        return $this->state([
            'description' => $this->faker->paragraph()
        ]);
    }

    public function sansDescription()
    {
        return $this->state([
            'description' => null
        ]);
    }
}
