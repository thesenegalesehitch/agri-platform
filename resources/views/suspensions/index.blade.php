<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">
			@if($isAdmin)
				📋 Demandes de Réactivation
			@else
				Mes Demandes de Réactivation
			@endif
		</h2>
	</x-slot>

	<!-- Filtres (admin uniquement) -->
	@if($isAdmin)
		<div class="content-card fade-in mb-6">
			<div class="flex flex-wrap items-center gap-3">
				<a href="{{ route('suspension-requests.index', ['status' => '']) }}" 
				   class="px-4 py-2 rounded-lg {{ !$statusFilter ? 'bg-[#5c4033] text-white' : 'bg-[#f8f6f3] text-[#5c4033] hover:bg-[#e0dcd6]' }}">
					Toutes
				</a>
				<a href="{{ route('suspension-requests.index', ['status' => 'pending']) }}" 
				   class="px-4 py-2 rounded-lg {{ $statusFilter === 'pending' ? 'bg-[#5c4033] text-white' : 'bg-[#f8f6f3] text-[#5c4033] hover:bg-[#e0dcd6]' }}">
					⏳ En attente
				</a>
				<a href="{{ route('suspension-requests.index', ['status' => 'approved']) }}" 
				   class="px-4 py-2 rounded-lg {{ $statusFilter === 'approved' ? 'bg-[#5c4033] text-white' : 'bg-[#f8f6f3] text-[#5c4033] hover:bg-[#e0dcd6]' }}">
					✓ Approuvées
				</a>
				<a href="{{ route('suspension-requests.index', ['status' => 'rejected']) }}" 
				   class="px-4 py-2 rounded-lg {{ $statusFilter === 'rejected' ? 'bg-[#5c4033] text-white' : 'bg-[#f8f6f3] text-[#5c4033] hover:bg-[#e0dcd6]' }}">
					✗ Rejetées
				</a>
			</div>
		</div>
	@endif

	<!-- Liste des demandes -->
	<div class="space-y-4">
		@forelse($requests as $request)
			<div class="content-card fade-in">
				<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
					<div class="flex-1">
						@if($isAdmin)
							<p class="font-semibold text-[#5c4033] mb-1">
								{{ $request->user->name }} ({{ $request->user->email }})
							</p>
						@endif
						<p class="text-sm text-[#55493f] mb-2">
							<strong>Raison :</strong> {{ $request->reason }}
						</p>
						<div class="flex flex-wrap gap-2 text-xs text-[#55493f]">
							<span>Date: {{ $request->created_at->format('d/m/Y à H:i') }}</span>
							@if($request->reviewed_at)
								<span>• Traitée le: {{ $request->reviewed_at->format('d/m/Y à H:i') }}</span>
							@endif
							@if($isAdmin && $request->admin)
								<span>• Par: {{ $request->admin->name }}</span>
							@endif
						</div>
						@if($request->response)
							<div class="mt-2 p-3 bg-[#f8f6f3] rounded-lg">
								<p class="text-xs font-medium text-[#5c4033] mb-1">Réponse de l'administrateur :</p>
								<p class="text-sm text-[#55493f]">{{ $request->response }}</p>
							</div>
						@endif
					</div>
					<div class="flex items-center gap-3">
						@if($request->status === 'pending')
							<span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">⏳ En attente</span>
							@if($isAdmin)
								<form method="POST" action="{{ route('admin.suspensions.approve', $request) }}" class="inline">
									@csrf @method('PATCH')
									<button type="submit" class="btn-primary-agri" style="padding: 0.5rem 1rem; font-size: 0.9rem;" onclick="return confirm('Approuver cette demande de réactivation ?')">
										✓ Approuver
									</button>
								</form>
								<button type="button" onclick="showRejectModal({{ $request->id }})" class="btn-danger-agri" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
									✗ Rejeter
								</button>
								
								<!-- Modal pour rejeter -->
								<div id="rejectModal{{ $request->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" onclick="if(event.target === this) hideRejectModal({{ $request->id }})">
									<div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 shadow-xl">
										<h3 class="section-title-agri mb-4">Rejeter la demande</h3>
										<form method="POST" action="{{ route('admin.suspensions.reject', $request) }}" class="space-y-3">
											@csrf @method('PATCH')
											<div class="form-group">
												<label class="form-label-agri">Raison du rejet</label>
												<textarea name="response" class="form-textarea-agri" rows="3" placeholder="Expliquez pourquoi la demande est rejetée..." required></textarea>
											</div>
											<div class="flex gap-3">
												<button type="submit" class="btn-danger-agri flex-1">Rejeter</button>
												<button type="button" onclick="hideRejectModal({{ $request->id }})" class="btn-secondary-agri flex-1">Annuler</button>
											</div>
										</form>
									</div>
								</div>
							@endif
						@elseif($request->status === 'approved')
							<span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">✓ Approuvée</span>
						@else
							<span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">✗ Rejetée</span>
						@endif
					</div>
				</div>
			</div>
		@empty
			<div class="content-card fade-in text-center py-12">
				<p class="text-[#55493f] text-lg">Aucune demande de réactivation pour le moment.</p>
			</div>
		@endforelse
	</div>

	@if($requests->hasPages())
		<div class="mt-6 flex justify-center">
			{{ $requests->links() }}
		</div>
	@endif

	@if($isAdmin)
		<script>
			function showRejectModal(id) {
				document.getElementById('rejectModal' + id).classList.remove('hidden');
			}
			function hideRejectModal(id) {
				document.getElementById('rejectModal' + id).classList.add('hidden');
			}
		</script>
	@endif
</x-app-layout>

