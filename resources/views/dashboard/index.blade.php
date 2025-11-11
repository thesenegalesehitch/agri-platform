<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">Dashboard</h2>
	</x-slot>

	<div class="mb-8 fade-in">
		<h2 class="section-title-agri">Bienvenue sur votre tableau de bord</h2>
		<p class="text-[#55493f]">Suivez vos équipements et vos demandes de location en toute simplicité.</p>
	</div>

	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
		@if($equipmentCount !== null)
			<div class="content-card fade-in">
				<div class="flex items-center">
					<div class="p-3 bg-blue-100 rounded-full">
						<span class="text-2xl">🚜</span>
					</div>
					<div class="ml-4">
						<p class="text-sm font-medium text-[#55493f]">Équipements</p>
						<p class="text-2xl font-bold text-[#5c4033]">{{ $equipmentCount }}</p>
					</div>
				</div>
			</div>
		@endif
		@if($ownerRentalsCount !== null)
			<div class="content-card fade-in">
				<div class="flex items-center">
					<div class="p-3 bg-yellow-100 rounded-full">
						<span class="text-2xl">🤝</span>
					</div>
					<div class="ml-4">
						<p class="text-sm font-medium text-[#55493f]">Demandes de location reçues</p>
						<p class="text-2xl font-bold text-[#5c4033]">{{ $ownerRentalsCount }}</p>
					</div>
				</div>
			</div>
		@endif
		@if($renterRentalsCount !== null)
			<div class="content-card fade-in">
				<div class="flex items-center">
					<div class="p-3 bg-green-100 rounded-full">
						<span class="text-2xl">📅</span>
					</div>
					<div class="ml-4">
						<p class="text-sm font-medium text-[#55493f]">Mes locations</p>
						<p class="text-2xl font-bold text-[#5c4033]">{{ $renterRentalsCount }}</p>
					</div>
				</div>
			</div>
		@endif
	</div>

	<div class="content-card fade-in">
		<div class="text-center">
			<h3 class="section-title-agri">Actions Rapides</h3>
			<p class="text-[#55493f] mb-6">Accédez rapidement aux fonctionnalités de votre profil.</p>
			<div class="flex flex-wrap justify-center gap-4">
				@role('producer')
					<a href="{{ route('equipment.index') }}" class="btn-primary-agri">🚜 Voir les équipements</a>
					<a href="{{ route('rentals.index') }}" class="btn-secondary-agri">📅 Suivre mes locations</a>
				@endrole
				@role('equipment_owner')
					<a href="{{ route('equipment.create') }}" class="btn-primary-agri">➕ Créer un Équipement</a>
					<a href="{{ route('equipment.index') }}" class="btn-secondary-agri">🚜 Mes Équipements</a>
					<a href="{{ route('rentals.index') }}" class="btn-secondary-agri">📋 Mes Locations</a>
				@endrole
				@role('admin')
					<a href="{{ route('admin.dashboard') }}" class="btn-danger-agri">⚙️ Administration</a>
					<a href="{{ route('admin.users.index') }}" class="btn-secondary-agri">👥 Gestion Utilisateurs</a>
				@endrole
			</div>
		</div>
	</div>
</x-app-layout>
