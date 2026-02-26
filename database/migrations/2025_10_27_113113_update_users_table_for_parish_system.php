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
        Schema::table('users', function (Blueprint $table) {
            // Alterar role para enum com novos valores
            $table->string('role')->default('usuario_padrao')->change();

            // Novos campos para verificação
            $table->string('phone')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('address')->nullable();

            // Relacionamento com grupo paroquial
            $table->foreignId('parish_group_id')->nullable()->constrained('groups')->onDelete('set null');

            // Configurações de notificação
            $table->boolean('email_notifications_enabled')->default(true);

            // Foto de perfil
            $table->string('profile_photo_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'phone_verified_at',
                'birth_date',
                'address',
                'email_notifications_enabled',
                'profile_photo_path',
            ]);
            $table->dropForeign(['parish_group_id']);
            $table->dropColumn('parish_group_id');
            $table->string('role')->default('admin')->change();
        });
    }
};
