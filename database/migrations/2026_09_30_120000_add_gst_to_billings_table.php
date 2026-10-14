<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('billings', function (Blueprint $table) {
            $table->decimal('invoice_amount', 10, 2)->default(0)->after('method'); // before GST
            $table->boolean('gst_applied')->default(false)->after('invoice_amount');
            $table->decimal('gst_amount', 10, 2)->default(0)->after('gst_applied');
            $table->decimal('total_amount', 10, 2)->default(0)->after('gst_amount'); // invoice + GST
        });

        // Backfill old records: their total was simply paid + pending, no GST.
        DB::table('billings')->update([
            'invoice_amount' => DB::raw('amount_paid + pending_amount'),
            'total_amount'   => DB::raw('amount_paid + pending_amount'),
        ]);
    }

    public function down(): void
    {
        Schema::table('billings', function (Blueprint $table) {
            $table->dropColumn(['invoice_amount', 'gst_applied', 'gst_amount', 'total_amount']);
        });
    }
};
