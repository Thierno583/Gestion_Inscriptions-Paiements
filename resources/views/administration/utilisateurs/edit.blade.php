@extends('layouts.app')

@section('title', 'Modifier un utilisateur')

@section('content')
<div class="container mt-4" style="max-width: 700px;">
    <div class="page-header mb-4">
        <h1>Modifier un utilisateur</h1>
        <div class="breadcrumb">
            <a href="{{ route('administration.utilisateurs.index') }}">Utilisateurs</a> &raquo; Édition
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

    <form action="{{ route('administration.utilisateurs.update', $user->id) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        <!-- Nom -->
        <div class="mb-3 row align-items-center">
            <label for="nom" class="col-sm-3 col-form-label">Nom *</label>
            <div class="col-sm-9">
                <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $user->personne?->nom) }}" required maxlength="100">
            </div>
        </div>

        <!-- Prénom -->
        <div class="mb-3 row align-items-center">
            <label for="prenom" class="col-sm-3 col-form-label">Prénom *</label>
            <div class="col-sm-9">
                <input type="text" name="prenom" id="prenom" class="form-control" value="{{ old('prenom', $user->personne?->prenom) }}" required maxlength="100">
            </div>
        </div>

        <!-- Nom d'utilisateur -->
        <div class="mb-3 row align-items-center">
            <label for="nom_d_utilisateur" class="col-sm-3 col-form-label">Nom d'utilisateur *</label>
            <div class="col-sm-9">
                <input type="text" name="nom_d_utilisateur" id="nom_d_utilisateur" class="form-control" value="{{ old('nom_d_utilisateur', $user->personne?->nom_d_utilisateur) }}" required maxlength="50">
            </div>
        </div>

        <!-- Email -->
        <div class="mb-3 row align-items-center">
            <label for="email" class="col-sm-3 col-form-label">Email *</label>
            <div class="col-sm-9">
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required maxlength="150">
            </div>
        </div>

        <!-- Téléphone -->
        <div class="mb-3 row align-items-center">
            <label for="telephone" class="col-sm-3 col-form-label">Téléphone</label>
            <div class="col-sm-9">
                <input type="tel" name="telephone" id="telephone" class="form-control" value="{{ old('telephone', $user->personne?->telephone) }}" maxlength="20">
            </div>
        </div>

        <!-- Date de naissance -->
        <div class="mb-3 row align-items-center">
            <label for="date_de_naissance" class="col-sm-3 col-form-label">Date de naissance</label>
            <div class="col-sm-9">
                <input type="date" name="date_de_naissance" id="date_de_naissance" class="form-control" value="{{ old('date_de_naissance', $user->personne?->date_de_naissance) }}">
            </div>
        </div>

        <!-- Adresse -->
        <div class="mb-3 row align-items-center">
            <label for="adresse" class="col-sm-3 col-form-label">Adresse</label>
            <div class="col-sm-9">
                <textarea name="adresse" id="adresse" class="form-control" rows="3">{{ old('adresse', $user->personne?->adresse) }}</textarea>
            </div>
        </div>

        <!-- CNI -->
       <!-- <div class="mb-3 row align-items-center">
            <label for="cni" class="col-sm-3 col-form-label">N° CNI</label>
            <div class="col-sm-9">
                <input type="text" name="cni" id="cni" class="form-control" value="{{ old('cni', $user->personne?->cni) }}" maxlength="100">
            </div>
        </div> -->

        <!-- Photo -->
        <div class="mb-3 row align-items-center">
            <label for="photo" class="col-sm-3 col-form-label">Photo de profil</label>
            <div class="col-sm-9">
                @if($user->photo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $user->personne?->photo) }}" alt="Photo actuelle" style="max-height: 80px; border-radius: 4px;">
                    </div>
                @endif
                <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
            </div>
        </div>

        <!-- Mot de passe -->
        <div class="mb-3 row align-items-center">
            <label for="password" class="col-sm-3 col-form-label">Mot de passe</label>
            <div class="col-sm-9">
                <input type="password" name="password" id="password" class="form-control" minlength="6" placeholder="Laisser vide pour ne pas changer">
            </div>
        </div>

        <!-- Confirmation mot de passe -->
        <div class="mb-3 row align-items-center">
            <label for="password_confirmation" class="col-sm-3 col-form-label">Confirmer mot de passe</label>
            <div class="col-sm-9">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" minlength="6" placeholder="Confirmez le mot de passe">
            </div>
        </div>

        <!-- Rôle -->
        <div class="mb-3 row align-items-center">
            <label for="role" class="col-sm-3 col-form-label">Rôle *</label>
            <div class="col-sm-9">
                <select name="role" id="role" class="form-select" required>
                    <option value="" disabled>-- Sélectionner un rôle --</option>
                    <option value="etudiant" {{ old('role', $user->role) == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                    <option value="administrateur" {{ old('role', $user->role) == 'administrateur' ? 'selected' : '' }}>Administrateur</option>
                    <option value="comptable" {{ old('role', $user->role) == 'comptable' ? 'selected' : '' }}>Comptable</option>
                </select>
            </div>
        </div>

        <!-- Boutons -->
        <div class="mb-3 row">
            <div class="offset-sm-3 col-sm-9">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Mettre à jour
                </button>
                <a href="{{ route('administration.utilisateurs.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </div>

    </form>
</div>
@endsection
