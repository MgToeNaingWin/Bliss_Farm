<?php
// database/migrations/2024_01_02_create_health_records_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('health_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livestock_id')->constrained()->onDelete('cascade');
            $table->date('record_date');
            $table->enum('type', ['vaccination', 'treatment', 'checkup', 'surgery', 'other']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('medication')->nullable();
            $table->string('dosage')->nullable();
            $table->date('next_due_date')->nullable();
            $table->foreignId('administered_by')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('cost', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_records');
    }
};
