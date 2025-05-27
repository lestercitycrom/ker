<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\ContactMethodType; // ← ЭТО ВАЖНО! Импортируем enum

/**
 * Model for storing messenger/contact methods.
 */
class ContactMethod extends Model
{
	use HasFactory;

	protected $fillable = [
		'contact_id',
		'type',
		'value',
	];

	protected $casts = [
		'type' => ContactMethodType::class, // Теперь найден корректно
	];

	public function contact(): BelongsTo
	{
		return $this->belongsTo(Contact::class);
	}
}
