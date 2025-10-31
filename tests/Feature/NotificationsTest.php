<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Equipment;
use App\Models\Rental;
use App\Notifications\OrderPaid;
use App\Notifications\RentalStatusChanged;
use Illuminate\Support\Facades\Notification;

it('sends notification on order paid', function () {
    Notification::fake();

    $buyer = User::factory()->create();
    $buyer->assignRole('buyer');
    $producer = User::factory()->create();
    $producer->assignRole('producer');

    $product = Product::create([
        'user_id' => $producer->id,
        'title' => 'Maïs',
        'price' => 3.00,
        'stock' => 5,
        'is_active' => true,
    ]);

    $this->actingAs($buyer)
        ->post(route('cart.add', $product));
    $this->post(route('cart.checkout'));

    Notification::assertSentTo($buyer, OrderPaid::class);
});

it('sends notifications on rental create and status change', function () {
    Notification::fake();

    $buyer = User::factory()->create();
    $buyer->assignRole('buyer');
    $owner = User::factory()->create();
    $owner->assignRole('equipment_owner');

    $equipment = Equipment::create([
        'user_id' => $owner->id,
        'title' => 'Pulvérisateur',
        'daily_rate' => 80,
        'is_available' => true,
        'is_active' => true,
    ]);

    $this->actingAs($buyer)
        ->post(route('rentals.store', $equipment), [
            'start_date' => now()->addDay()->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
        ]);

    Notification::assertSentToTimes($buyer, RentalStatusChanged::class, 1);
    Notification::assertSentToTimes($owner, RentalStatusChanged::class, 1);

    $rental = Rental::latest('id')->first();

    $this->actingAs($owner)
        ->patch(route('rentals.update', $rental), ['status' => 'approved']);

    Notification::assertSentTo($buyer, RentalStatusChanged::class);
});


