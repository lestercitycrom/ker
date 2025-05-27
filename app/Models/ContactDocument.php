<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Enums\ContactDocumentType;
use App\Models\Traits\HasActivityLog;


/**
 * Model for Contact Documents with media attachments.
 */
class ContactDocument extends Model implements HasMedia
{
	use HasFactory;
	use SoftDeletes;
	use InteractsWithMedia;
	use HasActivityLog;

	protected $fillable = [
		'contact_id',
		'type',
		'number',
		'issue_date',
		'exp_date',
		'notes',
	];


	protected $casts = [
		'type'       => ContactDocumentType::class,
		'issue_date' => 'date',
		'exp_date'   => 'date',
	];

	protected static $logAttributes = ['*'];

	public function contact(): BelongsTo
	{
		return $this->belongsTo(Contact::class);
	}

	public function registerMediaCollections(): void
	{
		$this->addMediaCollection('files')
			->useDisk('public')
			->acceptsMimeTypes(['image/*','application/pdf'])
			->withResponsiveImages();
	}
}
