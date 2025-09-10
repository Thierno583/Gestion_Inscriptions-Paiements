@extends('layouts.app')

@section('title', 'Paiements en Attente')

@section('content')
<div class="page-header">
    <h1>Paiements en Attente de Validation</h1>
    <div class="breadcrumb">
        <a href="{{ route('comptable.dashboard') }}">Tableau de bord</a> &raquo; Paiements en attente
    </div>
</div>

<!-- Statistiques des paiements en attente -->
<div class="dashboard-cards">
    <div class="card">
        <div class="card-icon" style="background-color: var(--warning);">
            <i class="fas fa-clock"></i>
        </div>
        <div class="card-content">
            <h3>En attente</h3>
            <p class="stat-number">{{ $paiements->count() }}</p>
            <small>Paiements à traiter</small>
        </div>
    </div>

    <div class="card">
        <div class="card-icon" style="background-color: var(--primary);">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div class="card-content">
            <h3>Montant total</h3>
            <p class="stat-number">{{ number_format($paiements->sum('montant'), 0, ',', ' ') }} FCFA</p>
            <small>À valider</small>
        </div>
    </div>

    <div class="card">
        <div class="card-icon" style="background-color: var(--secondary);">
            <i class="fas fa-calendar-day"></i>
        </div>
        <div class="card-content">
            <h3>Aujourd'hui</h3>
            <p class="stat-number">{{ $paiements->where('created_at', '>=', today())->count() }}</p>
            <small>Nouveaux paiements</small>
        </div>
    </div>
</div>

<!-- Actions en lot -->
<div class="bulk-actions">
    <div class="bulk-header">
        <h3>Actions en lot</h3>
        <div class="bulk-controls">
            <button type="button" class="btn btn-outline" onclick="selectAll()">
                <i class="fas fa-check-square"></i> Tout sélectionner
            </button>
            <button type="button" class="btn btn-success" onclick="validateSelected()" disabled id="validateBtn">
                <i class="fas fa-check"></i> Valider sélectionnés
            </button>
            <button type="button" class="btn btn-danger" onclick="rejectSelected()" disabled id="rejectBtn">
                <i class="fas fa-times"></i> Rejeter sélectionnés
            </button>
        </div>
    </div>
</div>

