@extends('layouts.app')

@section('title', 'Gestion des Classes')

@section('content')
<div class="page-header">
    <h1>Gestion des Classes</h1>
    <div class="breadcrumb">
        <a href="{{ route('administration.dashboard') }}">Tableau de bord</a> &raquo; Classes
    </div>
</div>

<!-- Statistiques des classes -->
<div class="dashboard-cards">
    <div class="card">
        <div class="card-icon" style="background-color: var(--primary);">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div class="card-content">
            <h3>Total Classes</h3>
            <p class="stat-number">{{ $classes->count() }}</p>
            <small>Classes disponibles</small>
        </div>
    </div>

    <div class="card">
        <div class="card-icon" style="background-color: var(--secondary);">
            <i class="fas fa-users"></i>
        </div>
        <div class="card-content">
            <h3>Étudiants inscrits</h3>
            <p class="stat-number">{{ $classes->sum(fn($c) => $c->inscriptions->count()) }}</p>
            <small>Total des inscriptions</small>
        </div>
    </div>
</div>

<div class="admin-section">
    <div class="section-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3><i class="fas fa-list"></i> Liste des Classes</h3>
        <a href="{{ route('administration.classes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouvelle Classe
        </a>
    </div>

    @if($classes && $classes->count() > 0)
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Libellé</th>
                        <th>Description</th>
                        <th>Inscriptions</th>
                        <th>Date création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classes as $classe)
                        <tr>
                            <td><strong>{{ $classe->libelle }}</strong></td>
                            <td>{{ $classe->description ?? 'Aucune description' }}</td>
                            <td><span class="badge-info">{{ $classe->inscriptions->count() }} étudiant(s)</span></td>
                            <td>{{ $classe->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('administration.classes.show', $classe) }}" class="btn-small btn-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('administration.classes.edit', $classe) }}" class="btn-small btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('administration.classes.destroy', $classe) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-small btn-danger" onclick="return confirm('Supprimer cette classe ?')" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-chalkboard-teacher"></i></div>
            <h4>Aucune classe trouvée</h4>
            <p>Commencez par créer votre première classe.</p>
            <a href="{{ route('administration.classes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Créer une classe
            </a>
        </div>
    @endif
</div>

<style>
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
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-info { background: var(--primary); }
.btn-warning { background: var(--warning); }
.btn-danger { background: var(--danger); }

.btn-small:hover {
    opacity: 0.8;
}

.badge-info {
    background-color: rgba(52, 152, 219, 0.1);
    color: var(--primary);
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    border: 1px solid rgba(52, 152, 219, 0.3);
    font-size: 0.85rem;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 768px) {
    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    .table {
        font-size: 0.9rem;
    }
    .table th, .table td {
        padding: 0.5rem;
    }
}
</style>
@endsection
