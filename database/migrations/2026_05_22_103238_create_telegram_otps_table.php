<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('telegram_otps', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable(); // sdt client enter khi book, có thể để null lúc test
            $table->string('telegram_chat_id'); // id Telegram để gửi tin
            $table->string('otp_code'); // mã OTP 6 số
            $table->timestamp('expires_at'); // tg mã hết hạn
            $table->timestamp('verified_at')->nullable(); // khi xác thực thành công thì lưu thời điểm này
            $table->timestamps();
            $table->index('telegram_chat_id');
            $table->index('otp_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_otps');
    }
};
