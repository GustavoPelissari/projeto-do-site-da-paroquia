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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action'); // Ação realizada (create, update, delete, etc.)
            $table->string('resource_type'); // Tipo do recurso (User, Group, News, etc.)
            $table->unsignedBigInteger('resource_id')->nullable(); // ID do recurso
            $table->text('description'); // Descrição da ação
            $table->json('old_values')->nullable(); // Valores anteriores (JSON)
            $table->json('new_values')->nullable(); // Novos valores (JSON)
            $table->ipAddress('ip_address')->nullable(); // IP do usuário
            $table->text('user_agent')->nullable(); // User agent do navegador
            $table->timestamps();

            // Índices para performance
            $table->index(['user_id', 'created_at']);
            $table->index(['resource_type', 'resource_id']);
            $table->index(['action']);
            $table->index(['created_at']);
            $table->index(['ip_address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
