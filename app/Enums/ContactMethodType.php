<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

/**
 * Enum for contact methods with Filament label & icon support.
 */
enum ContactMethodType: string implements HasLabel, HasIcon
{
	case Skype    = 'skype';
	case Telegram = 'telegram';
	case Viber    = 'viber';
	case Whatsapp = 'whatsapp';

	/**
	 * Return display label for Filament.
	 */
	public function getLabel(): string
	{
		return match ($this) {
			self::Skype    => 'Skype',
			self::Telegram => 'Telegram',
			self::Viber    => 'Viber',
			self::Whatsapp => 'Whatsapp',
		};
	}

	/**
	 * Return icon for Filament (Heroicons, etc).
	 */
	public function getIcon(): string
	{
		return match ($this) {
			self::Skype    => 'heroicon-o-chat',
			self::Telegram => 'heroicon-o-chat-alt',
			self::Viber    => 'heroicon-o-phone',
			self::Whatsapp => 'heroicon-o-phone',
		};
	}
}
