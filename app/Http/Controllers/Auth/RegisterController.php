<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Administrateur;
use App\Models\Comptable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'account_type' => ['required', 'in:etudiant,admin,comptable'],
            'telephone' => ['required', 'string', 'max:20'],
            'date_de_naissance' => ['required', 'date'],
            'adresse' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'], // 2MB max
            'accepte_email' => ['nullable', 'boolean'], // Uniquement pour les étudiants
        ]);

        // Création de l'utilisateur de base
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'telephone' => $validatedData['telephone'],
            'date_de_naissance' => $validatedData['date_de_naissance'],
            'adresse' => $validatedData['adresse'],
            'nom_utilisateur' => $this->generateUsername($validatedData['name']),
        ]);

        // Création de l'entité spécifique selon le type de compte
        switch ($validatedData['account_type']) {
            case 'etudiant':
                $user->etudiant()->create([
                    'matricule' => 'ETD' . now()->format('YmdHis'),
                    'accepte_email' => $validatedData['accepte_email'] ?? false
                ]);
                break;

            case 'admin':
                $user->administrateur()->create([
                    'numero_identification' => 'ADM' . now()->format('YmdHis'),
                    'est_super_admin' => false
                ]);
                break;

            case 'comptable':
                $user->comptable()->create([
                    'numero_agrement' => 'CMP' . now()->format('YmdHis'),
                    'date_embauche' => now(),
                    'est_actif' => true
                ]);
                break;
        }

        // Gestion de la photo de profil si fournie
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('public/photos');
            $user->update(['photo' => str_replace('public/', '', $path)]);
        }

        Auth::login($user);

        return redirect()
            ->route($validatedData['account_type'] . '.dashboard')
            ->with('success', 'Inscription réussie ! Bienvenue sur votre tableau de bord.');
    }

    /**
     * Génère un nom d'utilisateur unique
     */
    protected function generateUsername(string $name): string
    {
        $username = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $name));
        $originalUsername = $username;
        $counter = 1;

        while (User::where('nom_utilisateur', $username)->exists()) {
            $username = $originalUsername . $counter;
            $counter++;
        }

        return $username;
    }
}
