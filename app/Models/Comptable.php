<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Personne;
use App\Models\Paiement;

class Comptable extends Model
{
    use HasFactory;

    protected $fillable = [
        'personne_id',
        // ajoute d’autres champs spécifiques au comptable ici si besoin
    ];

    public function personne()
    {
        return $this->belongsTo(Personne::class, 'personne_id', 'id');
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}
