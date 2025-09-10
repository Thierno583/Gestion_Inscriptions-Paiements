@extends('layouts.app')

@section('title', 'Tableau de bord Comptable')

@section('content')
<div class="page-header">
    <h1>Tableau de bord Comptable</h1>
    <div class="welcome-message">
        Bonjour {{ Auth::user()->name }}, bienvenue sur votre espace comptable.
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
        @if(session('recu_url'))
            <a href="{{ session('recu_url') }}" target="_blank" class="btn btn-sm btn-primary ml-2">
                <i class="fas fa-download"></i> Télécharger le reçu
            </a>
        @endif
    </div>
@endif

<!-- Statistiques des paiements -->
<div class="dashboard-cards">
    <div class="card">
        <div class="card-icon" style="background-color: var(--warning);">
            <i class="fas fa-clock"></i>
        </div>
        <div class="card-content">
            <h3>Paiements en attente</h3>
            <p class="stat-number">{{ $paiementsEnAttente ?? 0 }}</p>
            <small>À valider</small>
            <a href="{{ route('comptable.paiements.en_attente') }}" class="card-link">Traiter <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="card">
        <div class="card-icon" style="background-color: var(--secondary);">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="card-content">
            <h3>Paiements validés</h3>
            <p class="stat-number">{{ $paiementsValides ?? 0 }}</p>
            <small>Ce mois-ci</small>
            <a href="{{ route('comptable.paiements.historique') }}" class="card-link">Voir <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="card">
        <div class="card-icon" style="background-color: var(--primary);">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div class="card-content">
            <h3>Montant total</h3>
            <p class="stat-number">{{ number_format($montantTotal ?? 0, 0, ',', ' ') }} FCFA</p>
            <small>Revenus du mois</small>
        </div>
    </div>

    <div class="card">
        <div class="card-icon" style="background-color: var(--danger);">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="card-content">
            <h3>Paiements rejetés</h3>
            <p class="stat-number">{{ $paiementsRejetes ?? 0 }}</p>
            <small>Nécessitent attention</small>
        </div>
    </div>
</div>

<!-- Actions rapides -->
<div class="quick-actions">
    <h3>Actions rapides</h3>
    <div class="action-grid">
        <a href="{{ route('comptable.paiements.en_attente') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="action-content">
                <h4>Valider les paiements</h4>
                <p>Traiter les paiements en attente de validation</p>
            </div>
        </a>

        <a href="{{ route('comptable.paiements.historique') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-history"></i>
            </div>
            <div class="action-content">
                <h4>Historique complet</h4>
                <p>Consulter l'historique des paiements</p>
            </div>
        </a>

        <a href="{{ route('comptable.rapports.index') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="action-content">
                <h4>Rapports financiers</h4>
                <p>Générer des rapports de revenus</p>
            </div>
        </a>

        <a href="#" class="action-card">
            <div class="action-icon">
                <i class="fas fa-download"></i>
            </div>
            <div class="action-content">
                <h4>Export des données</h4>
                <p>Exporter les données comptables</p>
            </div>
        </a>
    </div>
</div>

<!-- Paiements récents -->
<div class="recent-payments">
    <h3>Paiements récents nécessitant validation</h3>
    @if(isset($paiementsRecents) && $paiementsRecents->count() > 0)
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Étudiant</th>
                        <th>Montant</th>
                        <th>Mode</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paiementsRecents as $paiement)
                        <tr>
                            <td>{{ $paiement->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $paiement->etudiant->personne->nom ?? 'N/A' }}</td>
                            <td class="amount-cell">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $paiement->mode_paiement)) }}</td>
                            <td>
                                <span class="status-badge status-warning">
                                    <i class="fas fa-clock"></i> En attente
                                </span>
                            </td>
                           <td>
                              <form action="/comptable/api/paiements/{{ $paiement->id }}/valider" method="POST" style="display:inline;">
                                    @csrf
                                  <button type="submit" class="btn-small btn-success">
                                      <i class="fas fa-check"></i> Valider
                                  </button>
                               </form>
                           </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state-small">
            <i class="fas fa-check-circle"></i>
            <p>Aucun paiement en attente de validation</p>
        </div>
    @endif
</div>

<style>
.welcome-message {
    color: var(--gray);
    margin-bottom: 2rem;
    font-size: 1.1rem;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: bold;
    color: var(--dark);
    margin: 0.5rem 0;
}

.quick-actions {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    margin: 2rem 0;
}

.quick-actions h3 {
    margin-bottom: 1.5rem;
    color: var(--dark);
}

.action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

.action-card {
    display: flex;
    align-items: center;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 8px;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s;
    border: 2px solid transparent;
}

.action-card:hover {
    background: white;
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    text-decoration: none;
    color: inherit;
}

.action-icon {
    background: var(--primary);
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-right: 1rem;
    flex-shrink: 0;
}

.action-content h4 {
    margin: 0 0 0.5rem 0;
    color: var(--dark);
    font-size: 1.1rem;
}

.action-content p {
    margin: 0;
    color: var(--gray);
    font-size: 0.9rem;
}

.recent-payments {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    margin: 2rem 0;
}

.recent-payments h3 {
    margin-bottom: 1.5rem;
    color: var(--dark);
}

.empty-state-small {
    text-align: center;
    padding: 2rem;
    color: var(--gray);
}

.empty-state-small i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.3;
}

.amount-cell {
    font-weight: 600;
    color: var(--secondary);
}

.btn-small {
    padding: 0.4rem 0.8rem;
    font-size: 0.85rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    color: white;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}

.btn-success { background: var(--secondary); }
.btn-small:hover { opacity: 0.8; }

/* Responsive */
@media (max-width: 768px) {
    .action-grid {
        grid-template-columns: 1fr;
    }

    .action-card {
        padding: 1rem;
    }

    .action-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
}
</style>
@endsection
