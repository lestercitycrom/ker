<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderItem extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'service_order_id',
		'maintenance_type_id',
		'cost',
	];

	public function serviceOrder()
	{
		return $this->belongsTo(ServiceOrder::class);
	}

	public function maintenanceType()
	{
		return $this->belongsTo(MaintenanceType::class);
	}
}
