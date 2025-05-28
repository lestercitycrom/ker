<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceSchedule extends Model
{
	protected $fillable = [
		'vehicle_id',
		'maintenance_type_id',
		'last_date',
		'last_odometer',
		'next_date_due',
		'next_odometer_due',
	];

	protected $casts = [
		'vehicle_id'          => 'integer',
		'maintenance_type_id' => 'integer',
		'last_date'           => 'date',
		'next_date_due'       => 'date',
		'last_odometer'       => 'integer',
		'next_odometer_due'   => 'integer',
	];

	public function vehicle()
	{
		return $this->belongsTo(Vehicle::class);
	}

	public function maintenanceType()
	{
		return $this->belongsTo(MaintenanceType::class);
	}
}
