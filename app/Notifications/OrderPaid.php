<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPaid extends Notification implements ShouldQueue
{
	use Queueable;

	public function __construct(public Order $order) {}

	public function via(object $notifiable): array
	{
		return ['mail','database'];
	}

	public function toMail(object $notifiable): MailMessage
	{
		return (new MailMessage)
			->subject('Commande payée')
			->line('Votre commande #'.$this->order->id.' a été payée.')
			->action('Voir la commande', url('/orders/'.$this->order->id));
	}

	public function toArray(object $notifiable): array
	{
		return [
			'order_id' => $this->order->id,
			'total' => $this->order->total,
			'status' => $this->order->status,
		];
	}
}
