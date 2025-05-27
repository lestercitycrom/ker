<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('contact_documents', function (Blueprint $table): void {
			$table->id();

			// Связь с контактами
			$table->foreignId('contact_id')
				  ->constrained('contacts')
				  ->cascadeOnDelete();

			// Тип документа
			$table->enum('type', [
				'driver_license',
				'passport',
				'tax_identification',
				'payment_card',
				'card_id',
				'other',
			]);

			// Номера и даты
			$table->string('number')->nullable();
			$table->date('issue_date')->nullable();
			$table->date('exp_date')->nullable();

			// Примечания
			$table->text('notes')->nullable();

			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('contact_documents');
	}
};
