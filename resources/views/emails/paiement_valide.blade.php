<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement validé</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .highlight {
            background-color: #e7f3ff;
            padding: 15px;
            border-left: 4px solid #007bff;
            margin: 20px 0;
        }
        .details {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>✅ Paiement Validé</h1>
    </div>
    
    <div class="content">
        <p>Bonjour <strong>{{ $etudiantPrenom }} {{ $etudiantNom }}</strong>,</p>
        
        <div class="highlight">
            <p><strong>Excellente nouvelle !</strong> Votre paiement a été validé avec succès par notre service comptabilité.</p>
        </div>
        
        <div class="details">
            <h3>📋 Détails du paiement</h3>
            <ul>
                <li><strong>Montant :</strong> {{ $montant }} FCFA</li>
                <li><strong>Classe :</strong> {{ $classe }}</li>
                <li><strong>Date de validation :</strong> {{ $datePaiement }}</li>
                <li><strong>Référence :</strong> {{ $reference }}</li>
                <li><strong>Validé par :</strong> {{ $comptablePrenom }} {{ $comptableNom }}</li>
            </ul>
        </div>
        
        <p>Votre inscription est maintenant confirmée. Vous pouvez consulter votre reçu de paiement dans votre espace étudiant.</p>
        
        <p>Si vous avez des questions, n'hésitez pas à contacter notre service administratif.</p>
        
        <p>Cordialement,<br>
        <strong>L'équipe administrative</strong></p>
    </div>
    
    <div class="footer">
        <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
    </div>
</body>
</html>
