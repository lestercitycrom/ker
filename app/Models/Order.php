<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasActivityLog;
use App\Enums\OrderStatus;

class Order extends Model
{
	use SoftDeletes;
	use HasActivityLog;

	protected $fillable = [
		'contact_id',
		'vehicle_category_id',
		'vehicle_id',
		'manager_id',
		'status',
		'source',
		'code',
		'start_at',
		'end_at',
		'pickup_location_id',
		'return_location_id',
		'return_to_different_location',
		'pickup_notes',
		'return_notes',
		'coupon_code',
		'discount_amount',
		'total_amount',
		'balance_due',
	];

	protected $casts = [
		'start_at'                      => 'datetime',
		'end_at'                        => 'datetime',
		'return_to_different_location'  => 'boolean',
		'discount_amount'               => 'float',
		'total_amount'                  => 'float',
		'balance_due'                   => 'float',
		'status'                        => OrderStatus::class,
	];

	// Client/renter
	public function contact()      { return $this->belongsTo(Contact::class, 'contact_id'); }
	// Category
	public function category()     { return $this->belongsTo(VehicleCategory::class, 'vehicle_category_id'); }
	// Car
	public function vehicle()      { return $this->belongsTo(Vehicle::class, 'vehicle_id'); }
	// Manager/issuer
	public function manager()      { return $this->belongsTo(Contact::class, 'manager_id'); }
	// Pickup/return locations
	public function pickupLocation()   { return $this->belongsTo(Location::class, 'pickup_location_id'); }
	public function returnLocation()   { return $this->belongsTo(Location::class, 'return_location_id'); }

	// Payments
	public function payments()     { return $this->hasMany(OrderPayment::class); }
	// Extras
	public function extras()       { return $this->belongsToMany(Extra::class, 'order_extra')->withPivot(['quantity', 'price']); }
	// Damages
	public function damages()      { return $this->hasMany(Damage::class); }
	

	
}
