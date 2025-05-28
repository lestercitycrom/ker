<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('service_orders', function (Blueprint $table) {
			$table->id();
			$table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
			$table->foreignId('contact_id')->nullable()->constrained('contacts')->nullOnDelete(); // Service partner (Contact)
			$table->enum('status', ['planned','in_service','completed'])->default('planned');
			$table->dateTime('start_date')->nullable();
			$table->dateTime('end_date')->nullable();
			$table->integer('odometer')->nullable();
			$table->decimal('total_cost', 10, 2)->default(0);
			$table->boolean('paid')->default(false);
			$table->text('notes')->nullable();
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('service_orders');
	}
};
