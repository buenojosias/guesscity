<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->boolean('dark_mode')->default(false);
            $table->enum('default_mode', ['static', 'dynamic'])->default('static'); // Modo que o jogo carregará por padrão
            $table->boolean('neighbor_cities')->default(false); // Desafio de carregar locais de cidades vizinhas
            $table->decimal('latitude', 10, 8)->nullable(); // Localização padrão escolhida pelo usuário, necessário para o default_radius
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('default_radius')->nullable(); // Limitação de raio dos locais carregados, sem limite de null
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preferences');
    }
};
