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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->tinyInteger('type')->default(0);
            $table->text('alamat')->nullable();
            $table->integer('telp')->unsigned()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedBigInteger('anggotaTim')->nullable();
            $table->string('password');
            $table->boolean('disabled')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
