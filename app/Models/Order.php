<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	use HasFactory;

	protected $fillable = ['buyer_id','status','total','paid_at'];

	protected $casts = [
		'paid_at' => 'datetime',
	];

	public function buyer()
	{
		return $this->belongsTo(User::class, 'buyer_id');
	}

	public function items()
	{
		return $this->hasMany(OrderItem::class);
	}
}
