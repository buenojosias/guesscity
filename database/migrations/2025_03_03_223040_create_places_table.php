<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained();
            $table->string('name'); // Nome de identificação do local, visível pelo usuário após tentar adivinhar
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('panoid', 100)->nullable(); // Fornecido pela API do Google
            $table->json('pov'); // heading, pitch Define o ponto de vista da câmera
            $table->string('type')->index(); // Tipo de local (rua, esquina, praça, parque, monumento, etc)
            $table->integer('level')->default(1)->index(); // Nível de dificuldade de identificação do local
            $table->json('hints')->nullable(); // Dicas para ajudar o usuário a adivinhar o local, com perguntas e respostas
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('active')->default(true); // Indica se o local está ativo para ser jogado
            $table->boolean('has_image')->default(false); // Indica se o local possui imagem
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
