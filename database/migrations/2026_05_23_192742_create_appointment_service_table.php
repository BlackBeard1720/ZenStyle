<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointment_service', function (Blueprint $table) {
            $table->id();

            $table->foreignId('appointment_id')
                ->constrained('appointments')
                ->cascadeOnDelete();

            $table->foreignId('service_id')
                ->constrained('services')
                ->cascadeOnDelete();

            $table->foreignId('staff_id')
                ->nullable()
                ->constrained('staff')
                ->nullOnDelete();

            $table->decimal('price_at_booking', 10, 2)
                ->nullable();

            // Bảng gốc của bạn không có timestamps
            // nên không thêm $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_service');
    }
};
