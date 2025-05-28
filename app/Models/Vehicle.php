<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasActivityLog;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Enums\VehicleStatus;

class Vehicle extends Model implements HasMedia
{
	use SoftDeletes, InteractsWithMedia, HasActivityLog;

	protected $fillable = [
		'contact_id',
		'vehicle_category_id',
		'base_location_id',
		'current_location_id',
		'type',
		'brand',
		'model',
		'registration_number',
		'year',
		'vin',
		'transmission',
		'engine_volume',
		'fuel_type',
		'body_type',
		'drive_type',
		'color',
		'odometer',
		'fuel_level',
		'tank_volume',
		'fuel_consumption',
		'seat_count',
		'door_count',
		'large_bags',
		'small_bags',
		'features',
		'extra_attributes',
		'tracker_imei',
		'tracker_phone_number',
		'status',
	];

	protected $casts = [
		'features'          => 'array',
		'extra_attributes'  => 'array',
		'year'              => 'integer',
		'odometer'          => 'integer',
		'fuel_level'        => 'integer',
		'tank_volume'       => 'integer',
		'fuel_consumption'  => 'float',
		'seat_count'        => 'integer',
		'door_count'        => 'integer',
		'large_bags'        => 'integer',
		'small_bags'        => 'integer',
		'status'            => VehicleStatus::class,
	];

	// Новый FK: владелец/контакт (универсально)
	public function contact()
	{
		return $this->belongsTo(Contact::class, 'contact_id');
	}

	public function category()
	{
		return $this->belongsTo(VehicleCategory::class, 'vehicle_category_id');
	}

	public function baseLocation()
	{
		return $this->belongsTo(Location::class, 'base_location_id');
	}

	public function currentLocation()
	{
		return $this->belongsTo(Location::class, 'current_location_id');
	}

	public function orders() { return $this->hasMany(Order::class); }
	public function damages() { return $this->hasMany(Damage::class); }
	public function maintenanceSchedules() { return $this->hasMany(MaintenanceSchedule::class); }
	public function serviceOrders() { return $this->hasMany(ServiceOrder::class); }
}
