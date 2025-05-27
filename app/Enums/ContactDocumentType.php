<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasDescription;

/**
 * ContactDocumentType: типы документов для контакта
 */
enum ContactDocumentType: string implements HasLabel, HasColor, HasIcon, HasDescription
{
	case DriverLicense       = 'driver_license';
	case Passport            = 'passport';
	case TaxIdentification   = 'tax_identification';
	case PaymentCard         = 'payment_card';
	case CardId              = 'card_id';
	case Other               = 'other';

	/**
	 * Get label for enum value.
	 */
	public function getLabel(): string
	{
		return match ($this) {
			self::DriverLicense     => 'Driver license',
			self::Passport          => 'Passport',
			self::TaxIdentification => 'Tax identification number',
			self::PaymentCard       => 'Payment card',
			self::CardId            => 'Card id',
			self::Other             => 'Other',
		};
	}

	/**
	 * Get color for enum value.
	 */
	public function getColor(): string
	{
		return match ($this) {
			self::DriverLicense     => 'primary',
			self::Passport          => 'success',
			self::TaxIdentification => 'warning',
			self::PaymentCard       => 'info',
			self::CardId            => 'secondary',
			self::Other             => 'danger',
		};
	}

	/**
	 * Get icon for enum value.
	 */
	public function getIcon(): string
	{
		return match ($this) {
			self::DriverLicense     => 'heroicon-o-document-text',
			self::Passport          => 'heroicon-o-identification',
			self::TaxIdentification => 'heroicon-o-receipt-tax',
			self::PaymentCard       => 'heroicon-o-credit-card',
			self::CardId            => 'heroicon-o-identification',
			self::Other             => 'heroicon-o-document',
		};
	}

	/**
	 * Get description for enum value.
	 */
	public function getDescription(): string
	{
		return match ($this) {
			self::DriverLicense     => 'Driver’s license document',
			self::Passport          => 'Passport document',
			self::TaxIdentification => 'TIN / Tax ID document',
			self::PaymentCard       => 'Photo of payment card used',
			self::CardId            => 'Card identification document',
			self::Other             => 'Other supporting document',
		};
	}
}
