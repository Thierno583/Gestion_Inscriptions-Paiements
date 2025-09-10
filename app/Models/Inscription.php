<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // en haut du fichier
class Inscription extends Model
{
    //
    use HasFactory; // dans la classe

    protected $fillable = [
        'etudiant_id', 'classe_id', 'administration_id',
        'annee_academique', 'date_inscription'
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function administration()
    {
        return $this->belongsTo(Administration::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    // méthode simulée depuis UML
    public function envoyer_confirmation_email()
    {
        // à implémenter : envoi d'email après inscription
    }

}
