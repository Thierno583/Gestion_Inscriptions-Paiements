<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'inscription_id', 'comptable_id',
        'date_paiement', 'montant', 'reference_transaction',
        'mode_paiement', 'statut'
    ];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }

    public function comptable()
    {
        return $this->belongsTo(Comptable::class);
    }

    public function etudiant()
    {
        return $this->hasOneThrough(Etudiant::class, Inscription::class, 'id', 'id', 'inscription_id', 'etudiant_id');
    }

    public function envoyer_validation_email()
    {
        // à implémenter : envoi d'email après validation du paiement
    }
}
