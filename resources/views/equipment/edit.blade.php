<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">Modifier le Matériel</h2>
	</x-slot>
	
	<div class="content-card fade-in">
		<form method="POST" action="{{ route('equipment.update', $equipment) }}" enctype="multipart/form-data">
			@csrf
			@method('PUT')
			
			<div class="form-group">
				<label for="title" class="form-label-agri">Titre *</label>
				<input 
					type="text" 
					id="title"
					name="title" 
					class="form-input-agri"
					value="{{ old('title', $equipment->title) }}"
					placeholder="Titre du matériel" 
					required 
				/>
				@error('title')
					<span class="form-error-agri">{{ $message }}</span>
				@enderror
			</div>

			<div class="form-group">
				<label for="category_id" class="form-label-agri">Catégorie</label>
				<select id="category_id" name="category_id" class="form-select-agri">
					<option value="">Aucune catégorie</option>
					@isset($categories)
						@foreach($categories as $category)
							<option value="{{ $category->id }}" {{ old('category_id', $equipment->category_id) == $category->id ? 'selected' : '' }}>
								{{ $category->name }}
							</option>
						@endforeach
					@endisset
				</select>
				@error('category_id')
					<span class="form-error-agri">{{ $message }}</span>
				@enderror
			</div>

			<div class="form-group">
				<label for="description" class="form-label-agri">Description</label>
				<textarea 
					id="description"
					name="description" 
					class="form-textarea-agri"
					rows="5"
					placeholder="Description du matériel (optionnel)"
				>{{ old('description', $equipment->description) }}</textarea>
				@error('description')
					<span class="form-error-agri">{{ $message }}</span>
				@enderror
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
				<div class="form-group">
					<label for="daily_rate" class="form-label-agri">Tarif journalier *</label>
					<input 
						type="number" 
						step="0.01" 
						id="daily_rate"
						name="daily_rate" 
						class="form-input-agri"
						value="{{ old('daily_rate', $equipment->daily_rate) }}"
						placeholder="Tarif par jour" 
						required 
					/>
					@error('daily_rate')
						<span class="form-error-agri">{{ $message }}</span>
					@enderror
				</div>

				<div class="form-group">
					<label for="pricing_unit" class="form-label-agri">Unité de prix *</label>
					<select id="pricing_unit" name="pricing_unit" class="form-select-agri" required>
						<option value="">Sélectionnez l'unité de prix</option>
						<option value="per_hour" {{ old('pricing_unit', $equipment->pricing_unit) == 'per_hour' ? 'selected' : '' }}>Par heure</option>
						<option value="per_day" {{ old('pricing_unit', $equipment->pricing_unit) == 'per_day' ? 'selected' : '' }}>Par jour</option>
						<option value="per_week" {{ old('pricing_unit', $equipment->pricing_unit) == 'per_week' ? 'selected' : '' }}>Par semaine</option>
						<option value="per_month" {{ old('pricing_unit', $equipment->pricing_unit) == 'per_month' ? 'selected' : '' }}>Par mois</option>
					</select>
					@error('pricing_unit')
						<span class="form-error-agri">{{ $message }}</span>
					@enderror
				</div>
			</div>

			<div class="form-group">
				<label for="location" class="form-label-agri">Localisation</label>
				<input 
					type="text" 
					id="location"
					name="location" 
					class="form-input-agri"
					value="{{ old('location', $equipment->location) }}"
					placeholder="Ville, région" 
				/>
				@error('location')
					<span class="form-error-agri">{{ $message }}</span>
				@enderror
			</div>

			<div class="flex flex-col space-y-2 form-group">
				<label class="inline-flex items-center">
					<input 
						type="checkbox" 
						name="is_available" 
						value="1"
						{{ old('is_available', $equipment->is_available) ? 'checked' : '' }}
						class="rounded border-[#d0c9c0] text-[#4CAF50] focus:ring-[#4CAF50]"
					/>
					<span class="ml-2 text-[#55493f]">Équipement disponible</span>
				</label>
				<label class="inline-flex items-center">
					<input 
						type="checkbox" 
						name="is_active" 
						value="1"
						{{ old('is_active', $equipment->is_active) ? 'checked' : '' }}
						class="rounded border-[#d0c9c0] text-[#4CAF50] focus:ring-[#4CAF50]"
					/>
					<span class="ml-2 text-[#55493f]">Matériel actif</span>
				</label>
			</div>

			<div class="flex gap-3 mt-6">
				<button type="submit" class="btn-primary-agri">
					Enregistrer les modifications
				</button>
				<a href="{{ route('equipment.show', $equipment) }}" class="btn-secondary-agri">
					Annuler
				</a>
			</div>
		</form>
	</div>
</x-app-layout>
