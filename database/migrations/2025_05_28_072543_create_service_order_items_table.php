<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('service_order_items', function (Blueprint $table) {
			$table->id();
			$table->foreignId('service_order_id')->constrained('service_orders')->cascadeOnDelete();
			$table->foreignId('maintenance_type_id')->constrained('maintenance_types')->cascadeOnDelete();
			$table->decimal('cost', 10, 2)->nullable();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('service_order_items');
	}
};
