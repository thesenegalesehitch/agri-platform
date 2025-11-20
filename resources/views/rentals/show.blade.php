<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">Location #{{ $rental->id }}</h2>
	</x-slot>

	<div class="max-w-4xl mx-auto">
		@if($rental->equipment->images && $rental->equipment->images->count())
			<div class="content-card fade-in mb-6">
				@php $primary = $rental->equipment->images->firstWhere('is_primary', 1) ?? $rental->equipment->images->first(); @endphp
				@if($primary)
					<div class="relative overflow-hidden rounded-lg shadow-lg mb-4">
						<img
							src="{{ $primary->url }}"
							loading="eager"
							decoding="async"
							class="w-full h-64 md:h-80 object-cover"
							alt="{{ $rental->equipment->title }}"
							width="800"
							height="320"
						/>
						<div class="absolute inset-0 bg-gradient-to-t from-[#5c4033]/80 to-transparent"></div>
						<div class="absolute bottom-4 left-4 text-white">
							<h1 class="text-2xl md:text-3xl font-bold mb-2">{{ $rental->equipment->title }}</h1>
							<p class="text-lg font-semibold">{{ number_format($rental->total, 0, ',', ' ') }} FCFA total</p>
						</div>
					</div>
				@endif
			</div>
		@endif

		<div class="content-card fade-in">
			<!-- Informations de la location -->
			<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
				<div>
					<h3 class="section-title-agri mb-4">Détails de la Location</h3>
					<div class="space-y-3">
						<div class="flex items-start">
							<span class="font-semibold text-[#5c4033] w-40">ID Location:</span>
							<span class="text-[#55493f] flex-1">#{{ $rental->id }}</span>
						</div>
						<div class="flex items-start">
							<span class="font-semibold text-[#5c4033] w-40">Matériel:</span>
							<span class="text-[#55493f] flex-1">{{ $rental->equipment->title }}</span>
						</div>
						@if($rental->equipment->category)
							<div class="flex items-start">
								<span class="font-semibold text-[#5c4033] w-40">Catégorie:</span>
								<span class="text-[#55493f] flex-1">{{ $rental->equipment->category->name }}</span>
							</div>
						@endif
						<div class="flex items-start">
							<span class="font-semibold text-[#5c4033] w-40">Date de début:</span>
							<span class="text-[#55493f] flex-1">{{ $rental->start_date->format('d/m/Y') }}</span>
						</div>
						<div class="flex items-start">
							<span class="font-semibold text-[#5c4033] w-40">Date de fin:</span>
							<span class="text-[#55493f] flex-1">{{ $rental->end_date->format('d/m/Y') }}</span>
						</div>
						<div class="flex items-start">
							<span class="font-semibold text-[#5c4033] w-40">Statut:</span>
							<span class="flex-1">
								<span class="px-3 py-1 rounded-full text-sm font-medium
									@if($rental->status === 'approved' || $rental->status === 'active') bg-green-100 text-green-800
									@elseif($rental->status === 'pending') bg-yellow-100 text-yellow-800
									@elseif($rental->status === 'rejected' || $rental->status === 'cancelled') bg-red-100 text-red-800
									@else bg-blue-100 text-blue-800
									@endif">
									{{ ucfirst($rental->status) }}
								</span>
							</span>
						</div>
						<div class="flex items-start">
							<span class="font-semibold text-[#5c4033] w-40">Total:</span>
							<span class="text-[#4CAF50] font-bold text-xl flex-1">{{ number_format($rental->total, 0, ',', ' ') }} FCFA</span>
						</div>
						<div class="flex items-start">
							<span class="font-semibold text-[#5c4033] w-40">Créée le:</span>
							<span class="text-[#55493f] flex-1">{{ $rental->created_at->format('d/m/Y H:i') }}</span>
						</div>
						@if($rental->updated_at != $rental->created_at)
							<div class="flex items-start">
								<span class="font-semibold text-[#5c4033] w-40">Modifiée le:</span>
								<span class="text-[#55493f] flex-1">{{ $rental->updated_at->format('d/m/Y H:i') }}</span>
							</div>
						@endif
					</div>
				</div>

				<div>
					<h3 class="section-title-agri mb-4">Informations du Locataire</h3>
					@if($rental->renter)
						<div class="space-y-3">
							<div class="flex items-start">
								<span class="font-semibold text-[#5c4033] w-40">Nom:</span>
								<span class="text-[#55493f] flex-1">{{ $rental->renter->name }}</span>
							</div>
							@if($rental->renter->phone)
								<div class="flex items-start">
									<span class="font-semibold text-[#5c4033] w-40">Téléphone:</span>
									<span class="text-[#55493f] flex-1">{{ $rental->renter->phone }}</span>
								</div>
							@endif
							@if($rental->renter->email)
								<div class="flex items-start">
									<span class="font-semibold text-[#5c4033] w-40">Email:</span>
									<span class="text-[#55493f] flex-1">{{ $rental->renter->email }}</span>
								</div>
							@endif
							@if($rental->renter->ville || $rental->renter->region)
								<div class="flex items-start">
									<span class="font-semibold text-[#5c4033] w-40">Localisation:</span>
									<span class="text-[#55493f] flex-1">
										📍 {{ $rental->renter->ville ? $rental->renter->ville.', ' : '' }}{{ $rental->renter->region ?: '' }}
									</span>
								</div>
							@endif
						</div>
					@endif
				</div>
			</div>

			<!-- Informations du propriétaire -->
			<div class="border-t border-[#d0c9c0] pt-6 mt-6">
				<h3 class="section-title-agri mb-4">Informations du Propriétaire</h3>
				@if($rental->equipment->user)
					<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
						<div class="space-y-3">
							<div class="flex items-start">
								<span class="font-semibold text-[#5c4033] w-40">Nom:</span>
								<span class="text-[#55493f] flex-1">{{ $rental->equipment->user->name }}</span>
							</div>
							@if($rental->equipment->user->phone)
								<div class="flex items-start">
									<span class="font-semibold text-[#5c4033] w-40">Téléphone:</span>
									<span class="text-[#55493f] flex-1">{{ $rental->equipment->user->phone }}</span>
								</div>
							@endif
							@if($rental->equipment->user->email)
								<div class="flex items-start">
									<span class="font-semibold text-[#5c4033] w-40">Email:</span>
									<span class="text-[#55493f] flex-1">{{ $rental->equipment->user->email }}</span>
								</div>
							@endif
						</div>
						<div class="space-y-3">
							@if($rental->equipment->user->ville || $rental->equipment->user->region)
								<div class="flex items-start">
									<span class="font-semibold text-[#5c4033] w-40">Localisation:</span>
									<span class="text-[#55493f] flex-1">
										📍 {{ $rental->equipment->user->ville ? $rental->equipment->user->ville.', ' : '' }}{{ $rental->equipment->user->region ?: '' }}
										@if($rental->equipment->user->address_line1)
											<br><span class="text-sm">{{ $rental->equipment->user->address_line1 }}</span>
										@endif
									</span>
								</div>
							@endif
							@if($rental->equipment->user->company_name)
								<div class="flex items-start">
									<span class="font-semibold text-[#5c4033] w-40">Entreprise:</span>
									<span class="text-[#55493f] flex-1">{{ $rental->equipment->user->company_name }}</span>
								</div>
							@endif
						</div>
					</div>
				@endif
			</div>

			<!-- Actions pour le propriétaire -->
			@can('update', $rental)
				<div class="border-t border-[#d0c9c0] pt-6 mt-6">
					<h3 class="section-title-agri mb-4">Mettre à jour le statut</h3>
					<form method="POST" action="{{ route('rentals.update', $rental) }}" class="space-y-4">
						@csrf @method('PATCH')
						<div class="form-group">
							<label for="status" class="form-label-agri">Nouveau statut</label>
							<select name="status" id="status" class="form-select-agri" required>
								<option value="">Sélectionner un statut</option>
								<option value="approved" {{ $rental->status === 'approved' ? 'selected' : '' }}>Approuvé</option>
								<option value="rejected" {{ $rental->status === 'rejected' ? 'selected' : '' }}>Rejeté</option>
								<option value="active" {{ $rental->status === 'active' ? 'selected' : '' }}>Actif</option>
								<option value="completed" {{ $rental->status === 'completed' ? 'selected' : '' }}>Terminé</option>
								<option value="cancelled" {{ $rental->status === 'cancelled' ? 'selected' : '' }}>Annulé</option>
							</select>
						</div>
						<button type="submit" class="btn-primary-agri">
							💾 Mettre à jour le statut
						</button>
					</form>
				</div>
			@endcan

			<!-- Bouton retour -->
			<div class="border-t border-[#d0c9c0] pt-6 mt-6">
				<a href="{{ route('rentals.index') }}" class="btn-secondary-agri">
					⬅️ Retour aux locations
				</a>
			</div>
		</div>
	</div>
</x-app-layout>