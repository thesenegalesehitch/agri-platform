<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">Demandes d'Annulation de Commandes</h2>
	</x-slot>

	<div class="max-w-6xl mx-auto">
		@if(session('status'))
			<div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
				{{ session('status') }}
			</div>
		@endif

		@if($orders->count() > 0)
			<div class="content-card fade-in">
				<div class="overflow-x-auto">
					<table class="min-w-full divide-y divide-[#d0c9c0]">
						<thead class="bg-[#f8f6f3]">
							<tr>
								<th class="px-6 py-3 text-left text-xs font-medium text-[#5c4033] uppercase tracking-wider">Commande</th>
								<th class="px-6 py-3 text-left text-xs font-medium text-[#5c4033] uppercase tracking-wider">Client</th>
								<th class="px-6 py-3 text-left text-xs font-medium text-[#5c4033] uppercase tracking-wider">Montant</th>
								<th class="px-6 py-3 text-left text-xs font-medium text-[#5c4033] uppercase tracking-wider">Statut</th>
								<th class="px-6 py-3 text-left text-xs font-medium text-[#5c4033] uppercase tracking-wider">Date demande</th>
								<th class="px-6 py-3 text-right text-xs font-medium text-[#5c4033] uppercase tracking-wider">Actions</th>
							</tr>
						</thead>
						<tbody class="bg-white divide-y divide-[#d0c9c0]">
							@foreach($orders as $order)
								<tr class="hover:bg-[#f8f6f3]">
									<td class="px-6 py-4 whitespace-nowrap">
										<span class="font-semibold text-[#5c4033]">#{{ $order->id }}</span>
									</td>
									<td class="px-6 py-4 whitespace-nowrap">
										<div>
											<div class="text-sm font-medium text-[#55493f]">{{ $order->buyer->name }}</div>
											<div class="text-sm text-[#55493f]">{{ $order->buyer->email }}</div>
										</div>
									</td>
									<td class="px-6 py-4 whitespace-nowrap">
										<span class="font-bold text-[#4CAF50]">
											{{ number_format($order->total * 655.957, 0, ',', ' ') }} FCFA
										</span>
									</td>
									<td class="px-6 py-4 whitespace-nowrap">
										<span class="px-2 py-1 text-xs font-semibold rounded-full
											@if($order->status === 'paid') bg-green-100 text-green-800
											@elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
											@elseif($order->status === 'pending_payment') bg-blue-100 text-blue-800
											@else bg-gray-100 text-gray-800
											@endif">
											{{ ucfirst($order->status) }}
										</span>
									</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm text-[#55493f]">
										{{ $order->cancellation_requested_at ? $order->cancellation_requested_at->format('d/m/Y H:i') : '-' }}
									</td>
									<td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
										<a href="{{ route('admin.orders.cancellations.show', $order) }}" class="btn-primary-agri text-sm">
											Voir détails
										</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<div class="mt-6">
					{{ $orders->links() }}
				</div>
			</div>
		@else
			<div class="content-card fade-in text-center py-12">
				<span class="text-6xl mb-4 block">✅</span>
				<p class="text-[#55493f] text-lg">Aucune demande d'annulation en attente</p>
			</div>
		@endif
	</div>
</x-app-layout>

