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
        Schema::create('company_shareholdings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();
            $table->string('symbol', 20)->index();
            $table->json('payload');
            $table->string('source')->default('yahoo_finance');
            $table->string('cache_store')->nullable();
            $table->string('cache_key')->nullable();
            $table->timestamp('fetched_at');
            $table->timestamps();

            $table->index(['company_id', 'fetched_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_shareholdings');
    }
};
