<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleCategory;

class VehicleCategorySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(): void
	{
		// Array of vehicle categories
		$categories = [
			[
				'name' => 'Малий, Механіка',
				'description' => 'Toyota Igo, Volkswagen Up або подібний',
				'daily_rate' => 2230, // 50 * 44.5
				'monthly_rate' => null,
				'seat_count' => null,
				'door_count' => null,
			],
			[
				'name' => 'Малий, Автомат',
				'description' => 'Toyota Igo, Volkswagen Up або подібний',
				'daily_rate' => 2670, // 60 * 44.5
				'monthly_rate' => null,
				'seat_count' => null,
				'door_count' => null,
			],
			[
				'name' => 'Економ, Механіка',
				'description' => 'Toyota Yaris, Volkswagen Polo або подібний',
				'daily_rate' => 2670, // 60 * 44.5
				'monthly_rate' => null,
				'seat_count' => null,
				'door_count' => null,
			],
			[
				'name' => 'Економ, Автомат',
				'description' => 'Toyota Yaris, Volkswagen Polo або подібний',
				'daily_rate' => 3115, // 70 * 44.5
				'monthly_rate' => null,
				'seat_count' => null,
				'door_count' => null,
			],
			[
				'name' => 'Компакт, Механіка',
				'description' => 'Toyota Corolla, Volkswagen Golf або подібний',
				'daily_rate' => 3115, // 70 * 44.5
				'monthly_rate' => null,
				'seat_count' => null,
				'door_count' => null,
			],
			[
				'name' => 'Компакт, Автомат',
				'description' => 'Toyota Corolla, Volkswagen Golf або подібний',
				'daily_rate' => 3560, // 80 * 44.5
				'monthly_rate' => null,
				'seat_count' => null,
				'door_count' => null,
			],
			[
				'name' => 'Кабріолет, Механіка',
				'description' => 'Peugeot 308 cc або подібний',
				'daily_rate' => 4450, // 100 * 44.5
				'monthly_rate' => null,
				'seat_count' => null,
				'door_count' => null,
			],
			[
				'name' => 'Кабріолет, Автомат',
				'description' => 'Mercedes E class кабріолет',
				'daily_rate' => 6675, // 150 * 44.5
				'monthly_rate' => null,
				'seat_count' => null,
				'door_count' => null,
			],
		];

		// Insert data into vehicle_categories table
		foreach ($categories as $category) {
			VehicleCategory::create($category);
		}
	}
}
