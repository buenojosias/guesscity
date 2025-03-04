<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('place_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('place_id')->constrained('places')->cascadeOnDelete();
            $table->integer('total_plays')->default(0); // Total de vezes que o local foi jogado
            $table->decimal('avg_time', 8, 2)->default(0); // Tempo médio gasto no local
            $table->decimal('avg_distance_error', 8, 2)->default(0); // Erro médio (em metros)
            $table->decimal('accuracy_percentage', 5, 2)->default(0); // Porcentagem de acertos
            $table->integer('popularity')->default(0); // Popularidade calculada (ou pode ser um cálculo de média ponderada)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('place_metrics');
    }
};
