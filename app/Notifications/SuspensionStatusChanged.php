<?php

namespace App\Notifications;

use App\Models\SuspensionRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuspensionStatusChanged extends Notification implements ShouldQueue
{
	use Queueable;

	public function __construct(public SuspensionRequest $suspensionRequest) {}

	public function via(object $notifiable): array
	{
		return ['mail','database'];
	}

	public function toMail(object $notifiable): MailMessage
	{
		return (new MailMessage)
			->subject('Décision sur votre requête de réactivation')
			->line('Votre requête est: '.$this->suspensionRequest->status)
			->action('Voir', url('/suspension-requests/'.$this->suspensionRequest->id));
	}

	public function toArray(object $notifiable): array
	{
		return [
			'suspension_request_id' => $this->suspensionRequest->id,
			'status' => $this->suspensionRequest->status,
		];
	}
}
