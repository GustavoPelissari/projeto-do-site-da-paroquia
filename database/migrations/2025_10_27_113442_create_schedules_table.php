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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Quem criou
            $table->string('title'); // Título da escala (ex: "Escala de Novembro 2025")
            $table->text('description')->nullable(); // Descrição adicional
            $table->string('pdf_path'); // Caminho para o arquivo PDF
            $table->string('pdf_filename'); // Nome original do arquivo
            $table->date('start_date'); // Data de início da escala
            $table->date('end_date'); // Data de fim da escala
            $table->json('metadata')->nullable(); // Metadados extraídos do PDF (datas, nomes, etc.)
            $table->boolean('is_active')->default(true); // Se a escala está ativa
            $table->timestamps();

            // Índices para performance
            $table->index(['group_id', 'is_active']);
            $table->index(['start_date', 'end_date']);
            $table->index(['user_id']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
