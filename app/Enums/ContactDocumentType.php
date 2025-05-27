<?php

namespace App\Enums;

use Filament\Tables\Concerns\HasColor;
use Filament\Tables\Concerns\HasLabel;
use Filament\Tables\Concerns\HasIcon;
use Filament\Tables\Concerns\HasDescription;

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

	public function label(): string
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

	public function color(): string
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

	public function icon(): string
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

	public function description(): string
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
