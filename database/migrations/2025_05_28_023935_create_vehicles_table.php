<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('vehicles', function (Blueprint $table) {
			$table->id();
			$table->foreignId('contact_id')->constrained('contacts')->cascadeOnDelete(); // заменили company_id на contact_id
			$table->foreignId('vehicle_category_id')->constrained('vehicle_categories')->cascadeOnDelete();
			$table->foreignId('base_location_id')->nullable()->constrained('locations')->nullOnDelete();
			$table->foreignId('current_location_id')->nullable()->constrained('locations')->nullOnDelete();

			$table->string('type')->default('Car');
			$table->string('brand');
			$table->string('model');
			$table->string('registration_number');
			$table->year('year')->nullable();
			$table->string('vin')->nullable();
			$table->enum('transmission', ['AT','MT','AM','CVT','NONE'])->nullable();
			$table->decimal('engine_volume', 4, 1)->nullable();
			$table->enum('fuel_type', ['Gasoline','Diesel','Hybrid','Electric','LPG','CNG','Other'])->nullable();
			$table->string('body_type')->nullable();
			$table->enum('drive_type', ['FWD','RWD','AWD'])->nullable();
			$table->string('color')->nullable();
			$table->integer('odometer')->default(0);
			$table->tinyInteger('fuel_level')->default(0);
			$table->integer('tank_volume')->nullable();
			$table->decimal('fuel_consumption', 5, 2)->nullable();
			$table->tinyInteger('seat_count')->nullable();
			$table->tinyInteger('door_count')->nullable();
			$table->tinyInteger('large_bags')->nullable();
			$table->tinyInteger('small_bags')->nullable();
			$table->json('features')->nullable();
			$table->json('extra_attributes')->nullable();
			$table->string('tracker_imei')->nullable();
			$table->string('tracker_phone_number')->nullable();
			$table->string('status')->default('draft');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('vehicles');
	}
};
