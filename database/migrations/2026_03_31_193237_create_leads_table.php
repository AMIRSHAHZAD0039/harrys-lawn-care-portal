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
        // Safety check: only create the table if it does not exist already
        if (!Schema::hasTable('leads')) {
            Schema::create('leads', function (Blueprint $table) {
                $table->id();
                $table->string('first_name');
                $table->string('last_name')->nullable();
                $table->string('email')->unique();
                $table->string('phone')->nullable();
                $table->text('address')->nullable();
                $table->date('date_of_lead')->nullable();
                $table->string('source')->nullable();
                $table->string('property_type')->nullable();
                
                $table->string('service')->nullable();
                $table->string('sub_services')->nullable();
                

                $table->text('message')->nullable();
                $table->string('commercial_property_size')->nullable();
                $table->text('comments')->nullable();
                $table->string('status')->nullable();
                $table->string('frequency_selected')->nullable();
                $table->string('package_selected')->nullable();
                $table->string('per_visit_charges')->nullable();
                $table->string('total_charges')->nullable();
                $table->string('visit_number')->nullable();
                $table->date('visit_date')->nullable();
                $table->time('visit_time')->nullable();
                $table->string('visit_status')->nullable();
                $table->string('payment_status')->nullable();
                $table->string('client_status')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
