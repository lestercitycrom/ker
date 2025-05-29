<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasActivityLog;

class Violation extends Model
{
	use HasActivityLog;

	protected $fillable = [
		'vehicle_id',
		'order_id',
		'contact_id',
		'occurred_at',
		'type',
		'location',
		'latitude',
		'longitude',
		'fine_amount',
		'details',
		'resolved',
	];

	protected $casts = [
		'occurred_at' => 'datetime',
		'latitude'    => 'float',
		'longitude'   => 'float',
		'fine_amount' => 'float',
		'resolved'    => 'boolean',
	];

	public function vehicle() { return $this->belongsTo(Vehicle::class); }
	public function order()   { return $this->belongsTo(Order::class); }
	public function contact() { return $this->belongsTo(Contact::class); }
}
