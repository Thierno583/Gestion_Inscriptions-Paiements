<?php

namespace App\Mail;

use App\Models\Inscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaiementInscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inscription;

    /**
     * Crée une nouvelle instance du Mailable
     */
    public function __construct(Inscription $inscription)
    {
        $this->inscription = $inscription;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Paiement de votre inscription')
            ->markdown('emails.paiement.inscription');
    }
}
