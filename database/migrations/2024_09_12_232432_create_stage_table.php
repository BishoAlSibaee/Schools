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
        Schema::create('stage', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_building');
            $table->string('stage_name',50);
            $table->integer('stage_number');
            $table->foreign('id_building')->references('id')->on('building')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stage');
    }
};
