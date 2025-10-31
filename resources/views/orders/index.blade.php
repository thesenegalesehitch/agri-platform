<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">Mes Commandes</h2>
	</x-slot>

	<div class="content-card fade-in mb-6">
		<form method="GET" class="flex flex-wrap items-center gap-2">
			<select name="status" class="form-select-agri min-w-[150px]">
				<option value="">Tous les statuts</option>
				@foreach(['pending','paid','cancelled','completed'] as $st)
					<option value="{{ $st }}" {{ request('status')===$st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
				@endforeach
			</select>
			<input type="date" name="from" value="{{ request('from') }}" class="form-input-agri" />
			<input type="date" name="to" value="{{ request('to') }}" class="form-input-agri" />
			<button type="submit" class="btn-primary-agri">
				🔍 Filtrer
			</button>
		</form>
	</div>

	<div class="content-card fade-in">
		@if($orders->count() > 0)
			<div class="overflow-x-auto">
				<table class="table-agri">
					<thead>
						<tr>
							<th>#</th>
							<th>Total</th>
							<th>Statut</th>
							<th>Date</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($orders as $order)
							<tr>
								<td class="font-semibold text-[#5c4033]">#{{ $order->id }}</td>
								<td class="font-semibold text-[#4CAF50]">{{ number_format($order->total * 655.957, 0, ',', ' ') }} FCFA</td>
								<td>
									<span class="px-3 py-1 rounded-full text-sm font-medium
										@if($order->status === 'paid') bg-green-100 text-green-800
										@elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
										@elseif($order->status === 'cancelled') bg-red-100 text-red-800
										@else bg-blue-100 text-blue-800
										@endif">
										{{ ucfirst($order->status) }}
									</span>
								</td>
								<td>{{ $order->created_at->format('d/m/Y') }}</td>
								<td>
									<a href="{{ route('orders.show',$order) }}" class="btn-primary-agri" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
										Voir détails
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			@if($orders->hasPages())
				<div class="mt-6 flex justify-center">
					{{ $orders->links() }}
				</div>
			@endif
		@else
			<div class="text-center py-12">
				<p class="text-[#55493f] text-lg">Aucune commande pour le moment.</p>
				<a href="{{ route('products.index') }}" class="btn-primary-agri mt-4">
					Découvrir les produits
				</a>
			</div>
		@endif
	</div>
</x-app-layout>
