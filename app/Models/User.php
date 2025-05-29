<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
///use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
	use HasApiTokens;  // Enable API token authentication
	// Enable factory support
	use HasFactory;
	// Enable sending notifications
	use Notifiable;
	// Enable roles & permissions
	//use HasRoles;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
		'password' => 'hashed',
	];

	/**
	 * Determine if the user can access the given Filament panel.
	 *
	 * @param  \Filament\Panel  $panel
	 * @return bool
	 */
	public function canAccessPanel(Panel $panel): bool
	{
		return true; // Replace with your access logic
	}
}
