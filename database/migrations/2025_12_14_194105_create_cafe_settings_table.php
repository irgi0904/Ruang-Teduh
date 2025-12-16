<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cafe_settings', function (Blueprint $table) {
            $table->id();
            $table->string('cafe_name', 150);
            $table->string('cafe_logo', 255)->nullable();
            $table->text('cafe_address')->nullable();
            $table->string('cafe_phone', 20)->nullable();
            $table->string('cafe_email', 100)->nullable();
            $table->decimal('tax_percentage', 5, 2)->default(0);
            $table->string('currency', 10)->default('IDR');
            $table->string('timezone', 50)->default('Asia/Jakarta');
            $table->text('business_hours')->nullable(); 
            $table->boolean('is_open')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cafe_settings');
    }
};