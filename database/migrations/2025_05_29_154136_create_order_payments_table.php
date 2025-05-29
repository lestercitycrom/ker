<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('order_payments', function (Blueprint $table) {
			$table->id();
			$table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
			$table->enum('type', ['deposit','payment','discount','deposit_hold'])->default('payment');
			$table->enum('method', ['card','cash','bank_transfer','online','other'])->nullable();
			$table->decimal('amount', 10, 2);
			$table->dateTime('date')->nullable();
			$table->string('transaction_id')->nullable();
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('order_payments');
	}
};
