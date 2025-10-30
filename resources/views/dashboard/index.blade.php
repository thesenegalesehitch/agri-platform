<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Dashboard
		</h2>
	</x-slot>

	<div class="py-8">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="mb-8">
				<h2 class="text-2xl font-bold text-gray-800 mb-2">Bienvenue sur votre tableau de bord</h2>
				<p class="text-gray-600">Gérez vos produits, équipements et transactions en toute simplicité.</p>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
				@if($productsCount !== null)
					<div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition-shadow">
						<div class="flex items-center">
							<div class="p-3 bg-green-100 rounded-full">
								<span class="text-2xl">🌾</span>
							</div>
							<div class="ml-4">
								<p class="text-sm font-medium text-gray-600">Produits</p>
								<p class="text-2xl font-bold text-gray-900">{{ $productsCount }}</p>
							</div>
						</div>
					</div>
				@endif
				@if($equipmentCount !== null)
					<div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition-shadow">
						<div class="flex items-center">
							<div class="p-3 bg-blue-100 rounded-full">
								<span class="text-2xl">🚜</span>
							</div>
							<div class="ml-4">
								<p class="text-sm font-medium text-gray-600">Équipements</p>
								<p class="text-2xl font-bold text-gray-900">{{ $equipmentCount }}</p>
							</div>
						</div>
					</div>
				@endif
				@if($ordersCount !== null)
					<div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition-shadow">
						<div class="flex items-center">
							<div class="p-3 bg-yellow-100 rounded-full">
								<span class="text-2xl">📦</span>
							</div>
							<div class="ml-4">
								<p class="text-sm font-medium text-gray-600">Commandes</p>
								<p class="text-2xl font-bold text-gray-900">{{ $ordersCount }}</p>
							</div>
						</div>
					</div>
				@endif
				@if($rentalsCount !== null)
					<div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition-shadow">
						<div class="flex items-center">
							<div class="p-3 bg-purple-100 rounded-full">
								<span class="text-2xl">🔧</span>
							</div>
							<div class="ml-4">
								<p class="text-sm font-medium text-gray-600">Locations</p>
								<p class="text-2xl font-bold text-gray-900">{{ $rentalsCount }}</p>
							</div>
						</div>
					</div>
				@endif
			</div>

			<div class="bg-white shadow-lg rounded-lg p-8">
				<div class="text-center">
					<img src="/images/pexels-enginakyurt-1435904.jpg" alt="Agriculture moderne" class="w-full h-64 object-cover rounded-lg mb-6" />
					<h3 class="text-xl font-semibold text-gray-800 mb-4">Plateforme Agri-Platform Sénégal</h3>
					<p class="text-gray-600 mb-6">Connectez-vous avec l'agriculture moderne du Sénégal. Gérez vos produits et équipements efficacement.</p>
					<div class="flex flex-wrap justify-center gap-4">
						<a href="{{ route('products.index') }}" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">Voir mes Produits</a>
						<a href="{{ route('equipment.index') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Voir mes Équipements</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>
