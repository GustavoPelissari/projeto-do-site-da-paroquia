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
        // Remove duplicate group_id column from users table
        // We use parish_group_id instead for consistency
        if (Schema::hasColumn('users', 'group_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['group_id']);
                $table->dropColumn('group_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add group_id column if needed
        if (! Schema::hasColumn('users', 'group_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('group_id')->nullable()->after('parish_group_id');
                $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null');
            });
        }
    }
};
