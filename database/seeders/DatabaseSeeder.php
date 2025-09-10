<?php

namespace Database\Seeders;

use App\Models\{
    Administration,
    Classe,
    Comptable,
    Etudiant,
    Inscription,
    Paiement,
    Personne,
    User
};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Désactiver les contraintes FK temporairement
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Vider les tables dans l'ordre inverse des dépendances
        User::truncate();
        Paiement::truncate();
        Inscription::truncate();
        Etudiant::truncate();
        Comptable::truncate();
        Administration::truncate();
        Personne::truncate();
        Classe::truncate();

        // Réactiver les contraintes
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // 1. Création des utilisateurs admin
        User::firstOrCreate(
            ['email' => 'admin@ecole.edu'],
            [
                'name' => 'Admin System',
                'password' => Hash::make('password')
            ]
        );

        // 2. Création des classes avec libellés uniques
        $niveaux = ['Licence 1', 'Licence 2', 'Licence 3', 'Master 1', 'Master 2'];
        $groupes = ['A', 'B', 'C'];

        foreach ($niveaux as $niveau) {
            foreach ($groupes as $groupe) {
                Classe::firstOrCreate(
                    ['libelle' => "$niveau Groupe $groupe"],
                    ['description' => "Description pour $niveau Groupe $groupe"]
                );
            }
        }
        $classes = Classe::all();

        // 3. Création des personnes et étudiants
        $etudiants = Etudiant::factory()
            ->count(30)
            ->has(Personne::factory())
            ->create();

        // 4. Création admin et comptable
        $adminPersonne = Personne::firstOrCreate(
            ['email' => 'admin@ecole.edu'],
            [
                'nom' => 'Admin',
                'prenom' => 'Ecole',
                'nom_d_utilisateur' => 'admin.ecole'
            ]
        );
        $admin = Administration::firstOrCreate(['personne_id' => $adminPersonne->id]);

        $comptablePersonne = Personne::firstOrCreate(
            ['email' => 'comptable@ecole.edu'],
            [
                'nom' => 'Comptable',
                'prenom' => 'Ecole',
                'nom_d_utilisateur' => 'comptable.ecole'
            ]
        );
        $comptable = Comptable::firstOrCreate(['personne_id' => $comptablePersonne->id]);

        // 5. Création des inscriptions
        $inscriptions = Inscription::factory()
            ->count(40)
            ->sequence(fn () => [
                'etudiant_id' => $etudiants->random()->id,
                'classe_id' => $classes->random()->id,
                'administration_id' => $admin->id
            ])
            ->create();

        // 6. Création des paiements
        Paiement::factory()
            ->count(60)
            ->sequence(fn () => [
                'inscription_id' => $inscriptions->random()->id,
                'comptable_id' => $comptable->id,
                'statut' => fake()->randomElement(['valide', 'en_attente', 'rejete'])
            ])
            ->create();

        // 7. Compte de test
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password')
            ]
        );
    }
}
