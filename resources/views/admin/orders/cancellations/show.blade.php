<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">Détails de la Demande d'Annulation - Commande #{{ $order->id }}</h2>
	</x-slot>

	<div class="max-w-4xl mx-auto">
		@if(session('status'))
			<div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
				{{ session('status') }}
			</div>
		@endif

		@if($errors->any())
			<div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
				<ul class="list-disc list-inside text-red-600 text-sm space-y-1">
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<div class="content-card fade-in mb-6">
			<h3 class="section-title-agri mb-4">Informations de la Commande</h3>
			<div class="grid grid-cols-2 gap-4 mb-4">
				<div>
					<span class="text-[#55493f] font-medium">Commande:</span>
					<span class="font-semibold text-[#5c4033]">#{{ $order->id }}</span>
				</div>
				<div>
					<span class="text-[#55493f] font-medium">Statut:</span>
					<span class="px-2 py-1 text-xs font-semibold rounded-full
						@if($order->status === 'paid') bg-green-100 text-green-800
						@elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
						@elseif($order->status === 'pending_payment') bg-blue-100 text-blue-800
						@else bg-gray-100 text-gray-800
						@endif">
						{{ ucfirst($order->status) }}
					</span>
				</div>
				<div>
					<span class="text-[#55493f] font-medium">Montant total:</span>
					<span class="font-bold text-[#4CAF50]">
						{{ number_format($order->total * 655.957, 0, ',', ' ') }} FCFA
					</span>
				</div>
				<div>
					<span class="text-[#55493f] font-medium">Date de demande:</span>
					<span class="text-[#55493f]">
						{{ $order->cancellation_requested_at ? $order->cancellation_requested_at->format('d/m/Y à H:i') : '-' }}
					</span>
				</div>
			</div>

			<div class="border-t border-[#d0c9c0] pt-4 mt-4">
				<h4 class="font-semibold text-[#5c4033] mb-2">Raison de l'annulation:</h4>
				<p class="text-[#55493f] bg-[#f8f6f3] p-4 rounded-lg">
					{{ $order->cancellation_reason }}
				</p>
			</div>
		</div>

		<div class="content-card fade-in mb-6">
			<h3 class="section-title-agri mb-4">Informations du Client</h3>
			<div class="grid grid-cols-2 gap-4">
				<div>
					<span class="text-[#55493f] font-medium">Nom:</span>
					<span class="text-[#5c4033]">{{ $order->buyer->name }}</span>
				</div>
				<div>
					<span class="text-[#55493f] font-medium">Email:</span>
					<span class="text-[#5c4033]">{{ $order->buyer->email }}</span>
				</div>
				@if($order->buyer->phone)
					<div>
						<span class="text-[#55493f] font-medium">Téléphone:</span>
						<span class="text-[#5c4033]">{{ $order->buyer->phone }}</span>
					</div>
				@endif
			</div>
		</div>

		<div class="content-card fade-in mb-6">
			<h3 class="section-title-agri mb-4">Articles de la Commande</h3>
			<div class="space-y-3">
				@foreach($order->items as $item)
					<div class="flex items-center justify-between p-4 bg-[#f8f6f3] rounded-lg">
						<div>
							<p class="font-semibold text-[#5c4033]">{{ $item->product->title }}</p>
							<p class="text-sm text-[#55493f]">Quantité: {{ $item->quantity }} × {{ number_format($item->unit_price * 655.957, 0, ',', ' ') }} FCFA</p>
						</div>
						<span class="font-bold text-[#4CAF50]">
							{{ number_format($item->total * 655.957, 0, ',', ' ') }} FCFA
						</span>
					</div>
				@endforeach
			</div>
		</div>

		<div class="content-card fade-in">
			<h3 class="section-title-agri mb-4">Actions</h3>
			<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
				<form method="POST" action="{{ route('admin.orders.cancellations.approve', $order) }}" class="flex-1">
					@csrf
					<button type="submit" class="btn-primary-agri w-full" onclick="return confirm('Êtes-vous sûr de vouloir approuver cette annulation ? Le stock sera restauré.')">
						✅ Approuver l'annulation
					</button>
				</form>

				<form method="POST" action="{{ route('admin.orders.cancellations.reject', $order) }}" class="flex-1">
					@csrf
					<div class="mb-3">
						<label for="rejection_reason" class="form-label-agri">
							Raison du rejet <span class="text-red-600">*</span>
						</label>
						<textarea 
							name="rejection_reason" 
							id="rejection_reason" 
							rows="3" 
							class="form-input-agri" 
							placeholder="Expliquez pourquoi la demande est rejetée (minimum 10 caractères)"
							required
							minlength="10"
							maxlength="500"
						></textarea>
					</div>
					<button type="submit" class="btn-danger-agri w-full" onclick="return confirm('Êtes-vous sûr de vouloir rejeter cette demande d\'annulation ?')">
						❌ Rejeter la demande
					</button>
				</form>
			</div>
		</div>

		<div class="mt-6">
			<a href="{{ route('admin.orders.cancellations.index') }}" class="btn-secondary-agri">
				← Retour à la liste
			</a>
		</div>
	</div>
</x-app-layout>

