<x-app-layout>
	<x-slot name="header"><h2 class="font-semibold text-xl">Créer un utilisateur</h2></x-slot>
	<div class="p-6 max-w-2xl">
		<form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">@csrf
			<input name="name" class="w-full border p-2" placeholder="Nom" required />
			<input type="email" name="email" class="w-full border p-2" placeholder="Email" required />
			<input type="password" name="password" class="w-full border p-2" placeholder="Mot de passe" required />
			<input type="password" name="password_confirmation" class="w-full border p-2" placeholder="Confirmer" required />
			<select name="role" class="w-full border p-2" required>
				<option value="buyer">Acheteur</option>
				<option value="producer">Producteur</option>
				<option value="equipment_owner">Propriétaire matériel</option>
				<option value="admin">Admin</option>
			</select>
			<button class="px-4 py-2 bg-green-600 text-white rounded">Créer</button>
		</form>
	</div>
</x-app-layout>

