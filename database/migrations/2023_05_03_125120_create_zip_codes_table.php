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
        Schema::create('zip_codes', function (Blueprint $table) {
            $table->id();
            $table->string('zip_code');
            $table->string('locality');
            $table->unsignedBigInteger('federal_entity_id');
            $table->foreign('federal_entity_id')
                ->references('id')
                ->on('federal_entities')
                ->onDelete('cascade');
            $table->unsignedBigInteger('municipality_id');
            $table->foreign('municipality_id')
                ->references('id')
                ->on('municipalities')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zip_codes');
    }
};
