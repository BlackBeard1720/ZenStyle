<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id')
                ->constrained('staff')
                ->cascadeOnDelete();

            $table->integer('month');
            $table->integer('year');

            $table->decimal('base_salary', 12, 2)->default(0);
            $table->decimal('commission', 12, 2)->default(0);
            $table->decimal('total_salary', 12, 2)->default(0);

            $table->enum('status', [
                'draft',
                'confirmed',
                'paid',
            ])->default('draft');

            $table->timestamps();

            $table->unique(['staff_id', 'month', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
