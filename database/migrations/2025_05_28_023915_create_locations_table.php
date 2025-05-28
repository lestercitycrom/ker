<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('locations', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('address')->nullable();
			$table->string('city')->nullable();
			$table->string('country')->nullable();
			$table->string('phone')->nullable();

			// Время работы по дням недели
			$table->time('mon_from')->nullable();
			$table->time('mon_to')->nullable();
			$table->time('tue_from')->nullable();
			$table->time('tue_to')->nullable();
			$table->time('wed_from')->nullable();
			$table->time('wed_to')->nullable();
			$table->time('thu_from')->nullable();
			$table->time('thu_to')->nullable();
			$table->time('fri_from')->nullable();
			$table->time('fri_to')->nullable();
			$table->time('sat_from')->nullable();
			$table->time('sat_to')->nullable();
			$table->time('sun_from')->nullable();
			$table->time('sun_to')->nullable();

			// Опции-галочки
			$table->boolean('activate_reservation_non_working_hours')->default(false);
			$table->boolean('activate_custom_location_delivery')->default(false);
			$table->boolean('delivery_fee_pickup_return')->default(false);
			$table->boolean('enable_paid_return_another_location')->default(false);
			$table->boolean('connect_all_vehicles')->default(false);

			$table->decimal('latitude', 10, 7)->nullable();
			$table->decimal('longitude', 10, 7)->nullable();
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('locations');
	}
};
