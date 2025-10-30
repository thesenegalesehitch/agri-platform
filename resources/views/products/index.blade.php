<x-app-layout>
	<x-slot name="header"><h2 class="font-semibold text-xl">Mes Produits</h2></x-slot>
	<div class="p-6 flex items-center justify-between">
		<a href="{{ route('products.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded">Nouveau</a>
		<form method="GET" action="{{ route('products.index') }}" class="flex items-center space-x-2">
			<input name="q" value="{{ request('q') }}" placeholder="Recherche" class="border p-2" />
			<select name="category_id" class="border p-2">
				<option value="">Catégorie</option>
				@isset($categories)
					@foreach($categories as $cat)
						<option value="{{ $cat->id }}" {{ (string)$cat->id === (string)request('category_id') ? 'selected' : '' }}>{{ $cat->name }}</option>
					@endforeach
				@endisset
			</select>
			<input type="number" step="0.01" name="min_price" value="{{ request('min_price') }}" placeholder="Min FCFA" class="border p-2 w-28" />
			<input type="number" step="0.01" name="max_price" value="{{ request('max_price') }}" placeholder="Max FCFA" class="border p-2 w-28" />
			<button class="px-3 py-2 bg-gray-800 text-white rounded">Filtrer</button>
		</form>
	</div>
	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
		@foreach($products as $product)
			<div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow">
				@if($product->images && $product->images->count())
					@php $primaryImage = $product->images->firstWhere('is_primary', 1) ?? $product->images->first(); @endphp
					<div class="h-48 overflow-hidden">
						<img src="{{ Storage::url($primaryImage->path) }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" alt="{{ $product->title }}" />
					</div>
				@else
					<div class="h-48 bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
						<span class="text-4xl">🌾</span>
					</div>
				@endif
				<div class="p-4">
					<h3 class="font-bold text-lg mb-2 text-gray-800">{{ $product->title }}</h3>
					<p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ Str::limit($product->description, 100) }}</p>
					<div class="flex justify-between items-center">
						<span class="text-lg font-semibold text-green-600">{{ number_format($product->price * 655.957, 0, ',', ' ') }} FCFA</span>
						<a href="{{ route('products.show',$product) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">Voir détails</a>
					</div>
				</div>
			</div>
		@endforeach
	</div>
	<div class="p-6">{{ $products->links() }}</div>
</x-app-layout>
