<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id')
                ->constrained('staff')
                ->cascadeOnDelete();

            $table->date('work_date');
            $table->timestamp('check_in')->nullable();
            $table->timestamp('check_out')->nullable();

            $table->enum('status', [
                'present',
                'late',
                'absent',
                'leave',
            ])->default('present');

            $table->timestamps();

            $table->unique(['staff_id', 'work_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
