<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            $table->foreignId('supplier_id')
                ->nullable()
                ->constrained('suppliers')
                ->nullOnDelete();

            $table->string('product_name');

            $table->string('sku', 50)
                ->nullable()
                ->unique();

            $table->text('description')
                ->nullable();

            $table->decimal('price', 10, 2)
                ->nullable();

            $table->integer('stock_quantity')
                ->default(0);

            $table->integer('min_threshold')
                ->default(0);

            $table->enum('status', [
                'active',
                'inactive'
            ])->default('active');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
