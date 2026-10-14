<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('route_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('assignment_id')
                  ->constrained('quote_assignments')
                  ->cascadeOnDelete();

            $table->date('service_date');
            $table->integer('stop_order')->nullable();
            $table->string('route_type')->default('optimized');
            $table->string('status')->default('pending'); // pending | completed | skipped

            // BEFORE photos: JSON array of objects, each:
            // { "path": "...", "lat": 49.28, "lng": -123.12, "accuracy": 8, "taken_at": "2026-07-10 08:14:00" }
            // TEXT (not string) because many photos + GPS overflow VARCHAR(255).
            $table->text('before_photo')->nullable();
            $table->timestamp('started_at')->nullable();   // first before photo added

            // AFTER photos: same JSON-array-of-objects shape.
            $table->text('proof_photo')->nullable();
            $table->timestamp('completed_at')->nullable();  // set by explicit "Complete Job" action

            $table->timestamps();

            $table->index(['service_date', 'assignment_id']);
            $table->unique(['assignment_id', 'service_date']); // no double-booking same client same day
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('route_schedules');
    }
};