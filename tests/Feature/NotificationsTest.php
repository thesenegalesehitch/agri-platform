<?php

use App\Models\User;
use App\Models\Equipment;
use App\Models\Rental;
use App\Notifications\RentalStatusChanged;
use Illuminate\Support\Facades\Notification;

it('sends notifications on rental create and status change', function () {
    Notification::fake();

    $producer = User::factory()->create();
    $producer->assignRole('producer');
    $owner = User::factory()->create();
    $owner->assignRole('equipment_owner');

    $equipment = Equipment::create([
        'user_id' => $owner->id,
        'title' => 'Pulvérisateur',
        'daily_rate' => 80,
        'is_available' => true,
        'is_active' => true,
    ]);

    $this->actingAs($producer)
        ->post(route('rentals.store', $equipment), [
            'start_date' => now()->addDay()->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
        ]);

    Notification::assertSentToTimes($producer, RentalStatusChanged::class, 1);
    Notification::assertSentToTimes($owner, RentalStatusChanged::class, 1);

    $rental = Rental::latest('id')->first();

    $this->actingAs($owner)
        ->patch(route('rentals.update', $rental), ['status' => 'approved']);

    Notification::assertSentTo($producer, RentalStatusChanged::class);
});


