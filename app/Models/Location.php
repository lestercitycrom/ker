<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
	protected $fillable = [
		'name',
		'address',
		'city',
		'country',
		'phone',
		'mon_from', 'mon_to',
		'tue_from', 'tue_to',
		'wed_from', 'wed_to',
		'thu_from', 'thu_to',
		'fri_from', 'fri_to',
		'sat_from', 'sat_to',
		'sun_from', 'sun_to',
		'activate_reservation_non_working_hours',
		'activate_custom_location_delivery',
		'delivery_fee_pickup_return',
		'enable_paid_return_another_location',
		'connect_all_vehicles',
		'latitude',
		'longitude',
	];

	protected $casts = [
		'activate_reservation_non_working_hours'   => 'boolean',
		'activate_custom_location_delivery'        => 'boolean',
		'delivery_fee_pickup_return'               => 'boolean',
		'enable_paid_return_another_location'      => 'boolean',
		'connect_all_vehicles'                     => 'boolean',
		'mon_from' => 'datetime:H:i',
		'mon_to'   => 'datetime:H:i',
		'tue_from' => 'datetime:H:i',
		'tue_to'   => 'datetime:H:i',
		'wed_from' => 'datetime:H:i',
		'wed_to'   => 'datetime:H:i',
		'thu_from' => 'datetime:H:i',
		'thu_to'   => 'datetime:H:i',
		'fri_from' => 'datetime:H:i',
		'fri_to'   => 'datetime:H:i',
		'sat_from' => 'datetime:H:i',
		'sat_to'   => 'datetime:H:i',
		'sun_from' => 'datetime:H:i',
		'sun_to'   => 'datetime:H:i',
	];

	public function vehiclesAsBase()
	{
		return $this->hasMany(Vehicle::class, 'base_location_id');
	}

	public function vehiclesAsCurrent()
	{
		return $this->hasMany(Vehicle::class, 'current_location_id');
	}
}
