<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('orders', function (Blueprint $table) {
			$table->id();
			$table->foreignId('contact_id')->constrained('contacts')->cascadeOnDelete();			// клиент/арендатор
			$table->foreignId('vehicle_category_id')->nullable()->constrained('vehicle_categories')->nullOnDelete();
			$table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->nullOnDelete();	// машина (может быть null до выдачи)
			$table->foreignId('manager_id')->nullable()->constrained('contacts')->nullOnDelete();	// кто оформил (Contact как менеджер)
			$table->enum('status', [
				'booking', 'reserved', 'rental', 'done', 'cancel', 'reject'
			])->default('booking');
			$table->string('source')->nullable();					// канал/агент ("manual", "hotel", ...)
			$table->string('code')->nullable();						// код заказа (TCDK2Y...)
			$table->dateTime('start_at');							// начало аренды
			$table->dateTime('end_at');								// окончание аренды
			$table->foreignId('pickup_location_id')->nullable()->constrained('locations')->nullOnDelete();
			$table->foreignId('return_location_id')->nullable()->constrained('locations')->nullOnDelete();
			$table->boolean('return_to_different_location')->default(false);
			$table->text('pickup_notes')->nullable();
			$table->text('return_notes')->nullable();
			$table->string('coupon_code')->nullable();
			$table->decimal('discount_amount', 10, 2)->default(0);
			$table->decimal('total_amount', 10, 2)->default(0);
			$table->decimal('balance_due', 10, 2)->default(0);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('orders');
	}
};
