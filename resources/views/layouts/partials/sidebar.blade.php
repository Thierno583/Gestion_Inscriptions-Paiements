@php
    $role = Auth::user()?->role->nom ?? null;
@endphp

@if ($role === 'etudiant')
    @include('partials.sidebar-etudiant')
@elseif ($role === 'administrateur')
    @include('partials.sidebar-admin')
@elseif ($role === 'comptable')
    @include('partials.sidebar-comptable')
@else
    <div class="alert alert-danger">Aucune sidebar pour ce rôle.</div>
@endif
