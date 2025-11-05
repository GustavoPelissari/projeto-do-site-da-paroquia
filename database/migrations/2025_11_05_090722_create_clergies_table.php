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
        Schema::create('clergies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('role', ['paroco', 'vigario', 'padre_colaborador', 'diacono']); // pároco, vigário, padre colaborador, diácono
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->integer('order')->default(0); // Para ordenar a exibição
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clergies');
    }
};
