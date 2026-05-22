<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Gửi OTP Telegram</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center">
<div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
  <h1 class="text-2xl font-bold text-gray-800 mb-2">
    Gửi OTP Telegram
  </h1>

  <p class="text-gray-500 mb-6">
    Nhập số điện thoại đã liên kết Telegram để nhận mã OTP.
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

  <form action="{{ route('telegram.otp.send') }}" method="POST" class="space-y-4">
    @csrf

    <div>
      <label class="block text-sm font-semibold text-gray-700 mb-1">
        Số điện thoại
      </label>
      <input
        type="text"
        name="phone"
        id="phone"
        value="{{ old('phone', '0900000000') }}"
        class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
        placeholder="0900000000"
        required
      >
      @error('phone')
      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>
    <button
      type="button"
      id="link-telegram-btn"
      class="w-full bg-slate-700 hover:bg-slate-800 text-white font-bold py-3 rounded-lg transition"
    >
      Lien ket Telegram
    </button>
    <button
      type="submit"
      class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition"
    >
      Gửi OTP
    </button>
  </form>
</div>
<script>
  document.getElementById('link-telegram-btn').addEventListener('click', function () {
    const phoneInput = document.getElementById('phone');
    const phone = phoneInput.value.trim();

    if (!phone) {
      alert('Vui long nhap so dien thoai truoc.');
      phoneInput.focus();
      return;
    }
    // Mo bot Telegram kem phone
    const botUsername = 'zenstyle_minh_t2512e_bot';
    const telegramUrl = `https://t.me/${botUsername}?start=${encodeURIComponent(phone)}`;

    window.open(telegramUrl, '_blank');
  });
</script>
</body>
</html>
