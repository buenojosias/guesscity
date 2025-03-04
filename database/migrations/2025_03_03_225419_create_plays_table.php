<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('place_id')->constrained()->cascadeOnDelete();
            $table->integer('user_level'); // Nível do usuário no momento do jogo
            $table->enum('mode', ['static', 'dynamic']);
            $table->integer('time'); // Tempo em segundos que o usuário levou para acertar
            $table->integer('target_distance'); // Distância entre o local correto e o local marcado
            $table->integer('hints')->default(0); // Quantidade de dicas que o usuário usou
            $table->integer('errors')->default(0); // Quantidade de erros que o usuário cometeu
            $table->integer('selected_radius')->nullable(); // Distância máxima definida pelo usuário
            $table->integer('score'); // Pontuação do usuário neste jogo
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plays');
    }
};
