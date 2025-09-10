@php
    $role = strtolower(Auth::user()->role ?? '');
@endphp

<p>Role actuel: {{ $role }}</p>

@if ($role === 'etudiant')
    @include('partials.sidebar-etudiant')
@elseif ($role === 'comptable')
    @include('partials.sidebar-comptable')
@elseif ($role === 'admin')  
    @include('partials.sidebar-admin')
@else
    <p class="text-danger">Aucun menu disponible pour ce rôle: {{ $role }}</p>
@endif
