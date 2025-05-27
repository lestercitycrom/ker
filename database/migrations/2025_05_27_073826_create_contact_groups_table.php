<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_groups', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->comment('Назва групи контакту');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_groups');
    }
};
