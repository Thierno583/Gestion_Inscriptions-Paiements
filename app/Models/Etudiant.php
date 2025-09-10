<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Personne;
use App\Models\Inscription;
use App\Models\Paiement;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'personne_id',
        'matricule',
        'accepte_email',
        // autres champs si besoin
    ];

    public function personne()
    {
        return $this->belongsTo(Personne::class, 'personne_id', 'id');
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class, 'etudiant_id', 'id');
    }

    /**
     * Relation via hasManyThrough : tous les paiements de toutes les inscriptions de l'étudiant
     */
    public function paiements()
    {
        return $this->hasManyThrough(
            Paiement::class,
            Inscription::class,
            'etudiant_id',    // clé étrangère dans inscriptions vers etudiants
            'inscription_id', // clé étrangère dans paiements vers inscriptions
            'id',             // clé locale dans etudiants
            'id'              // clé locale dans inscriptions
        );
    }
}
