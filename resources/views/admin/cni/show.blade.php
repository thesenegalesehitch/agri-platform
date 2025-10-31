<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">Vérification CNI - {{ $user->name }}</h2>
	</x-slot>

	@php
		use Illuminate\Support\Facades\Storage;
	@endphp

	<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
		<!-- Informations utilisateur -->
		<div class="content-card fade-in">
			<h3 class="section-title-agri mb-4">Informations Utilisateur</h3>
			<div class="space-y-3">
				<div>
					<p class="text-sm font-medium text-[#5c4033]">Nom complet</p>
					<p class="text-[#55493f]">{{ $user->name }}</p>
				</div>
				<div>
					<p class="text-sm font-medium text-[#5c4033]">Email</p>
					<p class="text-[#55493f]">{{ $user->email }}</p>
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
				@if($user->cni_number)
					<div>
						<p class="text-sm font-medium text-[#5c4033]">Numéro CNI</p>
						<p class="text-[#55493f]">{{ $user->cni_number }}</p>
					</div>
				@endif
				<div>
					<p class="text-sm font-medium text-[#5c4033]">Rôles</p>
					<div class="flex flex-wrap gap-2 mt-1">
						@foreach($user->roles as $role)
							<span class="px-2 py-1 bg-[#f8f6f3] text-[#5c4033] rounded text-xs">{{ $role->name }}</span>
						@endforeach
					</div>
				</div>
				<div>
					<p class="text-sm font-medium text-[#5c4033]">Statut</p>
					@if($user->is_suspended)
						<span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">Suspendu</span>
					@else
						<span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Actif</span>
					@endif
				</div>
			</div>
		</div>

		<!-- Photos CNI -->
		<div class="content-card fade-in">
			<h3 class="section-title-agri mb-4">Photos de la CNI</h3>
			
			<div class="space-y-4">
				<div>
					<p class="text-sm font-medium text-[#5c4033] mb-2">Recto</p>
					@if($user->cni_recto_path)
						<img src="{{ Storage::url($user->cni_recto_path) }}" alt="CNI Recto" class="w-full rounded-lg border border-[#d0c9c0] cursor-pointer hover:opacity-90" onclick="window.open(this.src, '_blank')">
					@else
						<div class="w-full h-48 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">Non fourni</div>
					@endif
				</div>

				<div>
					<p class="text-sm font-medium text-[#5c4033] mb-2">Verso</p>
					@if($user->cni_verso_path)
						<img src="{{ Storage::url($user->cni_verso_path) }}" alt="CNI Verso" class="w-full rounded-lg border border-[#d0c9c0] cursor-pointer hover:opacity-90" onclick="window.open(this.src, '_blank')">
					@else
						<div class="w-full h-48 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">Non fourni</div>
					@endif
				</div>
			</div>
		</div>
	</div>

	<!-- Actions de vérification -->
	@if(!$user->cni_verified)
		<div class="content-card fade-in mt-6">
			<h3 class="section-title-agri mb-4">Action de Vérification</h3>
			
			<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
				<!-- Approuver -->
				<div class="border-2 border-green-200 rounded-lg p-4 bg-green-50">
					<h4 class="font-semibold text-green-800 mb-3">✓ Approuver la CNI</h4>
					<form method="POST" action="{{ route('admin.cni.approve', $user) }}" class="space-y-3">
						@csrf
						<div class="form-group">
							<label class="form-label-agri">Notes (optionnel)</label>
							<textarea name="notes" class="form-textarea-agri" rows="3" placeholder="Notes internes..."></textarea>
						</div>
						<button type="submit" class="btn-primary-agri w-full" style="background: #4CAF50;">
							✓ Approuver la CNI
						</button>
					</form>
				</div>

				<!-- Rejeter -->
				<div class="border-2 border-red-200 rounded-lg p-4 bg-red-50">
					<h4 class="font-semibold text-red-800 mb-3">✗ Rejeter la CNI</h4>
					<form method="POST" action="{{ route('admin.cni.reject', $user) }}" class="space-y-3">
						@csrf
						<div class="form-group">
							<label class="form-label-agri">Raison du rejet *</label>
							<textarea name="notes" class="form-textarea-agri" rows="3" placeholder="Expliquez pourquoi la CNI est rejetée (sera envoyé à l'utilisateur)" required></textarea>
						</div>
						<button type="submit" class="btn-danger-agri w-full">
							✗ Rejeter la CNI
						</button>
					</form>
				</div>
			</div>
		</div>
	@else
		<!-- Statut vérifié -->
		<div class="content-card fade-in mt-6">
			<div class="bg-green-50 border-2 border-green-200 rounded-lg p-4">
				<p class="text-green-800 font-semibold mb-2">✓ CNI Vérifiée</p>
				<p class="text-sm text-green-700">
					Vérifiée le {{ $user->cni_verified_at->format('d/m/Y à H:i') }}
					@if($user->cni_verification_notes)
						<br><strong>Notes:</strong> {{ $user->cni_verification_notes }}
					@endif
				</p>
			</div>
		</div>
	@endif

	<div class="mt-6">
		<a href="{{ route('admin.cni.index') }}" class="btn-secondary-agri">
			← Retour à la liste
		</a>
	</div>
</x-app-layout>

