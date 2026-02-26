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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->enum('source', ['Website', 'Referral', 'Social Media', 'Cold Call', 'WhatsApp', 'Events'])->default('Website');
            $table->enum('category', ['Not Interested', 'Followup', 'Pending', 'Confirm'])->default('Pending');
            $table->decimal('value', 12, 2)->nullable();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->boolean('has_notes')->default(false);
            $table->integer('notes_count')->default(0);
            $table->text('description')->nullable();
            $table->timestamp('followup_date')->nullable();
            $table->string('avatar_color')->default('indigo');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
