<x-app-layout>
	<x-slot name="header"><h2 class="font-semibold text-xl">Utilisateurs</h2></x-slot>
	<div class="p-6">
		<div class="flex items-center justify-between mb-4">
			<form method="GET" class="flex items-center space-x-2">
				<input name="q" value="{{ request('q') }}" placeholder="Recherche nom/email" class="border p-2" />
				<button class="px-3 py-2 bg-gray-800 text-white rounded">Filtrer</button>
			</form>
			<a href="{{ route('admin.users.create') }}" class="px-3 py-2 bg-green-600 text-white rounded">Créer</a>
		</div>
		<table class="min-w-full bg-white">
			<thead><tr><th class="p-2 text-left">Nom</th><th class="p-2">Email</th><th class="p-2">Rôles</th><th class="p-2">Suspendu</th><th class="p-2">Actions</th></tr></thead>
			<tbody>
			@foreach($users as $u)
				<tr class="border-t">
					<td class="p-2">{{ $u->name }}</td>
					<td class="p-2">{{ $u->email }}</td>
					<td class="p-2">{{ implode(', ', $u->getRoleNames()->toArray()) }}</td>
					<td class="p-2">{{ $u->is_suspended ? 'Oui' : 'Non' }}</td>
					<td class="p-2 space-x-2">
						<a href="{{ route('admin.users.edit', $u) }}" class="px-3 py-1 bg-blue-600 text-white rounded">Éditer</a>
						<form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="inline">@csrf @method('DELETE')
							<button class="px-3 py-1 bg-red-600 text-white rounded" onclick="return confirm('Supprimer ?')">Supprimer</button>
						</form>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<div class="mt-4">{{ $users->links() }}</div>
	</div>
</x-app-layout>

