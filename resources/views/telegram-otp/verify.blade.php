<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Xác thực OTP Telegram</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center">
<div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
  <h1 class="text-2xl font-bold text-gray-800 mb-2">
    Xác thực OTP
  </h1>

  <p class="text-gray-500 mb-6">
    Nhập mã OTP đã được gửi tới Telegram của bạn.
  </p>

  @if (session('success'))
    <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-3">
      {{ session('success') }}
    </div>
  @endif

  @if (session('error'))
    <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3">
      {{ session('error') }}
    </div>
  @endif

  <form action="{{ route('telegram.otp.verify') }}" method="POST" class="space-y-4">
    @csrf

    <div>
      <label class="block text-sm font-semibold text-gray-700 mb-1">
        Số điện thoại
      </label>
      <input
        type="text"
        name="phone"
        value="{{ old('phone', '0900000000') }}"
        class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
        placeholder="0900000000"
        required
      >
      @error('phone')
      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label class="block text-sm font-semibold text-gray-700 mb-1">
        Mã OTP
      </label>
      <input
        type="text"
        name="otp_code"
        value="{{ old('otp_code') }}"
        maxlength="6"
        class="w-full border rounded-lg px-4 py-2 tracking-widest text-center text-xl font-bold focus:outline-none focus:ring-2 focus:ring-blue-400"
        placeholder="123456"
        required
      >
      @error('otp_code')
      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <button
      type="submit"
      class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition"
    >
      Xác thực
    </button>
  </form>
</div>
</body>
</html>
