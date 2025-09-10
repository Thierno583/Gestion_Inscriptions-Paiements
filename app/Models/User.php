<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Personne;
use App\Models\Etudiant;
use App\Models\Administration;
use App\Models\Comptable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function personne()
    {
        return $this->hasOne(Personne::class, 'user_id', 'id');
    }

    // Dans User.php
public function etudiant()
{
    return $this->hasOneThrough(
        Etudiant::class,  // Modèle final
        Personne::class,  // Modèle intermédiaire
        'user_id',        // clé étrangère dans personnes (vers users.id)
        'personne_id',    // clé étrangère dans etudiants (vers personnes.id)
        'id',             // clé locale dans users
        'id'              // clé locale dans personnes
    );
}



     public function administration()
{
    return $this->hasOneThrough(
        Administration::class,  // modèle final
        Personne::class,        // modèle intermédiaire
        'user_id',              // clé étrangère sur Personne (relie User à Personne)
        'personne_id',          // clé étrangère sur Administration (relie Personne à Administration)
        'id',                   // clé locale sur User
        'id'                    // clé locale sur Personne
    );
}




    public function comptable()
    {
        return $this->hasOneThrough(
            Comptable::class,
            Personne::class,
            'user_id',
            'personne_id',
            'id',
            'id'
        );
    }
}
