<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->string('type')->default('text'); // text|image|video|audio|file|location
            $table->text('content');
            $table->json('metadata')->nullable(); // filename, size, mime_type
            $table->unsignedBigInteger('parent_message_id')->nullable(); // for replies
            $table->boolean('is_edited')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();

            $table->index(['chat_id', 'created_at']);
            $table->index('sender_id');
            $table->index('parent_message_id');
        });

        Schema::table('chat_participants', function (Blueprint $table) {
            $table->foreign('last_read_message_id')->references('id')->on('messages')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('chat_participants', function (Blueprint $table) {
            $table->dropForeign(['last_read_message_id']);
        });
        Schema::dropIfExists('messages');
    }
};
