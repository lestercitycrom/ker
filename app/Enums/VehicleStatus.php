<?php

namespace App\Enums;

use Filament\Support\Contracts\{HasLabel, HasColor, HasIcon, HasDescription};

enum VehicleStatus: string implements HasLabel, HasColor, HasIcon, HasDescription
{
	case Active = 'active';
	case Draft = 'draft';
	case ForSale = 'for_sale';
	case Removed = 'removed';

	public function getLabel(): string
	{
		return match ($this) {
			self::Active => 'Активно',
			self::Draft => 'Черновик',
			self::ForSale => 'В продаже',
			self::Removed => 'Удалено',
		};
	}

	public function getColor(): string
	{
		return match ($this) {
			self::Active => 'success',
			self::Draft => 'gray',
			self::ForSale => 'warning',
			self::Removed => 'danger',
		};
	}

	public function getIcon(): string
	{
		return match ($this) {
			self::Active => 'heroicon-o-check-circle',
			self::Draft => 'heroicon-o-pencil',
			self::ForSale => 'heroicon-o-currency-dollar',
			self::Removed => 'heroicon-o-trash',
		};
	}

	public function getDescription(): string
	{
		return match ($this) {
			self::Active => 'Машина доступна для аренды',
			self::Draft => 'Машина не отображается клиентам',
			self::ForSale => 'Машина продается',
			self::Removed => 'Машина удалена из эксплуатации',
		};
	}
}
