<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="p-6 bg-white shadow sm:rounded-lg">
                    <h3 class="font-semibold mb-2">Rôles</h3>
                    <p class="text-sm text-gray-600">{{ implode(', ', auth()->user()->getRoleNames()->toArray()) ?: 'Aucun' }}</p>
                    <p class="mt-2 text-sm">Statut: <span class="font-medium">{{ auth()->user()->is_suspended ? 'Suspendu' : 'Actif' }}</span></p>
                </div>

                @role('producer')
                <div class="p-6 bg-white shadow sm:rounded-lg">
                    <h3 class="font-semibold mb-2">Espace Producteur</h3>
                    <p class="text-sm mb-3">Gérer vos produits et votre stock.</p>
                    <div class="space-x-2">
                        <a href="{{ route('products.index') }}" class="px-3 py-2 bg-blue-600 text-white rounded">Mes produits</a>
                        <a href="{{ route('products.create') }}" class="px-3 py-2 bg-gray-800 text-white rounded">Nouveau produit</a>
                    </div>
                </div>
                @endrole

                @role('equipment_owner')
                <div class="p-6 bg-white shadow sm:rounded-lg">
                    <h3 class="font-semibold mb-2">Espace Propriétaire matériel</h3>
                    <p class="text-sm mb-3">Gérer vos matériels et disponibilités.</p>
                    <div class="space-x-2">
                        <a href="{{ route('equipment.index') }}" class="px-3 py-2 bg-blue-600 text-white rounded">Mes matériels</a>
                        <a href="{{ route('equipment.create') }}" class="px-3 py-2 bg-gray-800 text-white rounded">Nouveau matériel</a>
                        <a href="{{ route('rentals.index') }}" class="px-3 py-2 bg-indigo-600 text-white rounded">Mes locations</a>
                    </div>
                </div>
                @endrole

                @role('buyer')
                <div class="p-6 bg-white shadow sm:rounded-lg">
                    <h3 class="font-semibold mb-2">Espace Acheteur</h3>
                    <p class="text-sm mb-3">Voir vos commandes et votre panier.</p>
                    <div class="space-x-2">
                        <a href="{{ route('orders.index') }}" class="px-3 py-2 bg-blue-600 text-white rounded">Mes commandes</a>
                        <a href="{{ route('cart.index') }}" class="px-3 py-2 bg-gray-800 text-white rounded">Mon panier</a>
                    </div>
                </div>
                @endrole

                <div class="p-6 bg-white shadow sm:rounded-lg">
                    <h3 class="font-semibold mb-2">Compte & Sécurité</h3>
                    <p class="text-sm mb-3">Gérez vos informations, mot de passe et sécurité.</p>
                    <div class="space-x-2">
                        <a href="{{ route('profile.edit') }}" class="px-3 py-2 bg-blue-600 text-white rounded">Modifier mon profil</a>
                        <a href="{{ route('suspension-requests.index') }}" class="px-3 py-2 bg-red-600 text-white rounded">Requête de réactivation</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
