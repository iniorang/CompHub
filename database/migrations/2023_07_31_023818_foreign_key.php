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
        Schema::table('users', function (Blueprint $table) {
            // $table->unsignedBigInteger('anggotaTim')->nullable();
            $table->foreign('anggotaTim')->references('id')->on('tims')->nullabale();
        });

        // Schema::table('kompetisis', function (Blueprint $table) {
        //     // $table->unsignedBigInteger('org');
        //     $table->foreign('org')->references('id')->on('organizers');
        // });

        // Schema::table('tims', function (Blueprint $table) {
        //     $table->foreign('ketua')->references('id')->on('users');
        // });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
