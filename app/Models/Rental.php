<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
	use HasFactory;

	protected $fillable = ['equipment_id','renter_id','start_date','end_date','status','total'];

	protected $casts = [
		'start_date' => 'date',
		'end_date' => 'date',
	];

	public function equipment()
	{
		return $this->belongsTo(Equipment::class);
	}

	public function renter()
	{
		return $this->belongsTo(User::class, 'renter_id');
	}
}
