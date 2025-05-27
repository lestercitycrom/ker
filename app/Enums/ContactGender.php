<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

/**
 * Gender enum for Contact model (PHP 8.1 native).
 */
enum ContactGender: int implements HasLabel, HasColor, HasIcon, HasDescription
{
	case Male    = 1;
	case Female  = 2;
	case Unknown = 3;

	/**
	 * Human-readable label.
	 */
	public function getLabel(): string
	{
		return match ($this) {
			self::Male    => 'Чоловіча',
			self::Female  => 'Жіноча',
			self::Unknown => 'Не вказано',
		};
	}

	/**
	 * Badge color for Filament table.
	 */
	public function getColor(): string
	{
		return match ($this) {
			self::Male    => 'primary',
			self::Female  => 'pink',
			self::Unknown => 'secondary',
		};
	}

	/**
	 * Icon for Filament table.
	 */
	public function getIcon(): string
	{
		return match ($this) {
			self::Male    => 'heroicon-o-user',
			self::Female  => 'heroicon-o-user-circle',
			self::Unknown => 'heroicon-o-question-mark-circle',
		};
	}

	/**
	 * Tooltip / description.
	 */
	public function getDescription(): string
	{
		return match ($this) {
			self::Male    => 'Стать: чоловіча',
			self::Female  => 'Стать: жіноча',
			self::Unknown => 'Стать не вказана',
		};
	}
}
