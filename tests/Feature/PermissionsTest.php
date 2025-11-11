<?php

use App\Models\User;
use App\Models\Equipment;

it('prevents non-owners from updating equipment', function () {
    $owner = User::factory()->create();
    $owner->assignRole('equipment_owner');
    $someoneElse = User::factory()->create();
    $someoneElse->assignRole('equipment_owner');

    $equipment = Equipment::create([
        'user_id' => $owner->id,
        'title' => 'Moissonneuse',
        'daily_rate' => 200,
        'is_available' => true,
        'is_active' => true,
    ]);

    $this->actingAs($someoneElse)
        ->put(route('equipment.update', $equipment), ['title' => 'Y'])
        ->assertStatus(403);

    expect($equipment->fresh()->title)->toBe('Moissonneuse');
});


