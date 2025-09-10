<a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <i class="fas fa-tachometer-alt"></i>
    <span>Tableau de bord</span>
</a>

<a href="{{ route('admin.utilisateurs.index') }}" class="{{ request()->routeIs('admin.utilisateurs.*') ? 'active' : '' }}">
    <i class="fas fa-users"></i>
    <span>Gestion utilisateurs</span>
</a>

<a href="{{ route('admin.classes.index') }}" class="{{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">
    <i class="fas fa-book"></i>
    <span>Gestion classes</span>
</a>

<a href="{{ route('admin.inscriptions.index') }}" class="{{ request()->routeIs('admin.inscriptions.*') ? 'active' : '' }}">
    <i class="fas fa-file-signature"></i>
    <span>Validation inscriptions</span>
</a>

<a href="{{ route('admin.paiements.index') }}" class="{{ request()->routeIs('admin.paiements.*') ? 'active' : '' }}">
    <i class="fas fa-money-check-alt"></i>
    <span>Suivi paiements</span>
</a>
