<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title-agri">{{ __('Profile') }}</h2>
    </x-slot>

    <div class="space-y-6">
        <div class="content-card fade-in">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="content-card fade-in">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="content-card fade-in">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="content-card fade-in">
                <h3 class="section-title-agri">Rôles</h3>
                <p class="text-sm text-[#55493f] mb-4">{{ implode(', ', auth()->user()->getRoleNames()->toArray()) ?: 'Aucun' }}</p>
                <p class="text-sm">Statut: <span class="font-medium text-[#5c4033]">{{ auth()->user()->is_suspended ? 'Suspendu' : 'Actif' }}</span></p>
            </div>

            @role('producer')
            <div class="content-card fade-in">
				<h3 class="section-title-agri">Espace Producteur</h3>
				<p class="text-sm text-[#55493f] mb-3">Accédez aux matériels disponibles et suivez vos demandes de location.</p>
                <div class="flex flex-wrap gap-2">
					<a href="{{ route('equipment.index') }}" class="btn-primary-agri" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Voir les matériels</a>
					<a href="{{ route('rentals.index') }}" class="btn-secondary-agri" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Mes locations</a>
                </div>
            </div>
            @endrole

            @role('equipment_owner')
            <div class="content-card fade-in">
                <h3 class="section-title-agri">Espace Propriétaire matériel</h3>
                <p class="text-sm text-[#55493f] mb-3">Gérer vos matériels et disponibilités.</p>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('equipment.index') }}" class="btn-primary-agri" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Mes matériels</a>
                    <a href="{{ route('equipment.create') }}" class="btn-secondary-agri" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Nouveau matériel</a>
                    <a href="{{ route('rentals.index') }}" class="btn-secondary-agri" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Mes locations</a>
                </div>
            </div>
            @endrole

            <div class="content-card fade-in">
                <h3 class="section-title-agri">Compte & Sécurité</h3>
                <p class="text-sm text-[#55493f] mb-3">Gérez vos informations, mot de passe et sécurité.</p>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('profile.edit') }}" class="btn-primary-agri" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Modifier profil</a>
                    <a href="{{ route('suspension-requests.index') }}" class="btn-danger-agri" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Réactivation</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
