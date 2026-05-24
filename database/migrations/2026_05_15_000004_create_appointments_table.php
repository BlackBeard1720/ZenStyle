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

                $table->foreignId('client_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->foreignId('coupon_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete();

                $table->date('appointment_date');

                $table->time('appointment_time');

                $table->string('status')
                    ->default('pending');

                $table->text('notes')
                    ->nullable();

                $table->decimal('total_amount', 10, 2)
                    ->default(0);

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_service');
        Schema::dropIfExists('appointments');
    }
};
