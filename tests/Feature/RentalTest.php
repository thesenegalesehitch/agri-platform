<?php

use App\Models\User;
use App\Models\Equipment;
use App\Models\Rental;
use Illuminate\Support\Facades\Hash;

it('prevents overlapping rentals and allows valid request', function () {
    $buyer = User::factory()->create(['password' => Hash::make('password')]);
    $buyer->assignRole('buyer');

    $owner = User::factory()->create();
    $owner->assignRole('equipment_owner');

    $equipment = Equipment::create([
        'user_id' => $owner->id,
        'title' => 'Tracteur',
        'daily_rate' => 100,
        'is_available' => true,
        'is_active' => true,
    ]);

    // Existing approved rental
    Rental::create([
        'equipment_id' => $equipment->id,
        'renter_id' => $buyer->id,
        'start_date' => now()->addDays(5)->toDateString(),
        'end_date' => now()->addDays(7)->toDateString(),
        'status' => 'approved',
        'total' => 200,
    ]);

    $this->actingAs($buyer)
        ->post(route('rentals.store', $equipment), [
            'start_date' => now()->addDays(6)->toDateString(),
            'end_date' => now()->addDays(8)->toDateString(),
        ])->assertSessionHasErrors('dates');

    $this->post(route('rentals.store', $equipment), [
        'start_date' => now()->addDays(8)->toDateString(),
        'end_date' => now()->addDays(9)->toDateString(),
    ])->assertSessionHas('status');
});
