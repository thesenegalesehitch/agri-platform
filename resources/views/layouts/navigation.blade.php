<nav class="nav-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="text-lg font-bold text-white flex items-center gap-2">
                        <span class="text-2xl">🌾</span>
                        <span>AgriPlatform</span>
                    </a>
                </div>
                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('products.index')" :active="request()->is('products*')" class="text-white hover:text-green-300">
                        Produits
                    </x-nav-link>
                    <x-nav-link :href="route('equipment.index')" :active="request()->is('equipment*')" class="text-white hover:text-green-300">
                        Équipements
                    </x-nav-link>
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-green-300">
                            Dashboard
                        </x-nav-link>
                        @role('producer')
                            <x-nav-link :href="route('products.index')" :active="request()->is('products*')" class="text-white hover:text-green-300">
                                Mes Produits
                            </x-nav-link>
                        @endrole
                        @role('equipment_owner')
                            <x-nav-link :href="route('equipment.index')" :active="request()->is('equipment*')" class="text-white hover:text-green-300">
                                Mes Matériels
                            </x-nav-link>
                            <x-nav-link :href="route('rentals.index')" :active="request()->is('rentals*')" class="text-white hover:text-green-300">
                                Locations
                            </x-nav-link>
                        @endrole
                        @role('buyer')
                            <x-nav-link :href="route('orders.index')" :active="request()->is('orders*')" class="text-white hover:text-green-300">
                                Commandes
                            </x-nav-link>
                            <x-nav-link :href="route('cart.index')" :active="request()->is('cart')" class="text-white hover:text-green-300">
                                Panier
                            </x-nav-link>
                        @endrole
                        @role('admin')
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->is('admin*')" class="text-white hover:text-green-300">
                                Admin
                            </x-nav-link>
                        @endrole
                    @endauth
                </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button 
                            @click="open = !open" 
                            @click.away="open = false"
                            class="flex items-center gap-2 text-white hover:text-green-300 transition-colors focus:outline-none"
                        >
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center font-bold text-lg ring-2 ring-white/30 hover:ring-white/50 transition-all">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div 
                            x-show="open"
                            x-cloak
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl py-1 z-50 border border-[#d0c9c0]"
                        >
                            <div class="px-4 py-2 border-b border-[#d0c9c0]">
                                <p class="text-sm font-semibold text-[#5c4033]">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-[#55493f]">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-[#5c4033] hover:bg-[#f8f6f3] transition-colors">
                                <span>👤</span>
                                <span>Mon Profil</span>
                            </a>
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-[#5c4033] hover:bg-[#f8f6f3] transition-colors">
                                <span>📊</span>
                                <span>Dashboard</span>
                            </a>
                            <hr class="my-1 border-[#d0c9c0]">
                            <a href="{{ route('contact') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-[#5c4033] hover:bg-[#f8f6f3] transition-colors">
                                <span>📞</span>
                                <span>Contact</span>
                            </a>
                            <a href="{{ route('support') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-[#5c4033] hover:bg-[#f8f6f3] transition-colors">
                                <span>❓</span>
                                <span>Support</span>
                            </a>
                            <a href="{{ route('about') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-[#5c4033] hover:bg-[#f8f6f3] transition-colors">
                                <span>ℹ️</span>
                                <span>À propos</span>
                            </a>
                            <hr class="my-1 border-[#d0c9c0]">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <span>🚪</span>
                                    <span>Déconnexion</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex space-x-3">
                        <a href="{{ route('login') }}" class="text-white hover:text-green-300 px-3 py-2 text-sm font-medium transition-colors">
                            Connexion
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary-agri">
                                Inscription
                            </a>
                        @endif
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
