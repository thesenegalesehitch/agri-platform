<x-app-layout>
	<x-slot name="header"><h2 class="font-semibold text-xl">Nouveau Matériel</h2></x-slot>
	<div class="p-6">
		<form method="POST" action="{{ route('equipment.store') }}" class="space-y-4" enctype="multipart/form-data">@csrf
			<input name="title" class="w-full border p-2" placeholder="Titre" required />
			<textarea name="description" class="w-full border p-2" placeholder="Description (optionnel)"></textarea>
			<input type="number" step="0.01" name="daily_rate" class="w-full border p-2" placeholder="Tarif" required />
			<select name="pricing_unit" class="w-full border p-2" required>
				<option value="">Sélectionnez l'unité de prix</option>
				<option value="per_hour">Par heure</option>
				<option value="per_day">Par jour</option>
				<option value="per_week">Par semaine</option>
				<option value="per_month">Par mois</option>
			</select>
			<input name="location" class="w-full border p-2" placeholder="Localisation" />
			<input type="file" name="images[]" class="w-full border p-2" multiple accept="image/*" />
			<button class="px-4 py-2 bg-blue-600 text-white rounded">Créer</button>
		</form>
	</div>
</x-app-layout>
