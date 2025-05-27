<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

/**
 * ContactType: individual или company.
 */
enum ContactType: string implements HasLabel, HasColor
{
	case Individual = 'individual';
	case Company    = 'company';

	/**
	 * Human-readable label for Filament.
	 */
	public function getLabel(): string
	{
		return match ($this) {
			self::Individual => 'Физическое лицо',
			self::Company    => 'Компания',
		};
	}

	/**
	 * Badge color for Filament table.
	 */
	public function getColor(): string
	{
		return match ($this) {
			self::Individual => 'primary',
			self::Company    => 'success',
		};
	}

	/** Для Filament-форм используйте: Select::make('type')->options(ContactType::cases()) */
}
