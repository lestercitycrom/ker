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

	/**
	 * Vehicle relation.
	 */
	public function vehicle()
	{
		return $this->belongsTo(Vehicle::class);
	}

	/**
	 * Order relation.
	 */
	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	/**
	 * Contact relation.
	 */
	public function contact()
	{
		return $this->belongsTo(Contact::class);
	}

	/**
	 * Register media collections for damage photos.
	 */
	public function registerMediaCollections(): void
	{
		$this
			->addMediaCollection('photos')
			->useDisk('public') // или другой диск, если требуется
			->acceptsFile(function ($file) {
				return in_array($file->mimeType, ['image/jpeg', 'image/png', 'image/webp']);
			})
			->multiple();
	}
}
