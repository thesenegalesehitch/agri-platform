<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\RentalStatusChanged;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Rental::query()->with('equipment');
        if ($user->hasRole('equipment_owner')) {
            $query->whereHas('equipment', fn ($q) => $q->where('user_id', $user->id));
        } else {
            $query->where('renter_id', $user->id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('from')) {
            $query->whereDate('start_date', '>=', $request->input('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('end_date', '<=', $request->input('to'));
        }
        $rentals = $query->latest()->paginate(12);
        return view('rentals.index', compact('rentals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ?Equipment $equipment = null)
    {
        $data = $request->validate([
            'start_date' => ['required','date','after_or_equal:today'],
            'end_date' => ['required','date','after:start_date'],
        ]);

        if (!$equipment && $request->route('equipment')) {
            $equipment = Equipment::findOrFail($request->route('equipment'));
        }

        // Availability check
        $overlap = $equipment->rentals()
            ->whereIn('status', ['pending','approved','active'])
            ->where(function ($q) use ($data) {
                $q->whereBetween('start_date', [$data['start_date'], $data['end_date']])
                  ->orWhereBetween('end_date', [$data['start_date'], $data['end_date']])
                  ->orWhere(function ($q2) use ($data) {
                      $q2->where('start_date', '<=', $data['start_date'])
                         ->where('end_date', '>=', $data['end_date']);
                  });
            })->exists();
        if ($overlap) {
            return back()->withErrors(['dates' => 'Période indisponible']);
        }

        $days = max(1, (new \Carbon\Carbon($data['start_date']))->diffInDays((new \Carbon\Carbon($data['end_date']))));
        $total = max(0.01, $days * $equipment->daily_rate);

        $rental = Rental::create([
            'equipment_id' => $equipment->id,
            'renter_id' => Auth::id(),
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => 'pending',
            'total' => $total,
        ]);

        // Notify renter and owner
        Auth::user()->notify(new RentalStatusChanged($rental));
        $equipment->user->notify(new RentalStatusChanged($rental));

        return back()->with('status', 'Demande de location envoyée');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rental $rental)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rental $rental)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rental $rental)
    {
        $request->validate(['status' => ['required','in:approved,rejected,active,completed,cancelled']]);
        $rental->update(['status' => $request->input('status')]);
        // Notify both parties
        $rental->renter->notify(new RentalStatusChanged($rental));
        $rental->equipment->user->notify(new RentalStatusChanged($rental));
        return back()->with('status', 'Location mise à jour');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rental $rental)
    {
        //
    }
}
