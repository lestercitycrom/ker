<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaintenanceType;

class MaintenanceTypeSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$types = [
			['name' => 'Заміна масла', 'interval_km' => 10000, 'interval_days' => 365, 'description' => 'Регулярна заміна моторного масла'],
			['name' => 'Заміна масляного фільтра', 'interval_km' => 10000, 'interval_days' => 365, 'description' => 'Заміна фільтра при кожній зміні масла'],
			['name' => 'Заміна повітряного фільтра', 'interval_km' => 15000, 'interval_days' => 365, 'description' => 'Перевірка та заміна повітряного фільтра'],
			['name' => 'Перевірка гальмівної системи', 'interval_km' => 15000, 'interval_days' => 365, 'description' => 'Огляд і сервіс гальмівних колодок та дисків'],
			['name' => 'Заміна гальмівної рідини', 'interval_km' => null, 'interval_days' => 730, 'description' => 'Заміна гальмівної рідини кожні 2 роки'],
			['name' => 'Перевірка/заміна акумулятора', 'interval_km' => null, 'interval_days' => 730, 'description' => 'Діагностика або заміна акумулятора'],
			['name' => 'Перевірка підвіски', 'interval_km' => 20000, 'interval_days' => 730, 'description' => 'Огляд підвіски та рульового керування'],
			['name' => 'Заміна свічок запалювання', 'interval_km' => 30000, 'interval_days' => 1095, 'description' => 'Рекомендовано кожні 30 000 км або 3 роки'],
			['name' => 'Заміна охолоджувальної рідини', 'interval_km' => null, 'interval_days' => 1095, 'description' => 'Заміна антифризу кожні 3 роки'],
			['name' => 'Технічний огляд (ТО)', 'interval_km' => 20000, 'interval_days' => 365, 'description' => 'Комплексний технічний огляд автомобіля'],
		];

		foreach ($types as $type) {
			MaintenanceType::firstOrCreate(
				['name' => $type['name']],
				[
					'interval_km' => $type['interval_km'],
					'interval_days' => $type['interval_days'],
					'description' => $type['description'],
				]
			);
		}
	}
}
