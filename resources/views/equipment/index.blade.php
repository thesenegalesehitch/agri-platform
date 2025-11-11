@php
	use Illuminate\Support\Facades\Storage;
	use Illuminate\Support\Str;
@endphp

<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">
			@auth
				@role('equipment_owner')
					Mes Matériels
				@elserole('admin')
					Équipements Disponibles
				@else
					Équipements Disponibles
				@endrole
			@else
				Équipements Disponibles
			@endauth
		</h2>
	</x-slot>

	<div class="content-card fade-in mb-6">
		<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
			@role('equipment_owner')
				<a href="{{ route('equipment.create') }}" class="btn-primary-agri">
					➕ Nouveau Matériel
				</a>
			@endrole
			
			<form method="GET" action="{{ route('equipment.index') }}" class="flex flex-wrap items-center gap-2 flex-1" id="equipment-search-form">
				<div class="relative flex-1 min-w-[200px]" id="search-equipment-wrapper">
					<input 
						type="text"
						name="q" 
						id="search-equipment"
						value="{{ request('q') }}" 
						placeholder="Recherche matériel, description, localité..." 
						class="form-input-agri w-full" 
						autocomplete="off"
					/>
					<div id="search-equipment-results" class="hidden absolute z-50 w-full mt-1 bg-white border border-[#d0c9c0] rounded-lg shadow-lg max-h-60 overflow-y-auto"></div>
				</div>
				<div class="relative min-w-[150px]" id="search-location-equipment-wrapper">
					<input 
						type="text"
						name="location" 
						id="search-location-equipment"
						value="{{ request('location') }}" 
						placeholder="Localité..." 
						class="form-input-agri w-full" 
						autocomplete="off"
					/>
					<div id="search-location-equipment-results" class="hidden absolute z-50 w-full mt-1 bg-white border border-[#d0c9c0] rounded-lg shadow-lg max-h-60 overflow-y-auto"></div>
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
					name="min_rate" 
					value="{{ request('min_rate') }}" 
					placeholder="Min FCFA/j" 
					class="form-input-agri w-28" 
				/>
				<input 
					type="number" 
					step="0.01" 
					name="max_rate" 
					value="{{ request('max_rate') }}" 
					placeholder="Max FCFA/j" 
					class="form-input-agri w-28" 
				/>
				<label class="inline-flex items-center space-x-2">
					<input 
						type="checkbox" 
						name="available" 
						value="1" 
						{{ request('available') ? 'checked' : '' }}
						class="rounded border-[#d0c9c0] text-[#4CAF50] focus:ring-[#4CAF50]"
					/>
					<span class="text-[#55493f] text-sm">Disponible</span>
				</label>
				<button type="submit" class="btn-primary-agri">
					🔍 Filtrer
				</button>
			</form>
		</div>
	</div>

	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
		@foreach($equipment as $item)
			<div class="content-card fade-in hover:shadow-xl transition-shadow">
				@if($item->images && $item->images->count())
					@php $primaryImage = $item->images->firstWhere('is_primary', 1) ?? $item->images->first(); @endphp
					<div class="h-48 overflow-hidden rounded-lg mb-4">
						<img 
							src="{{ $primaryImage->url }}" 
							loading="lazy"
							decoding="async"
							class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" 
							alt="{{ $item->title }}"
							width="400"
							height="192"
						/>
					</div>
				@else
					<div class="h-48 bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center rounded-lg mb-4">
						<span class="text-4xl">🚜</span>
					</div>
				@endif
				<div>
					<h3 class="font-bold text-lg mb-2 text-[#5c4033]">{{ $item->title }}</h3>
					<p class="text-sm text-[#55493f] mb-3 line-clamp-2">{{ Str::limit($item->description, 100) }}</p>
					@if($item->is_available)
						<p class="text-xs text-[#4CAF50] mb-2">✓ Disponible</p>
					@else
						<p class="text-xs text-red-600 mb-2">✗ Indisponible</p>
					@endif
					<div class="flex justify-between items-center gap-2 mt-4">
						<span class="text-lg font-semibold text-[#4CAF50]">{{ number_format($item->daily_rate * 655.957, 0, ',', ' ') }} FCFA/jour</span>
						<div class="flex gap-2">
							@auth
								@role('producer')
									@if($item->is_available)
										<button 
											type="button" 
											class="btn-primary-agri" 
											style="padding: 0.5rem 1rem; font-size: 0.9rem;"
											onclick="showRentalModal({{ $item->id }}, '{{ $item->title }}')"
										>
											📅 Louer
										</button>
									@endif
								@endrole
							@endauth
							<a href="{{ route('equipment.show',$item) }}" class="btn-secondary-agri" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
								Voir détails
							</a>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>

	@if($equipment->hasPages())
		<div class="mt-6 flex justify-center">
			{{ $equipment->links() }}
		</div>
	@endif

	<script>
		(function() {
			const searchInput = document.getElementById('search-equipment');
			const locationInput = document.getElementById('search-location-equipment');
			const searchResults = document.getElementById('search-equipment-results');
			const locationResults = document.getElementById('search-location-equipment-results');
			let searchTimeout, locationTimeout;

			// Autocomplétion pour la recherche d'équipements
			if (searchInput) {
				searchInput.addEventListener('input', function() {
					const query = this.value.trim();
					clearTimeout(searchTimeout);
					
					if (query.length < 2) {
						searchResults.classList.add('hidden');
						return;
					}

					searchTimeout = setTimeout(() => {
						fetch(`{{ route('api.search.equipment') }}?q=${encodeURIComponent(query)}`)
							.then(response => response.json())
							.then(data => {
								searchResults.innerHTML = '';
								if (data.length > 0) {
									data.forEach(item => {
										const div = document.createElement('div');
										div.className = 'p-3 hover:bg-[#edf6f0] cursor-pointer border-b border-[#d0c9c0] last:border-b-0';
										div.innerHTML = `
											<div class="font-semibold text-[#5c4033]">${item.title}</div>
											<div class="text-xs text-[#55493f]">${item.category || ''} - ${item.location || ''} - ${item.daily_rate} FCFA/jour</div>
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

		// Modal pour la location rapide
		function showRentalModal(equipmentId, equipmentTitle) {
			const today = new Date().toISOString().split('T')[0];
			const tomorrow = new Date();
			tomorrow.setDate(tomorrow.getDate() + 1);
			const tomorrowStr = tomorrow.toISOString().split('T')[0];

			// Récupérer le token CSRF depuis la meta tag
			const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

			const modal = document.createElement('div');
			modal.id = 'rentalModal';
			modal.className = 'fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4';
			modal.innerHTML = `
				<div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
					<div class="flex justify-between items-center mb-4">
						<h3 class="text-xl font-bold text-[#5c4033]">Louer: ${equipmentTitle}</h3>
						<button onclick="closeRentalModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
					</div>
					<form id="quickRentalForm" method="POST" action="/equipment/${equipmentId}/rent">
						<input type="hidden" name="_token" value="${csrfToken}">
						<div class="space-y-4">
							<div>
								<label for="start_date" class="form-label-agri">Date de début</label>
								<input 
									type="date" 
									id="start_date" 
									name="start_date" 
									class="form-input-agri" 
									value="${today}" 
									min="${today}" 
									required
								>
							</div>
							<div>
								<label for="end_date" class="form-label-agri">Date de fin</label>
								<input 
									type="date" 
									id="end_date" 
									name="end_date" 
									class="form-input-agri" 
									value="${tomorrowStr}" 
									min="${tomorrowStr}" 
									required
								>
							</div>
						</div>
						<div class="flex gap-3 mt-6">
							<button type="submit" class="btn-primary-agri flex-1">
								📅 Confirmer la location
							</button>
							<button type="button" onclick="closeRentalModal()" class="btn-secondary-agri flex-1">
								Annuler
							</button>
						</div>
					</form>
				</div>
			`;
			document.body.appendChild(modal);

			// Gestion de la date de fin automatique
			const startDateInput = modal.querySelector('#start_date');
			const endDateInput = modal.querySelector('#end_date');
			
			startDateInput.addEventListener('change', function() {
				const startDate = new Date(this.value);
				const nextDay = new Date(startDate);
				nextDay.setDate(nextDay.getDate() + 1);
				endDateInput.min = nextDay.toISOString().split('T')[0];
				
				if (endDateInput.value && new Date(endDateInput.value) <= startDate) {
					endDateInput.value = nextDay.toISOString().split('T')[0];
				}
			});

			// Fermer en cliquant à l'extérieur
			modal.addEventListener('click', function(e) {
				if (e.target === modal) {
					closeRentalModal();
				}
			});
		}

		function closeRentalModal() {
			const modal = document.getElementById('rentalModal');
			if (modal) {
				modal.remove();
			}
		}

		// Fermer avec Échap
		document.addEventListener('keydown', function(e) {
			if (e.key === 'Escape') {
				closeRentalModal();
			}
		});
	</script>
</x-app-layout>
