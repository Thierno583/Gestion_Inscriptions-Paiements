@extends('layouts.app')

@section('title', 'Modifier la classe')

@section('content')
<h1>Modifier la classe</h1>

<form action="{{ route('administration.classes.edit', $classe->id) }}" method="POST" style="max-width: 500px;">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="libelle">Libellé de la classe</label>
        <input type="text" name="libelle" id="libelle" class="form-control" value="{{ old('libelle', $classe->libelle) }}" required>
        @error('libelle')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mt-3">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $classe->description) }}</textarea>
        @error('description')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mt-3">
        <label for="frais_inscription">Frais d'inscription</label>
        <input type="number" name="frais_inscription" id="frais_inscription" class="form-control" value="{{ old('frais_inscription', $classe->frais_inscription) }}" min="0">
        @error('frais_inscription')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mt-3">
        <label for="frais_mensualite">Frais de mensualité</label>
        <input type="number" name="frais_mensualite" id="frais_mensualite" class="form-control" value="{{ old('frais_mensualite', $classe->frais_mensualite) }}" min="0">
        @error('frais_mensualite')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mt-3">
        <label for="frais_soutenance">Frais de soutenance</label>
        <input type="number" name="frais_soutenance" id="frais_soutenance" class="form-control" value="{{ old('frais_soutenance', $classe->frais_soutenance) }}" min="0">
        @error('frais_soutenance')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary mt-3">Mettre à jour la classe</button>
</form>
@endsection
