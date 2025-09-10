<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Paiement;

class PaiementValideMail extends Mailable
{
    use Queueable, SerializesModels;

    public $paiement;

    public function __construct(Paiement $paiement)
    {
        $this->paiement = $paiement;
    }

    public function build()
    {
        // Charger les relations nécessaires
        $this->paiement->load([
            'inscription.etudiant.personne',
            'inscription.classe',
            'comptable.personne'
        ]);

        return $this->subject('Paiement validé avec succès')
                    ->view('emails.paiement_valide')
                    ->with([
                        'etudiantNom' => $this->paiement->inscription->etudiant->personne->nom ?? 'Étudiant',
                        'etudiantPrenom' => $this->paiement->inscription->etudiant->personne->prenom ?? '',
                        'montant' => number_format($this->paiement->montant, 0, ',', ' '),
                        'classe' => $this->paiement->inscription->classe->libelle ?? 'Classe inconnue',
                        'datePaiement' => $this->paiement->date_validation ? \Carbon\Carbon::parse($this->paiement->date_validation)->format('d/m/Y') : now()->format('d/m/Y'),
                        'comptableNom' => $this->paiement->comptable->personne->nom ?? 'Comptable',
                        'comptablePrenom' => $this->paiement->comptable->personne->prenom ?? '',
                        'reference' => $this->paiement->reference_transaction ?? 'N/A',
                    ]);
    }
}
