<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            $table->string('code', 50)
                ->unique();

            $table->decimal('discount_value', 10, 2)
                ->nullable();

            $table->decimal('min_order_value', 10, 2)
                ->nullable();

            $table->date('expiry_date')
                ->nullable();

            $table->string('status', 20)
                ->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
