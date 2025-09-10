<a href="{{ route('etudiant.dashboard') }}" class="{{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}">
    <i class="fas fa-tachometer-alt"></i>
    <span>Tableau de bord</span>
</a>

<a href="{{ route('etudiant.inscription') }}" class="{{ request()->routeIs('etudiant.inscription') ? 'active' : '' }}">
    <i class="fas fa-file-alt"></i>
    <span>Inscription aux cours</span>
</a>

<a href="{{ route('etudiant.paiement') }}" class="{{ request()->routeIs('etudiant.paiement') ? 'active' : '' }}">
    <i class="fas fa-money-bill-wave"></i>
    <span>Mes paiements</span>
</a>

<a href="{{ route('etudiant.profil') }}" class="{{ request()->routeIs('etudiant.profil') ? 'active' : '' }}">
    <i class="fas fa-user-circle"></i>
    <span>Mon profil</span>
</a>
