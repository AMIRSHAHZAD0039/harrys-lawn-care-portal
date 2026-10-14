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
        Schema::table('quotes', function (Blueprint $table) {
            $table->string('seasonal_frequency')->nullable()->after('service_type');

        $table->decimal('seasonal_subtotal',10,2)->nullable();
        $table->decimal('seasonal_discount',10,2)->nullable();
        $table->decimal('seasonal_gst',10,2)->nullable();
        $table->decimal('seasonal_total',10,2)->nullable();

        $table->decimal('onetime_subtotal',10,2)->nullable();
        $table->decimal('onetime_discount',10,2)->nullable();
        $table->decimal('onetime_gst',10,2)->nullable();
        $table->decimal('onetime_total',10,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
  public function down(): void
{
    Schema::table('quotes', function (Blueprint $table) {
        $table->dropColumn([
            'seasonal_frequency',
            'seasonal_subtotal','seasonal_discount','seasonal_gst','seasonal_total',
            'onetime_subtotal','onetime_discount','onetime_gst','onetime_total',
        ]);
    });
}
};
