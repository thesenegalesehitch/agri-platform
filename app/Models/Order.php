<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	use HasFactory;

	protected $fillable = ['buyer_id','status','total','paid_at','payment_method','cash_payment_details','cancellation_requested','cancellation_reason','cancellation_requested_at'];

	protected $casts = [
		'paid_at' => 'datetime',
		'cancellation_requested_at' => 'datetime',
	];

	public function buyer()
	{
		return $this->belongsTo(User::class, 'buyer_id');
	}

	public function items()
	{
		return $this->hasMany(OrderItem::class);
	}

	/**
	 * Vérifie si une commande peut être payée
	 */
	public function canBePaid(): bool
	{
		return in_array($this->status, ['pending', 'pending_payment', 'pending_validation']);
	}

	/**
	 * Vérifie si une commande peut être annulée
	 */
	public function canBeCancelled(): bool
	{
		return in_array($this->status, ['pending', 'pending_payment', 'pending_validation']);
	}

	/**
	 * Vérifie si une commande est en attente de paiement
	 */
	public function isPendingPayment(): bool
	{
		return in_array($this->status, ['pending_payment', 'pending_validation']);
	}
}
