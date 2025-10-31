<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">Gestion des Utilisateurs</h2>
	</x-slot>

	<div class="content-card fade-in mb-6">
		<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
			<form method="GET" class="flex items-center gap-2 flex-1">
				<input 
					name="q" 
					value="{{ request('q') }}" 
					placeholder="Recherche nom/email" 
					class="form-input-agri flex-1" 
				/>
				<button type="submit" class="btn-primary-agri">
					🔍 Filtrer
				</button>
			</form>
			<a href="{{ route('admin.users.create') }}" class="btn-primary-agri">
				➕ Créer un utilisateur
			</a>
		</div>
	</div>

	<div class="content-card fade-in">
		<div class="overflow-x-auto">
			<table class="table-agri">
				<thead>
					<tr>
						<th>Nom</th>
						<th>Email</th>
						<th>Rôles</th>
						<th>Suspendu</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $u)
						<tr id="user-{{ $u->id }}">
							<td class="font-semibold text-[#5c4033]">{{ $u->name }}</td>
							<td class="text-[#55493f]">{{ $u->email }}</td>
							<td class="text-[#55493f]">
								@foreach($u->getRoleNames()->toArray() as $roleName)
									<span class="px-2 py-1 bg-[#f8f6f3] text-[#5c4033] rounded text-xs mr-1">{{ $roleName }}</span>
								@endforeach
							</td>
							<td>
								@if($u->is_suspended)
									<span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">Oui</span>
								@else
									<span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Non</span>
								@endif
							</td>
							<td class="space-x-2">
								<a href="{{ route('admin.users.edit', $u) }}" class="btn-secondary-agri" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
									✏️ Éditer
								</a>
								<form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="inline">
									@csrf @method('DELETE')
									<button type="submit" class="btn-danger-agri" style="padding: 0.5rem 1rem; font-size: 0.9rem;" onclick="return confirm('Supprimer cet utilisateur ?')">
										🗑️ Supprimer
									</button>
								</form>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		@if($users->hasPages())
			<div class="mt-6 flex justify-center">
				{{ $users->links() }}
			</div>
		@endif
	</div>
</x-app-layout>
