@component('mail::message')
# Bonjour {{ $inscription->etudiant->personne->prenom }},

Votre inscription pour l'année académique {{ $inscription->annee_academique }} a été **validée**.

Merci de procéder au paiement des frais d'inscription dès que possible.

@component('mail::button', ['url' => route('paiement.page', $inscription->id)])
Payer maintenant
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
