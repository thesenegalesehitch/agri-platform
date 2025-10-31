<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">Dashboard</h2>
	</x-slot>

	<div class="mb-8 fade-in">
		<h2 class="section-title-agri">Bienvenue sur votre tableau de bord</h2>
		<p class="text-[#55493f]">Gérez vos produits, équipements et transactions en toute simplicité.</p>
	</div>

	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
		@if($productsCount !== null)
			<div class="content-card fade-in">
				<div class="flex items-center">
					<div class="p-3 bg-green-100 rounded-full">
						<span class="text-2xl">🌾</span>
					</div>
					<div class="ml-4">
						<p class="text-sm font-medium text-[#55493f]">Produits</p>
						<p class="text-2xl font-bold text-[#5c4033]">{{ $productsCount }}</p>
					</div>
				</div>
			</div>
		@endif
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
		@if($ordersCount !== null)
			<div class="content-card fade-in">
				<div class="flex items-center">
					<div class="p-3 bg-yellow-100 rounded-full">
						<span class="text-2xl">📦</span>
					</div>
					<div class="ml-4">
						<p class="text-sm font-medium text-[#55493f]">Commandes</p>
						<p class="text-2xl font-bold text-[#5c4033]">{{ $ordersCount }}</p>
					</div>
				</div>
			</div>
		@endif
		@if($rentalsCount !== null)
			<div class="content-card fade-in">
				<div class="flex items-center">
					<div class="p-3 bg-purple-100 rounded-full">
						<span class="text-2xl">🔧</span>
					</div>
					<div class="ml-4">
						<p class="text-sm font-medium text-[#55493f]">Locations</p>
						<p class="text-2xl font-bold text-[#5c4033]">{{ $rentalsCount }}</p>
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
					<a href="{{ route('products.create') }}" class="btn-primary-agri">➕ Créer un Produit</a>
					<a href="{{ route('products.index') }}" class="btn-secondary-agri">📦 Mes Produits</a>
				@endrole
				@role('equipment_owner')
					<a href="{{ route('equipment.create') }}" class="btn-primary-agri">➕ Créer un Équipement</a>
					<a href="{{ route('equipment.index') }}" class="btn-secondary-agri">🚜 Mes Équipements</a>
					<a href="{{ route('rentals.index') }}" class="btn-secondary-agri">📋 Mes Locations</a>
				@endrole
				@role('buyer')
					<a href="{{ route('products.index') }}" class="btn-primary-agri">🛒 Voir les Produits</a>
					<a href="{{ route('equipment.index') }}" class="btn-secondary-agri">🚜 Voir les Équipements</a>
					<a href="{{ route('cart.index') }}" class="btn-primary-agri">🛒 Mon Panier</a>
					<a href="{{ route('orders.index') }}" class="btn-secondary-agri">📦 Mes Commandes</a>
				@endrole
				@role('admin')
					<a href="{{ route('admin.dashboard') }}" class="btn-danger-agri">⚙️ Administration</a>
					<a href="{{ route('admin.users.index') }}" class="btn-secondary-agri">👥 Gestion Utilisateurs</a>
				@endrole
			</div>
		</div>
	</div>
</x-app-layout>
