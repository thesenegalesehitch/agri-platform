<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Equipment")
 */
class EquipmentController extends Controller
{
	/**
	 * @OA\Get(
	 *   path="/api/equipment",
	 *   tags={"Equipment"},
	 *   security={{"sanctum":{}}},
	 *   @OA\Response(response=200, description="List")
	 * )
	 */
	public function index(Request $request)
	{
		$query = Equipment::query()->with('category');
		
		// Si l'utilisateur est un propriétaire d'équipement, afficher uniquement ses équipements
		if (Auth::check() && Auth::user()->hasRole('equipment_owner')) {
			$query->where('user_id', Auth::id());
		} else {
			// Pour les non-connectés et autres rôles, afficher uniquement les équipements actifs et disponibles
			$query->where('is_active', true)->where('is_available', true);
		}
		
		if ($request->filled('q')) {
			$query->where(function ($q) use ($request) {
				$q->where('title', 'like', '%'.$request->q.'%')
				  ->orWhere('description', 'like', '%'.$request->q.'%')
				  ->orWhere('location', 'like', '%'.$request->q.'%');
			});
		}
		if ($request->filled('location')) {
			$query->where('location', 'like', '%'.$request->input('location').'%');
		}
		if ($request->filled('category_id')) {
			$query->where('category_id', $request->integer('category_id'));
		}
		if ($request->boolean('available')) {
			$query->where('is_available', true);
		}
		if ($request->filled('min_rate')) {
			$query->where('daily_rate', '>=', (float)$request->input('min_rate'));
		}
		if ($request->filled('max_rate')) {
			$query->where('daily_rate', '<=', (float)$request->input('max_rate'));
		}
        $equipment = $query->with('images')->latest()->paginate(12);
        if ($request->wantsJson()) return response()->json($equipment);
        $categories = Category::where('type','equipment')->orderBy('name')->get();
        return view('equipment.index', compact('equipment','categories'));
	}

    public function create()
	{
        $categories = Category::where('type','equipment')->orderBy('name')->get();
        return view('equipment.create', compact('categories'));
	}

	public function store(StoreEquipmentRequest $request)
	{
		$equipment = Equipment::create([
			'user_id' => Auth::id(),
			'category_id' => $request->integer('category_id') ?: null,
			'title' => (string)$request->input('title'),
			'description' => $request->input('description'),
			'daily_rate' => $request->input('daily_rate'),
			'pricing_unit' => $request->input('pricing_unit'),
			'is_available' => $request->boolean('is_available', true),
			'location' => $request->input('location'),
			'is_active' => $request->boolean('is_active', true),
		]);

		if ($request->hasFile('images')) {
			foreach ($request->file('images') as $image) {
				$path = $image->store('uploads', 'public');
				$equipment->images()->create([
					'path' => $path,
					'is_primary' => false,
					'sort_order' => (int)(($equipment->images()->max('sort_order') ?? 0) + 1),
				]);
			}
		}

		return redirect()->route('equipment.show', $equipment)->with('status', 'Matériel créé');
	}

	public function show(Equipment $equipment, Request $request)
	{
		$equipment->load('images', 'category', 'user');
		if ($request->wantsJson()) return response()->json($equipment);
		return view('equipment.show', compact('equipment'));
	}

	public function edit(Equipment $equipment)
	{
		$categories = Category::where('type','equipment')->orderBy('name')->get();
		return view('equipment.edit', compact('equipment', 'categories'));
	}

	public function update(UpdateEquipmentRequest $request, Equipment $equipment)
	{
		$this->authorize('update', $equipment);
		$equipment->update($request->validated());
		return redirect()->route('equipment.show', $equipment)->with('status', 'Matériel mis à jour');
	}

	public function destroy(Equipment $equipment)
	{
		$this->authorize('delete', $equipment);
		$equipment->delete();
		return redirect()->route('equipment.index')->with('status', 'Matériel supprimé');
	}
}
