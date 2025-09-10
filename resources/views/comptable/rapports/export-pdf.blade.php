<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport Financier - {{ ucfirst($periode) }} {{ $annee }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            background: #f8f9fa;
            padding: 10px;
            border-left: 4px solid #007bff;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .stat-item {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 15px;
            border: 1px solid #ddd;
        }
        
        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 11px;
            color: #666;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        .amount {
            text-align: right;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .type-frais-grid {
            display: table;
            width: 100%;
        }
        
        .type-frais-item {
            display: table-cell;
            width: 33.33%;
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rapport Financier</h1>
        <p>Période: {{ ucfirst($periode) }} 
            @if($periode == 'mois')
                {{ DateTime::createFromFormat('!m', $mois)->format('F') }}
            @endif
            {{ $annee }}
        </p>
        <p>Généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <!-- Statistiques Générales -->
    <div class="section">
        <div class="section-title">Statistiques Générales</div>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">{{ number_format($statistiques['revenus_totaux'], 0, ',', ' ') }} FCFA</div>
                <div class="stat-label">Revenus Totaux</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $statistiques['nombre_paiements_valides'] }}</div>
                <div class="stat-label">Paiements Validés</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $statistiques['taux_validation'] }}%</div>
                <div class="stat-label">Taux de Validation</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ number_format($statistiques['revenus_moyens_etudiant'], 0, ',', ' ') }} FCFA</div>
                <div class="stat-label">Revenu Moyen/Étudiant</div>
            </div>
        </div>
    </div>

    <!-- Analyse par Type de Frais -->
    <div class="section">
        <div class="section-title">Répartition par Type de Frais</div>
        <div class="type-frais-grid">
            <div class="type-frais-item">
                <strong>Frais d'Inscription</strong><br>
                {{ number_format($analyseTypeFrais['inscription']['montant'], 0, ',', ' ') }} FCFA<br>
                <small>({{ $analyseTypeFrais['inscription']['pourcentage'] }}%)</small>
            </div>
            <div class="type-frais-item">
                <strong>Frais de Mensualité</strong><br>
                {{ number_format($analyseTypeFrais['mensualite']['montant'], 0, ',', ' ') }} FCFA<br>
                <small>({{ $analyseTypeFrais['mensualite']['pourcentage'] }}%)</small>
            </div>
            <div class="type-frais-item">
                <strong>Frais de Soutenance</strong><br>
                {{ number_format($analyseTypeFrais['soutenance']['montant'], 0, ',', ' ') }} FCFA<br>
                <small>({{ $analyseTypeFrais['soutenance']['pourcentage'] }}%)</small>
            </div>
        </div>
    </div>

    <!-- Performance par Classe -->
    <div class="section">
        <div class="section-title">Performance par Classe</div>
        <table>
            <thead>
                <tr>
                    <th>Classe</th>
                    <th>Revenus</th>
                    <th>Nb Paiements</th>
                    <th>Nb Étudiants</th>
                    <th>Revenu Moyen/Étudiant</th>
                </tr>
            </thead>
            <tbody>
                @foreach($analyseClasses as $classe)
                <tr>
                    <td>{{ $classe['classe'] }}</td>
                    <td class="amount">{{ number_format($classe['revenus'], 0, ',', ' ') }} FCFA</td>
                    <td>{{ $classe['nombre_paiements'] }}</td>
                    <td>{{ $classe['nombre_etudiants'] }}</td>
                    <td class="amount">{{ number_format($classe['revenu_moyen_etudiant'], 0, ',', ' ') }} FCFA</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Analyse par Mode de Paiement -->
    <div class="section">
        <div class="section-title">Répartition par Mode de Paiement</div>
        <table>
            <thead>
                <tr>
                    <th>Mode de Paiement</th>
                    <th>Montant</th>
                    <th>Nombre</th>
                    <th>Pourcentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($analyseModePaiement as $mode)
                <tr>
                    <td>{{ $mode['mode'] }}</td>
                    <td class="amount">{{ number_format($mode['montant'], 0, ',', ' ') }} FCFA</td>
                    <td>{{ $mode['nombre'] }}</td>
                    <td>{{ $mode['pourcentage'] }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Système de Gestion des Inscriptions et Paiements - Rapport généré automatiquement</p>
    </div>
</body>
</html>
