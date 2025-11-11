<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    /**
     * Autocomplétion pour les équipements
     */
    public function autocompleteEquipment(Request $request): JsonResponse
    {
        $query = $request->input('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $results = Equipment::where('is_active', true)
            ->where('is_available', true)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', '%'.$query.'%')
                  ->orWhere('description', 'like', '%'.$query.'%')
                  ->orWhere('location', 'like', '%'.$query.'%');
            })
            ->with('category')
            ->limit(10)
            ->get()
            ->map(function ($equipment) {
                return [
                    'id' => $equipment->id,
                    'title' => $equipment->title,
                    'category' => $equipment->category?->name,
                    'location' => $equipment->location,
                    'daily_rate' => $equipment->daily_rate,
                    'url' => route('equipment.show', $equipment),
                ];
            });

        return response()->json($results);
    }

    /**
     * Autocomplétion pour les localités (régions/villes)
     */
    public function autocompleteLocations(Request $request): JsonResponse
    {
        $query = $request->input('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        // Localités depuis les équipements
        $equipmentLocations = Equipment::whereNotNull('location')
            ->where('location', 'like', '%'.$query.'%')
            ->where('is_active', true)
            ->distinct()
            ->pluck('location')
            ->take(10)
            ->toArray();

        // Localités depuis les utilisateurs (producteurs)
        $userLocations = User::whereHas('roles', function ($q) {
                $q->where('name', 'producer');
            })
            ->where(function ($q) use ($query) {
                $q->where('region', 'like', '%'.$query.'%')
                  ->orWhere('ville', 'like', '%'.$query.'%');
            })
            ->distinct()
            ->get()
            ->map(function ($user) {
                if ($user->ville && $user->region) {
                    return $user->ville.', '.$user->region;
                }
                return $user->region ?: $user->ville;
            })
            ->filter()
            ->unique()
            ->take(10)
            ->toArray();

        // Fusionner et nettoyer
        $allLocations = array_unique(array_merge($equipmentLocations, $userLocations));
        $results = array_slice($allLocations, 0, 10);

        return response()->json(array_map(function ($location) {
            return ['location' => $location];
        }, $results));
    }
}

