<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'description',
        'frais_inscription',
        'frais_mensualite',
        'frais_soutenance'
    ];

    protected $casts = [
        'frais_inscription' => 'integer',
        'frais_mensualite' => 'integer',
        'frais_soutenance' => 'integer',
    ];

    /**
     * Obtenir les inscriptions de cette classe
     */
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}
