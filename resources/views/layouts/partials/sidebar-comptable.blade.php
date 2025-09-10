<div class="w-64 bg-white border-r fixed h-full flex flex-col">
    <!-- Logo -->
    <div class="p-4 border-b flex items-center justify-center">
        <img src="{{ asset('storage/logo-universite.png') }}" alt="Logo Université" class="h-12 w-auto">
    </div>

    <!-- Menu -->
    <nav class="flex-1 overflow-y-auto">
        <div class="space-y-1 mt-4">
            <!-- Dashboard -->
            <a href="{{ route('comptable.dashboard') }}"
               class="{{ request()->routeIs('comptable.dashboard') ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-transparent text-gray-600' }} flex items-center px-4 py-3 border-l-4 hover:bg-blue-50 transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Dashboard
            </a>

            <!-- Paiements en Attente -->
            <a href="{{ route('comptable.paiements') }}"
               class="{{ request()->routeIs('comptable.paiements*') ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-transparent text-gray-600' }} flex items-center px-4 py-3 border-l-4 hover:bg-blue-50 transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Paiements en Attente
            </a>

            <!-- Historique -->
            <a href="{{ route('comptable.historique') }}"
               class="{{ request()->routeIs('comptable.historique*') ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-transparent text-gray-600' }} flex items-center px-4 py-3 border-l-4 hover:bg-blue-50 transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                Historique
            </a>

            <!-- Rapports -->
            <a href="{{ route('comptable.rapports') }}"
               class="{{ request()->routeIs('comptable.rapports*') ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-transparent text-gray-600' }} flex items-center px-4 py-3 border-l-4 hover:bg-blue-50 transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Générer Rapports
            </a>
        </div>
    </nav>

    <!-- Footer -->
    <div class="p-4 border-t">
        <div class="flex items-center">
            <img class="h-8 w-8 rounded-full" src="{{ Auth::user()->photo_url ?? asset('images/default-avatar.png') }}" alt="Photo profil">
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-700">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</p>
                <p class="text-xs text-gray-500">Comptable</p>
            </div>
        </div>
    </div>
</div>
