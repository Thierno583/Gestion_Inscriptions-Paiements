<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Personne;
use App\Models\Inscription;

class Administration extends Model
{
    use HasFactory;

    protected $fillable = [
        'personne_id',
        // ajoute ici d'autres champs propres à l'administration si besoin
    ];

    public function personne()
    {
        return $this->belongsTo(Personne::class, 'personne_id', 'id');
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function user()
{
    return $this->belongsTo(User::class);
    // Ou pour une relation polymorphique :
    // return $this->morphOne(Personne::class, 'personne');
}
}
