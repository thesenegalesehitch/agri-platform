<x-app-layout>
	<x-slot name="header"><h2 class="font-semibold text-xl">{{ $product->title }}</h2></x-slot>
	<div class="max-w-4xl mx-auto">
		@if($product->images && $product->images->count())
			<div class="mb-6">
				@php $primary = $product->images->firstWhere('is_primary', 1) ?? $product->images->first(); @endphp
				@if($primary)
					<div class="relative overflow-hidden rounded-lg shadow-lg mb-4">
						<img src="{{ Storage::url($primary->path) }}" class="w-full h-64 md:h-80 object-cover" alt="{{ $product->title }}" />
						<div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
						<div class="absolute bottom-4 left-4 text-white">
							<h1 class="text-2xl md:text-3xl font-bold mb-2">{{ $product->title }}</h1>
							<p class="text-lg font-semibold">{{ number_format($product->price * 655.957, 0, ',', ' ') }} FCFA</p>
						</div>
					</div>
				@endif
				@if($product->images->count() > 1)
					<div class="grid grid-cols-2 md:grid-cols-4 gap-3">
						@foreach($product->images->where('id', '!=', $primary->id ?? null) as $img)
							<div class="relative group overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-shadow">
								<img src="{{ Storage::url($img->path) }}" class="w-full h-24 md:h-32 object-cover" alt="Image {{ $loop->iteration }}" />
								<div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
								@role('producer')
									<form method="POST" action="{{ route('images.destroy', $img) }}" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">@csrf @method('DELETE')
										<button class="px-2 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">×</button>
									</form>
								@endrole
							</div>
						@endforeach
					</div>
				@endif
			</div>
		@endif

		<div class="bg-white shadow-lg rounded-lg p-6">
			<p class="text-gray-700 mb-4 leading-relaxed">{{ $product->description }}</p>
			@role('producer')
				<div class="border-t pt-6 mt-6">
					<h3 class="text-lg font-semibold mb-4 text-gray-800">Gestion des Images</h3>
					<form method="POST" action="{{ route('images.reorder') }}" class="mb-6">@csrf @method('PATCH')
						<input type="hidden" name="imageable_type" value="product" />
						<input type="hidden" name="imageable_id" value="{{ $product->id }}" />
						<div class="space-y-3">
							@foreach($product->images as $img)
								<div class="flex items-center space-x-4 p-3 bg-gray-50 rounded-lg">
									<span class="w-16 text-sm font-medium">#{{ $img->id }}</span>
									<input type="number" name="orders[{{ $img->id }}]" value="{{ $img->sort_order }}" class="border p-2 w-20 rounded" />
									<label class="inline-flex items-center space-x-2">
										<input type="radio" name="primary_id" value="{{ $img->id }}" {{ $img->is_primary ? 'checked' : '' }} />
										<span class="text-sm">Image principale</span>
									</label>
								</div>
							@endforeach
						</div>
						<button class="mt-4 px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors">Enregistrer l'ordre</button>
					</form>
				</div>
			@endrole

			@role('producer')
				<div class="border-t pt-6 mt-6">
					<h3 class="text-lg font-semibold mb-4 text-gray-800">Ajouter des Images</h3>
					<form method="POST" action="{{ route('images.store') }}" enctype="multipart/form-data" class="flex flex-wrap items-center gap-4">@csrf
						<input type="hidden" name="imageable_type" value="product" />
						<input type="hidden" name="imageable_id" value="{{ $product->id }}" />
						<div class="flex-1 min-w-64">
							<input type="file" name="images[]" multiple required class="border p-3 rounded-lg w-full" />
						</div>
						<label class="inline-flex items-center space-x-2">
							<input type="checkbox" name="is_primary" value="1" class="rounded" />
							<span>Définir comme principale</span>
						</label>
						<button class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Uploader</button>
					</form>
				</div>
			@endrole

			<div class="border-t pt-6 mt-6 flex flex-wrap gap-3">
				<a href="{{ route('products.edit',$product) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">Modifier</a>
				<form method="POST" action="{{ route('products.destroy',$product) }}" class="inline">@csrf @method('DELETE')
					<button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">Supprimer</button>
				</form>
			</div>
		</div>
	</div>
</x-app-layout>
