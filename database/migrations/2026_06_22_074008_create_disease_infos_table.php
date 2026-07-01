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
        Schema::create('disease_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_type_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->string('disease_title');
            $table->longText('disease_desc')->nullable();
            $table->string('disease_img')->nullable();
            $table->longText('symptoms')->nullable();      // Signs
            $table->longText('prevent')->nullable();   // Prevention
            $table->longText('treated')->nullable();   // Treatment
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disease_infos');
    }
};
