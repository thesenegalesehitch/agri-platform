<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">Vérification des CNI</h2>
	</x-slot>

	@php
		use Illuminate\Support\Facades\Storage;
	@endphp

	<!-- Filtres -->
	<div class="content-card fade-in mb-6">
		<div class="flex flex-wrap items-center gap-3">
			<a href="{{ route('admin.cni.index', ['filter' => 'pending']) }}" 
			   class="px-4 py-2 rounded-lg {{ $filter === 'pending' ? 'bg-[#5c4033] text-white' : 'bg-[#f8f6f3] text-[#5c4033] hover:bg-[#e0dcd6]' }}">
				⏳ En attente
			</a>
			<a href="{{ route('admin.cni.index', ['filter' => 'verified']) }}" 
			   class="px-4 py-2 rounded-lg {{ $filter === 'verified' ? 'bg-[#5c4033] text-white' : 'bg-[#f8f6f3] text-[#5c4033] hover:bg-[#e0dcd6]' }}">
				✓ Vérifiées
			</a>
			<a href="{{ route('admin.cni.index', ['filter' => 'all']) }}" 
			   class="px-4 py-2 rounded-lg {{ $filter === 'all' ? 'bg-[#5c4033] text-white' : 'bg-[#f8f6f3] text-[#5c4033] hover:bg-[#e0dcd6]' }}">
				Toutes
			</a>
		</div>
	</div>

	<!-- Liste des utilisateurs avec CNI -->
	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
		@foreach($users as $user)
			<div class="content-card fade-in">
				<div class="flex items-center justify-between mb-4">
					<div>
						<h3 class="font-bold text-lg text-[#5c4033]">{{ $user->name }}</h3>
						<p class="text-sm text-[#55493f]">{{ $user->email }}</p>
						@if($user->cni_number)
							<p class="text-xs text-[#55493f] mt-1">CNI: {{ $user->cni_number }}</p>
						@endif
					</div>
					@if($user->cni_verified)
						<span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">✓ Vérifiée</span>
					@else
						<span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">⏳ En attente</span>
					@endif
				</div>

				<div class="grid grid-cols-2 gap-3 mb-4">
					<div>
						<p class="text-xs text-[#55493f] mb-1">Recto</p>
						@if($user->cni_recto_path)
							<img src="{{ Storage::url($user->cni_recto_path) }}" alt="CNI Recto" class="w-full h-24 object-cover rounded border border-[#d0c9c0]">
						@else
							<div class="w-full h-24 bg-gray-100 rounded flex items-center justify-center text-xs text-gray-400">Non fourni</div>
						@endif
					</div>
					<div>
						<p class="text-xs text-[#55493f] mb-1">Verso</p>
						@if($user->cni_verso_path)
							<img src="{{ Storage::url($user->cni_verso_path) }}" alt="CNI Verso" class="w-full h-24 object-cover rounded border border-[#d0c9c0]">
						@else
							<div class="w-full h-24 bg-gray-100 rounded flex items-center justify-center text-xs text-gray-400">Non fourni</div>
						@endif
					</div>
				</div>

				@if($user->cni_verified_at)
					<p class="text-xs text-[#55493f] mb-3">
						Vérifiée le {{ $user->cni_verified_at->format('d/m/Y à H:i') }}
					</p>
				@endif

				@if(!$user->cni_verified)
					<div class="flex gap-2">
						<a href="{{ route('admin.cni.show', $user) }}" class="btn-primary-agri flex-1" style="padding: 0.5rem; font-size: 0.9rem; text-align: center;">
							👁️ Voir & Vérifier
						</a>
					</div>
				@else
					<a href="{{ route('admin.cni.show', $user) }}" class="btn-secondary-agri w-full" style="padding: 0.5rem; font-size: 0.9rem; text-align: center;">
						👁️ Voir les détails
					</a>
				@endif
			</div>
		@endforeach
	</div>

	@if($users->isEmpty())
		<div class="content-card fade-in text-center py-12">
			<p class="text-[#55493f] text-lg">Aucune CNI à vérifier pour le moment.</p>
		</div>
	@endif

	@if($users->hasPages())
		<div class="mt-6 flex justify-center">
			{{ $users->links() }}
		</div>
	@endif
</x-app-layout>

