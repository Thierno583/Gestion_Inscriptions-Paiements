@extends('layouts.app')

@section('title', 'Créer une Classe')

@section('content')
<div class="page-header">
    <h1>Créer une Nouvelle Classe</h1>
    <div class="breadcrumb">
        <a href="{{ route('administration.dashboard') }}">Tableau de bord</a> &raquo;
        <a href="{{ route('administration.classes.index') }}">Classes</a> &raquo;
        Créer
    </div>
</div>

<div class="admin-section">
    <div class="section-header">
        <h3><i class="fas fa-plus"></i> Informations de la Classe</h3>
    </div>

    <form action="{{ route('administration.classes.store') }}" method="POST" class="form-container">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="libelle">Libellé de la classe <span class="required">*</span></label>
                <input type="text"
                       id="libelle"
                       name="libelle"
                       value="{{ old('libelle') }}"
                       required
                       maxlength="100"
                       placeholder="Ex: Licence 1 Informatique">
                @error('libelle')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description"
                          name="description"
                          rows="4"
                          placeholder="Description optionnelle de la classe">{{ old('description') }}</textarea>
                @error('description')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-section">
            <h4><i class="fas fa-euro-sign"></i> Frais Associés</h4>

            <div class="form-row">
                <div class="form-group">
                    <label for="frais_inscription">Frais d'inscription <span class="required">*</span></label>
                    <div class="input-group">
                        <input type="number"
                               id="frais_inscription"
                               name="frais_inscription"
                               value="{{ old('frais_inscription', 0) }}"
                               required
                               min="0"
                               step="1"
                               placeholder="0">
                        <span class="input-addon">FCFA</span>
                    </div>
                    @error('frais_inscription')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="frais_mensualite">Frais de mensualité <span class="required">*</span></label>
                    <div class="input-group">
                        <input type="number"
                               id="frais_mensualite"
                               name="frais_mensualite"
                               value="{{ old('frais_mensualite', 0) }}"
                               required
                               min="0"
                               step="1"
                               placeholder="0">
                        <span class="input-addon">FCFA</span>
                    </div>
                    @error('frais_mensualite')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="frais_soutenance">Frais de soutenance <span class="required">*</span></label>
                    <div class="input-group">
                        <input type="number"
                               id="frais_soutenance"
                               name="frais_soutenance"
                               value="{{ old('frais_soutenance', 0) }}"
                               required
                               min="0"
                               step="1"
                               placeholder="0">
                        <span class="input-addon">FCFA</span>
                    </div>
                    @error('frais_soutenance')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('administration.classes.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Annuler
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Créer la classe
            </button>
        </div>
    </form>
</div>

<style>
.form-container {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.form-section {
    margin: 2rem 0;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 6px;
    border-left: 4px solid var(--primary);
}

.form-section h4 {
    margin-bottom: 1rem;
    color: var(--primary);
    font-size: 1.1rem;
}

.form-row {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.form-group {
    flex: 1;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #333;
}

.required {
    color: var(--danger);
}

.form-group input, .form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.form-group input:focus, .form-group textarea:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
}

.input-group {
    display: flex;
    align-items: stretch;
}

.input-group input {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.input-addon {
    padding: 0.75rem 1rem;
    background: #e9ecef;
    border: 1px solid #ddd;
    border-left: none;
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
    font-size: 0.9rem;
    color: #6c757d;
}

.error-message {
    color: var(--danger);
    font-size: 0.85rem;
    margin-top: 0.25rem;
    display: block;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #eee;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-primary {
    background: var(--primary);
    color: white;
}

.btn-primary:hover {
    background: #2980b9;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

/* Responsive */
@media (max-width: 768px) {
    .form-row {
        flex-direction: column;
        gap: 0;
    }

    .form-actions {
        flex-direction: column;
    }

    .form-container {
        padding: 1rem;
    }
}
</style>
@endsection
