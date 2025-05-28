<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('order_extra', function (Blueprint $table) {
			$table->id();
			$table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
			$table->foreignId('extra_id')->constrained('extras')->cascadeOnDelete();
			$table->tinyInteger('quantity')->default(1);
			$table->decimal('price', 10, 2); // Final price for this option in this order
		});
	}
	public function down(): void
	{
		Schema::dropIfExists('order_extra');
	}
};
