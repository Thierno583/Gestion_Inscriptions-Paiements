<x-mail::message>
# Bonjour {{ $inscription->etudiant->personne->prenom }},

Votre inscription pour l'année académique **{{ $inscription->annee_academique }}** a été **validée** ✅.

Veuillez procéder au paiement des frais d'inscription en cliquant sur le bouton ci-dessous :

<x-mail::button :url="route('paiement.page', $inscription->id)">
Payer maintenant
</x-mail::button>

Si vous avez déjà payé, merci d’ignorer ce message.

Cordialement,
{{ config('app.name') }}
</x-mail::message>
