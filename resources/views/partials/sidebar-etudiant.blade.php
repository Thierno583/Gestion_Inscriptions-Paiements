<div class="sidebar-content" style="width: 16rem; background-color: #fff; border-right: 1px solid #ddd; position: fixed; height: 100%; display: flex; flex-direction: column;">
    <!-- Logo -->
    

    <!-- Menu principal -->
    <nav class="menu" style="flex: 1; overflow-y: auto;">
        <!-- Groupe Menu -->
        <div style="margin-top: 1rem;">
            <!-- Item Actif (dynamique) -->
            <a href="{{ route('etudiant.dashboard') }}"
               class="{{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}" style="display: flex; align-items: center; padding: 0.5rem 1rem; border-left: 4px solid #fff;">
                <i class="fas fa-tachometer-alt" style="font-size: 1.25rem; margin-right: 0.5rem;"></i>
                Tableau de bord
            </a>

            <!-- Item Inscriptions -->
            <a href="{{ route('etudiant.inscriptions.index') }}"
               class="{{ request()->routeIs('etudiant.inscriptions*') ? 'active' : '' }}" style="display: flex; align-items: center; padding: 0.5rem 1rem; border-left: 4px solid #fff;">
                <i class="fas fa-clipboard-list" style="font-size: 1.25rem; margin-right: 0.5rem;"></i>
                Mes Inscriptions
            </a>

            <!-- Item Paiements -->
            <a href="{{ route('etudiant.paiements.index') }}"
               class="{{ request()->routeIs('etudiant.paiements*') ? 'active' : '' }}" style="display: flex; align-items: center; padding: 0.5rem 1rem; border-left: 4px solid #fff;">
                <i class="fas fa-credit-card" style="font-size: 1.25rem; margin-right: 0.5rem;"></i>
                Mes Paiements
            </a>
        </div>
    </nav>

    <!-- Pied de menu -->
    <div style="position: absolute; bottom: 0; width: 100%; padding: 1rem; border-top: 1px solid #ddd;">
        <div style="display: flex; align-items: center; color: #333;">
            <i class="fas fa-user-circle" style="font-size: 2rem; margin-right: 0.8rem;"></i>
            <div>
                <p style="font-weight: 500; margin: 0;">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</p>
                <p style="font-size: 0.8rem; opacity: 0.8; margin: 0;">Étudiant</p>
            </div>
        </div>
    </div>
</div>
