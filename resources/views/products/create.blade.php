<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">Nouveau Produit</h2>
	</x-slot>

	<div class="content-card fade-in">
		<form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
			@csrf

			<div class="form-group">
				<label for="title" class="form-label-agri">Titre *</label>
				<input 
					type="text" 
					id="title" 
					name="title" 
					class="form-input-agri" 
					placeholder="Titre du produit" 
					value="{{ old('title') }}"
					required 
				/>
				@error('title')
					<span class="form-error-agri">{{ $message }}</span>
				@enderror
			</div>

			<div class="form-group">
				<label for="category_id" class="form-label-agri">Catégorie</label>
				<select id="category_id" name="category_id" class="form-select-agri">
					<option value="">Sélectionnez une catégorie (optionnel)</option>
					@isset($categories)
						@foreach($categories as $category)
							<option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
					placeholder="Description du produit (optionnel)"
					rows="5"
				>{{ old('description') }}</textarea>
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
						placeholder="Prix" 
						value="{{ old('price') }}"
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
						<option value="per_unit" {{ old('pricing_unit') == 'per_unit' ? 'selected' : '' }}>Par unité</option>
						<option value="per_kilo" {{ old('pricing_unit') == 'per_kilo' ? 'selected' : '' }}>Par kilo</option>
						<option value="per_hectare" {{ old('pricing_unit') == 'per_hectare' ? 'selected' : '' }}>Par hectare</option>
						<option value="per_hour" {{ old('pricing_unit') == 'per_hour' ? 'selected' : '' }}>Par heure</option>
						<option value="per_day" {{ old('pricing_unit') == 'per_day' ? 'selected' : '' }}>Par jour</option>
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
					placeholder="Quantité en stock" 
					value="{{ old('stock') }}"
					required 
				/>
				@error('stock')
					<span class="form-error-agri">{{ $message }}</span>
				@enderror
			</div>

			<div class="form-group">
				<label for="images" class="form-label-agri">Images</label>
				<input 
					type="file" 
					id="images" 
					name="images[]" 
					class="form-input-agri" 
					multiple 
					accept="image/*" 
				/>
				@error('images')
					<span class="form-error-agri">{{ $message }}</span>
				@enderror
			</div>

			<div class="flex gap-3 mt-6">
				<button type="submit" class="btn-primary-agri">
					Créer le produit
				</button>
				<a href="{{ route('products.index') }}" class="btn-secondary-agri">
					Annuler
				</a>
			</div>
		</form>
	</div>
</x-app-layout>
