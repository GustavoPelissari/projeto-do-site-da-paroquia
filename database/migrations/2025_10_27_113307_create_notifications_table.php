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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // Tipo da notificação
            $table->string('title'); // Título da notificação
            $table->text('message'); // Mensagem da notificação
            $table->json('data')->nullable(); // Dados adicionais (JSON)
            $table->timestamp('read_at')->nullable(); // Quando foi lida
            $table->boolean('email_sent')->default(false); // Se e-mail foi enviado
            $table->timestamp('email_sent_at')->nullable(); // Quando e-mail foi enviado
            $table->timestamps();

            // Índices para performance
            $table->index(['user_id', 'read_at']);
            $table->index(['user_id', 'type']);
            $table->index(['created_at']);
            $table->index(['type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
