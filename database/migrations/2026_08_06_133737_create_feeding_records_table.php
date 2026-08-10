<?php
// database/migrations/2024_01_03_create_feeding_records_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feeding_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livestock_id')->constrained()->onDelete('cascade');
            $table->date('record_date');
            $table->string('feed_type');
            $table->decimal('quantity', 8, 2);
            $table->string('unit')->default('kg');
            $table->time('feeding_time')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feeding_records');
    }
};
