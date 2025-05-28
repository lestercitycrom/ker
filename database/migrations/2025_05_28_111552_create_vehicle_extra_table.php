<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('vehicle_extra', function (Blueprint $table) {
			$table->id();
			$table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
			$table->foreignId('extra_id')->constrained('extras')->cascadeOnDelete();
		});
	}
	public function down(): void
	{
		Schema::dropIfExists('vehicle_extra');
	}
};
