<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\Traits\HasActivityLog;
use App\Enums\ContactType;
use App\Enums\ContactGender;

class Contact extends Model implements HasMedia
{
	use HasFactory;
	use SoftDeletes;
	use InteractsWithMedia;
	use HasActivityLog;

	/**
	 * Mass-assignable fields
	 *
	 * @var array<int,string>
	 */
	protected $fillable = [
		'type',
		'first_name',
		'last_name',
		'group_id',
		'company_name',
		'contact_person',
		'registration_number',
		'vat_number',
		'website',
		'gender',
		'birthday',
		'country',
		'state',
		'city',
		'street',
		'building',
		'zip',
		'email',
		'phone',
		'notes',
	];

	/**
	 * Cast attributes to appropriate types
	 *
	 * @var array<string,string>
	 */
	protected $casts = [
		'type'     => ContactType::class,
		'gender'   => ContactGender::class,
		'birthday' => 'date',
	];

	/**
	 * Belongs to a contact group.
	 */
	public function group(): BelongsTo
	{
		return $this->belongsTo(ContactGroup::class);
	}

	/**
	 * Dynamic messenger/contact methods.
	 */
	public function methods(): HasMany
	{
		return $this->hasMany(ContactMethod::class);
	}

	/**
	 * Document relation.
	 */
	public function documents(): HasMany
	{
		return $this->hasMany(ContactDocument::class);
	}

	/**
	 * Configure media collections.
	 */
	public function registerMediaCollections(): void
	{
		// Single profile photo
		$this->addMediaCollection('photo')
			->singleFile();

		// Multiple document files
		$this->addMediaCollection('documents');
	}
}
