<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactGroup;

class ContactGroupSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            'Клієнти',
            'Партнери',
            'Чорний список',
        ];

        foreach ($groups as $name) {
            ContactGroup::firstOrCreate(['name' => $name]);
        }
    }
}
