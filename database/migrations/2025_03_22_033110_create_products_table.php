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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['affiliated', 'unaffiliated'])->default('unaffiliated')->nullable();
            $table->foreignId('categories_id')->constrained('categories')->onDelete('cascade');
            $table->boolean('local_product')->default(false);
            $table->string('name');
            $table->text('description');
            $table->string('source');
            $table->string('image');
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
