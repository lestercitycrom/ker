<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('vehicle_categories', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('description')->nullable();
			$table->decimal('daily_rate', 10, 2)->nullable();
			$table->decimal('monthly_rate', 10, 2)->nullable();
			$table->integer('seat_count')->nullable();
			$table->integer('door_count')->nullable();
			$table->timestamps();
		});
	}
	public function down(): void
	{
		Schema::dropIfExists('vehicle_categories');
	}
};
