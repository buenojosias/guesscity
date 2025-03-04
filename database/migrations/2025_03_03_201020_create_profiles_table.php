<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('city_id')->nullable();
            $table->string('nickname')->unique()->index();
            $table->string('avatar')->nullable();
            $table->integer('points')->default(0); // Pontuação do usuário
            $table->integer('level')->default(1); // Nível do usuário, vai subindo de acordo com a pontuação
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
