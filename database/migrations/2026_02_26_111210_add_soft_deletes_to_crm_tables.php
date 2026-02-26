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
        Schema::table('leads', function (Blueprint $table) {
            if (!Schema::hasColumn('leads', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('deals', function (Blueprint $table) {
            if (!Schema::hasColumn('deals', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('followups', function (Blueprint $table) {
            if (!Schema::hasColumn('followups', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('notes', function (Blueprint $table) {
            if (!Schema::hasColumn('notes', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('deals', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('followups', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('notes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