<div class="payments-section">
    <div class="section-header">
        <h3><i class="fas fa-list"></i> Liste des Paiements en Attente</h3>
        <div class="filter-controls">
            <select onchange="filterByMode(this.value)" class="filter-select">
                <option value="">Tous les modes</option>
                <option value="carte_bancaire">Carte bancaire</option>
                <option value="mobile_money">Mobile Money</option>
                <option value="virement">Virement</option>
                <option value="especes">Espèces</option>
            </select>
        </div>
    </div>

    @if($paiements && $paiements->count() > 0)
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll()">
                        </th>
                        <th>Date</th>
                        <th>Étudiant</th>
                        <th>Inscription</th>
                        <th>Montant</th>
                        <th>Mode</th>
                        <th>Référence</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paiements as $paiement)
                        <tr data-mode="{{ $paiement->mode_paiement }}" data-id="{{ $paiement->id }}">
                            <td>
                                <input type="checkbox" class="payment-checkbox" value="{{ $paiement->id }}" onchange="updateBulkButtons()">
                            </td>
                            <td>
                                <div class="date-info">
                                    <strong>{{ $paiement->created_at->format('d/m/Y') }}</strong>
                                    <small>{{ $paiement->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="student-info">
                                      @if($paiement->inscription && $paiement->inscription->etudiant && $paiement->inscription->etudiant->personne)
                                      <strong>{{ $paiement->inscription->etudiant->personne->nom }}
                                      {{ $paiement->inscription->etudiant->personne->prenom }}</strong>
                                      <small>{{ $paiement->inscription->etudiant->matricule ?? 'N/A' }}</small>
                                      @else
                                      <strong>Étudiant non trouvé</strong>
                                      <small>N/A</small>
                                      @endif
                                </div>
                           </td>
                            <td>
                                <div class="inscription-info">
                                    <strong>{{ $paiement->inscription->classe->libelle ?? 'N/A' }}</strong>
                                    <small>{{ $paiement->inscription->annee_academique ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="amount-cell">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</span>
                            </td>
                            <td>
                                <span class="mode-badge">
                                    @switch($paiement->mode_paiement)
                                        @case('carte_bancaire')
                                            💳 Carte bancaire
                                            @break
                                        @case('mobile_money')
                                            📱 Mobile Money
                                            @break
                                        @case('virement')
                                            🏦 Virement
                                            @break
                                        @case('especes')
                                            💵 Espèces
                                            @break
                                        @default
                                            {{ ucfirst(str_replace('_', ' ', $paiement->mode_paiement)) }}
                                    @endswitch
                                </span>
                            </td>
                            <td>
                                <code class="reference-code">{{ $paiement->reference_transaction }}</code>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button type="button" class="btn-small btn-success" onclick="validatePayment({{ $paiement->id }})" title="Valider">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" class="btn-small btn-danger" onclick="rejectPayment({{ $paiement->id }})" title="Rejeter">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <button type="button" class="btn-small btn-info" onclick="viewDetails({{ $paiement->id }})" title="Détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h4>Aucun paiement en attente</h4>
            <p>Tous les paiements ont été traités. Excellent travail !</p>
            <a href="{{ route('paiements.historique') }}" class="btn btn-primary">
                <i class="fas fa-history"></i> Voir l'historique
            </a>
        </div>
    @endif
</div>

<script>
let selectedPayments = [];

function selectAll() {
    const checkboxes = document.querySelectorAll('.payment-checkbox');
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');

    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
    selectAllCheckbox.checked = true;
    updateBulkButtons();
}

function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const checkboxes = document.querySelectorAll('.payment-checkbox');

    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    updateBulkButtons();
}

function updateBulkButtons() {
    const checkedBoxes = document.querySelectorAll('.payment-checkbox:checked');
    const validateBtn = document.getElementById('validateBtn');
    const rejectBtn = document.getElementById('rejectBtn');

    if (checkedBoxes.length > 0) {
        validateBtn.disabled = false;
        rejectBtn.disabled = false;
    } else {
        validateBtn.disabled = true;
        rejectBtn.disabled = true;
    }

    selectedPayments = Array.from(checkedBoxes).map(cb => cb.value);
}

function validateSelected() {
    if (selectedPayments.length === 0) return;

    if (confirm(`Valider ${selectedPayments.length} paiement(s) sélectionné(s) ?`)) {
        // Ici vous pouvez ajouter l'appel AJAX pour valider les paiements
        console.log('Validation des paiements:', selectedPayments);
        // Exemple d'appel AJAX (à adapter selon votre API)
        // fetch('/api/paiements/validate-bulk', { ... })
    }
}

function rejectSelected() {
    if (selectedPayments.length === 0) return;

    if (confirm(`Rejeter ${selectedPayments.length} paiement(s) sélectionné(s) ?`)) {
        // Ici vous pouvez ajouter l'appel AJAX pour rejeter les paiements
        console.log('Rejet des paiements:', selectedPayments);
    }
}

function validatePayment(id) {
    if (confirm('Valider ce paiement ?')) {
        // Appel AJAX pour valider un paiement individuel
        console.log('Validation du paiement:', id);
    }
}

function rejectPayment(id) {
    if (confirm('Rejeter ce paiement ?')) {
        // Appel AJAX pour rejeter un paiement individuel
        console.log('Rejet du paiement:', id);
    }
}

function viewDetails(id) {
    // Ouvrir une modal ou rediriger vers les détails
    console.log('Voir détails du paiement:', id);
}

function filterByMode(mode) {
    const rows = document.querySelectorAll('tbody tr[data-mode]');

    rows.forEach(row => {
        if (mode === '' || row.dataset.mode === mode) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>

<style>
.bulk-actions {
    background: white;
    padding: 1.5rem 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    margin: 2rem 0;
}

.bulk-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.bulk-controls {
    display: flex;
    gap: 1rem;
}

.btn-outline {
    background: transparent;
    border: 2px solid var(--primary);
    color: var(--primary);
}

.btn-outline:hover {
    background: var(--primary);
    color: white;
}

.payments-section {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.section-header {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    padding: 1.5rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.filter-controls {
    display: flex;
    gap: 1rem;
}

.filter-select {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 4px;
    background: white;
    color: var(--dark);
}

.date-info, .student-info, .inscription-info {
    display: flex;
    flex-direction: column;
}

.date-info small, .student-info small, .inscription-info small {
    color: var(--gray);
    font-size: 0.8rem;
}

.mode-badge {
    background: var(--light);
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.85rem;
    color: var(--dark);
}

.reference-code {
    background: var(--light);
    padding: 0.3rem 0.6rem;
    border-radius: 4px;
    font-family: 'Courier New', monospace;
    font-size: 0.8rem;
    color: var(--dark);
}

.amount-cell {
    font-weight: 600;
    color: var(--secondary);
    font-size: 1.1rem;
}

.action-buttons {
    display: flex;
    gap: 0.3rem;
}

.btn-small {
    padding: 0.4rem 0.6rem;
    font-size: 0.8rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    color: white;
}

.btn-success { background: var(--secondary); }
.btn-info { background: var(--primary); }
.btn-danger { background: var(--danger); }

.btn-small:hover { opacity: 0.8; }
.btn-small:disabled { opacity: 0.5; cursor: not-allowed; }

/* Responsive */
@media (max-width: 768px) {
    .bulk-header {
        flex-direction: column;
        gap: 1rem;
    }

    .bulk-controls {
        flex-wrap: wrap;
        justify-content: center;
    }

    .section-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .table {
        font-size: 0.9rem;
    }

    .table th,
    .table td {
        padding: 0.5rem;
    }
}
</style>
@endsection
