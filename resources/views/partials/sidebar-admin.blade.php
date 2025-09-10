<div class="w-64 bg-gray-900 border-r fixed h-full flex flex-col">
    

    <!-- Menu -->
    <nav class="flex-1 overflow-y-auto">
        <div class="space-y-1 mt-4">
            <!-- Dashboard -->
            <a href="{{ route('administration.dashboard') }}"
               class="{{ request()->routeIs('administration.dashboard') ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-transparent text-gray-600' }} flex items-center px-4 py-3 border-l-4 hover:bg-blue-50 transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Dashboard
            </a>

            <!-- Gestion Utilisateurs -->
            <a href="{{ route('administration.utilisateurs.index') }}"
               class="{{ request()->routeIs('administration.utilisateurs*') ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-transparent text-gray-600' }} flex items-center px-4 py-3 border-l-4 hover:bg-blue-50 transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Gérer Utilisateurs
            </a>

            <!-- Validation Inscriptions -->
            <a href="{{ route('administration.inscriptions.index') }}"
               class="{{ request()->routeIs('administration.inscriptions*') ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-transparent text-gray-600' }} flex items-center px-4 py-3 border-l-4 hover:bg-blue-50 transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Valider Inscriptions
            </a>

            <!-- Gestion Classes -->
            <a href="{{ route('administration.classes.index') }}"
               class="{{ request()->routeIs('administration.classes*') ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-transparent text-gray-600' }} flex items-center px-4 py-3 border-l-4 hover:bg-blue-50 transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Gérer Classes
            </a>
        </div>
    </nav>

    <!-- Footer -->
    <div class="p-4 border-t">
        <div class="flex items-center">
            <img class="h-8 w-8 rounded-full" src="{{ Auth::user()->photo_url ?? asset('images/default-avatar.png') }}" alt="Photo profil">
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-700">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</p>
                <p class="text-xs text-gray-500">Administrateur</p>
            </div>
        </div>
    </div>
</div>
