<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
	protected $fillable = [
		'name',
		'category',
		'price',
		'price_per_day',
		'description',
	];

	protected $casts = [
		'price_per_day' => 'boolean',
		'price' => 'float',
	];

	// В каких заказах была выбрана эта опция
	public function orders()
	{
		return $this->belongsToMany(Order::class, 'order_extra')
			->withPivot(['quantity', 'price']);
	}

	// В каких авто эта опция доступна
	public function vehicles()
	{
		return $this->belongsToMany(Vehicle::class, 'vehicle_extra');
	}
}
