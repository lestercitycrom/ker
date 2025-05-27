<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table): void {
            $table->id();

            // Общие
            $table->enum('type', ['individual', 'company'])->default('individual')->comment('Тип контакту');
            $table->string('first_name')->comment('Ім’я');
            $table->string('last_name')->nullable()->comment('Прізвище');
            $table->foreignId('group_id')->constrained('contact_groups')->comment('Група контакту');

            // Компания
            $table->string('company_name')->nullable()->comment('Назва компанії');
            $table->string('contact_person')->nullable()->comment('Контактна особа');
            $table->string('registration_number')->nullable()->comment('Реєстраційний номер');
            $table->string('vat_number')->nullable()->comment('VAT номер');
            $table->string('website')->nullable()->comment('Веб-сайт');

            // Фізособа
            $table->enum('gender', [1, 2, 3])->nullable()->comment('Стать');
            $table->date('birthday')->nullable()->comment('Дата народження');

            // Адреса
            $table->unsignedBigInteger('country')->nullable()->comment('Країна (ID)');
            $table->string('state')->nullable()->comment('Область/штат');
            $table->string('city')->nullable()->comment('Місто');
            $table->string('street')->nullable()->comment('Вулиця');
            $table->string('building')->nullable()->comment('Будинок/офіс');
            $table->string('zip')->nullable()->comment('Поштовий індекс');

            // Контакти
            $table->string('email')->nullable()->comment('Email');
            $table->string('phone')->nullable()->comment('Телефон');

            // Заметки
            $table->text('notes')->nullable()->comment('Примітки');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
