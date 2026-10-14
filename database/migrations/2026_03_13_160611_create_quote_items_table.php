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
        Schema::create('quote_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('quote_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('type')->default('seasonal'); 
            $table->string('frequency')->nullable(); 

            $table->string('description')->nullable();
            $table->decimal('qty',10,2)->nullable();
            $table->decimal('rate',10,2)->nullable();
            $table->decimal('amount',10,2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_items');
    }
};
