<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCancellationApproved extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order) {}

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
            ->subject('Demande d\'annulation approuvée - Commande #' . $this->order->id)
            ->line('Votre demande d\'annulation pour la commande #' . $this->order->id . ' a été approuvée.')
            ->line('**Montant:** ' . $total)
            ->line('La commande a été annulée et le stock des produits a été restauré.')
            ->action('Voir la commande', url('/orders/' . $this->order->id))
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
        ];
    }
}
