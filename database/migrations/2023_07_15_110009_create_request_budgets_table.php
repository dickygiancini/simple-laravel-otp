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
        Schema::create('request_budgets', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->decimal('balance', 15, 2)->default(0);
            $table->foreignId('status_id')
            ->constrained('mst_status')
            ->onDelete('cascade');
            $table->timestamps();
            $table->foreign('user_id')
            ->references('id')
            ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_budgets');
    }
};
