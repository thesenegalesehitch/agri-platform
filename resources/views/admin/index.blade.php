<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin</h2>
	</x-slot>
	<div class="py-6">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<table class="min-w-full bg-white">
				<thead><tr><th class="p-2 text-left">Nom</th><th class="p-2">Email</th><th class="p-2">Suspendu</th><th class="p-2">Actions</th></tr></thead>
				<tbody>
				@foreach($users as $u)
					<tr class="border-t">
						<td class="p-2">{{ $u->name }}</td>
						<td class="p-2">{{ $u->email }}</td>
						<td class="p-2">{{ $u->is_suspended ? 'Oui' : 'Non' }}</td>
						<td class="p-2 space-x-2">
							@if(!$u->is_suspended)
								<form method="POST" action="{{ route('admin.users.suspend', $u) }}" class="inline">@csrf @method('PATCH')<button class="px-3 py-1 bg-red-600 text-white rounded">Suspendre</button></form>
							@else
								<form method="POST" action="{{ route('admin.users.reactivate', $u) }}" class="inline">@csrf @method('PATCH')<button class="px-3 py-1 bg-green-600 text-white rounded">Réactiver</button></form>
							@endif
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			<div class="mt-4">{{ $users->links() }}</div>
		</div>
	</div>
</x-app-layout>
