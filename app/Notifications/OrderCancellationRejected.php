<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCancellationRejected extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order, public string $rejectionReason) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $total = number_format($this->order->total * 655.957, 0, ',', ' ') . ' FCFA';
        
        return (new MailMessage)
            ->subject('Demande d\'annulation rejetée - Commande #' . $this->order->id)
            ->line('Votre demande d\'annulation pour la commande #' . $this->order->id . ' a été rejetée.')
            ->line('**Montant:** ' . $total)
            ->line('**Raison du rejet:**')
            ->line($this->rejectionReason)
            ->action('Voir la commande', url('/orders/' . $this->order->id))
            ->line('Si vous avez des questions, veuillez contacter le support.')
            ->line('Merci d\'utiliser AgriLink !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'total' => $this->order->total,
            'status' => $this->order->status,
            'rejection_reason' => $this->rejectionReason,
        ];
    }
}
