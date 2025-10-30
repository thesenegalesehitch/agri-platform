<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;

it('allows buyer to add to cart and checkout to create an order', function () {
    $buyer = User::factory()->create(['password' => Hash::make('password')]);
    $buyer->assignRole('buyer');

    $producer = User::factory()->create();
    $producer->assignRole('producer');

    $product = Product::create([
        'user_id' => $producer->id,
        'title' => 'Pommes',
        'price' => 2.50,
        'stock' => 10,
        'is_active' => true,
    ]);

    $this->actingAs($buyer)
        ->post(route('cart.add', $product))
        ->assertSessionHas('status');

    $this->post(route('cart.checkout'))
        ->assertRedirect();

    expect(Order::where('buyer_id', $buyer->id)->count())->toBe(1);
});
