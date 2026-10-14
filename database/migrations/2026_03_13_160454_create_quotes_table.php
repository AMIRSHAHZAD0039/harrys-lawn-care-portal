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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();

            $table->string('quote_number')->nullable();
            $table->date('date')->nullable();
            $table->date('valid_until')->nullable();
            $table->string('prepared_by')->nullable();

            $table->string('client_name')->nullable();
            $table->string('client_address')->nullable();
            $table->string('client_phone')->nullable();
            $table->string('client_email')->nullable();

            $table->string('lawn_size')->nullable();
            $table->string('service_area')->nullable();
            $table->string('terrain')->nullable();
            $table->string('access')->nullable();

            $table->text('condition')->nullable();
            $table->text('hazards')->nullable();

            $table->string('service_type')->nullable();

            $table->decimal('subtotal',10,2)->nullable();
            $table->decimal('discount',10,2)->nullable();
            $table->decimal('gst',10,2)->nullable();
            $table->decimal('total',10,2)->nullable();

            $table->text('notes')->nullable();
            $table->text('representative')->nullable();

            $table->string('client_signature')->nullable();
            $table->string('client_name_print')->nullable();
            $table->date('signature_date')->nullable();

            /* NEW FIELDS */

            $table->string('token')->unique()->nullable();
            $table->boolean('signed')->default(false);
            $table->string('status')->nullable();
            $table->longText('signature')->nullable();

            $table->boolean('is_void')->default(false);
            $table->string('void_reason')->nullable();
            $table->string('associated_group')->nullable();
            $table->string('associated_week')->nullable();
            $table->string('payment_method')->nullable();

            $table->timestamp('signed_at')->nullable();
            $table->text('sign_reason')->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
