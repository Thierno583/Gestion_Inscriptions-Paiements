@extends('layouts.app')

@section('title', 'Détails de la classe')

@section('content')
<div class="page-header">
    <h1>Détails de la classe : {{ $classe->libelle }}</h1>
    <div>
        <strong>Description:</strong> {{ $classe->description }}
    </div>
    <div>
        <strong>Frais d'inscription:</strong> {{ number_format($classe->frais_inscription, 0, ',', ' ') }} FCFA
    </div>
    <div>
        <strong>Frais de mensualité:</strong> {{ number_format($classe->frais_mensualite, 0, ',', ' ') }} FCFA
    </div>
    <div>
        <strong>Frais de soutenance:</strong> {{ number_format($classe->frais_soutenance, 0, ',', ' ') }} FCFA
    </div>
    <a href="{{ route('administration.classes.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>
@endsection
