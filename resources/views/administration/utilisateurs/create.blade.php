@extends('layouts.app')

@section('title', 'Créer un nouvel utilisateur')

@section('content')
<div class="container mt-4" style="max-width: 700px;">
    <div class="page-header mb-4">
        <h1>Créer un nouvel utilisateur</h1>
        <div class="breadcrumb">
            <a href="{{ route('administration.utilisateurs.index') }}">Utilisateurs</a> &raquo; Création
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert" style="background-color: #e74c3c; color: white; padding: 1rem; border-radius: 4px; margin-bottom: 2rem;">
            <strong>Attention !</strong> Veuillez corriger les erreurs ci-dessous :
            <ul style="margin-top: 0.5rem;">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('administration.utilisateurs.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="mb-3 row align-items-center">
            <label for="nom" class="col-sm-3 col-form-label">Nom *</label>
            <div class="col-sm-9">
                <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom') }}" required maxlength="100" placeholder="Nom">
            </div>
        </div>

        <div class="mb-3 row align-items-center">
            <label for="prenom" class="col-sm-3 col-form-label">Prénom *</label>
            <div class="col-sm-9">
                <input type="text" name="prenom" id="prenom" class="form-control" value="{{ old('prenom') }}" required maxlength="100" placeholder="Prénom">
            </div>
        </div>

        <div class="mb-3 row align-items-center">
            <label for="nom_d_utilisateur" class="col-sm-3 col-form-label">Nom d'utilisateur *</label>
            <div class="col-sm-9">
                <input type="text" name="nom_d_utilisateur" id="nom_d_utilisateur" class="form-control" value="{{ old('nom_d_utilisateur') }}" required maxlength="50" placeholder="Nom d'utilisateur">
            </div>
        </div>

        <div class="mb-3 row align-items-center">
            <label for="email" class="col-sm-3 col-form-label">Email *</label>
            <div class="col-sm-9">
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required maxlength="150" placeholder="exemple@mail.com">
            </div>
        </div>

        <div class="mb-3 row align-items-center">
            <label for="telephone" class="col-sm-3 col-form-label">Téléphone</label>
            <div class="col-sm-9">
                <input type="tel" name="telephone" id="telephone" class="form-control" value="{{ old('telephone') }}" maxlength="20" placeholder="Téléphone">
            </div>
        </div>

        <div class="mb-3 row align-items-center">
            <label for="date_de_naissance" class="col-sm-3 col-form-label">Date de naissance</label>
            <div class="col-sm-9">
                <input type="date" name="date_de_naissance" id="date_de_naissance" class="form-control" value="{{ old('date_de_naissance') }}">
            </div>
        </div>

        <div class="mb-3 row align-items-center">
            <label for="adresse" class="col-sm-3 col-form-label">Adresse</label>
            <div class="col-sm-9">
                <textarea name="adresse" id="adresse" class="form-control" rows="3" placeholder="Adresse complète">{{ old('adresse') }}</textarea>
            </div>
        </div>

      <!--  <div class="mb-3 row align-items-center">
            <label for="cni" class="col-sm-3 col-form-label">N° CNI</label>
            <div class="col-sm-9">
                <input type="text" name="cni" id="cni" class="form-control" value="{{ old('cni') }}" maxlength="100" placeholder="Numéro de carte d'identité">
            </div>
        </div> -->

        <div class="mb-3 row align-items-center">
            <label for="photo" class="col-sm-3 col-form-label">Photo de profil</label>
            <div class="col-sm-9">
                <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
            </div>
        </div>

        <div class="mb-3 row align-items-center">
            <label for="password" class="col-sm-3 col-form-label">Mot de passe *</label>
            <div class="col-sm-9">
                <input type="password" name="password" id="password" class="form-control" required minlength="6" placeholder="Mot de passe">
            </div>
        </div>

        <div class="mb-3 row align-items-center">
            <label for="password_confirmation" class="col-sm-3 col-form-label">Confirmer le mot de passe *</label>
            <div class="col-sm-9">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required minlength="6" placeholder="Confirmation mot de passe">
            </div>
        </div>

        <div class="mb-3 row align-items-center">
    <label for="role" class="col-sm-3 col-form-label">Rôle *</label>
    <div class="col-sm-9">
        <select name="role" id="role" class="form-select" required>
            <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Sélectionner un rôle --</option>
            <option value="etudiant" {{ old('role') == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
            <option value="comptable" {{ old('role') == 'comptable' ? 'selected' : '' }}>Comptable</option>
        </select>
    </div>
</div>


        <div class="mb-3 row">
            <div class="offset-sm-3 col-sm-9">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Créer
                </button>
                <a href="{{ route('administration.utilisateurs.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </div>

    </form>
</div>
@endsection
