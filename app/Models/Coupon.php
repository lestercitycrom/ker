<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasActivityLog;

class Coupon extends Model
{
	use HasActivityLog;

	protected $fillable = [
		'code',
		'discount_amount',
		'discount_percent',
		'valid_from',
		'valid_to',
		'max_uses',
		'times_used',
	];

	protected $casts = [
		'discount_amount' => 'float',
		'discount_percent'=> 'integer',
		'valid_from'      => 'date',
		'valid_to'        => 'date',
		'max_uses'        => 'integer',
		'times_used'      => 'integer',
	];
}
