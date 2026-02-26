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
        // Update Deal Stages to match UI
        Schema::table('deals', function (Blueprint $table) {
            $table->string('stage', 50)->default('Prospect')->change();
        });

        // Add performance indexes
        Schema::table('leads', function (Blueprint $table) {
            $table->index('name');
            $table->index('email');
            $table->index('company');
            $table->index('source');
            $table->index('category');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->index('name');
            $table->index('email');
            $table->index('company');
            $table->index('status');
        });

        Schema::table('deals', function (Blueprint $table) {
            $table->index('title');
            $table->index('stage');
            $table->index('value');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('name');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['name', 'email']);
        });

        Schema::table('deals', function (Blueprint $table) {
            $table->dropIndex(['title', 'stage', 'value']);
            $table->enum('stage', ['Open', 'Won', 'Lost'])->default('Open')->change();
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex(['name', 'email', 'company', 'status']);
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->dropIndex(['name', 'email', 'company', 'source', 'category']);
        });
    }
};
