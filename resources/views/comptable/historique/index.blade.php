@extends('layouts.app')

@section('title', 'Historique des Paiements')

@section('content')
<div class="page-header">
    <h1>Historique des Paiements</h1>
    <div class="breadcrumb">
        <a href="{{ route('comptable.dashboard') }}">Tableau de bord</a> &raquo; Historique
    </div>
</div>

<!-- Statistiques de l'historique -->
<div class="dashboard-cards">
    <div class="card">
        <div class="card-icon" style="background-color: var(--secondary);">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="card-content">
            <h3>Paiements validés</h3>
            <p class="stat-number">{{ $paiements->where('statut', 'validé')->count() }}</p>
            <small>Total confirmés</small>
        </div>
    </div>

    <div class="card">
        <div class="card-icon" style="background-color: var(--primary);">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div class="card-content">
            <h3>Revenus totaux</h3>
            <p class="stat-number">{{ number_format($paiements->where('statut', 'validé')->sum('montant'), 0, ',', ' ') }} FCFA</p>
            <small>Montant encaissé</small>
        </div>
    </div>

    <div class="card">
        <div class="card-icon" style="background-color: var(--warning);">
            <i class="fas fa-calendar-month"></i>
        </div>
        <div class="card-content">
            <h3>Ce mois</h3>
            <p class="stat-number">{{ $paiements->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
            <small>Paiements traités</small>
        </div>
    </div>

    <div class="card">
        <div class="card-icon" style="background-color: var(--danger);">
            <i class="fas fa-times-circle"></i>
        </div>
        <div class="card-content">
            <h3>Rejetés</h3>
            <p class="stat-number">{{ $paiements->where('statut', 'rejeté')->count() }}</p>
            <small>Paiements refusés</small>
        </div>
    </div>
</div>

<!-- Filtres et recherche -->
<div class="filters-section">
    <div class="filters-header">
        <h3>Filtres et recherche</h3>
        <button type="button" class="btn btn-outline" onclick="resetFilters()">
            <i class="fas fa-undo"></i> Réinitialiser
        </button>
    </div>

    <div class="filters-grid">
        <div class="filter-group">
            <label>Période</label>
            <select onchange="filterByPeriod(this.value)" id="periodFilter">
                <option value="">Toutes les périodes</option>
                <option value="today">Aujourd'hui</option>
                <option value="week">Cette semaine</option>
                <option value="month">Ce mois</option>
                <option value="quarter">Ce trimestre</option>
                <option value="year">Cette année</option>
            </select>
        </div>

        <div class="filter-group">
            <label>Statut</label>
            <select onchange="filterByStatus(this.value)" id="statusFilter">
                <option value="">Tous les statuts</option>
                <option value="valide">Validés</option>
                <option value="rejete">Rejetés</option>
                <option value="en_attente">En attente</option>
            </select>
        </div>

        <div class="filter-group">
            <label>Mode de paiement</label>
            <select onchange="filterByMode(this.value)" id="modeFilter">
                <option value="">Tous les modes</option>
                <option value="carte_bancaire">Carte bancaire</option>
                <option value="mobile_money">Mobile Money</option>
                <option value="virement">Virement</option>
                <option value="especes">Espèces</option>
            </select>
        </div>

        <div class="filter-group">
            <label>Recherche</label>
            <input type="text" placeholder="Nom étudiant, référence..." onkeyup="searchPayments(this.value)" id="searchInput">
        </div>
    </div>
</div>

<div class="history-section">
    <div class="section-header">
        <h3><i class="fas fa-history"></i> Historique Complet</h3>
        <div class="export-controls">
     <a href="{{ route('comptable.historique.export.excel') }}" class="btn btn-success">
        <i class="fas fa-file-excel"></i> Export Excel
     </a>
     <a href="" class="btn btn-info">
        <i class="fas fa-file-pdf"></i> Export PDF
     </a>
    </div>

</div>

    @if($paiements && $paiements->count() > 0)
        <div class="table-container">
            <table class="table" id="paymentsTable">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Date <i class="fas fa-sort"></i></th>
                        <th onclick="sortTable(1)">Étudiant <i class="fas fa-sort"></i></th>
                        <th onclick="sortTable(2)">Classe <i class="fas fa-sort"></i></th>
                        <th onclick="sortTable(3)">Montant <i class="fas fa-sort"></i></th>
                        <th onclick="sortTable(4)">Mode <i class="fas fa-sort"></i></th>
                        <th onclick="sortTable(5)">Référence <i class="fas fa-sort"></i></th>
                        <th onclick="sortTable(6)">Statut <i class="fas fa-sort"></i></th>
                        <th>Validé par</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paiements as $paiement)
                        <tr data-status="{{ $paiement->statut }}"
                            data-mode="{{ $paiement->mode_paiement }}"
                            data-date="{{ $paiement->created_at->format('Y-m-d') }}"
                            data-search="{{ strtolower($paiement->etudiant->personne->nom ?? '') }} {{ strtolower($paiement->etudiant->personne->prenom ?? '') }} {{ strtolower($paiement->reference_transaction) }}">
                            <td>
                                <div class="date-info">
                                    <strong>{{ $paiement->created_at->format('d/m/Y') }}</strong>
                                    <small>{{ $paiement->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="student-info">
                                    <strong>{{ $paiement->inscription->etudiant->personne->nom ?? 'N/A' }} {{ $paiement->inscription->etudiant->personne->prenom ?? '' }}</strong>
                                    <small>{{ $paiement->inscription->etudiant->matricule ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td>{{ $paiement->inscription->classe->libelle ?? 'N/A' }}</td>
                            <td>
                                <span class="amount-cell">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</span>
                            </td>
                            <td>
                                <span class="mode-badge">
                                    @switch($paiement->mode_paiement)
                                        @case('carte_bancaire')
                                            💳 Carte
                                            @break
                                        @case('mobile_money')
                                            📱 Mobile
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
                                @switch($paiement->statut)
                                    @case('valide')
                                        <span class="status-badge status-success">
                                            <i class="fas fa-check-circle"></i> Validé
                                        </span>
                                        @break
                                    @case('rejete')
                                        <span class="status-badge status-danger">
                                            <i class="fas fa-times-circle"></i> Rejeté
                                        </span>
                                        @break
                                    @case('en_attente')
                                        <span class="status-badge status-warning">
                                            <i class="fas fa-clock"></i> En attente
                                        </span>
                                        @break
                                    @default
                                        <span class="status-badge status-neutral">
                                            {{ ucfirst($paiement->statut) }}
                                        </span>
                                @endswitch
                            </td>
                            <td>
                                @if($paiement->comptable)
                                    <div class="validator-info">
                                        <strong>{{ $paiement->comptable->personne->nom ?? 'N/A' }}</strong>
                                        <small>{{ $paiement->updated_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button type="button" class="btn-small btn-info" onclick="viewDetails({{ $paiement->id }})" title="Détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn-small btn-primary" onclick="printReceipt({{ $paiement->id }})" title="Reçu">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    @if($paiement->statut === 'valide')
                                        <button type="button" class="btn-small btn-warning" onclick="sendEmail({{ $paiement->id }})" title="Envoyer email">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-info">
            <p>Affichage de {{ $paiements->count() }} paiement(s) sur un total de {{ $paiements->count() }}</p>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-history"></i>
            </div>
            <h4>Aucun paiement dans l'historique</h4>
            <p>L'historique des paiements apparaîtra ici une fois que des paiements auront été traités.</p>
        </div>
    @endif
</div>

<!-- Modal de détails du paiement -->
<div id="detailsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-eye"></i> Détails du Paiement</h3>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <div class="modal-body" id="modalBody">
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i> Chargement...
            </div>
        </div>
    </div>
</div>

<script>
let sortDirection = {};

function filterByPeriod(period) {
    const rows = document.querySelectorAll('tbody tr[data-date]');
    const today = new Date();

    rows.forEach(row => {
        const rowDate = new Date(row.dataset.date);
        let show = true;

        switch(period) {
            case 'today':
                show = rowDate.toDateString() === today.toDateString();
                break;
            case 'week':
                const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
                show = rowDate >= weekAgo;
                break;
            case 'month':
                show = rowDate.getMonth() === today.getMonth() && rowDate.getFullYear() === today.getFullYear();
                break;
            case 'quarter':
                const quarter = Math.floor(today.getMonth() / 3);
                const rowQuarter = Math.floor(rowDate.getMonth() / 3);
                show = rowQuarter === quarter && rowDate.getFullYear() === today.getFullYear();
                break;
            case 'year':
                show = rowDate.getFullYear() === today.getFullYear();
                break;
            default:
                show = true;
        }

        row.style.display = show ? '' : 'none';
    });
}

function filterByStatus(status) {
    const rows = document.querySelectorAll('tbody tr[data-status]');

    rows.forEach(row => {
        if (status === '' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
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

function searchPayments(query) {
    const rows = document.querySelectorAll('tbody tr[data-search]');
    const searchTerm = query.toLowerCase();

    rows.forEach(row => {
        if (searchTerm === '' || row.dataset.search.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function resetFilters() {
    document.getElementById('periodFilter').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('modeFilter').value = '';
    document.getElementById('searchInput').value = '';

    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => row.style.display = '');
}

function sortTable(columnIndex) {
    const table = document.getElementById('paymentsTable');
    const rows = Array.from(table.querySelectorAll('tbody tr'));
    const isAscending = sortDirection[columnIndex] !== 'asc';

    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex].textContent.trim();
        const bValue = b.cells[columnIndex].textContent.trim();

        if (isAscending) {
            return aValue.localeCompare(bValue);
        } else {
            return bValue.localeCompare(aValue);
        }
    });

    const tbody = table.querySelector('tbody');
    rows.forEach(row => tbody.appendChild(row));

    sortDirection[columnIndex] = isAscending ? 'asc' : 'desc';
}

function viewDetails(id) {
    // Ouvrir la modal
    document.getElementById('detailsModal').style.display = 'block';
    
    // Afficher le spinner de chargement
    document.getElementById('modalBody').innerHTML = `
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-spin"></i> Chargement des détails...
        </div>
    `;
    
    // Récupérer les détails via AJAX
    fetch(`/comptable/paiements/${id}/details`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayPaiementDetails(data.paiement);
            } else {
                document.getElementById('modalBody').innerHTML = `
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle"></i>
                        Erreur lors du chargement des détails
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            document.getElementById('modalBody').innerHTML = `
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    Erreur de connexion
                </div>
            `;
        });
}

function displayPaiementDetails(paiement) {
    const modalBody = document.getElementById('modalBody');
    
    modalBody.innerHTML = `
        <div class="details-container">
            <!-- Informations générales -->
            <div class="detail-section">
                <h4><i class="fas fa-info-circle"></i> Informations Générales</h4>
                <div class="detail-grid">
                    <div class="detail-item">
                        <label>Référence:</label>
                        <span class="reference-code">${paiement.reference_transaction}</span>
                    </div>
                    <div class="detail-item">
                        <label>Date de paiement:</label>
                        <span>${new Date(paiement.date_paiement).toLocaleDateString('fr-FR')}</span>
                    </div>
                    <div class="detail-item">
                        <label>Montant:</label>
                        <span class="amount-highlight">${new Intl.NumberFormat('fr-FR').format(paiement.montant)} FCFA</span>
                    </div>
                    <div class="detail-item">
                        <label>Mode de paiement:</label>
                        <span class="mode-badge">${formatModePayment(paiement.mode_paiement)}</span>
                    </div>
                    <div class="detail-item">
                        <label>Statut:</label>
                        <span class="status-badge ${getStatusClass(paiement.statut)}">
                            ${getStatusIcon(paiement.statut)} ${formatStatus(paiement.statut)}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Informations étudiant -->
            <div class="detail-section">
                <h4><i class="fas fa-user-graduate"></i> Informations Étudiant</h4>
                <div class="detail-grid">
                    <div class="detail-item">
                        <label>Nom complet:</label>
                        <span>${paiement.inscription?.etudiant?.personne?.nom || 'N/A'} ${paiement.inscription?.etudiant?.personne?.prenom || ''}</span>
                    </div>
                    <div class="detail-item">
                        <label>Matricule:</label>
                        <span>${paiement.inscription?.etudiant?.matricule || 'N/A'}</span>
                    </div>
                    <div class="detail-item">
                        <label>Email:</label>
                        <span>${paiement.inscription?.etudiant?.personne?.user?.email || 'N/A'}</span>
                    </div>
                    <div class="detail-item">
                        <label>Téléphone:</label>
                        <span>${paiement.inscription?.etudiant?.personne?.telephone || 'N/A'}</span>
                    </div>
                </div>
            </div>

            <!-- Informations inscription -->
            <div class="detail-section">
                <h4><i class="fas fa-graduation-cap"></i> Informations Inscription</h4>
                <div class="detail-grid">
                    <div class="detail-item">
                        <label>Classe:</label>
                        <span>${paiement.inscription?.classe?.libelle || 'N/A'}</span>
                    </div>
                    <div class="detail-item">
                        <label>Année académique:</label>
                        <span>${paiement.inscription?.annee_academique || 'N/A'}</span>
                    </div>
                    <div class="detail-item">
                        <label>Date d'inscription:</label>
                        <span>${paiement.inscription?.date_inscription ? new Date(paiement.inscription.date_inscription).toLocaleDateString('fr-FR') : 'N/A'}</span>
                    </div>
                </div>
            </div>

            <!-- Informations validation -->
            ${paiement.comptable ? `
            <div class="detail-section">
                <h4><i class="fas fa-user-check"></i> Informations Validation</h4>
                <div class="detail-grid">
                    <div class="detail-item">
                        <label>Validé par:</label>
                        <span>${paiement.comptable?.personne?.nom || 'N/A'} ${paiement.comptable?.personne?.prenom || ''}</span>
                    </div>
                    <div class="detail-item">
                        <label>Date de validation:</label>
                        <span>${new Date(paiement.updated_at).toLocaleDateString('fr-FR')} à ${new Date(paiement.updated_at).toLocaleTimeString('fr-FR')}</span>
                    </div>
                </div>
            </div>
            ` : ''}

            <!-- Actions -->
            <div class="detail-actions">
                <button type="button" class="btn btn-primary" onclick="printReceipt(${paiement.id})">
                    <i class="fas fa-print"></i> Imprimer le reçu
                </button>
                ${paiement.statut === 'validé' ? `
                <button type="button" class="btn btn-warning" onclick="sendEmail(${paiement.id})">
                    <i class="fas fa-envelope"></i> Envoyer par email
                </button>
                ` : ''}
                <button type="button" class="btn btn-secondary" onclick="closeModal()">
                    <i class="fas fa-times"></i> Fermer
                </button>
            </div>
        </div>
    `;
}

function closeModal() {
    document.getElementById('detailsModal').style.display = 'none';
}

function formatModePayment(mode) {
    const modes = {
        'carte_bancaire': '💳 Carte bancaire',
        'mobile_money': '📱 Mobile Money',
        'orange_money': '🟠 Orange Money',
        'virement': '🏦 Virement',
        'especes': '💵 Espèces'
    };
    return modes[mode] || mode.replace('_', ' ');
}

function formatStatus(status) {
    const statuses = {
        'valide': 'Validé',
        'validé': 'Validé',
        'rejete': 'Rejeté',
        'rejeté': 'Rejeté',
        'en_attente': 'En attente'
    };
    return statuses[status] || status;
}

function getStatusClass(status) {
    const classes = {
        'valide': 'status-success',
        'validé': 'status-success',
        'rejete': 'status-danger',
        'rejeté': 'status-danger',
        'en_attente': 'status-warning'
    };
    return classes[status] || 'status-neutral';
}

function getStatusIcon(status) {
    const icons = {
        'valide': '<i class="fas fa-check-circle"></i>',
        'validé': '<i class="fas fa-check-circle"></i>',
        'rejete': '<i class="fas fa-times-circle"></i>',
        'rejeté': '<i class="fas fa-times-circle"></i>',
        'en_attente': '<i class="fas fa-clock"></i>'
    };
    return icons[status] || '<i class="fas fa-question-circle"></i>';
}

// Fermer la modal en cliquant à l'extérieur
window.onclick = function(event) {
    const modal = document.getElementById('detailsModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}

function printReceipt(id) {
    const url = `/paiements/${id}/recu`;
    const win = window.open(url, '_blank');
    win.focus();
}

</script>

<style>
.filters-section {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    margin: 2rem 0;
}

.filters-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.filters-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.filter-group {
    display: flex;
    flex-direction: column;
}

.filter-group label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--dark);
}

.filter-group select,
.filter-group input {
    padding: 0.75rem;
    border: 2px solid #e0e0e0;
    border-radius: 6px;
    font-size: 1rem;
    transition: border-color 0.3s;
}

.filter-group select:focus,
.filter-group input:focus {
    outline: none;
    border-color: var(--primary);
}

.history-section {
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

.export-controls {
    display: flex;
    gap: 1rem;
}

.table th {
    cursor: pointer;
    user-select: none;
    position: relative;
}

.table th:hover {
    background-color: #e8f4f8;
}

.table th i {
    margin-left: 0.5rem;
    opacity: 0.5;
}

.date-info, .student-info {
    display: flex;
    flex-direction: column;
}

.date-info small, .student-info small {
    color: var(--gray);
    font-size: 0.8rem;
}

.validator-info {
    display: flex;
    flex-direction: column;
}

.validator-info small {
    color: var(--gray);
    font-size: 0.75rem;
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
    font-size: 1.05rem;
}

.pagination-info {
    padding: 1rem 2rem;
    background: #f8f9fa;
    border-top: 1px solid #e0e0e0;
    text-align: center;
    color: var(--gray);
}

.text-muted {
    color: var(--gray);
    font-style: italic;
}

/* Responsive */
@media (max-width: 768px) {
    .filters-grid {
        grid-template-columns: 1fr;
    }

    .section-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .export-controls {
        flex-wrap: wrap;
        justify-content: center;
    }

    .table {
        font-size: 0.85rem;
    }

    .table th,
    .table td {
        padding: 0.5rem;
    }
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(3px);
}

.modal-content {
    background-color: white;
    margin: 2% auto;
    padding: 0;
    border-radius: 12px;
    width: 90%;
    max-width: 800px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-header {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    padding: 1.5rem 2rem;
    border-radius: 12px 12px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    margin: 0;
    font-size: 1.3rem;
}

.close {
    color: white;
    font-size: 2rem;
    font-weight: bold;
    cursor: pointer;
    transition: opacity 0.3s;
    line-height: 1;
}

.close:hover {
    opacity: 0.7;
}

.modal-body {
    padding: 2rem;
}

.loading-spinner {
    text-align: center;
    padding: 3rem;
    color: var(--primary);
    font-size: 1.1rem;
}

.loading-spinner i {
    font-size: 2rem;
    margin-bottom: 1rem;
    display: block;
}

.error-message {
    text-align: center;
    padding: 2rem;
    color: var(--danger);
    font-size: 1.1rem;
}

.error-message i {
    font-size: 2rem;
    margin-bottom: 1rem;
    display: block;
}

.details-container {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.detail-section {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1.5rem;
    border-left: 4px solid var(--primary);
}

.detail-section h4 {
    margin: 0 0 1rem 0;
    color: var(--dark);
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}

.detail-item label {
    font-weight: 600;
    color: var(--gray);
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-item span {
    font-size: 1rem;
    color: var(--dark);
}

.amount-highlight {
    font-size: 1.2rem !important;
    font-weight: bold !important;
    color: var(--secondary) !important;
}

.detail-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    padding-top: 1rem;
    border-top: 1px solid #e0e0e0;
    margin-top: 1rem;
}

.detail-actions .btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s;
}

.detail-actions .btn-primary {
    background: var(--primary);
    color: white;
}

.detail-actions .btn-warning {
    background: var(--warning);
    color: white;
}

.detail-actions .btn-secondary {
    background: var(--gray);
    color: white;
}

.detail-actions .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Responsive modal */
@media (max-width: 768px) {
    .modal-content {
        width: 95%;
        margin: 5% auto;
        max-height: 85vh;
    }
    
    .modal-header {
        padding: 1rem 1.5rem;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .detail-grid {
        grid-template-columns: 1fr;
    }
    
    .detail-actions {
        flex-direction: column;
    }
    
    .detail-actions .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

@endsection
