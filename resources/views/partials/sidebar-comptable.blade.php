<div class="w-64 bg-blue-900 border-r fixed h-full flex flex-col">
    <!-- Logo -->
    

    <!-- Menu -->
    <nav class="flex-1 overflow-y-auto menu mt-4 pb-20">
        <div class="space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('comptable.dashboard') }}"
               class="{{ request()->routeIs('comptable.dashboard') ? 'border-green-500 bg-green-50 text-green-700' : 'border-transparent text-white' }} flex items-center px-4 py-3 border-l-4 hover:bg-red-600 hover:text-white transition-colors">
                <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                Dashboard
            </a>

            <!-- Paiements en Attente -->
            <a href="{{ route('comptable.paiements.index') }}"
               class="{{ request()->routeIs('comptable.paiements*') ? 'border-green-500 bg-green-50 text-green-700' : 'border-transparent text-white' }} flex items-center px-4 py-3 border-l-4 hover:bg-red-600 hover:text-white transition-colors">
                <i class="fas fa-credit-card w-5 h-5 mr-3"></i>
                Paiements en Attente
            </a>

            <!-- Historique -->
            <a href="{{ route('comptable.historique.index') }}"
               class="{{ request()->routeIs('comptable.historique*') ? 'border-green-500 bg-green-50 text-green-700' : 'border-transparent text-white' }} flex items-center px-4 py-3 border-l-4 hover:bg-red-600 hover:text-white transition-colors">
                <i class="fas fa-history w-5 h-5 mr-3"></i>
                Historique
            </a>
        </div>
    </nav>

    <!-- Footer -->
    <div class="mt-auto p-4 border-t border-white/10 flex items-center text-white">
        <i class="fas fa-calculator text-2xl mr-3"></i>
        <div>
            <p class="font-medium m-0">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</p>
            <p class="text-sm opacity-80 m-0">Comptable</p>
        </div>
    </div>
</div>
