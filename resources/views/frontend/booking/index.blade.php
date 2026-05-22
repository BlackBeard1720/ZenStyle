<x-frontend.layout title="ZenStyle — Đặt lịch" main-class="bg-zen-bg-soft pt-20">
  {{--
      Flow EasySalon (Ant-style). Tailwind v4 + JS (frontend/booking.js): chọn ngày/giờ/dịch vụ/stylist/khách, cập nhật tóm tắt.
  --}}
  @php
    $bookingToday = now()->startOfDay();
    $bookingWeekStart = $bookingToday->copy()->startOfWeek(\Carbon\CarbonInterface::MONDAY);
    $bookingDayLabels = ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'];
    $bookingDaySummaries = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'];
    $bookingDays = collect(range(0, 6))->map(function ($offset) use ($bookingWeekStart, $bookingToday, $bookingDayLabels, $bookingDaySummaries) {
        $date = $bookingWeekStart->copy()->addDays($offset);

        return [
            'label' => $bookingDayLabels[$offset],
            'display' => $date->format('d/m'),
            'iso' => $date->toDateString(),
            'summary' => $bookingDaySummaries[$offset].', '.$date->format('d/m/Y'),
            'selected' => $date->isSameDay($bookingToday),
        ];
    });

    $bookingStylists = $staff->map(function ($s, $index) {
        $isActive = $s->status === 'active';
        $years = $s->hire_date
            ? max(0, (int) \Carbon\Carbon::parse($s->hire_date)->diffInYears(now()))
            : null;
        $experience = $years !== null
            ? ($years >= 1 ? $years . ' năm kinh nghiệm' : 'Dưới 1 năm kinh nghiệm')
            : null;

        return [
            'id'           => $s->id,
            'name'         => $s->full_name,
            'role'         => $s->specialization ?? 'Nhân viên',
            'experience'   => $experience,
            'status'       => $isActive ? 'Có thể đặt lịch' : 'Bận',
            'status_class' => $isActive
                ? 'bg-zen-accent-soft text-zen-primary ring-zen-primary/20'
                : 'bg-zen-warning/10 text-zen-warning ring-zen-warning/20',
            'image'        => asset('images/tailadmin/user/user-0' . (($index % 3) + 1) . '.jpg'),
            'is_available' => $isActive,
            'checked'      => $index === 0 && $isActive,
        ];
    })->all();
  @endphp

  <div id="booking-page" class="pb-12 pt-6 sm:pt-8">
    <div class="mx-auto max-w-7xl px-4 sm:px-6">
      <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
          <p class="text-xs font-medium uppercase tracking-wide text-zen-muted">Booking online</p>
          <h1 class="mt-1 text-xl font-semibold text-zen-text sm:text-2xl">Đặt lịch hẹn</h1>
        </div>
        <p class="max-w-xl text-sm text-zen-muted sm:text-right">Hoàn tất các bước bên dưới để giữ chỗ tại salon.</p>
      </div>
    </div>

    <form
      id="booking-form"
      method="POST"
      action="{{ route('booking.store') }}"
      class="mx-auto mt-5 grid max-w-7xl gap-5 px-4 sm:mt-6 sm:px-6 lg:grid-cols-[minmax(0,1fr)_minmax(21rem,24rem)] lg:items-start lg:gap-6 xl:grid-cols-[minmax(0,1fr)_minmax(23rem,26rem)]"
    >
      @csrf

      <input type="hidden" name="appointment_time" value="" data-booking-time-input>

      <div class="min-w-0 space-y-5">
        @if($errors->any() && ! $errors->has('otp'))
          <div class="rounded-zen-md border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-700">
            {{ $errors->first() }}
          </div>
        @endif

        {{-- Ngày + lịch tuần + khung giờ --}}
        <section class="rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen sm:p-6">
          <h2 class="text-base font-semibold text-zen-text">Chọn ngày &amp; giờ</h2>
          <p class="mt-1 text-sm text-zen-muted">Chọn ngày trong tuần và khung giờ bắt đầu.</p>

          <div class="mt-4">
            <label for="booking-date" class="mb-2 block text-sm font-medium text-zen-muted">Hoặc chọn ngày</label>
            <input
              id="booking-date"
              name="appointment_date"
              type="date"
              value="{{ $bookingToday->toDateString() }}"
              min="{{ $bookingToday->toDateString() }}"
              class="h-10 w-full max-w-xs rounded border border-zen-border bg-white px-3 text-sm text-zen-text outline-none ring-zen-primary focus:border-zen-primary focus:ring-2 focus:ring-zen-primary/20"
            >
          </div>

          <p class="mb-2 mt-6 text-sm font-medium text-zen-muted">Tuần này</p>
          <div class="grid grid-cols-2 gap-2 sm:grid-cols-4 xl:grid-cols-7" role="radiogroup" aria-label="Chọn ngày trong tuần">
            @foreach ($bookingDays as $day)
              <button
                type="button"
                data-booking-day
                data-date="{{ $day['iso'] }}"
                data-summary="{{ $day['summary'] }}"
                aria-pressed="{{ $day['selected'] ? 'true' : 'false' }}"
                class="rounded border px-3 py-2 text-left text-sm transition-colors border-zen-border bg-white text-zen-muted hover:border-zen-primary/40"
              >
                <span class="block text-xs text-zen-muted">{{ $day['label'] }}</span>
                <span class="block tabular-nums">{{ $day['display'] }}</span>
              </button>
            @endforeach
          </div>

          <p class="mb-2 mt-6 text-sm font-medium text-zen-muted">Khung giờ trống</p>
          <div class="grid grid-cols-2 gap-2 sm:grid-cols-4 lg:grid-cols-6" role="radiogroup" aria-label="Giờ bắt đầu">
            @foreach (['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '14:00', '14:30', '15:00', '15:30', '16:00', '17:00'] as $slot)
              <button
                type="button"
                data-booking-slot
                data-slot="{{ $slot }}"
                aria-pressed="false"
                class="rounded border px-2 py-2 text-sm transition-colors border-zen-border bg-white text-zen-muted hover:border-zen-primary/50"
              >
                {{ $slot }}
              </button>
            @endforeach
          </div>
        </section>

        {{-- Nhân viên --}}
        <section class="rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen sm:p-6">
          <h2 class="text-base font-semibold text-zen-text">Chọn nhân viên</h2>
          <p class="mt-1 text-sm text-zen-muted">Để salon sắp xếp lịch hoặc chọn stylist yêu thích.</p>
          <div class="mt-4 grid min-w-0 gap-4 md:grid-cols-2 xl:grid-cols-3" role="radiogroup" aria-label="Chọn nhân viên phụ trách">
            @foreach ($bookingStylists as $stylist)
              @php
                $stylistAvailable = $stylist['is_available'] ?? true;
              @endphp
              <label
                data-booking-stylist-card
                data-booking-stylist-available="{{ $stylistAvailable ? 'true' : 'false' }}"
                role="radio"
                aria-disabled="{{ $stylistAvailable ? 'false' : 'true' }}"
                @class([
                  'group relative flex min-w-0 flex-col overflow-hidden rounded-zen-md border-2 border-zen-border bg-white p-4 text-left shadow-sm transition duration-200 has-[:focus-visible]:ring-2 has-[:focus-visible]:ring-zen-primary/40',
                  'cursor-pointer hover:-translate-y-0.5 hover:border-zen-primary/50 hover:shadow-zen has-[:checked]:border-zen-primary has-[:checked]:bg-zen-accent-soft has-[:checked]:shadow-zen-md' => $stylistAvailable,
                  'cursor-not-allowed opacity-60 grayscale-[.15]' => ! $stylistAvailable,
                ])
              >
                <input
                  type="radio"
                  name="staff_id"
                  value="{{ $stylist['id'] }}"
                  data-booking-stylist-radio
                  data-stylist-name="{{ $stylist['name'] }}"
                  data-stylist-available="{{ $stylistAvailable ? 'true' : 'false' }}"
                  class="peer sr-only"
                  @checked($stylist['checked'] && $stylistAvailable)
                  @disabled(! $stylistAvailable)
                >

                <span class="flex min-w-0 items-start gap-3">
                  <img
                    src="{{ $stylist['image'] }}"
                    alt="Ảnh đại diện {{ $stylist['name'] }}"
                    class="size-14 shrink-0 rounded-full border-2 border-white object-cover shadow-sm ring-1 ring-zen-border"
                    loading="lazy"
                  >
                  <span class="min-w-0 flex-1">
                    <span data-stylist-label class="block break-words text-sm font-semibold text-zen-text">{{ $stylist['name'] }}</span>
                    <span class="mt-1 block break-words text-xs font-medium text-zen-primary">{{ $stylist['role'] }}</span>
                    <span class="mt-2 inline-flex max-w-full rounded-full px-2.5 py-1 text-xs font-medium ring-1 {{ $stylist['status_class'] }}">
                      {{ $stylist['status'] }}
                    </span>
                  </span>
                </span>

                @if($stylist['experience'])
                  <span class="mt-4 grid gap-2 text-xs text-zen-muted">
                    <span class="grid grid-cols-[minmax(0,1fr)_auto] items-start gap-3">
                      <span>Kinh nghiệm</span>
                      <span class="text-right font-semibold text-zen-text">{{ $stylist['experience'] }}</span>
                    </span>
                  </span>
                @endif
              </label>
            @endforeach
          </div>
        </section>

        {{-- Dịch vụ --}}
        <section class="rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen sm:p-6">
          <h2 class="text-base font-semibold text-zen-text">Chọn dịch vụ</h2>
          <p class="mt-1 text-sm text-zen-muted">Có thể chọn nhiều dịch vụ trong một lịch.</p>
          <ul class="mt-4 divide-y divide-zen-border rounded border border-zen-border">
            @forelse ($services as $service)
              <li
                class="grid gap-3 p-4 sm:grid-cols-[minmax(0,1fr)_auto] sm:items-center"
                data-booking-service-row
                data-service-name="{{ $service->name }}"
                data-service-price="{{ (int) $service->price }}"
              >
                <label class="flex min-w-0 cursor-pointer items-start gap-3">
                  <input
                    type="checkbox"
                    name="service_ids[]"
                    value="{{ $service->id }}"
                    class="mt-0.5 size-4 shrink-0 rounded border-zen-border-dark text-zen-primary focus:ring-zen-primary/30"
                    @checked(in_array((string) $service->id, old('service_ids', []), true))
                  >
                  <span class="min-w-0">
                    <span class="block break-words text-sm font-medium text-zen-text">{{ $service->name }}</span>
                    <span class="mt-0.5 block text-xs text-zen-muted">
                      {{ $service->duration }} phút
                      @if($service->description)
                        - {{ $service->description }}
                      @endif
                    </span>
                  </span>
                </label>
                <span class="text-sm font-semibold text-zen-primary sm:text-right">{{ number_format((float) $service->price, 0, ',', '.') }}đ</span>
              </li>
            @empty
              <li class="p-4 text-sm text-zen-muted">
                Hiện chưa có dịch vụ đang hoạt động.
              </li>
            @endforelse
          </ul>
        </section>

        {{-- Khuyến mãi --}}
        <section class="rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen sm:p-6">
          <h2 class="text-base font-semibold text-zen-text">Mã khuyến mãi</h2>
          <p class="mt-1 text-sm text-zen-muted">Nhập mã ưu đãi (nếu có).</p>
          <div class="mt-4 flex flex-col gap-2 sm:flex-row">
            <input
              type="text"
              name="coupon_code"
              data-booking-promo-input
              placeholder="VD: SUMMER2026"
              class="h-10 flex-1 rounded-zen-sm border border-zen-border px-3 text-sm outline-none placeholder:text-zen-muted/70 focus:border-zen-primary focus:ring-2 focus:ring-zen-primary/20"
            >
            <button
              type="button"
              data-booking-promo-apply
              class="h-10 shrink-0 rounded-zen-sm border border-zen-primary bg-zen-bg px-5 text-sm font-medium text-zen-primary transition hover:bg-zen-accent-soft"
            >
              Áp dụng
            </button>
          </div>
          <p data-booking-promo-hint class="mt-2 text-xs text-zen-muted" hidden></p>
        </section>

        {{-- Thông tin liên hệ --}}
        <section class="rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen sm:p-6">
          <h2 class="text-base font-semibold text-zen-text">Thông tin liên hệ</h2>
          <p class="mt-1 text-sm text-zen-muted">Salon dùng thông tin này để xác nhận lịch.</p>
          <div class="mt-4 grid gap-4 sm:grid-cols-2">
            <div>
              <label for="full-name" class="mb-1.5 block text-sm font-medium text-zen-muted">Họ và tên</label>
              <input
                id="full-name"
                name="full_name"
                type="text"
                placeholder="Nguyễn Văn A"
                class="h-10 w-full rounded-zen-sm border border-zen-border px-3 text-sm outline-none focus:border-zen-primary focus:ring-2 focus:ring-zen-primary/20"
              >
            </div>
            <div>
              <label for="phone" class="mb-1.5 block text-sm font-medium text-zen-muted">Số điện thoại</label>
              <input
                id="phone"
                name="phone"
                type="tel"
                placeholder="09xx xxx xxx"
                class="h-10 w-full rounded-zen-sm border border-zen-border px-3 text-sm outline-none focus:border-zen-primary focus:ring-2 focus:ring-zen-primary/20"
              >
            </div>
            <div class="sm:col-span-2">
              <label for="note" class="mb-1.5 block text-sm font-medium text-zen-muted">Ghi chú (tuỳ chọn)</label>
              <textarea
                id="note"
                name="notes"
                rows="4"
                placeholder="Ví dụ: mong muốn tư vấn màu, tình trạng tóc..."
                class="w-full resize-y rounded-zen-sm border border-zen-border px-3 py-2 text-sm outline-none focus:border-zen-primary focus:ring-2 focus:ring-zen-primary/20"
              ></textarea>
            </div>
          </div>
        </section>

      </div>

      {{-- Sidebar tóm tắt --}}
      <aside class="min-w-0 lg:sticky lg:top-24">
        <div id="booking-summary-card" class="scroll-mt-24 rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen sm:p-6">
          <h2 class="text-base font-semibold text-zen-text">Tóm tắt đặt lịch</h2>
          <dl class="mt-4 space-y-3 text-sm">
            <div class="grid grid-cols-[6rem_minmax(0,1fr)] gap-3 border-b border-dashed border-zen-border pb-3">
              <dt class="text-zen-muted">Salon</dt>
              <dd id="booking-summary-branch" class="min-w-0 text-right font-medium text-zen-text">ZenStyle FPT Aptech</dd>
            </div>
            <div class="grid grid-cols-[6rem_minmax(0,1fr)] gap-3 border-b border-dashed border-zen-border pb-3">
              <dt class="text-zen-muted">Thời gian</dt>
              <dd class="min-w-0 text-right font-medium text-zen-text">
                <span id="booking-summary-time-line" class="block">—</span>
                <span id="booking-summary-date-line" class="block text-xs font-normal text-zen-muted">{{ $bookingDaySummaries[$bookingToday->dayOfWeekIso - 1] }}, {{ $bookingToday->format('d/m/Y') }}</span>
              </dd>
            </div>
            <div class="grid grid-cols-[6rem_minmax(0,1fr)] gap-3 border-b border-dashed border-zen-border pb-3">
              <dt class="text-zen-muted">Nhân viên</dt>
              <dd id="booking-summary-stylist" class="min-w-0 break-words text-right font-medium text-zen-text">Bất kỳ nhân viên</dd>
            </div>
            <div>
              <dt class="text-zen-muted">Dịch vụ</dt>
              <dd id="booking-summary-services" class="mt-2 min-w-0 space-y-1 break-words text-right font-medium text-zen-text">
                <p class="text-xs font-normal text-zen-muted">Chưa chọn dịch vụ</p>
              </dd>
            </div>
          </dl>

          <div class="my-4 border-t border-zen-border"></div>

          <div class="flex items-baseline justify-between gap-4">
            <span class="text-sm text-zen-muted">Tạm tính</span>
            <span id="booking-summary-total" class="text-xl font-semibold text-zen-primary">0đ</span>
          </div>

          <button
            type="submit"
            class="mt-5 flex h-10 w-full items-center justify-center rounded-zen-sm bg-zen-primary text-sm font-medium text-white transition hover:bg-zen-primary-dark"
          >
            Hoàn tất đặt lịch
          </button>

          <p class="mt-4 text-center text-xs leading-relaxed text-zen-muted">
            Bằng việc xác nhận, bạn đồng ý với quy định đặt lịch và chính sách của ZenStyle.
            Lịch được giữ tối đa 15 phút sau xác nhận.
          </p>
        </div>
      </aside>
    </form>
  </div>

  @if(session('otp_pending') || $errors->has('otp'))
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
      <div class="w-full max-w-md rounded-zen-md bg-white p-6 shadow-zen-md">
        <h2 class="text-xl font-bold text-zen-text">Xác nhận OTP</h2>
        @php
          $bookingData = session('booking_data', []);
          $otpPhone = $bookingData['phone'] ?? old('phone');
          $telegramLinked = $otpPhone ? \App\Models\TelegramUser::where('phone', $otpPhone)->exists() : false;
        @endphp

        <div class="mt-4 rounded-zen-sm border border-zen-border bg-zen-bg-soft p-3">
          <p class="text-sm text-zen-muted">
            So dien thoai nhan OTP:
            <span class="font-semibold text-zen-text">{{ $otpPhone ?: 'Chua co so dien thoai' }}</span>
          </p>

          @if($telegramLinked)
            <p class="mt-3 rounded bg-green-100 p-3 text-sm text-green-700">
              Telegram da duoc lien ket voi so dien thoai nay.
            </p>
          @else
            <button
              type="button"
              id="link-telegram-btn"
              data-phone="{{ $otpPhone }}"
              class="mt-3 h-10 w-full rounded-zen-sm border border-zen-primary bg-white px-3 text-sm font-medium text-zen-primary transition hover:bg-zen-accent-soft"
            >
              Lien ket Telegram de nhan OTP
            </button>

            <p class="mt-2 text-xs text-zen-muted">
              Sau khi mo bot, hay bam Start va gui so dien thoai: {{ $otpPhone }}
            </p>
          @endif
        </div>

        <form method="POST" action="{{ route('booking.send-telegram-otp') }}" class="mt-3">
          @csrf
          <button type="submit" class="h-10 w-full rounded-zen-sm bg-zen-primary px-3 text-sm font-medium text-white transition hover:bg-zen-primary-dark">
            Gui OTP qua Telegram
          </button>
        </form>

        @if(session('success'))
          <p class="mt-3 rounded bg-green-100 p-3 text-sm text-green-700">
            {{ session('success') }}
          </p>
        @endif

        <form method="POST" action="{{ route('booking.verify.otp') }}" class="mt-4">
          @csrf

          <input name="otp" maxlength="6" class="h-11 w-full rounded border border-zen-border px-3 text-zen-text outline-none focus:border-zen-primary focus:ring-2 focus:ring-zen-primary/20">

          @error('otp')
            <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
          @enderror

          <button type="submit" class="mt-4 h-10 w-full rounded bg-zen-primary text-white transition hover:bg-zen-primary-dark">
            Xác nhận OTP
          </button>
        </form>
      </div>
    </div>
  @endif
  @push('scripts')
    <script>
      const linkTelegramBtn = document.getElementById('link-telegram-btn');

      if (linkTelegramBtn) {
        linkTelegramBtn.addEventListener('click', function () {
          // Lay phone tu popup OTP
          const phone = this.dataset.phone;

          if (!phone) {
            alert('Khong tim thay so dien thoai dat lich.');
            return;
          }

          // Mo bot Telegram de khach bam Start
          const botUsername = @json(config('services.telegram.bot_username'));
          const telegramUrl = `https://t.me/${botUsername}`;

          window.open(telegramUrl, '_blank');
        });
      }
    </script>
  @endpush
</x-frontend.layout>
