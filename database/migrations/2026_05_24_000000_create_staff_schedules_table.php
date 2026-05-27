<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id')
                ->constrained('staff')
                ->cascadeOnDelete();

            $table->date('work_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->enum('status', [
                'scheduled',
                'off',
                'leave',
            ])->default('scheduled');

            $table->text('note')->nullable();
            $table->timestamps();

            $table->unique(['staff_id', 'work_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_schedules');
    }
};
