@extends('layouts.app')

@section('title', 'Validation des paiements')

@section('content')
<div class="page-header">
    <h1>Validation des paiements</h1>
    <div class="breadcrumb">
        <a href="{{ route('administration.dashboard') }}">Tableau de bord</a> &raquo; Validation des paiements
    </div>
</div>

<div class="card">
    <div class="card-body">
        <p>Liste des paiements en attente de validation :</p>

        {{-- Exemple de tableau --}}
        <table class="table">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Montant</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach($paiements as $paiement) --}}
                <tr>
                    <td>PAI-0001</td>
                    <td>50 000 FCFA</td>
                    <td>2025-08-12</td>
                    <td>
                        <a href="#" class="btn btn-success btn-sm">Valider</a>
                        <a href="#" class="btn btn-danger btn-sm">Rejeter</a>
                    </td>
                </tr>
                {{-- @endforeach --}}
            </tbody>
        </table>
    </div>
</div>
@endsection
