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
        Schema::create('shareholder_entities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('normalized_name', 191)->unique();
            $table->string('type', 40)->nullable();
            $table->enum('status', ['unknown', 'affiliated', 'unaffiliated', 'blocked'])->default('unknown');
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index('type');
            $table->index('status');
        });

        Schema::create('company_shareholder_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();
            $table->foreignId('shareholder_entity_id')
                ->constrained('shareholder_entities')
                ->cascadeOnDelete();
            $table->foreignId('company_shareholding_id')
                ->nullable()
                ->constrained('company_shareholdings')
                ->nullOnDelete();
            $table->string('relationship_type', 40)->nullable();
            $table->decimal('percent_held', 12, 8)->nullable();
            $table->unsignedBigInteger('position')->nullable();
            $table->decimal('market_value', 20, 2)->nullable();
            $table->decimal('percent_change', 12, 8)->nullable();
            $table->date('report_date')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->unique(['company_id', 'shareholder_entity_id'], 'company_shareholder_unique');
            $table->index('shareholder_entity_id', 'company_shareholder_entity_lookup');
            $table->index('company_shareholding_id', 'company_shareholder_snapshot_lookup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_shareholder_positions');
        Schema::dropIfExists('shareholder_entities');
    }
};
