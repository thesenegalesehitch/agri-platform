<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="text-lg font-semibold text-green-700">AgriPlatform</a>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                        À propos
                    </x-nav-link>
                    <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                        Contact
                    </x-nav-link>
                    <x-nav-link :href="route('support')" :active="request()->routeIs('support')">
                        Support
                    </x-nav-link>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>
                    @role('producer')
                        <x-nav-link :href="route('products.index')" :active="request()->is('products*')">
                            Produits
                        </x-nav-link>
                    @endrole
                    @role('equipment_owner')
                        <x-nav-link :href="route('equipment.index')" :active="request()->is('equipment*')">
                            Matériels
                        </x-nav-link>
                        <x-nav-link :href="route('rentals.index')" :active="request()->is('rentals*')">
                            Locations
                        </x-nav-link>
                    @endrole
                    @role('buyer')
                        <x-nav-link :href="route('orders.index')" :active="request()->is('orders*')">
                            Commandes
                        </x-nav-link>
                        <x-nav-link :href="route('cart.index')" :active="request()->is('cart')">
                            Panier
                        </x-nav-link>
                    @endrole
                    @role('admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->is('admin')">
                            Admin
                        </x-nav-link>
                    @endrole
                </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                Profil
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    Déconnexion
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>
</nav>
