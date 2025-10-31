@php
	use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">{{ $equipment->title }}</h2>
	</x-slot>

	<div class="max-w-4xl mx-auto">
		@if($equipment->images && $equipment->images->count())
			<div class="content-card fade-in mb-6">
				@php $primary = $equipment->images->firstWhere('is_primary', 1) ?? $equipment->images->first(); @endphp
				@if($primary)
					<div class="relative overflow-hidden rounded-lg shadow-lg mb-4">
						<img 
							src="{{ Storage::url($primary->path) }}" 
							loading="eager"
							decoding="async"
							class="w-full h-64 md:h-80 object-cover" 
							alt="{{ $equipment->title }}"
							width="800"
							height="320"
						/>
						<div class="absolute inset-0 bg-gradient-to-t from-[#5c4033]/80 to-transparent"></div>
						<div class="absolute bottom-4 left-4 text-white">
							<h1 class="text-2xl md:text-3xl font-bold mb-2">{{ $equipment->title }}</h1>
							<p class="text-lg font-semibold">{{ number_format($equipment->daily_rate * 655.957, 0, ',', ' ') }} FCFA / jour</p>
						</div>
					</div>
				@endif
				@if($equipment->images->count() > 1)
					<div class="mt-4">
						<h4 class="text-lg font-semibold text-[#5c4033] mb-3">Autres photos ({{ $equipment->images->count() - 1 }})</h4>
						<div class="grid grid-cols-2 md:grid-cols-4 gap-3">
							@foreach($equipment->images->where('id', '!=', $primary->id ?? null)->sortBy('sort_order') as $img)
								<div class="relative group overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-all cursor-pointer" onclick="openImageModal('{{ Storage::url($img->path) }}', '{{ $equipment->title }}')">
									<img 
										src="{{ Storage::url($img->path) }}" 
										loading="lazy"
										decoding="async"
										class="w-full h-32 md:h-40 object-cover group-hover:scale-110 transition-transform duration-300" 
										alt="Image {{ $loop->iteration }} - {{ $equipment->title }}"
										width="250"
										height="160"
									/>
									<div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
									@role('equipment_owner')
										@if(Auth::id() === $equipment->user_id)
											<form method="POST" action="{{ route('images.destroy', $img) }}" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity z-10" onclick="event.stopPropagation(); return confirm('Supprimer cette image ?');">
												@csrf @method('DELETE')
												<button type="submit" class="px-2 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">×</button>
											</form>
										@endif
									@endrole
								</div>
							@endforeach
						</div>
					</div>
				@endif
			</div>
		@endif

		<div class="content-card fade-in">
			<!-- Informations principales -->
			<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
				<div>
					<h3 class="section-title-agri mb-4">Informations du Matériel</h3>
					<div class="space-y-3">
						<div class="flex items-start">
							<span class="font-semibold text-[#5c4033] w-40">Titre:</span>
							<span class="text-[#55493f] flex-1">{{ $equipment->title }}</span>
						</div>
						@if($equipment->category)
							<div class="flex items-start">
								<span class="font-semibold text-[#5c4033] w-40">Catégorie:</span>
								<span class="text-[#55493f] flex-1">{{ $equipment->category->name }}</span>
							</div>
						@endif
						<div class="flex items-start">
							<span class="font-semibold text-[#5c4033] w-40">Tarif journalier:</span>
							<span class="text-[#4CAF50] font-bold text-xl flex-1">
								{{ number_format($equipment->daily_rate * 655.957, 0, ',', ' ') }} FCFA
								@if($equipment->pricing_unit)
									<span class="text-sm text-[#55493f] font-normal">
										/ @if($equipment->pricing_unit === 'per_hour') heure
										@elseif($equipment->pricing_unit === 'per_day') jour
										@elseif($equipment->pricing_unit === 'per_week') semaine
										@elseif($equipment->pricing_unit === 'per_month') mois
										@endif
									</span>
								@else
									<span class="text-sm text-[#55493f] font-normal">/ jour</span>
								@endif
							</span>
						</div>
						@if($equipment->location)
							<div class="flex items-start">
								<span class="font-semibold text-[#5c4033] w-40">Localisation:</span>
								<span class="text-[#55493f] flex-1">📍 {{ $equipment->location }}</span>
							</div>
						@endif
						<div class="flex items-start">
							<span class="font-semibold text-[#5c4033] w-40">Disponibilité:</span>
							<span class="flex-1">
								@if($equipment->is_available)
									<span class="px-3 py-1 bg-[#edf6f0] text-[#4CAF50] rounded-full text-sm font-medium">✓ Disponible</span>
								@else
									<span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">⏸ Indisponible</span>
								@endif
							</span>
						</div>
						<div class="flex items-start">
							<span class="font-semibold text-[#5c4033] w-40">Statut:</span>
							<span class="flex-1">
								@if($equipment->is_active)
									<span class="px-3 py-1 bg-[#edf6f0] text-[#4CAF50] rounded-full text-sm font-medium">✓ Actif</span>
								@else
									<span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">✗ Inactif</span>
								@endif
							</span>
						</div>
					</div>
				</div>
				
				<div>
					<h3 class="section-title-agri mb-4">Informations du Propriétaire</h3>
					@if($equipment->user)
						<div class="space-y-3">
							<div class="flex items-start">
								<span class="font-semibold text-[#5c4033] w-40">Nom:</span>
								<span class="text-[#55493f] flex-1">{{ $equipment->user->name }}</span>
							</div>
							@if($equipment->user->region || $equipment->user->ville)
								<div class="flex items-start">
									<span class="font-semibold text-[#5c4033] w-40">Localisation:</span>
									<span class="text-[#55493f] flex-1">
										📍 {{ $equipment->user->ville ? $equipment->user->ville.', ' : '' }}{{ $equipment->user->region ?: '' }}
										@if($equipment->user->address_line1)
											<br><span class="text-sm">{{ $equipment->user->address_line1 }}</span>
										@endif
									</span>
								</div>
							@endif
							@if($equipment->user->phone)
								<div class="flex items-start">
									<span class="font-semibold text-[#5c4033] w-40">Téléphone:</span>
									<span class="text-[#55493f] flex-1">{{ $equipment->user->phone }}</span>
								</div>
							@endif
							@if($equipment->user->company_name)
								<div class="flex items-start">
									<span class="font-semibold text-[#5c4033] w-40">Entreprise:</span>
									<span class="text-[#55493f] flex-1">{{ $equipment->user->company_name }}</span>
								</div>
							@endif
							@if($equipment->user->fleet_size)
								<div class="flex items-start">
									<span class="font-semibold text-[#5c4033] w-40">Parc:</span>
									<span class="text-[#55493f] flex-1">{{ $equipment->user->fleet_size }} équipement(s)</span>
								</div>
							@endif
						</div>
					@endif
				</div>
			</div>

			<!-- Description -->
			@if($equipment->description)
				<div class="border-t border-[#d0c9c0] pt-6 mt-6">
					<h3 class="section-title-agri mb-4">Description</h3>
					<p class="text-[#55493f] leading-relaxed text-lg whitespace-pre-line">{{ $equipment->description }}</p>
				</div>
			@endif

			@role('equipment_owner')
				@if(Auth::id() === $equipment->user_id)
					<div class="border-t border-[#d0c9c0] pt-6 mt-6">
						<h3 class="section-title-agri">Gestion des Images</h3>
						<form method="POST" action="{{ route('images.reorder') }}" class="mb-6">
							@csrf @method('PATCH')
							<input type="hidden" name="imageable_type" value="equipment" />
							<input type="hidden" name="imageable_id" value="{{ $equipment->id }}" />
							<div class="space-y-3">
								@foreach($equipment->images as $img)
									<div class="flex items-center space-x-4 p-3 bg-[#f8f6f3] rounded-lg">
										<span class="w-16 text-sm font-medium text-[#5c4033]">#{{ $img->id }}</span>
										<input type="number" name="orders[{{ $img->id }}]" value="{{ $img->sort_order }}" class="form-input-agri w-20" />
										<label class="inline-flex items-center space-x-2">
											<input type="radio" name="primary_id" value="{{ $img->id }}" {{ $img->is_primary ? 'checked' : '' }} class="text-[#4CAF50] focus:ring-[#4CAF50]" />
											<span class="text-sm text-[#55493f]">Image principale</span>
										</label>
									</div>
								@endforeach
							</div>
							<button type="submit" class="btn-primary-agri mt-4">
								Enregistrer l'ordre
							</button>
						</form>
					</div>

					<div class="border-t border-[#d0c9c0] pt-6 mt-6">
						<h3 class="section-title-agri">Ajouter des Images</h3>
						<form method="POST" action="{{ route('images.store') }}" enctype="multipart/form-data" class="flex flex-wrap items-center gap-4">
							@csrf
							<input type="hidden" name="imageable_type" value="equipment" />
							<input type="hidden" name="imageable_id" value="{{ $equipment->id }}" />
							<div class="flex-1 min-w-64">
								<input type="file" name="images[]" multiple required class="form-input-agri" />
							</div>
							<label class="inline-flex items-center space-x-2">
								<input type="checkbox" name="is_primary" value="1" class="rounded border-[#d0c9c0] text-[#4CAF50] focus:ring-[#4CAF50]" />
								<span class="text-[#55493f]">Définir comme principale</span>
							</label>
							<button type="submit" class="btn-primary-agri">
								📤 Uploader
							</button>
						</form>
					</div>

					<div class="border-t border-[#d0c9c0] pt-6 mt-6 flex flex-wrap gap-3">
						<a href="{{ route('equipment.edit',$equipment) }}" class="btn-secondary-agri">
							✏️ Modifier
						</a>
						<form method="POST" action="{{ route('equipment.destroy',$equipment) }}" class="inline">
							@csrf @method('DELETE')
							<button type="submit" class="btn-danger-agri" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet équipement ?')">
								🗑️ Supprimer
							</button>
						</form>
					</div>
				@endif
			@endrole

			@auth
				@role('buyer')
					<div class="border-t border-[#d0c9c0] pt-6 mt-6">
						<h3 class="section-title-agri">Demander une Location</h3>
						<form method="POST" action="{{ route('rentals.store', $equipment) }}" class="space-y-4">
							@csrf
							<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
								<div class="form-group">
									<label for="start_date" class="form-label-agri">Date de début</label>
									<input type="date" id="start_date" name="start_date" class="form-input-agri" required>
								</div>
								<div class="form-group">
									<label for="end_date" class="form-label-agri">Date de fin</label>
									<input type="date" id="end_date" name="end_date" class="form-input-agri" required>
								</div>
							</div>
							<button type="submit" class="btn-primary-agri">
								📅 Demander une location
							</button>
						</form>
					</div>
				@endrole
			@else
				<div class="border-t border-[#d0c9c0] pt-6 mt-6">
					<p class="text-[#55493f] mb-4">Vous devez être connecté pour louer cet équipement.</p>
					<a href="{{ route('login') }}" class="btn-primary-agri inline-block">
						🔐 Se connecter
					</a>
				</div>
			@endauth
		</div>
	</div>

	<!-- Modal pour afficher les images en grand -->
	<div id="imageModal" class="hidden fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
		<div class="relative max-w-4xl max-h-[90vh] w-full" onclick="event.stopPropagation()">
			<button onclick="closeImageModal()" class="absolute top-4 right-4 text-white text-4xl font-bold hover:text-[#81C784] transition-colors z-10">×</button>
			<img id="modalImage" src="" alt="" class="w-full h-auto object-contain rounded-lg" />
			<p id="modalTitle" class="text-white text-center mt-4 text-lg font-semibold"></p>
		</div>
	</div>

	<script>
		function openImageModal(imageUrl, title) {
			document.getElementById('modalImage').src = imageUrl;
			document.getElementById('modalTitle').textContent = title;
			document.getElementById('imageModal').classList.remove('hidden');
			document.body.style.overflow = 'hidden';
		}

		function closeImageModal() {
			document.getElementById('imageModal').classList.add('hidden');
			document.body.style.overflow = '';
		}

		// Fermer avec Échap
		document.addEventListener('keydown', function(e) {
			if (e.key === 'Escape') {
				closeImageModal();
			}
		});
	</script>
</x-app-layout>
