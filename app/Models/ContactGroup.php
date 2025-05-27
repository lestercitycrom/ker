<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Traits\LogsActivity;
use Filament\Shield\Models\HasShieldPermissions;
use App\Enums\ContactType;
use App\Enums\ContactGender;

/**
 * Model for Contact Groups.
 */
class ContactGroup extends Model
{
	use HasFactory;

	protected $fillable = [
		'name',
	];

	/**
	 * Contacts in this group.
	 */
	public function contacts(): HasMany
	{
		return $this->hasMany(Contact::class);
	}
}