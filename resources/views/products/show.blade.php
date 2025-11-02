@php
	use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">{{ $product->title }}</h2>
	</x-slot>

	<div class="max-w-4xl mx-auto">
		@if($product->images && $product->images->count())
			<div class="content-card fade-in mb-6">
				@php $primary = $product->images->firstWhere('is_primary', 1) ?? $product->images->first(); @endphp
				@if($primary)
					<div class="relative overflow-hidden rounded-lg shadow-lg mb-4">
						<img 
							src="{{ $primary->url }}" 
							loading="eager"
							decoding="async"
							class="w-full h-64 md:h-80 object-cover" 
							alt="{{ $product->title }}"
							width="800"
							height="320"
						/>
						<div class="absolute inset-0 bg-gradient-to-t from-[#5c4033]/80 to-transparent"></div>
						<div class="absolute bottom-4 left-4 text-white">
							<h1 class="text-2xl md:text-3xl font-bold mb-2">{{ $product->title }}</h1>
							<p class="text-lg font-semibold">{{ number_format($product->price * 655.957, 0, ',', ' ') }} FCFA</p>
						</div>
					</div>
				@endif
				@if($product->images->count() > 1)
					<div class="mt-4">
						<h4 class="text-lg font-semibold text-[#5c4033] mb-3">Autres photos ({{ $product->images->count() - 1 }})</h4>
						<div class="grid grid-cols-2 md:grid-cols-4 gap-3">
							@foreach($product->images->where('id', '!=', $primary->id ?? null)->sortBy('sort_order') as $img)
								<div class="relative group overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-all cursor-pointer" 								onclick="openImageModal('{{ $img->url }}', '{{ $product->title }}')">
									<img 
										src="{{ $img->url }}"
										loading="lazy"
										decoding="async"
										class="w-full h-32 md:h-40 object-cover group-hover:scale-110 transition-transform duration-300" 
										alt="Image {{ $loop->iteration }} - {{ $product->title }}"
										width="250"
										height="160"
									/>
									<div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
									@role('producer')
										@if(Auth::id() === $product->user_id)
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
					<h3 class="section-title-agri mb-4">Informations du Produit</h3>
					<div class="space-y-3">
						<div class="flex items-start">
							<span class="font-semibold text-[#5c4033] w-32">Titre:</span>
							<span class="text-[#55493f] flex-1">{{ $product->title }}</span>
						</div>
						@if($product->category)
							<div class="flex items-start">
								<span class="font-semibold text-[#5c4033] w-32">Catégorie:</span>
								<span class="text-[#55493f] flex-1">{{ $product->category->name }}</span>
							</div>
						@endif
						<div class="flex items-start">
							<span class="font-semibold text-[#5c4033] w-32">Prix:</span>
							<span class="text-[#4CAF50] font-bold text-xl flex-1">
								{{ number_format($product->price * 655.957, 0, ',', ' ') }} FCFA
								@if($product->pricing_unit)
									<span class="text-sm text-[#55493f] font-normal">
										/ @if($product->pricing_unit === 'per_kilo') kg
										@elseif($product->pricing_unit === 'per_unit') unité
										@elseif($product->pricing_unit === 'per_hectare') hectare
										@endif
									</span>
								@endif
							</span>
						</div>
						<div class="flex items-start">
							<span class="font-semibold text-[#5c4033] w-32">Stock:</span>
							<span class="text-[#55493f] flex-1">
								@if($product->stock > 0)
									<span class="text-[#4CAF50] font-semibold">{{ $product->stock }} unité(s) disponible(s)</span>
								@else
									<span class="text-red-600 font-semibold">Rupture de stock</span>
								@endif
							</span>
						</div>
						<div class="flex items-start">
							<span class="font-semibold text-[#5c4033] w-32">Statut:</span>
							<span class="flex-1">
								@if($product->is_active)
									<span class="px-3 py-1 bg-[#edf6f0] text-[#4CAF50] rounded-full text-sm font-medium">✓ Actif</span>
								@else
									<span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">✗ Inactif</span>
								@endif
							</span>
						</div>
					</div>
				</div>
				
				<div>
					<h3 class="section-title-agri mb-4">Informations du Vendeur</h3>
					@if($product->user)
						<div class="space-y-3">
							<div class="flex items-start">
								<span class="font-semibold text-[#5c4033] w-32">Nom:</span>
								<span class="text-[#55493f] flex-1">{{ $product->user->name }}</span>
							</div>
							@if($product->user->region || $product->user->ville)
								<div class="flex items-start">
									<span class="font-semibold text-[#5c4033] w-32">Localisation:</span>
									<span class="text-[#55493f] flex-1">
										📍 {{ $product->user->ville ? $product->user->ville.', ' : '' }}{{ $product->user->region ?: '' }}
										@if($product->user->address_line1)
											<br><span class="text-sm">{{ $product->user->address_line1 }}</span>
										@endif
									</span>
								</div>
							@endif
							@if($product->user->phone)
								<div class="flex items-start">
									<span class="font-semibold text-[#5c4033] w-32">Téléphone:</span>
									<span class="text-[#55493f] flex-1">{{ $product->user->phone }}</span>
								</div>
							@endif
							@if($product->user->farm_name)
								<div class="flex items-start">
									<span class="font-semibold text-[#5c4033] w-32">Ferme:</span>
									<span class="text-[#55493f] flex-1">{{ $product->user->farm_name }}</span>
								</div>
							@endif
						</div>
					@endif
				</div>
			</div>

			<!-- Description -->
			@if($product->description)
				<div class="border-t border-[#d0c9c0] pt-6 mt-6">
					<h3 class="section-title-agri mb-4">Description</h3>
					<p class="text-[#55493f] leading-relaxed text-lg whitespace-pre-line">{{ $product->description }}</p>
				</div>
			@endif

			@role('producer')
				@if(Auth::id() === $product->user_id)
					<div class="border-t border-[#d0c9c0] pt-6 mt-6">
						<h3 class="section-title-agri">Gestion des Images</h3>
						<form method="POST" action="{{ route('images.reorder') }}" class="mb-6">
							@csrf @method('PATCH')
							<input type="hidden" name="imageable_type" value="product" />
							<input type="hidden" name="imageable_id" value="{{ $product->id }}" />
							<div class="space-y-3">
								@foreach($product->images as $img)
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
						<h3 class="section-title-agri mb-4">Ajouter des Images (Maximum 10)</h3>
						<p class="text-sm text-[#55493f] mb-4">
							Images actuelles: {{ $product->images->count() }} / 10
						</p>
						
						<!-- Onglets -->
						<div class="border-b border-[#d0c9c0] mb-4">
							<div class="flex gap-4">
								<button type="button" onclick="switchImageTab('upload')" id="tab-upload" class="px-4 py-2 border-b-2 border-[#4CAF50] text-[#4CAF50] font-semibold">
									📁 Upload Local
								</button>
								<button type="button" onclick="switchImageTab('url')" id="tab-url" class="px-4 py-2 border-b-2 border-transparent text-[#55493f] hover:text-[#4CAF50]">
									🔗 Par URL
								</button>
							</div>
						</div>

						<!-- Formulaire Upload -->
						<div id="image-upload-tab" class="image-tab-content">
							<form method="POST" action="{{ route('images.store') }}" enctype="multipart/form-data" class="space-y-4">
								@csrf
								<input type="hidden" name="imageable_type" value="product" />
								<input type="hidden" name="imageable_id" value="{{ $product->id }}" />
								<div>
									<label class="form-label-agri">Sélectionner des fichiers</label>
									<input type="file" name="images[]" multiple accept="image/*" class="form-input-agri" />
									<p class="text-xs text-[#55493f] mt-1">Maximum 10 images au total ({{ $product->images->count() }} déjà ajoutées)</p>
								</div>
								<div class="flex items-center gap-3">
									<label class="inline-flex items-center space-x-2">
										<input type="checkbox" name="is_primary" value="1" class="rounded border-[#d0c9c0] text-[#4CAF50] focus:ring-[#4CAF50]" />
										<span class="text-[#55493f]">Définir la première comme principale</span>
									</label>
									<button type="submit" class="btn-primary-agri">
										📤 Uploader
									</button>
								</div>
							</form>
						</div>

						<!-- Formulaire URL -->
						<div id="image-url-tab" class="image-tab-content hidden">
							<form method="POST" action="{{ route('images.store') }}" enctype="multipart/form-data" class="space-y-4" id="url-form">
								@csrf
								<input type="hidden" name="imageable_type" value="product" />
								<input type="hidden" name="imageable_id" value="{{ $product->id }}" />
								<div id="url-inputs" class="space-y-2">
									<div class="url-input-group">
										<label class="form-label-agri">URL de l'image</label>
										<div class="flex gap-2">
											<input type="url" name="image_urls[]" placeholder="https://exemple.com/image.jpg" class="form-input-agri flex-1" />
											<button type="button" onclick="removeUrlInput(this)" class="btn-danger-agri px-3">✕</button>
										</div>
									</div>
								</div>
								<button type="button" onclick="addUrlInput()" class="btn-secondary-agri text-sm">
									+ Ajouter une autre URL
								</button>
								<div class="flex items-center gap-3 pt-2">
									<label class="form-label-agri">Image principale:</label>
									<select name="primary_image_index" id="primary-url-select" class="form-select-agri">
										<option value="">Aucune</option>
									</select>
								</div>
								<button type="submit" class="btn-primary-agri mt-4">
									🔗 Ajouter les Images
								</button>
							</form>
						</div>
					</div>

					<script>
						function switchImageTab(tab) {
							document.querySelectorAll('.image-tab-content').forEach(el => el.classList.add('hidden'));
							document.querySelectorAll('[id^="tab-"]').forEach(el => {
								el.classList.remove('border-[#4CAF50]', 'text-[#4CAF50');
								el.classList.add('border-transparent', 'text-[#55493f]');
							});
							
							if (tab === 'upload') {
								document.getElementById('image-upload-tab').classList.remove('hidden');
								document.getElementById('tab-upload').classList.add('border-[#4CAF50]', 'text-[#4CAF50');
								document.getElementById('tab-upload').classList.remove('border-transparent', 'text-[#55493f]');
							} else {
								document.getElementById('image-url-tab').classList.remove('hidden');
								document.getElementById('tab-url').classList.add('border-[#4CAF50]', 'text-[#4CAF50]');
								document.getElementById('tab-url').classList.remove('border-transparent', 'text-[#55493f]');
								updatePrimarySelect();
							}
						}

						function addUrlInput() {
							const container = document.getElementById('url-inputs');
							const newGroup = document.createElement('div');
							newGroup.className = 'url-input-group';
							newGroup.innerHTML = `
								<label class="form-label-agri">URL de l'image</label>
								<div class="flex gap-2">
									<input type="url" name="image_urls[]" placeholder="https://exemple.com/image.jpg" class="form-input-agri flex-1" onchange="updatePrimarySelect()" />
									<button type="button" onclick="removeUrlInput(this)" class="btn-danger-agri px-3">✕</button>
								</div>
							`;
							container.appendChild(newGroup);
							updatePrimarySelect();
						}

						function removeUrlInput(btn) {
							btn.closest('.url-input-group').remove();
							updatePrimarySelect();
						}

						function updatePrimarySelect() {
							const inputs = document.querySelectorAll('input[name="image_urls[]"]');
							const select = document.getElementById('primary-url-select');
							select.innerHTML = '<option value="">Aucune</option>';
							inputs.forEach((input, index) => {
								if (input.value.trim()) {
									const option = document.createElement('option');
									option.value = index;
									option.textContent = `Image ${index + 1}${input.value.length > 40 ? ': ' + input.value.substring(0, 40) + '...' : ': ' + input.value}`;
									select.appendChild(option);
								}
							});
						}
					</script>

					<div class="border-t border-[#d0c9c0] pt-6 mt-6 flex flex-wrap gap-3">
						<a href="{{ route('products.edit',$product) }}" class="btn-secondary-agri">
							✏️ Modifier
						</a>
						<form method="POST" action="{{ route('products.destroy',$product) }}" class="inline">
							@csrf @method('DELETE')
							<button type="submit" class="btn-danger-agri" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
								🗑️ Supprimer
							</button>
						</form>
					</div>
				@endif
			@endrole

			@auth
				@role('buyer')
					<div class="border-t border-[#d0c9c0] pt-6 mt-6">
						<form method="POST" action="{{ route('cart.add', $product) }}" class="inline">
							@csrf
							<button type="submit" class="btn-primary-agri" style="padding: 1rem 2rem; font-size: 1.1rem;">
								🛒 Ajouter au Panier
							</button>
						</form>
					</div>
				@endrole
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
