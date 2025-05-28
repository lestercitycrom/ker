<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Extra;

class ExtraSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$extras = [
			'Кондиціонер',
			'Клімат-контроль',
			'Клімат-контроль на дві зони',
			'Люк',
			'Панорамний люк',
			'Запуск кнопкою',
			'Безключовий доступ',
			'Задні парктроніки',
			'Вбудований навігатор',
			'Круїз-контроль',
			'Адаптивний круїз-контроль',
			'Apple CarPlay',
			'Android Auto',
			'Система попередження про зіткнення',
			'Система контролю виходу зі смуги',
			'Автоматичне екстрене гальмування',
			'Активний автопаркувальник',
			'Адаптивні фари',
			'Камера 360°',
			'Задня камера',
			'Фаркоп',
		];

		foreach ($extras as $name) {
			Extra::firstOrCreate([
				'name' => $name,
			], [
				'category' => null,
				'price' => 0,
				'price_per_day' => true,
				'description' => null,
			]);
		}
	}
}
