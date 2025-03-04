<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('plan', ['free', 'premium'])->default('free');
            $table->enum('role', ['admin', 'user', 'moderator', 'contributor'])->default('user');
            $table->integer('fidelity')->default(0); // Aumenta à medida de dias consecutivos que o usuário joga
            $table->integer('remaining_hints')->default(5); // Quantidade de dicas restantes do usuário no dia (diminui a cada uso e reseta a cada 24 horas)
            $table->integer('remaining_errors')->default(5); // Quantidade de vezes que o usuário ainda pode errar no dia (diminui a cada erro e reseta a cada 24 horas)
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
