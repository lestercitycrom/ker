<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleCategory extends Model
{
	protected $fillable = [
		'name',
		'description',
		'daily_rate',
		'monthly_rate',
		'seat_count',
		'door_count',
	];

	public function vehicles()
	{
		return $this->hasMany(Vehicle::class, 'vehicle_category_id');
	}
}
