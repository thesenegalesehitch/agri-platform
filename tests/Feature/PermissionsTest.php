<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Equipment;

it('prevents non-owners from updating products and equipment', function () {
    $producer = User::factory()->create();
    $producer->assignRole('producer');
    $other = User::factory()->create();
    $other->assignRole('producer');

    $product = Product::create([
        'user_id' => $producer->id,
        'title' => 'Blé',
        'price' => 5,
        'stock' => 5,
        'is_active' => true,
    ]);

    $this->actingAs($other)
        ->put(route('products.update', $product), ['title' => 'X'])
        ->assertStatus(403); // forbidden for non-owner

    expect($product->fresh()->title)->toBe('Blé');

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
