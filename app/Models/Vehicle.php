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
	use SoftDeletes;
	use InteractsWithMedia;
	use HasActivityLog;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int,string>
	 */
	protected $fillable = [
		'contact_id',
		'vehicle_category_id',
		'base_location_id',
		'current_location_id',
		'type',
		'brand_id',
		'model_id',
		'registration_number',
		'year',
		'vin',
		'transmission_id',
		'engine_volume',
		'fuel_id',
		'body_type_id',
		'drive_id',
		'color_id',
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

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string,string|class-string>
	 */
	protected $casts = [
		'contact_id'         => 'integer',
		'vehicle_category_id'=> 'integer',
		'base_location_id'   => 'integer',
		'current_location_id'=> 'integer',
		'year'               => 'integer',
		'brand_id'           => 'integer',
		'model_id'           => 'integer',
		'transmission_id'    => 'integer',
		'fuel_id'            => 'integer',
		'body_type_id'       => 'integer',
		'drive_id'           => 'integer',
		'color_id'           => 'integer',
		'features'           => 'array',
		'extra_attributes'   => 'array',
		'odometer'           => 'integer',
		'fuel_level'         => 'integer',
		'tank_volume'        => 'integer',
		'fuel_consumption'   => 'float',
		'seat_count'         => 'integer',
		'door_count'         => 'integer',
		'large_bags'         => 'integer',
		'small_bags'         => 'integer',
		'status'             => VehicleStatus::class,
	];

	/**
	 * Owner contact relationship.
	 */
	public function contact()
	{
		return $this->belongsTo(Contact::class, 'contact_id');
	}

	/**
	 * Vehicle category relationship.
	 */
	public function category()
	{
		return $this->belongsTo(VehicleCategory::class, 'vehicle_category_id');
	}

	/**
	 * Base location relationship.
	 */
	public function baseLocation()
	{
		return $this->belongsTo(Location::class, 'base_location_id');
	}

	/**
	 * Current location relationship.
	 */
	public function currentLocation()
	{
		return $this->belongsTo(Location::class, 'current_location_id');
	}

	/**
	 * Orders placed for this vehicle.
	 */
	public function orders()
	{
		return $this->hasMany(Order::class);
	}

	/**
	 * Damages recorded for this vehicle.
	 */
	public function damages()
	{
		return $this->hasMany(Damage::class);
	}

	/**
	 * Maintenance schedules for this vehicle.
	 */
	public function maintenanceSchedules()
	{
		return $this->hasMany(MaintenanceSchedule::class);
	}

	/**
	 * Service orders for this vehicle.
	 */
	public function serviceOrders()
	{
		return $this->hasMany(ServiceOrder::class);
	}

	/**
	 * Extras associated with this vehicle.
	 */
	public function extras()
	{
		return $this->belongsToMany(Extra::class, 'vehicle_extra');
	}
}
