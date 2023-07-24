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
        Schema::create('kompetisis', function (Blueprint $table) {
            $table->id();
            $table->string('img');
            $table->string('nama');
            $table->text('desk');
            $table->unsignedBigInteger('org');
            $table->foreign('org')->references('id')->on('organizers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kompetisis');
    }
};
