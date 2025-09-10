<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reçu de Paiement - {{ $paiement->reference_transaction }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        
        .header .subtitle {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .recu-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid #28a745;
        }
        
        .recu-info h2 {
            color: #28a745;
            margin: 0 0 10px 0;
            font-size: 18px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            font-weight: bold;
            padding: 8px 15px 8px 0;
            width: 30%;
            color: #555;
        }
        
        .info-value {
            display: table-cell;
            padding: 8px 0;
            color: #333;
        }
        
        .amount-section {
            background: #e8f5e8;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 25px 0;
            border: 2px solid #28a745;
        }
        
        .amount-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .amount-value {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            background: #007bff;
            color: white;
            padding: 10px 15px;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        
        .status-badge {
            background: #28a745;
            color: white;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }
        
        .reference-code {
            background: #e9ecef;
            padding: 8px 12px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            color: #495057;
            border: 1px solid #ced4da;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .validation-info {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
        }
        
        .validation-info h3 {
            color: #155724;
            margin: 0 0 10px 0;
            font-size: 14px;
        }
        
        .signature-section {
            margin-top: 40px;
            display: table;
            width: 100%;
        }
        
        .signature-box {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 20px;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 40px;
            padding-top: 5px;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REÇU DE PAIEMENT</h1>
        <div class="subtitle">Système de Gestion des Inscriptions et Paiements</div>
    </div>

    <div class="recu-info">
        <h2>✓ Paiement Validé</h2>
        <p>Ce reçu certifie que le paiement ci-dessous a été reçu et validé par notre administration.</p>
    </div>

    <!-- Informations du paiement -->
    <div class="section">
        <div class="section-title">Informations du Paiement</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Référence :</div>
                <div class="info-value">
                    <span class="reference-code">{{ $paiement->reference_transaction }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Date de paiement :</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Mode de paiement :</div>
                <div class="info-value">{{ ucfirst(str_replace('_', ' ', $paiement->mode_paiement)) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Type de frais :</div>
                <div class="info-value">{{ ucfirst($paiement->motif ?? 'N/A') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Statut :</div>
                <div class="info-value">
                    <span class="status-badge">{{ ucfirst($paiement->statut) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Montant -->
    <div class="amount-section">
        <div class="amount-label">Montant Payé</div>
        <div class="amount-value">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</div>
    </div>

    <!-- Informations étudiant -->
    <div class="section">
        <div class="section-title">Informations de l'Étudiant</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nom complet :</div>
                <div class="info-value">{{ $paiement->inscription->etudiant->personne->nom ?? 'N/A' }} {{ $paiement->inscription->etudiant->personne->prenom ?? '' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Matricule :</div>
                <div class="info-value">{{ $paiement->inscription->etudiant->matricule ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email :</div>
                <div class="info-value">{{ $paiement->inscription->etudiant->personne->user->email ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <!-- Informations inscription -->
    <div class="section">
        <div class="section-title">Informations de l'Inscription</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Classe :</div>
                <div class="info-value">{{ $paiement->inscription->classe->libelle ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Année académique :</div>
                <div class="info-value">{{ $paiement->inscription->annee_academique ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Date d'inscription :</div>
                <div class="info-value">{{ $paiement->inscription->date_inscription ? \Carbon\Carbon::parse($paiement->inscription->date_inscription)->format('d/m/Y') : 'N/A' }}</div>
            </div>
        </div>
    </div>

    @if($paiement->comptable)
    <!-- Informations de validation -->
    <div class="validation-info">
        <h3>Informations de Validation</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Validé par :</div>
                <div class="info-value">{{ $paiement->comptable->personne->nom ?? 'N/A' }} {{ $paiement->comptable->personne->prenom ?? '' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Date de validation :</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($paiement->updated_at)->format('d/m/Y à H:i') }}</div>
            </div>
        </div>
    </div>
    @endif

    <!-- Section signature -->
    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line">
                Signature de l'Étudiant
            </div>
        </div>
        <div class="signature-box">
            <div class="signature-line">
                Cachet de l'Administration
            </div>
        </div>
    </div>

    <div class="footer">
        <p><strong>Ce reçu est généré automatiquement et fait foi de paiement.</strong></p>
        <p>Généré le {{ now()->format('d/m/Y à H:i') }} - Système de Gestion des Inscriptions et Paiements</p>
        <p>Pour toute réclamation, veuillez contacter l'administration avec cette référence : {{ $paiement->reference_transaction }}</p>
    </div>
</body>
</html>
