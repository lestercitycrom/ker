<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasActivityLog;

class OrderPayment extends Model
{
	use HasActivityLog;

	protected $fillable = [
		'order_id',
		'type',
		'method',
		'amount',
		'date',
		'transaction_id',
	];

	protected $casts = [
		'date'   => 'datetime',
		'amount' => 'float',
	];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}
}
