<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            // 'all'    = signed customer, not yet promoted
            // 'active' = promoted to Active Customers (recurring / current work)
            $table->string('customer_status')->default('all')->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn('customer_status');
        });
    }
};