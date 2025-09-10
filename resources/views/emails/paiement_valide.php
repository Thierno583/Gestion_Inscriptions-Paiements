<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Paiement validé</title>
</head>
<body>
    <p>Bonjour {{ $etudiantNom }},</p>
    <p>Votre paiement de <strong>{{ $montant }} XOF</strong> pour l'inscription à la classe <strong>{{ $classe }}</strong> a été validé par le comptable le {{ $datePaiement }}.</p>
    <p>Merci pour votre règlement.</p>
</body>
</html>
