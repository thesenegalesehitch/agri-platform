<x-app-layout>
	<x-slot name="header"><h2 class="font-semibold text-xl">Nouveau Produit</h2></x-slot>
	<div class="p-6">
		<form method="POST" action="{{ route('products.store') }}" class="space-y-4" enctype="multipart/form-data">@csrf
			<input name="title" class="w-full border p-2" placeholder="Titre" required />
			<textarea name="description" class="w-full border p-2" placeholder="Description (optionnel)"></textarea>
			<input type="number" step="0.01" name="price" class="w-full border p-2" placeholder="Prix" required />
			<select name="pricing_unit" class="w-full border p-2" required>
				<option value="">Sélectionnez l'unité de prix</option>
				<option value="per_unit">Par unité</option>
				<option value="per_kilo">Par kilo</option>
				<option value="per_hectare">Par hectare</option>
				<option value="per_hour">Par heure</option>
				<option value="per_day">Par jour</option>
			</select>
			<input type="number" name="stock" class="w-full border p-2" placeholder="Stock" required />
			<input type="file" name="images[]" class="w-full border p-2" multiple accept="image/*" />
			<button class="px-4 py-2 bg-blue-600 text-white rounded">Créer</button>
		</form>
	</div>
</x-app-layout>
