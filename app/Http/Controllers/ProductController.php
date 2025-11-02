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
		$query = Product::query()->with('category', 'user');
		
		// Si l'utilisateur est un producteur, afficher uniquement ses produits
		if (Auth::check() && Auth::user()->hasRole('producer')) {
			$query->where('user_id', Auth::id());
		} else {
			// Pour les non-connectés et autres rôles, afficher uniquement les produits actifs
			$query->where('is_active', true);
		}
		
		if ($request->filled('q')) {
			$query->where(function ($q) use ($request) {
				$q->where('title', 'like', '%'.$request->q.'%')
				  ->orWhere('description', 'like', '%'.$request->q.'%')
				  ->orWhereHas('user', function ($userQuery) use ($request) {
					  $userQuery->where('region', 'like', '%'.$request->q.'%')
					           ->orWhere('ville', 'like', '%'.$request->q.'%')
					           ->orWhere('address_line1', 'like', '%'.$request->q.'%');
				  });
			});
		}
		if ($request->filled('location')) {
			$query->whereHas('user', function ($userQuery) use ($request) {
				$userQuery->where('region', 'like', '%'.$request->input('location').'%')
				         ->orWhere('ville', 'like', '%'.$request->input('location').'%')
				         ->orWhere('address_line1', 'like', '%'.$request->input('location').'%');
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
        $products = $query->with('images')->latest()->paginate(12);
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
		// Vérifier que l'utilisateur est authentifié
		if (!Auth::check()) {
			return redirect()->route('login')->withErrors(['error' => 'Vous devez être connecté pour créer un produit.']);
		}
		
		// Vérifier le rôle via middleware et policy
		$this->authorize('create', Product::class);
		
		// Double vérification du rôle
		if (!Auth::user()->hasRole('producer')) {
			abort(403, 'Vous n\'avez pas le rôle requis pour créer un produit.');
		}
		
        $categories = \Illuminate\Support\Facades\Cache::remember('categories_product', 3600, function () {
            return Category::where('type','product')->orderBy('name')->get();
        });
        return view('products.create', compact('categories'));
	}

	public function store(StoreProductRequest $request)
	{
		// Vérifier que l'utilisateur est authentifié
		if (!Auth::check()) {
			return redirect()->route('login')->withErrors(['error' => 'Vous devez être connecté pour créer un produit.']);
		}
		
		// Vérifier le rôle
		$this->authorize('create', Product::class);
		
		if (!Auth::user()->hasRole('producer')) {
			abort(403, 'Vous n\'avez pas le rôle requis pour créer un produit.');
		}
		
		\Illuminate\Support\Facades\DB::beginTransaction();
		try {
			$product = Product::create([
			'user_id' => Auth::id(),
			'category_id' => $request->integer('category_id') ?: null,
			'title' => (string)$request->input('title'),
			'description' => $request->input('description'),
			'price' => $request->input('price'),
			'pricing_unit' => $request->input('pricing_unit'),
			'stock' => $request->integer('stock'),
			'is_active' => $request->boolean('is_active', true),
		]);

			// Vérifier la limite de 10 images
			$currentImageCount = $product->images()->count();
			$newImageCount = count($request->file('images', []));
			if ($currentImageCount + $newImageCount > 10) {
				throw new \Exception('Vous ne pouvez pas avoir plus de 10 images. Actuellement: ' . $currentImageCount);
			}

			if ($request->hasFile('images')) {
				$firstImage = true;
				foreach ($request->file('images') as $image) {
					$path = $image->store('uploads', 'public');
					$product->images()->create([
						'path' => $path,
						'source_type' => 'local',
						'is_primary' => $firstImage && $product->images()->count() === 0, // Première image devient principale si aucune autre
						'sort_order' => (int)(($product->images()->max('sort_order') ?? 0) + 1),
					]);
					$firstImage = false;
				}
			}
			
			\Illuminate\Support\Facades\DB::commit();
			return redirect()->route('products.show', $product)->with('status', 'Produit créé avec succès');
		} catch (\Exception $e) {
			\Illuminate\Support\Facades\DB::rollBack();
			return back()->withErrors(['error' => 'Erreur lors de la création du produit: ' . $e->getMessage()])->withInput();
		}
	}

	public function show(Product $product, Request $request)
	{
		$product->load('images', 'category', 'user');
		if ($request->wantsJson()) return response()->json($product);
		return view('products.show', compact('product'));
	}

	public function edit(Product $product)
	{
		$this->authorize('update', $product);
        $categories = \Illuminate\Support\Facades\Cache::remember('categories_product', 3600, function () {
            return Category::where('type','product')->orderBy('name')->get();
        });
        return view('products.edit', compact('product', 'categories'));
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
