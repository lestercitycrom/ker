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
        Schema::table('vehicles', function (Blueprint $table) {
            // удаляем старые текстовые и enum-поля
            $table->dropColumn([
                'brand',
                'model',
                'transmission',
                'fuel_type',
                'body_type',
                'drive_type',
                'color',
            ]);

            // добавляем новые поля-ID из config
            $table->unsignedBigInteger('brand_id')
                  ->after('type');
            $table->unsignedBigInteger('model_id')
                  ->after('brand_id');
            $table->unsignedTinyInteger('transmission_id')
                  ->nullable()
                  ->after('vin');
            $table->unsignedTinyInteger('fuel_id')
                  ->nullable()
                  ->after('transmission_id');
            $table->unsignedTinyInteger('body_type_id')
                  ->nullable()
                  ->after('fuel_id');
            $table->unsignedTinyInteger('drive_id')
                  ->nullable()
                  ->after('body_type_id');
            $table->unsignedSmallInteger('color_id')
                  ->nullable()
                  ->after('drive_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // возвращаем старые поля
            $table->string('brand')
                  ->after('type');
            $table->string('model')
                  ->after('brand');
            $table->enum('transmission', ['AT','MT','AM','CVT','NONE'])
                  ->nullable()
                  ->after('vin');
            $table->enum('fuel_type', ['Gasoline','Diesel','Hybrid','Electric','LPG','CNG','Other'])
                  ->nullable()
                  ->after('transmission');
            $table->string('body_type')
                  ->nullable()
                  ->after('fuel_type');
            $table->enum('drive_type', ['FWD','RWD','AWD'])
                  ->nullable()
                  ->after('body_type');
            $table->string('color')
                  ->nullable()
                  ->after('drive_type');

            // удаляем ID-поля
            $table->dropColumn([
                'brand_id',
                'model_id',
                'transmission_id',
                'fuel_id',
                'body_type_id',
                'drive_id',
                'color_id',
            ]);
        });
    }
};
