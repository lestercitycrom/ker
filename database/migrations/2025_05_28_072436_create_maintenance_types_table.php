<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('maintenance_types', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->integer('interval_km')->nullable(); // Every X km
			$table->integer('interval_days')->nullable(); // Every X days
			$table->text('description')->nullable();
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('maintenance_types');
	}
};
