<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('damages', function (Blueprint $table) {
			$table->id();
			$table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete(); // Vehicle
			$table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete(); // Order, nullable
			$table->foreignId('contact_id')->nullable()->constrained('contacts')->nullOnDelete(); // Client, nullable
			$table->string('title')->nullable(); // Short damage description
			$table->text('description')->nullable(); // Details
			$table->enum('severity', ['light','medium','severe','very_severe'])->nullable(); // Damage degree
			$table->boolean('is_interior')->default(false); // Interior damage
			$table->string('part')->nullable(); // Part/area
			$table->boolean('resolved')->default(false);
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('damages');
	}
};
