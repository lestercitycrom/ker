<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasActivityLog;

class MaintenanceSchedule extends Model
{
	
	use SoftDeletes;
	use HasActivityLog;	
	
	protected $fillable = [
		'vehicle_id',
		'maintenance_type_id',
		'last_date',
		'last_odometer',
		'next_date_due',
		'next_odometer_due',
	];

	protected $casts = [
		'last_date'        => 'date',
		'next_date_due'    => 'date',
		'last_odometer'    => 'integer',
		'next_odometer_due'=> 'integer',
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
