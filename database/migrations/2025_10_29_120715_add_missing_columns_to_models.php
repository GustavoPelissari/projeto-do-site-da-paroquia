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
        // Add group_id to users table if not exists
        if (! Schema::hasColumn('users', 'group_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('group_id')->nullable()->after('parish_group_id');
                $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null');
            });
        }

        // Add missing columns to news table
        if (! Schema::hasColumn('news', 'group_id')) {
            Schema::table('news', function (Blueprint $table) {
                $table->unsignedBigInteger('group_id')->nullable()->after('user_id');
                $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null');
            });
        }

        if (! Schema::hasColumn('news', 'created_by')) {
            Schema::table('news', function (Blueprint $table) {
                $table->unsignedBigInteger('created_by')->nullable()->after('group_id');
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            });
        }

        if (! Schema::hasColumn('news', 'scope')) {
            Schema::table('news', function (Blueprint $table) {
                $table->enum('scope', ['global', 'parish', 'group'])->default('parish')->after('status');
            });
        }

        if (! Schema::hasColumn('news', 'featured_image')) {
            Schema::table('news', function (Blueprint $table) {
                $table->string('featured_image')->nullable()->after('image');
            });
        }

        // Add missing columns to events table
        if (! Schema::hasColumn('events', 'group_id')) {
            Schema::table('events', function (Blueprint $table) {
                $table->unsignedBigInteger('group_id')->nullable()->after('user_id');
                $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null');
            });
        }

        if (! Schema::hasColumn('events', 'created_by')) {
            Schema::table('events', function (Blueprint $table) {
                $table->unsignedBigInteger('created_by')->nullable()->after('group_id');
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove added columns
        if (Schema::hasColumn('users', 'group_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['group_id']);
                $table->dropColumn('group_id');
            });
        }

        if (Schema::hasColumn('news', 'group_id')) {
            Schema::table('news', function (Blueprint $table) {
                $table->dropForeign(['group_id']);
                $table->dropColumn('group_id');
            });
        }

        if (Schema::hasColumn('news', 'created_by')) {
            Schema::table('news', function (Blueprint $table) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            });
        }

        if (Schema::hasColumn('news', 'scope')) {
            Schema::table('news', function (Blueprint $table) {
                $table->dropColumn('scope');
            });
        }

        if (Schema::hasColumn('news', 'featured_image')) {
            Schema::table('news', function (Blueprint $table) {
                $table->dropColumn('featured_image');
            });
        }

        if (Schema::hasColumn('events', 'group_id')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropForeign(['group_id']);
                $table->dropColumn('group_id');
            });
        }

        if (Schema::hasColumn('events', 'created_by')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            });
        }
    }
};
