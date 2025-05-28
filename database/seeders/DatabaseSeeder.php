<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\{ContactGroupSeeder, VehicleCategorySeeder};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
		
		// $this->call(ContactGroupSeeder::class);
		$this->call(VehicleCategorySeeder::class);

    }
}
