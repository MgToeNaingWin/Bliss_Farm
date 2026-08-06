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
        Schema::table('post_comments', function (Blueprint $table) {
            // parent_id Column ကို Nullable အဖြစ် ပေါင်းထည့်ခြင်း
            $table->unsignedBigInteger('parent_id')->nullable()->after('sell_post_id');

            // Optional: Foreign key constraint ချိတ်လိုပါက
            // $table->foreign('parent_id')->references('id')->on('post_comments')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('post_comments', function (Blueprint $table) {
            $table->dropColumn('parent_id');
        });
    }
};
