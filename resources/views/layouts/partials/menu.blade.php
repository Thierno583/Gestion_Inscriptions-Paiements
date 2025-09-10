@php
    $role = Auth::user()->role->nom ?? null;
@endphp

@if ($role === 'etudiant')
    @include('partials.sidebar-etudiant')
@elseif ($role === 'comptable')
    @include('partials.sidebar-comptable')
@elseif ($role === 'administrateur')
    @include('partials.sidebar-admin')
@else
    <p class="text-danger">Aucun menu disponible pour ce rôle.</p>
@endif
