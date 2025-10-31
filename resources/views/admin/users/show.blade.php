<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">Détails Utilisateur - {{ $user->name }}</h2>
	</x-slot>

	<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
		<!-- Informations personnelles -->
		<div class="content-card fade-in">
			<h3 class="section-title-agri mb-4">Informations Personnelles</h3>
			<div class="space-y-4">
				<div>
					<p class="text-sm font-medium text-[#5c4033]">Nom complet</p>
					<p class="text-[#55493f]">{{ $user->name }}</p>
				</div>
				<div>
					<p class="text-sm font-medium text-[#5c4033]">Email</p>
					<p class="text-[#55493f]">
						{{ $user->email }}
						@if($user->email_verified_at)
							<span class="ml-2 text-green-600 text-xs">✓ Vérifié</span>
						@endif
					</p>
				</div>
				@if($user->phone)
					<div>
						<p class="text-sm font-medium text-[#5c4033]">Téléphone</p>
						<p class="text-[#55493f]">
							{{ $user->phone }}
							@if($user->phone_verified)
								<span class="ml-2 text-green-600 text-xs">✓ Vérifié</span>
							@endif
						</p>
					</div>
				@endif
				@if($user->region)
					<div>
						<p class="text-sm font-medium text-[#5c4033]">Région / Ville</p>
						<p class="text-[#55493f]">{{ $user->region }} / {{ $user->ville }}</p>
					</div>
				@endif
			</div>
		</div>

		<!-- Statut et Vérifications -->
		<div class="content-card fade-in">
			<h3 class="section-title-agri mb-4">Statut et Vérifications</h3>
			<div class="space-y-4">
				<div>
					<p class="text-sm font-medium text-[#5c4033]">Rôles</p>
					<div class="flex flex-wrap gap-2 mt-1">
						@foreach($user->roles as $role)
							<span class="px-2 py-1 bg-[#f8f6f3] text-[#5c4033] rounded text-xs">{{ $role->name }}</span>
						@endforeach
					</div>
				</div>
				<div>
					<p class="text-sm font-medium text-[#5c4033]">Statut du compte</p>
					@if($user->is_suspended)
						<span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">Suspendu</span>
					@else
						<span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Actif</span>
					@endif
				</div>
				<div>
					<p class="text-sm font-medium text-[#5c4033]">Vérification CNI</p>
					@if($user->cni_verified)
						<span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">✓ Vérifiée</span>
						@if($user->cni_verified_at)
							<p class="text-xs text-[#55493f] mt-1">Le {{ $user->cni_verified_at->format('d/m/Y à H:i') }}</p>
						@endif
					@elseif($user->cni_recto_path && $user->cni_verso_path)
						<a href="{{ route('admin.cni.show', $user) }}" class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium hover:bg-yellow-200">
							⏳ En attente de vérification
						</a>
					@else
						<span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm font-medium">Non fournie</span>
					@endif
				</div>
			</div>
		</div>
	</div>

	<!-- Actions -->
	<div class="content-card fade-in mt-6">
		<h3 class="section-title-agri mb-4">Actions</h3>
		<div class="flex flex-wrap gap-3">
			<a href="{{ route('admin.users.edit', $user) }}" class="btn-secondary-agri">
				✏️ Modifier
			</a>
			@if($user->cni_recto_path && $user->cni_verso_path && !$user->cni_verified)
				<a href="{{ route('admin.cni.show', $user) }}" class="btn-primary-agri">
					📄 Vérifier la CNI
				</a>
			@endif
			@if(!$user->is_suspended)
				<form method="POST" action="{{ route('admin.users.suspend', $user) }}" class="inline">
					@csrf @method('PATCH')
					<button type="submit" class="btn-danger-agri" onclick="return confirm('Êtes-vous sûr de vouloir suspendre cet utilisateur ?')">
						🚫 Suspendre
					</button>
				</form>
			@else
				<form method="POST" action="{{ route('admin.users.reactivate', $user) }}" class="inline">
					@csrf @method('PATCH')
					<button type="submit" class="btn-primary-agri">
						✅ Réactiver
					</button>
				</form>
			@endif
			<a href="{{ route('admin.users.index') }}" class="btn-secondary-agri">
				← Retour à la liste
			</a>
		</div>
	</div>
</x-app-layout>

