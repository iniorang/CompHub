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
        Schema::create('tim_ikut_komps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tim_id');
            $table->unsignedBigInteger('komps_id');
            $table->foreign('tim_id')->references('id')->on('tims');
            $table->foreign('komps_id')->references('id')->on('kompetisis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tim_ikut_komps');
    }
};
