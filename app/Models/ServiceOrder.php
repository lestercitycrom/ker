<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
	protected $fillable = [
		'vehicle_id',
		'contact_id',
		'status',
		'start_date',
		'end_date',
		'odometer',
		'total_cost',
		'paid',
		'notes',
	];

	protected $casts = [
		'start_date'  => 'datetime',
		'end_date'    => 'datetime',
		'odometer'    => 'integer',
		'total_cost'  => 'float',
		'paid'        => 'boolean',
	];

	public function vehicle() { return $this->belongsTo(Vehicle::class); }
	public function partner() { return $this->belongsTo(Contact::class, 'contact_id'); }
	public function items()   { return $this->hasMany(ServiceOrderItem::class); }
}
