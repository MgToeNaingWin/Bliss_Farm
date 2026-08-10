<?php
// database/migrations/2026_08_05_000000_create_financial_records_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('livestock_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('type', ['income', 'expense']);
            $table->string('category');
            $table->string('sub_category')->nullable();
            $table->string('description');
            $table->decimal('amount', 12, 2);
            $table->date('transaction_date');
            $table->string('payment_method')->nullable();
            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();
            $table->string('attachment')->nullable();
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('completed');
            $table->timestamps();

            // Indexes for faster queries
            $table->index(['user_id', 'transaction_date']);
            $table->index(['type', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_records');
    }
};
