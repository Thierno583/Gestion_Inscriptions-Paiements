<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu Paiement #{{ $paiement->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .recu-container { max-width: 600px; margin: auto; border: 1px solid #ccc; padding: 20px; }
        h2 { text-align: center; color: #2c3e50; }
        .info { margin-bottom: 15px; }
        .info strong { display: inline-block; width: 150px; }
        .amount { font-size: 1.2em; font-weight: bold; color: #27ae60; }
        .footer { text-align: center; margin-top: 30px; font-size: 0.9em; color: #555; }
        @media print {
            button { display: none; }
        }
    </style>
</head>
<body>
    <div class="recu-container">
        <h2>Reçu de Paiement</h2>

        <div class="info">
            <strong>Référence :</strong> {{ $paiement->reference_transaction }}
        </div>

        <div class="info">
            <strong>Date :</strong> {{ $paiement->created_at->format('d/m/Y H:i') }}
        </div>

        <div class="info">
            <strong>Étudiant :</strong> {{ $paiement->inscription->etudiant->personne->nom ?? '' }} {{ $paiement->inscription->etudiant->personne->prenom ?? '' }}
        </div>

        <div class="info">
            <strong>Classe :</strong> {{ $paiement->inscription->classe->libelle ?? '' }}
        </div>

        <div class="info">
            <strong>Montant :</strong> <span class="amount">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</span>
        </div>

        <div class="info">
            <strong>Mode de paiement :</strong> {{ ucfirst(str_replace('_', ' ', $paiement->mode_paiement)) }}
        </div>

        <div class="info">
            <strong>Validé par :</strong> {{ $paiement->comptable->personne->nom ?? '-' }}
        </div>

        <div class="footer">
            Merci pour votre paiement.<br>
            Généré automatiquement le {{ now()->format('d/m/Y H:i') }}
        </div>

        <div style="text-align:center; margin-top:20px;">
            <button onclick="window.print()">Imprimer le reçu</button>
        </div>
    </div>
</body>
</html>
