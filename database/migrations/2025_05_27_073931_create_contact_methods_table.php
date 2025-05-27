<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_methods', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('contact_id')
                  ->constrained('contacts')
                  ->cascadeOnDelete();
            $table->enum('type', ['skype','telegram','viber','whatsapp'])
                  ->comment('Тип мессенджера');
            $table->string('value')->comment('Логін або номер');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_methods');
    }
};
