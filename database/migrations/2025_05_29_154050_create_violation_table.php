<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('violations', function (Blueprint $table) {
			$table->id();
			$table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
			$table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
			$table->foreignId('contact_id')->nullable()->constrained('contacts')->nullOnDelete();
			$table->dateTime('occurred_at');
			$table->enum('type', [
				'speeding',
				'aggressive_driving',
				'engine_overheat',
				'low_battery',
				'unauthorized_movement',
				'out_of_zone',
				'other'
			]);
			$table->string('location')->nullable();
			$table->decimal('latitude', 10, 7)->nullable();
			$table->decimal('longitude', 10, 7)->nullable();
			$table->decimal('fine_amount', 10, 2)->default(0);
			$table->text('details')->nullable();
			$table->boolean('resolved')->default(false);
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('violations');
	}
};
