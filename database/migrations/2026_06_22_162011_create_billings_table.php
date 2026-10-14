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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
        $table->foreignId('quote_id')->constrained()->cascadeOnDelete();
        $table->string('service_detail');
        $table->string('status')->default('Unpaid');   // Paid / Unpaid / Partial
        $table->string('method')->nullable();
        $table->decimal('amount_paid', 10, 2)->default(0);
        $table->decimal('pending_amount', 10, 2)->default(0);
        $table->date('paid_date')->nullable();
        $table->text('notes')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
