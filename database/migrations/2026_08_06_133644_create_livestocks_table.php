<?php
// database/migrations/2024_01_01_create_livestocks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livestocks', function (Blueprint $table) {
            $table->id();
            $table->string('tag_number')->unique();
            $table->string('name')->nullable();
            $table->enum('type', ['cattle', 'sheep', 'goat', 'pig', 'horse', 'poultry', 'other']);
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth')->nullable();
            $table->string('breed')->nullable();
            $table->string('color')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->enum('status', ['active', 'sold', 'deceased', 'transferred'])->default('active');
            $table->foreignId('parent_id')->nullable()->constrained('livestocks')->onDelete('set null');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livestocks');
    }
};
