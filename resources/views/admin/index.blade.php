<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">Administration</h2>
	</x-slot>

	<!-- Statistiques -->
	<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
		<div class="content-card fade-in">
			<div class="flex items-center justify-between">
				<div>
					<p class="text-sm text-[#55493f] mb-1">Total Utilisateurs</p>
					<p class="text-2xl font-bold text-[#5c4033]">{{ $stats['total'] }}</p>
				</div>
				<div class="text-3xl">👥</div>
			</div>
		</div>
		<div class="content-card fade-in">
			<div class="flex items-center justify-between">
				<div>
					<p class="text-sm text-[#55493f] mb-1">Actifs</p>
					<p class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</p>
				</div>
				<div class="text-3xl">✅</div>
			</div>
		</div>
		<div class="content-card fade-in">
			<div class="flex items-center justify-between">
				<div>
					<p class="text-sm text-[#55493f] mb-1">Suspendus</p>
					<p class="text-2xl font-bold text-red-600">{{ $stats['suspended'] }}</p>
				</div>
				<div class="text-3xl">🚫</div>
			</div>
		</div>
		<div class="content-card fade-in">
			<div class="flex items-center justify-between">
				<div>
					<p class="text-sm text-[#55493f] mb-1">CNI en attente</p>
					<p class="text-2xl font-bold text-yellow-600">{{ $stats['pending_cni'] }}</p>
				</div>
				<div class="text-3xl">📄</div>
			</div>
		</div>
	</div>

	<!-- Actions rapides -->
	<div class="content-card fade-in mb-6">
		<h3 class="section-title-agri mb-4">Actions Rapides</h3>
		<div class="flex flex-wrap gap-3">
			<a href="{{ route('admin.users.index') }}" class="btn-primary-agri">
				👥 Gérer les Utilisateurs
			</a>
			<a href="{{ route('admin.cni.index') }}" class="btn-primary-agri">
				📄 Vérifier les CNI ({{ $stats['pending_cni'] }} en attente)
			</a>
			<a href="{{ route('suspension-requests.index') }}" class="btn-secondary-agri">
				🔓 Demandes de Réactivation
			</a>
		</div>
	</div>

	<!-- Filtres -->
	<div class="content-card fade-in mb-6">
		<div class="flex flex-wrap items-center gap-3">
			<a href="{{ route('admin.dashboard', ['filter' => 'all']) }}" 
			   class="px-4 py-2 rounded-lg {{ $filter === 'all' ? 'bg-[#5c4033] text-white' : 'bg-[#f8f6f3] text-[#5c4033] hover:bg-[#e0dcd6]' }}">
				Tous
			</a>
			<a href="{{ route('admin.dashboard', ['filter' => 'active']) }}" 
			   class="px-4 py-2 rounded-lg {{ $filter === 'active' ? 'bg-[#5c4033] text-white' : 'bg-[#f8f6f3] text-[#5c4033] hover:bg-[#e0dcd6]' }}">
				Actifs
			</a>
			<a href="{{ route('admin.dashboard', ['filter' => 'suspended']) }}" 
			   class="px-4 py-2 rounded-lg {{ $filter === 'suspended' ? 'bg-[#5c4033] text-white' : 'bg-[#f8f6f3] text-[#5c4033] hover:bg-[#e0dcd6]' }}">
				Suspendus
			</a>
			<a href="{{ route('admin.dashboard', ['filter' => 'unverified_cni']) }}" 
			   class="px-4 py-2 rounded-lg {{ $filter === 'unverified_cni' ? 'bg-[#5c4033] text-white' : 'bg-[#f8f6f3] text-[#5c4033] hover:bg-[#e0dcd6]' }}">
				CNI Non Vérifiées
			</a>
		</div>
	</div>

	<!-- Liste des utilisateurs -->
	<div class="content-card fade-in">
		<h3 class="section-title-agri mb-4">Liste des Utilisateurs</h3>
		
		<div class="overflow-x-auto">
			<table class="table-agri">
				<thead>
					<tr>
						<th>Nom</th>
						<th>Email</th>
						<th>Téléphone</th>
						<th>Rôles</th>
						<th>CNI</th>
						<th>Statut</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $u)
						<tr>
							<td class="font-semibold text-[#5c4033]">{{ $u->name }}</td>
							<td class="text-[#55493f]">{{ $u->email }}</td>
							<td class="text-[#55493f]">
								@if($u->phone)
									{{ $u->phone }}
									@if($u->phone_verified)
										<span class="text-xs text-green-600 ml-1">✓</span>
									@endif
								@else
									<span class="text-gray-400">-</span>
								@endif
							</td>
							<td class="text-[#55493f]">
								@foreach($u->roles as $role)
									<span class="px-2 py-1 bg-[#f8f6f3] text-[#5c4033] rounded text-xs mr-1">{{ $role->name }}</span>
								@endforeach
							</td>
							<td>
								@if($u->cni_verified)
									<span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">✓ Vérifiée</span>
								@elseif($u->cni_recto_path && $u->cni_verso_path)
									<a href="{{ route('admin.cni.show', $u) }}" class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium hover:bg-yellow-200">
										⏳ En attente
									</a>
								@else
									<span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">Non fournie</span>
								@endif
							</td>
							<td>
								@if($u->is_suspended)
									<span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">Suspendu</span>
								@else
									<span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Actif</span>
								@endif
							</td>
							<td class="space-x-2">
								<a href="{{ route('admin.users.show', $u) }}" class="btn-secondary-agri" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
									👁️ Voir
								</a>
								@if(!$u->is_suspended)
									<form method="POST" action="{{ route('admin.users.suspend', $u) }}" class="inline">
										@csrf @method('PATCH')
										<button type="submit" class="btn-danger-agri" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
											🚫 Suspendre
										</button>
									</form>
								@else
									<form method="POST" action="{{ route('admin.users.reactivate', $u) }}" class="inline">
										@csrf @method('PATCH')
										<button type="submit" class="btn-primary-agri" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
											✅ Réactiver
										</button>
									</form>
								@endif
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
