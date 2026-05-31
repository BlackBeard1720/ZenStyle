@php
  $bookingData = session('booking_data', []);
  $otpEmail = $bookingData['email'] ?? old('email');
  $otpLockedUntil = (int) session('booking_otp_locked_until', 0);
  $otpLockSeconds = max(0, $otpLockedUntil - now()->timestamp);
@endphp

@if(session()->has('booking_data') || session('otp_pending') || $errors->has('otp'))
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
    <div class="relative w-full max-w-md rounded-zen-md bg-zen-surface p-6 shadow-zen-md">
      <h2 class="text-xl font-bold text-zen-text">Email Verification</h2>
      <form method="POST" action="{{ route('booking.cancel-otp') }}" class="absolute right-4 top-4">@csrf<button type="submit" class="text-2xl leading-none text-zen-muted transition hover:text-zen-text cursor-pointer" aria-label="Close OTP popup">&times;</button></form>
      <div class="mt-4 rounded-zen-sm border border-zen-border bg-zen-bg-soft p-3"><p class="text-sm text-zen-muted">We sent a 6-digit OTP to your email: <span class="font-semibold text-zen-text">{{ $otpEmail ?: 'No email provided' }}</span></p></div>
      @if(session('success'))<p class="mt-3 rounded bg-green-100 p-3 text-sm text-green-800">{{ session('success') }}</p>@endif
      @if(session('error'))<p class="mt-3 rounded bg-red-100 p-3 text-sm text-red-800">{{ session('error') }}</p>@endif
      @if($otpLockSeconds > 0)
        <p id="otp-lock-message" class="mt-3 rounded bg-zen-accent-soft p-3 text-sm text-zen-accent-dark">You have entered the wrong OTP too many times. Please wait <span id="otp-countdown" data-seconds="{{ $otpLockSeconds }}">{{ $otpLockSeconds }}</span> seconds before trying again.</p>
      @endif
      <form method="POST" action="{{ route('booking.verify.otp') }}" class="mt-4">@csrf
        <input id="otp-input" name="otp" maxlength="6" placeholder="Enter 6-digit OTP" @disabled($otpLockSeconds > 0) class="h-11 w-full rounded border border-zen-border px-3 text-center text-lg font-semibold tracking-widest text-zen-text outline-none focus:border-zen-primary focus:ring-2 focus:ring-zen-primary/20 disabled:cursor-not-allowed disabled:bg-zen-bg-soft">
        @error('otp')<p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>@enderror
        <button type="submit" id="verify-otp-btn" @disabled($otpLockSeconds > 0) class="mt-4 h-10 w-full rounded bg-zen-primary text-white transition hover:bg-zen-primary-dark disabled:cursor-not-allowed disabled:bg-zen-border-dark cursor-pointer">Verify OTP</button>
      </form>
      <form method="POST" action="{{ route('booking.send-email-otp') }}" class="mt-3">@csrf<button type="submit" id="resend-otp-btn" @disabled($otpLockSeconds > 0) class="h-10 w-full rounded border border-zen-primary text-zen-primary transition hover:bg-zen-accent-soft disabled:cursor-not-allowed disabled:opacity-50 cursor-pointer">Resend OTP</button></form>
    </div>
  </div>
  @push('scripts')
    <script>
      const otpCountdown = document.getElementById('otp-countdown');const otpLockMessage = document.getElementById('otp-lock-message');const verifyOtpBtn = document.getElementById('verify-otp-btn');const resendOtpBtn = document.getElementById('resend-otp-btn');const otpInput = document.getElementById('otp-input');
      if (otpCountdown) { let seconds = Number(otpCountdown.dataset.seconds); const timer = setInterval(function () { seconds -= 1; otpCountdown.textContent = Math.max(seconds, 0); if (seconds <= 0) { clearInterval(timer); otpLockMessage?.classList.add('hidden'); verifyOtpBtn?.removeAttribute('disabled'); resendOtpBtn?.removeAttribute('disabled'); otpInput?.removeAttribute('disabled'); } }, 1000); }
    </script>
  @endpush
@endif
