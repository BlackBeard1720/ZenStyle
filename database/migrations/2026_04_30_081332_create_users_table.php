<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Chạy các migration.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('username');
            $table->string('email')->unique();
            $table->string('phone')->nullable();

            $table->string('password');

            $table->foreignId('role_id')->constrained();
            $table->string('status')->default('active');
            $table->timestamp('email_verified_at')->nullable();

            $table->rememberToken(); // Token nhớ
            $table->timestamps(); // Thời gian tạo và cập nhật
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Email dùng để đặt lại mật khẩu
            $table->string('token'); // Token đặt lại mật khẩu
            $table->timestamp('created_at')->nullable(); // Thời gian tạo token
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID phiên làm việc
            $table->foreignId('user_id')->nullable()->index(); // ID người dùng
            $table->string('ip_address', 45)->nullable(); // IP địa chỉ
            $table->text('user_agent')->nullable(); // User agent
            $table->longText('payload'); // Payload
            $table->integer('last_activity')->index(); // Thời gian hoạt động cuối cùng
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
