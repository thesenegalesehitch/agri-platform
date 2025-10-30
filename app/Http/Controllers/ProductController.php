<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Products")
 */
class ProductController extends Controller
{
	/**
	 * @OA\Get(
	 *   path="/api/products",
	 *   tags={"Products"},
	 *   security={{"sanctum":{}}},
	 *   @OA\Parameter(name="q", in="query", @OA\Schema(type="string")),
	 *   @OA\Parameter(name="category_id", in="query", @OA\Schema(type="integer")),
	 *   @OA\Parameter(name="min_price", in="query", @OA\Schema(type="number")),
	 *   @OA\Parameter(name="max_price", in="query", @OA\Schema(type="number")),
	 *   @OA\Response(response=200, description="List")
	 * )
	 */
	public function index(Request $request)
	{
		$query = Product::query()->with('category');
		if ($request->filled('q')) {
			$query->where(function ($q) use ($request) {
				$q->where('title', 'like', '%'.$request->q.'%')
				  ->orWhere('description', 'like', '%'.$request->q.'%');
			});
		}
		if ($request->filled('category_id')) {
			$query->where('category_id', $request->integer('category_id'));
		}
		if ($request->filled('min_price')) {
			$query->where('price', '>=', (float)$request->input('min_price'));
		}
		if ($request->filled('max_price')) {
			$query->where('price', '<=', (float)$request->input('max_price'));
		}
		if (Auth::check() && Auth::user()->hasRole('producer')) {
			$query->where('user_id', Auth::id());
		}
        $products = $query->latest()->paginate(12);
        if ($request->wantsJson()) return response()->json($products);
        $categories = Category::where('type', 'product')->orderBy('name')->get();
        return view('products.index', compact('products','categories'));
	}

	/**
	 * @OA\Post(
	 *   path="/api/products",
	 *   tags={"Products"},
	 *   security={{"sanctum":{}}},
	 *   @OA\RequestBody(required=true),
	 *   @OA\Response(response=201, description="Created")
	 * )
	 */
    public function create()
	{
        $categories = Category::where('type','product')->orderBy('name')->get();
        return view('products.create', compact('categories'));
	}

	public function store(StoreProductRequest $request)
	{
		$product = Product::create([
			'user_id' => Auth::id(),
			'category_id' => $request->integer('category_id'),
			'title' => (string)$request->input('title'),
			'description' => $request->input('description'),
			'price' => $request->input('price'),
			'pricing_unit' => $request->input('pricing_unit'),
			'stock' => $request->integer('stock'),
			'is_active' => $request->boolean('is_active', true),
		]);

		if ($request->hasFile('images')) {
			foreach ($request->file('images') as $image) {
				$path = $image->store('uploads', 'public');
				$product->images()->create([
					'path' => $path,
					'is_primary' => false,
					'sort_order' => (int)($product->images()->max('sort_order') + 1),
				]);
			}
		}

		return redirect()->route('products.show', $product)->with('status', 'Produit créé');
	}

	public function show(Product $product, Request $request)
	{
		if ($request->wantsJson()) return response()->json($product->load('images','category'));
		return view('products.show', compact('product'));
	}

	public function edit(Product $product)
	{
		return view('products.edit', compact('product'));
	}

	public function update(UpdateProductRequest $request, Product $product)
	{
		$this->authorize('update', $product);
		$product->update($request->validated());
		return redirect()->route('products.show', $product)->with('status', 'Produit mis à jour');
	}

	public function destroy(Product $product)
	{
		$this->authorize('delete', $product);
		$product->delete();
		return redirect()->route('products.index')->with('status', 'Produit supprimé');
	}
}
