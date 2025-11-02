<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CashPaymentRequested extends Notification implements ShouldQueue
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
        $buyer = $this->order->buyer;
        $total = number_format($this->order->total * 655.957, 0, ',', ' ') . ' FCFA';
        
        $message = (new MailMessage)
            ->subject('Demande de paiement en espèces - Commande #' . $this->order->id)
            ->line('Un client souhaite payer en espèces pour sa commande.')
            ->line('**Commande #' . $this->order->id . '**')
            ->line('**Client:** ' . $buyer->name . ' (' . $buyer->email . ')')
            ->line('**Montant total:** ' . $total);
        
        if ($this->order->cash_payment_details) {
            $message->line('**Détails du paiement:**')
                ->line($this->order->cash_payment_details);
        }
        
        $message->action('Voir la commande', url('/admin/orders/' . $this->order->id))
            ->line('Merci d\'utiliser AgriLink !');
        
        return $message;
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
            'buyer_name' => $this->order->buyer->name,
            'total' => $this->order->total,
            'cash_payment_details' => $this->order->cash_payment_details,
        ];
    }
}
