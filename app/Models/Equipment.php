<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'user_id','category_id','title','description','daily_rate','is_available','location','is_active','pricing_unit'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function images()
	{
		return $this->morphMany(Image::class, 'imageable');
	}

	public function rentals()
	{
		return $this->hasMany(Rental::class);
	}
}
