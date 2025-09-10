<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Etudiant;
use App\Models\Administration;
use App\Models\Comptable;

class Personne extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'date_de_naissance',
        'adresse',
        'nom_d_utilisateur',
        'photo',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function etudiant()
    {
        return $this->hasOne(Etudiant::class, 'personne_id', 'id');
    }

    public function administration()
    {
        return $this->hasOne(Administration::class, 'personne_id', 'id');
    }

    public function comptable()
    {
        return $this->hasOne(Comptable::class, 'personne_id', 'id');
    }
}
