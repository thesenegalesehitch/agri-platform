<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">Modifier le Produit</h2>
	</x-slot>
	
	<div class="content-card fade-in">
		<form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
			@csrf
			@method('PUT')
			
			<div class="form-group">
				<label for="title" class="form-label-agri">Titre *</label>
				<input 
					type="text" 
					id="title"
					name="title" 
					class="form-input-agri"
					value="{{ old('title', $product->title) }}"
					placeholder="Titre du produit" 
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
							<option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
					placeholder="Description du produit (optionnel)"
				>{{ old('description', $product->description) }}</textarea>
				@error('description')
					<span class="form-error-agri">{{ $message }}</span>
				@enderror
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
				<div class="form-group">
					<label for="price" class="form-label-agri">Prix *</label>
					<input 
						type="number" 
						step="0.01" 
						id="price"
						name="price" 
						class="form-input-agri"
						value="{{ old('price', $product->price) }}"
						placeholder="Prix" 
						required 
					/>
					@error('price')
						<span class="form-error-agri">{{ $message }}</span>
					@enderror
				</div>

				<div class="form-group">
					<label for="pricing_unit" class="form-label-agri">Unité de prix *</label>
					<select id="pricing_unit" name="pricing_unit" class="form-select-agri" required>
						<option value="">Sélectionnez l'unité de prix</option>
						<option value="per_unit" {{ old('pricing_unit', $product->pricing_unit) == 'per_unit' ? 'selected' : '' }}>Par unité</option>
						<option value="per_kilo" {{ old('pricing_unit', $product->pricing_unit) == 'per_kilo' ? 'selected' : '' }}>Par kilo</option>
						<option value="per_hectare" {{ old('pricing_unit', $product->pricing_unit) == 'per_hectare' ? 'selected' : '' }}>Par hectare</option>
						<option value="per_hour" {{ old('pricing_unit', $product->pricing_unit) == 'per_hour' ? 'selected' : '' }}>Par heure</option>
						<option value="per_day" {{ old('pricing_unit', $product->pricing_unit) == 'per_day' ? 'selected' : '' }}>Par jour</option>
					</select>
					@error('pricing_unit')
						<span class="form-error-agri">{{ $message }}</span>
					@enderror
				</div>
			</div>

			<div class="form-group">
				<label for="stock" class="form-label-agri">Stock *</label>
				<input 
					type="number" 
					id="stock"
					name="stock" 
					class="form-input-agri"
					value="{{ old('stock', $product->stock) }}"
					placeholder="Quantité en stock" 
					required 
				/>
				@error('stock')
					<span class="form-error-agri">{{ $message }}</span>
				@enderror
			</div>

			<div class="form-group">
				<label class="inline-flex items-center">
					<input 
						type="checkbox" 
						name="is_active" 
						value="1"
						{{ old('is_active', $product->is_active) ? 'checked' : '' }}
						class="rounded border-[#d0c9c0] text-[#4CAF50] focus:ring-[#4CAF50]"
					/>
					<span class="ml-2 text-[#55493f]">Produit actif</span>
				</label>
			</div>

			<div class="flex gap-3 mt-6">
				<button type="submit" class="btn-primary-agri">
					Enregistrer les modifications
				</button>
				<a href="{{ route('products.show', $product) }}" class="btn-secondary-agri">
					Annuler
				</a>
			</div>
		</form>
	</div>
</x-app-layout>
