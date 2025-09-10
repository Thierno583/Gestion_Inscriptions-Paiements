@extends('layouts.app')

@section('title', 'Rapports Financiers')

@section('content')
<div class="page-header">
    <h1>Rapports Financiers</h1>
    <div class="header-actions">
        <form method="GET" class="filter-form">
            <select name="periode" onchange="this.form.submit()">
                <option value="mois" {{ $periode == 'mois' ? 'selected' : '' }}>Ce mois</option>
                <option value="trimestre" {{ $periode == 'trimestre' ? 'selected' : '' }}>Ce trimestre</option>
                <option value="annee" {{ $periode == 'annee' ? 'selected' : '' }}>Cette année</option>
            </select>
            
            @if($periode == 'mois' || $periode == 'trimestre')
            <select name="mois" onchange="this.form.submit()">
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $mois == $i ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                    </option>
                @endfor
            </select>
            @endif
            
            <select name="annee" onchange="this.form.submit()">
                @for($i = now()->year; $i >= now()->year - 5; $i--)
                    <option value="{{ $i }}" {{ $annee == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
            
            <input type="hidden" name="periode" value="{{ $periode }}">
        </form>
        
        <a href="{{ route('comptable.rapports.export-pdf', request()->all()) }}" class="btn btn-primary">
            <i class="fas fa-download"></i> Export PDF
        </a>
    </div>
</div>

<!-- Statistiques Générales -->
<div class="dashboard-cards">
    <div class="card">
        <div class="card-icon" style="background-color: var(--primary);">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div class="card-content">
            <h3>Revenus Totaux</h3>
            <p class="stat-number">{{ number_format($statistiques['revenus_totaux'], 0, ',', ' ') }} FCFA</p>
            <small>Période sélectionnée</small>
        </div>
    </div>

    <div class="card">
        <div class="card-icon" style="background-color: var(--secondary);">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="card-content">
            <h3>Paiements Validés</h3>
            <p class="stat-number">{{ $statistiques['nombre_paiements_valides'] }}</p>
            <small>Taux: {{ $statistiques['taux_validation'] }}%</small>
        </div>
    </div>

    <div class="card">
        <div class="card-icon" style="background-color: var(--warning);">
            <i class="fas fa-clock"></i>
        </div>
        <div class="card-content">
            <h3>En Attente</h3>
            <p class="stat-number">{{ $statistiques['nombre_paiements_attente'] }}</p>
            <small>À traiter</small>
        </div>
    </div>

    <div class="card">
        <div class="card-icon" style="background-color: var(--info);">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="card-content">
            <h3>Revenu Moyen</h3>
            <p class="stat-number">{{ number_format($statistiques['revenus_moyens_etudiant'], 0, ',', ' ') }} FCFA</p>
            <small>Par étudiant</small>
        </div>
    </div>
</div>

<!-- Graphique d'évolution -->
<div class="chart-section">
    <h3>Évolution des Revenus (12 derniers mois)</h3>
    <div class="chart-container">
        <canvas id="evolutionChart"></canvas>
    </div>
</div>

<!-- Analyse par Type de Frais -->
<div class="analysis-section">
    <h3>Répartition par Type de Frais</h3>
    <div class="analysis-grid">
        <div class="chart-card">
            <canvas id="typeFraisChart"></canvas>
        </div>
        <div class="stats-card">
            <div class="stat-item">
                <div class="stat-label">
                    <span class="color-indicator" style="background: #FF6384;"></span>
                    Frais d'Inscription
                </div>
                <div class="stat-value">
                    {{ number_format($analyseTypeFrais['inscription']['montant'], 0, ',', ' ') }} FCFA
                    <small>({{ $analyseTypeFrais['inscription']['pourcentage'] }}%)</small>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-label">
                    <span class="color-indicator" style="background: #36A2EB;"></span>
                    Frais de Mensualité
                </div>
                <div class="stat-value">
                    {{ number_format($analyseTypeFrais['mensualite']['montant'], 0, ',', ' ') }} FCFA
                    <small>({{ $analyseTypeFrais['mensualite']['pourcentage'] }}%)</small>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-label">
                    <span class="color-indicator" style="background: #FFCE56;"></span>
                    Frais de Soutenance
                </div>
                <div class="stat-value">
                    {{ number_format($analyseTypeFrais['soutenance']['montant'], 0, ',', ' ') }} FCFA
                    <small>({{ $analyseTypeFrais['soutenance']['pourcentage'] }}%)</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Analyse par Classe -->
<div class="table-section">
    <h3>Performance par Classe</h3>
    <div class="table-container">
        <table class="table">
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
                    <td><strong>{{ $classe['classe'] }}</strong></td>
                    <td class="amount-cell">{{ number_format($classe['revenus'], 0, ',', ' ') }} FCFA</td>
                    <td>{{ $classe['nombre_paiements'] }}</td>
                    <td>{{ $classe['nombre_etudiants'] }}</td>
                    <td class="amount-cell">{{ number_format($classe['revenu_moyen_etudiant'], 0, ',', ' ') }} FCFA</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Analyse par Mode de Paiement -->
<div class="analysis-section">
    <h3>Répartition par Mode de Paiement</h3>
    <div class="analysis-grid">
        <div class="chart-card">
            <canvas id="modePaiementChart"></canvas>
        </div>
        <div class="stats-card">
            @foreach($analyseModePaiement as $mode)
            <div class="stat-item">
                <div class="stat-label">{{ $mode['mode'] }}</div>
                <div class="stat-value">
                    {{ number_format($mode['montant'], 0, ',', ' ') }} FCFA
                    <small>({{ $mode['pourcentage'] }}% - {{ $mode['nombre'] }} paiements)</small>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.header-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.filter-form {
    display: flex;
    gap: 0.5rem;
}

.filter-form select {
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    background: white;
}

.chart-section, .analysis-section, .table-section {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    margin: 2rem 0;
}

.chart-container {
    height: 400px;
    position: relative;
}

.analysis-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-top: 1rem;
}

.chart-card {
    height: 300px;
}

.stats-card {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.stat-item {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid var(--primary);
}

.stat-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.color-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.stat-value {
    font-size: 1.1rem;
    font-weight: bold;
    color: var(--primary);
}

.stat-value small {
    display: block;
    font-size: 0.9rem;
    color: var(--gray);
    font-weight: normal;
}

.amount-cell {
    font-weight: 600;
    color: var(--secondary);
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .analysis-grid {
        grid-template-columns: 1fr;
    }
    
    .filter-form {
        flex-wrap: wrap;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Graphique d'évolution temporelle
const evolutionCtx = document.getElementById('evolutionChart').getContext('2d');
new Chart(evolutionCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($evolutionTemporelle, 'mois')) !!},
        datasets: [{
            label: 'Revenus (FCFA)',
            data: {!! json_encode(array_column($evolutionTemporelle, 'revenus')) !!},
            borderColor: '#007bff',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return new Intl.NumberFormat('fr-FR').format(value) + ' FCFA';
                    }
                }
            }
        }
    }
});

// Graphique type de frais
const typeFraisCtx = document.getElementById('typeFraisChart').getContext('2d');
new Chart(typeFraisCtx, {
    type: 'doughnut',
    data: {
        labels: ['Inscription', 'Mensualité', 'Soutenance'],
        datasets: [{
            data: [
                {{ $analyseTypeFrais['inscription']['montant'] }},
                {{ $analyseTypeFrais['mensualite']['montant'] }},
                {{ $analyseTypeFrais['soutenance']['montant'] }}
            ],
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// Graphique mode de paiement
const modePaiementCtx = document.getElementById('modePaiementChart').getContext('2d');
new Chart(modePaiementCtx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($analyseModePaiement->pluck('mode')->toArray()) !!},
        datasets: [{
            data: {!! json_encode($analyseModePaiement->pluck('montant')->toArray()) !!},
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>
@endsection
