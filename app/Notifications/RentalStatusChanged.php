<?php

namespace App\Notifications;

use App\Models\Rental;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RentalStatusChanged extends Notification implements ShouldQueue
{
	use Queueable;

	public function __construct(public Rental $rental) {}

	public function via(object $notifiable): array
	{
		return ['mail','database'];
	}

	public function toMail(object $notifiable): MailMessage
	{
		return (new MailMessage)
			->subject('Statut de location mis à jour')
			->line('La location #'.$this->rental->id.' est maintenant: '.$this->rental->status)
			->action('Voir', url('/rentals/'.$this->rental->id));
	}

	public function toArray(object $notifiable): array
	{
		return [
			'rental_id' => $this->rental->id,
			'status' => $this->rental->status,
			'equipment_id' => $this->rental->equipment_id,
		];
	}
}
