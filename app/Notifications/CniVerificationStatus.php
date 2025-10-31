<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CniVerificationStatus extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public User $user,
        public string $status, // 'approved' ou 'rejected'
        public ?string $notes = null
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Statut de vérification de votre CNI - AgriPlatform');

        if ($this->status === 'approved') {
            $mail->line('Votre carte d\'identité nationale (CNI) a été vérifiée et approuvée.')
                 ->line('Votre compte est maintenant entièrement vérifié.')
                 ->action('Accéder à mon profil', url('/profile'));
        } else {
            $mail->line('Malheureusement, votre carte d\'identité nationale (CNI) n\'a pas pu être vérifiée.')
                 ->line('Raison : ' . ($this->notes ?? 'Documents non conformes'))
                 ->line('Veuillez télécharger de nouveaux documents CNI clairs et lisibles.')
                 ->action('Mettre à jour mon profil', url('/profile'));
        }

        return $mail;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'status' => $this->status,
            'notes' => $this->notes,
            'message' => $this->status === 'approved' 
                ? 'Votre CNI a été vérifiée et approuvée.'
                : 'Votre CNI a été rejetée. ' . ($this->notes ?? ''),
        ];
    }
}
