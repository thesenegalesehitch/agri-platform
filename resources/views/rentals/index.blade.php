<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">Mes Locations</h2>
	</x-slot>

	<div class="content-card fade-in mb-6">
		<form method="GET" class="flex flex-wrap items-center gap-2">
			<select name="status" class="form-select-agri min-w-[150px]">
				<option value="">Tous les statuts</option>
				@foreach(['pending','approved','rejected','active','completed','cancelled'] as $st)
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
		@if($rentals->count() > 0)
			<div class="overflow-x-auto">
				<table class="table-agri">
					<thead>
						<tr>
							<th>#</th>
							<th>Matériel</th>
							<th>Période</th>
							<th>Statut</th>
							<th>Total</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($rentals as $rental)
							<tr>
								<td class="font-semibold text-[#5c4033]">#{{ $rental->id }}</td>
								<td class="text-[#55493f]">{{ optional($rental->equipment)->title ?? 'N/A' }}</td>
								<td class="text-[#55493f]">{{ $rental->start_date->format('d/m/Y') }} → {{ $rental->end_date->format('d/m/Y') }}</td>
								<td>
									<span class="px-3 py-1 rounded-full text-sm font-medium
										@if($rental->status === 'approved' || $rental->status === 'active') bg-green-100 text-green-800
										@elseif($rental->status === 'pending') bg-yellow-100 text-yellow-800
										@elseif($rental->status === 'rejected' || $rental->status === 'cancelled') bg-red-100 text-red-800
										@else bg-blue-100 text-blue-800
										@endif">
										{{ ucfirst($rental->status) }}
									</span>
								</td>
								<td class="font-semibold text-[#4CAF50]">{{ number_format($rental->total * 655.957, 0, ',', ' ') }} FCFA</td>
								<td>
									<a href="{{ route('rentals.show', $rental) }}" class="btn-primary-agri" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
										Voir détails
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			@if($rentals->hasPages())
				<div class="mt-6 flex justify-center">
					{{ $rentals->links() }}
				</div>
			@endif
		@else
			<div class="text-center py-12">
				<p class="text-[#55493f] text-lg">Aucune location pour le moment.</p>
			</div>
		@endif
	</div>
</x-app-layout>
