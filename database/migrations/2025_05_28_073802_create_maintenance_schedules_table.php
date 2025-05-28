<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('maintenance_schedules', function (Blueprint $table) {
			$table->id();
			$table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
			$table->foreignId('maintenance_type_id')->constrained('maintenance_types')->cascadeOnDelete();
			$table->date('last_date')->nullable(); // Last service date
			$table->integer('last_odometer')->nullable(); // Last service km
			$table->date('next_date_due')->nullable(); // Next due
			$table->integer('next_odometer_due')->nullable();
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('maintenance_schedules');
	}
};
