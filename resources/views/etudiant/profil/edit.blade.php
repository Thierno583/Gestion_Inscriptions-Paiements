@extends('layouts.app')

@section('title', 'Modifier mon profil')

@section('content')
<div class="container">
    <h1>Modifier mes informations</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('etudiant.profil.update') }}">
        @csrf
        @method('patch')

        <!-- Nom -->
        <div class="form-group">
            <label for="name">Nom complet</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="form-control" required>
        </div>

        <!-- Email -->
        <div class="form-group mt-3">
            <label for="email">Adresse e-mail</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="form-control" required>
        </div>

        <!-- Mot de passe -->
        <div class="form-group mt-3">
            <label for="password">Nouveau mot de passe (laisser vide si inchangé)</label>
            <input id="password" name="password" type="password" class="form-control">
        </div>

        <div class="form-group mt-2">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
        <a href="{{ route('etudiant.dashboard') }}" class="btn btn-secondary mt-3">Retour au tableau de bord</a>
    </form>
</div>
@endsection
