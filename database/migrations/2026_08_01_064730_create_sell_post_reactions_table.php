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
    Schema::create('post_reactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sell_post_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('type'); // e.g., 'Like', 'Love', 'Bull', 'Deal', 'Wow'
        $table->timestamps();

        $table->unique(['sell_post_id', 'user_id']); // One reaction per user per post
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sell_post_reactions');
    }
};
