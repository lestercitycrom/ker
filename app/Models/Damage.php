<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Damage extends Model implements HasMedia
{
	use InteractsWithMedia;

	protected $fillable = [
		'vehicle_id',
		'order_id',
		'contact_id',
		'title',
		'description',
		'severity',
		'is_interior',
		'part',
		'resolved',
	];

	protected $casts = [
		'is_interior' => 'boolean',
		'resolved'    => 'boolean',
	];

	public function vehicle() { return $this->belongsTo(Vehicle::class); }
	public function order() { return $this->belongsTo(Order::class); }
	public function contact() { return $this->belongsTo(Contact::class); }
}
