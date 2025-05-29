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
		Schema::table('orders', function (Blueprint $table) {
			// Удаляем внешний ключ на vehicle_category_id, если был
			if (Schema::hasColumn('orders', 'vehicle_category_id')) {
				// Попытка удалить внешний ключ по стандартному имени
				$table->dropForeign(['vehicle_category_id']);
				// Удаляем сам столбец
				$table->dropColumn('vehicle_category_id');
			}

			// Удаляем внешний ключ на manager_id, если был
			// Попытка удалить внешний ключ по стандартному имени (если существует)
			try {
				$table->dropForeign(['manager_id']);
			} catch (\Throwable $e) {
				// Foreign key may not exist
			}

			// Меняем manager_id: nullable, без внешнего ключа, default null
			$table->unsignedBigInteger('manager_id')->nullable()->default(null)->change();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('orders', function (Blueprint $table) {
			// Возвращаем vehicle_category_id (без внешнего ключа)
			$table->unsignedBigInteger('vehicle_category_id')->nullable();

			// Возвращаем manager_id к non-nullable (если ранее был не nullable)
			$table->unsignedBigInteger('manager_id')->nullable(false)->default(0)->change();
			// Примечание: внешний ключ обратно не восстанавливается (требует доп. логики)
		});
	}
};
