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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('game_id')->nullable()->constrained()->onDelete('set null');
            $table->string('type');
            $table->decimal('amount', 10, 2);
            $table->decimal('balance', 10, 2);
            $table->json('details')->nullable();
            $table->string('status')->default('completed');
            $table->timestamps();

            // Indexes
            $table->index(['user_id', 'type']);
            $table->index(['game_id', 'type']);
            $table->index('status');
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