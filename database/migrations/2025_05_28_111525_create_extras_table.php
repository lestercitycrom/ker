<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('extras', function (Blueprint $table) {
			$table->id();
			$table->string('name');					// Name of the option
			$table->string('category')->nullable();	// Category (insurance, equipment)
			$table->decimal('price', 10, 2);		// Default price
			$table->boolean('price_per_day')->default(true); // Per day or one-time
			$table->text('description')->nullable();
			$table->timestamps();
		});
	}
	public function down(): void
	{
		Schema::dropIfExists('extras');
	}
};
