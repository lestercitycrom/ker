<?php

namespace App\Enums;

use Filament\Support\Contracts\{HasLabel, HasColor, HasIcon, HasDescription};

enum OrderStatus: string implements HasLabel, HasColor, HasIcon, HasDescription
{
	case Booking = 'booking';
	case Reserved = 'reserved';
	case Rental = 'rental';
	case Done = 'done';
	case Cancel = 'cancel';
	case Reject = 'reject';

	public function getLabel(): string
	{
		return match($this) {
			self::Booking => 'Бронь',
			self::Reserved => 'Резерв',
			self::Rental => 'Аренда',
			self::Done => 'Выполнен',
			self::Cancel => 'Отменен',
			self::Reject => 'Отклонен',
		};
	}

	public function getColor(): string
	{
		return match($this) {
			self::Booking => 'gray',
			self::Reserved => 'info',
			self::Rental => 'success',
			self::Done => 'secondary',
			self::Cancel => 'danger',
			self::Reject => 'warning',
		};
	}

	public function getIcon(): string
	{
		return match($this) {
			self::Booking => 'heroicon-o-bookmark',
			self::Reserved => 'heroicon-o-archive',
			self::Rental => 'heroicon-o-car',
			self::Done => 'heroicon-o-check-circle',
			self::Cancel => 'heroicon-o-ban',
			self::Reject => 'heroicon-o-x-circle',
		};
	}

	public function getDescription(): string
	{
		return match($this) {
			self::Booking => 'Заявка на бронь',
			self::Reserved => 'Подтвержденная бронь',
			self::Rental => 'Текущая аренда',
			self::Done => 'Аренда завершена',
			self::Cancel => 'Отмена клиентом',
			self::Reject => 'Отклонено администратором',
		};
	}
}
