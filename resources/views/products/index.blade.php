@php
	use Illuminate\Support\Facades\Storage;
	use Illuminate\Support\Str;
@endphp

<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">
			@auth
				@role('producer')
					Mes Produits
				@elserole('admin')
					Produits Disponibles
				@else
					Produits Disponibles
				@endrole
			@else
				Produits Disponibles
			@endauth
		</h2>
	</x-slot>

	<div class="content-card fade-in mb-6">
		<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
			@role('producer')
				<a href="{{ route('products.create') }}" class="btn-primary-agri">
					➕ Nouveau Produit
				</a>
			@endrole
			
			<form method="GET" action="{{ route('products.index') }}" class="flex flex-wrap items-center gap-2 flex-1" id="products-search-form">
				<div class="relative flex-1 min-w-[200px]" id="search-products-wrapper">
					<input 
						type="text"
						name="q" 
						id="search-products"
						value="{{ request('q') }}" 
						placeholder="Recherche produit, description, localité..." 
						class="form-input-agri w-full" 
						autocomplete="off"
					/>
					<div id="search-products-results" class="hidden absolute z-50 w-full mt-1 bg-white border border-[#d0c9c0] rounded-lg shadow-lg max-h-60 overflow-y-auto"></div>
				</div>
				<div class="relative min-w-[150px]" id="search-location-wrapper">
					<input 
						type="text"
						name="location" 
						id="search-location"
						value="{{ request('location') }}" 
						placeholder="Localité..." 
						class="form-input-agri w-full" 
						autocomplete="off"
					/>
					<div id="search-location-results" class="hidden absolute z-50 w-full mt-1 bg-white border border-[#d0c9c0] rounded-lg shadow-lg max-h-60 overflow-y-auto"></div>
				</div>
				<select name="category_id" class="form-select-agri min-w-[150px]">
					<option value="">Toutes catégories</option>
					@isset($categories)
						@foreach($categories as $cat)
							<option value="{{ $cat->id }}" {{ (string)$cat->id === (string)request('category_id') ? 'selected' : '' }}>{{ $cat->name }}</option>
						@endforeach
					@endisset
				</select>
				<input 
					type="number" 
					step="0.01" 
					name="min_price" 
					value="{{ request('min_price') }}" 
					placeholder="Min FCFA" 
					class="form-input-agri w-28" 
				/>
				<input 
					type="number" 
					step="0.01" 
					name="max_price" 
					value="{{ request('max_price') }}" 
					placeholder="Max FCFA" 
					class="form-input-agri w-28" 
				/>
				<button type="submit" class="btn-primary-agri">
					🔍 Filtrer
				</button>
			</form>
		</div>
	</div>

	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
		@foreach($products as $product)
			<div class="content-card fade-in hover:shadow-xl transition-shadow">
				@if($product->images && $product->images->count())
					@php $primaryImage = $product->images->firstWhere('is_primary', 1) ?? $product->images->first(); @endphp
					<div class="h-48 overflow-hidden rounded-lg mb-4">
						<img 
							src="{{ Storage::url($primaryImage->path) }}" 
							loading="lazy"
							decoding="async"
							class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" 
							alt="{{ $product->title }}"
							width="400"
							height="192"
						/>
					</div>
				@else
					<div class="h-48 bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center rounded-lg mb-4">
						<span class="text-4xl">🌾</span>
					</div>
				@endif
				<div>
					<h3 class="font-bold text-lg mb-2 text-[#5c4033]">{{ $product->title }}</h3>
					<p class="text-sm text-[#55493f] mb-3 line-clamp-2">{{ Str::limit($product->description, 100) }}</p>
					<div class="flex justify-between items-center mt-4">
						<span class="text-lg font-semibold text-[#4CAF50]">{{ number_format($product->price * 655.957, 0, ',', ' ') }} FCFA</span>
						<a href="{{ route('products.show',$product) }}" class="btn-primary-agri" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
							Voir détails
						</a>
					</div>
				</div>
			</div>
		@endforeach
	</div>

	@if($products->hasPages())
		<div class="mt-6 flex justify-center">
			{{ $products->links() }}
		</div>
	@endif

	<script>
		(function() {
			const searchInput = document.getElementById('search-products');
			const locationInput = document.getElementById('search-location');
			const searchResults = document.getElementById('search-products-results');
			const locationResults = document.getElementById('search-location-results');
			let searchTimeout, locationTimeout;

			// Autocomplétion pour la recherche de produits
			if (searchInput) {
				searchInput.addEventListener('input', function() {
					const query = this.value.trim();
					clearTimeout(searchTimeout);
					
					if (query.length < 2) {
						searchResults.classList.add('hidden');
						return;
					}

					searchTimeout = setTimeout(() => {
						fetch(`{{ route('api.search.products') }}?q=${encodeURIComponent(query)}`)
							.then(response => response.json())
							.then(data => {
								searchResults.innerHTML = '';
								if (data.length > 0) {
									data.forEach(item => {
										const div = document.createElement('div');
										div.className = 'p-3 hover:bg-[#edf6f0] cursor-pointer border-b border-[#d0c9c0] last:border-b-0';
										div.innerHTML = `
											<div class="font-semibold text-[#5c4033]">${item.title}</div>
											<div class="text-xs text-[#55493f]">${item.category || ''} - ${item.price} FCFA</div>
										`;
										div.addEventListener('click', () => {
											window.location.href = item.url;
										});
										searchResults.appendChild(div);
									});
									searchResults.classList.remove('hidden');
								} else {
									searchResults.classList.add('hidden');
								}
							})
							.catch(() => searchResults.classList.add('hidden'));
					}, 300);
				});

				// Fermer les résultats en cliquant ailleurs
				document.addEventListener('click', (e) => {
					if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
						searchResults.classList.add('hidden');
					}
				});
			}

			// Autocomplétion pour la localité
			if (locationInput) {
				locationInput.addEventListener('input', function() {
					const query = this.value.trim();
					clearTimeout(locationTimeout);
					
					if (query.length < 2) {
						locationResults.classList.add('hidden');
						return;
					}

					locationTimeout = setTimeout(() => {
						fetch(`{{ route('api.search.locations') }}?q=${encodeURIComponent(query)}`)
							.then(response => response.json())
							.then(data => {
								locationResults.innerHTML = '';
								if (data.length > 0) {
									data.forEach(item => {
										const div = document.createElement('div');
										div.className = 'p-3 hover:bg-[#edf6f0] cursor-pointer border-b border-[#d0c9c0] last:border-b-0';
										div.textContent = item.location;
										div.addEventListener('click', () => {
											locationInput.value = item.location;
											locationResults.classList.add('hidden');
										});
										locationResults.appendChild(div);
									});
									locationResults.classList.remove('hidden');
								} else {
									locationResults.classList.add('hidden');
								}
							})
							.catch(() => locationResults.classList.add('hidden'));
					}, 300);
				});

				// Fermer les résultats en cliquant ailleurs
				document.addEventListener('click', (e) => {
					if (!locationInput.contains(e.target) && !locationResults.contains(e.target)) {
						locationResults.classList.add('hidden');
					}
				});
			}
		})();
	</script>
</x-app-layout>
