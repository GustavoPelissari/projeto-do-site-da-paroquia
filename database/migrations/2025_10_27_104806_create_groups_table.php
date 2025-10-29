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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ex: "Coral", "Catequese", "Pastoral da Juventude"
            $table->text('description');
            $table->enum('category', ['liturgy', 'pastoral', 'service', 'formation', 'youth', 'family'])->default('pastoral');
            $table->string('coordinator_name')->nullable();
            $table->string('coordinator_phone')->nullable();
            $table->string('coordinator_email')->nullable();
            $table->text('meeting_info')->nullable(); // Ex: "Todos os sábados às 14h"
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
