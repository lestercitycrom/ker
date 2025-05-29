<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('coupons', function (Blueprint $table) {
			$table->id();
			$table->string('code')->unique();
			$table->decimal('discount_amount', 10, 2)->nullable();
			$table->integer('discount_percent')->nullable();
			$table->date('valid_from')->nullable();
			$table->date('valid_to')->nullable();
			$table->integer('max_uses')->nullable();
			$table->integer('times_used')->default(0);
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('coupons');
	}
};
