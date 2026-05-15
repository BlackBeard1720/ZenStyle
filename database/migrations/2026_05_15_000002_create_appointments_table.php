<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('appointments')) {
            Schema::create('appointments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
                $table->foreignId('coupon_id')->nullable();
                $table->date('appointment_date');
                $table->time('appointment_time');
                $table->string('status')->default('pending');
                $table->text('notes')->nullable();
                $table->decimal('total_amount', 10, 2)->default(0);
                $table->timestamps();

                $table->index(['appointment_date', 'appointment_time']);
                $table->index('status');
            });
        }

        if (! Schema::hasTable('appointment_service')) {
            Schema::create('appointment_service', function (Blueprint $table) {
                $table->id();
                $table->foreignId('appointment_id')->constrained('appointments')->cascadeOnDelete();
                $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
                $table->foreignId('staff_id')->nullable()->constrained('staff')->nullOnDelete();
                $table->decimal('price_at_booking', 10, 2);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_service');
        Schema::dropIfExists('appointments');
    }
};
