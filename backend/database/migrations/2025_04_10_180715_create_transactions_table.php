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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('reference')->unique();
            $table->foreignId('from_customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('to_customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['deposit', 'transfer']);
            $table->enum('status', ['pending', 'completed', 'failed', 'reversed'])->default('completed');
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->foreignId('reversed_by_admin_id')->nullable()->constrained('admins')->onDelete('set null');
            $table->timestamp('reversed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
