<x-frontend.layout title="ZenStyle — Đặt lịch" main-class="bg-zen-bg-soft pt-20">
  {{--
      Flow EasySalon (Ant-style). Tailwind v4 + JS (frontend/booking.js): chọn salon/ngày/giờ/dịch vụ/stylist/khách, cập nhật tóm tắt.
      Chưa gửi form backend.
  --}}
  <div id="booking-page" class="pb-12 pt-6 sm:pt-8">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
      <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
        <div>
          <p class="text-xs font-medium uppercase tracking-wide text-zen-muted">Booking online</p>
          <h1 class="mt-1 text-xl font-semibold text-zen-text sm:text-2xl">Đặt lịch hẹn</h1>
        </div>
        <p class="text-sm text-zen-muted">Hoàn tất các bước bên dưới để giữ chỗ tại salon.</p>
      </div>

      {{-- Step bar (kiểu Ant Design Steps) --}}

    </div>

    <div class="mx-auto mt-5 grid max-w-6xl gap-5 px-4 sm:mt-6 sm:px-6 lg:grid-cols-12 lg:gap-6">
      <div class="space-y-5 lg:col-span-8">
        <form method="POST" action="{{ route('booking.store') }}">
          <form
            method="POST"
            action="{{ route('booking.store') }}"
          >

            @csrf

            @if($errors->any())

              <div class="mb-4 rounded bg-red-100 p-3 text-red-600">

                {{ $errors->first() }}

              </div>

            @endif

            ...

          @csrf
          {{-- Số lượng khách (EasySalon có bước này) --}}
          <section class="rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen sm:p-6">
            <h2 class="text-base font-semibold text-zen-text">Số lượng khách</h2>
            <p class="mt-1 text-sm text-zen-muted">Số người sử dụng dịch vụ trong buổi hẹn.</p>
            <div class="mt-4 inline-flex items-center rounded border border-zen-border">
              <button type="button" data-booking-guest-minus class="px-4 py-2 text-sm text-zen-muted transition hover:bg-zen-bg-soft hover:text-zen-text focus:outline-none focus-visible:ring-2 focus-visible:ring-zen-primary/40" aria-label="Giảm số khách">−</button>
              <span data-booking-guest-value class="min-w-[3rem] border-x border-zen-border py-2 text-center text-sm font-medium text-zen-text tabular-nums">1</span>
              <button type="button" data-booking-guest-plus class="px-4 py-2 text-sm text-zen-muted transition hover:bg-zen-bg-soft hover:text-zen-text focus:outline-none focus-visible:ring-2 focus-visible:ring-zen-primary/40" aria-label="Tăng số khách">+</button>
            </div>
          </section>

          {{-- Ngày + lịch tuần (nút) + khung giờ --}}
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
          @endphp
          <section class="rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen sm:p-6">
            <h2 class="text-base font-semibold text-zen-text">Chọn ngày &amp; giờ</h2>
            <p class="mt-1 text-sm text-zen-muted">Chọn ngày trong tuần và khung giờ bắt đầu.</p>

            <div class="mt-4">
              <label for="booking-date" class="mb-2 block text-sm font-medium text-zen-muted">Hoặc chọn ngày</label>
              <input
                id="booking-date"
                type="date"
                value="{{ $bookingToday->toDateString() }}"
                min="{{ $bookingToday->toDateString() }}"
                class="h-10 max-w-xs rounded border border-zen-border bg-white px-3 text-sm text-zen-text outline-none ring-zen-primary focus:border-zen-primary focus:ring-2 focus:ring-zen-primary/20"
              >
            </div>

            <p class="mb-2 mt-6 text-sm font-medium text-zen-muted">Tuần này</p>
            <div class="flex flex-wrap gap-2" role="radiogroup" aria-label="Chọn ngày trong tuần">
              @foreach ($bookingDays as $day)
                <button
                  type="button"
                  data-booking-day
                  data-date="{{ $day['iso'] }}"
                  data-summary="{{ $day['summary'] }}"
                  aria-pressed="{{ $day['selected'] ? 'true' : 'false' }}"
                  class="min-w-[4.5rem] rounded border px-3 py-2 text-left text-sm transition-colors border-zen-border bg-white text-zen-muted hover:border-zen-primary/40"
                >
                  <span class="block text-xs text-zen-muted">{{ $day['label'] }}</span>
                  <span class="block tabular-nums">{{ $day['display'] }}</span>
                </button>
              @endforeach
            </div>

            <p class="mb-2 mt-6 text-sm font-medium text-zen-muted">Khung giờ trống</p>
            <div class="grid grid-cols-3 gap-2 sm:grid-cols-4 md:grid-cols-6" role="radiogroup" aria-label="Giờ bắt đầu">
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
            <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
              <label class="flex cursor-pointer items-center gap-3 rounded-zen-md border border-zen-border bg-zen-bg p-3 transition-colors has-[:checked]:border-2 has-[:checked]:border-zen-primary has-[:checked]:bg-zen-accent-soft hover:border-zen-primary/40">
                <input type="radio" name="staff_id" value="any" class="peer sr-only" checked>

                <span class="min-w-0 text-sm font-medium text-zen-text"><span data-stylist-label>Quách Tùng Dương</span></span>
              </label>
              <label class="flex cursor-pointer items-center gap-3 rounded-zen-md border border-zen-border bg-zen-bg p-3 transition-colors has-[:checked]:border-2 has-[:checked]:border-zen-primary has-[:checked]:bg-zen-accent-soft hover:border-zen-primary/40">
                <input type="radio" name="staff_id" value="lan-chi" class="peer sr-only">

                <span class="min-w-0 text-sm font-medium text-zen-text"><span data-stylist-label>Đinh Văn Hải</span></span>
              </label>
              <label class="flex cursor-pointer items-center gap-3 rounded-zen-md border border-zen-border bg-zen-bg p-3 transition-colors has-[:checked]:border-2 has-[:checked]:border-zen-primary has-[:checked]:bg-zen-accent-soft hover:border-zen-primary/40">
                <input type="radio" name="staff_id" value="hoang-nam" class="peer sr-only">
                <span class="min-w-0 text-sm font-medium text-zen-text"><span data-stylist-label>Lê Hoàng Nam</span></span>
              </label>
            </div>
          </section>

          {{-- Dịch vụ --}}
          <section class="rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen sm:p-6">
            <h2 class="text-base font-semibold text-zen-text">Chọn dịch vụ</h2>
            <p class="mt-1 text-sm text-zen-muted">Có thể chọn nhiều dịch vụ trong một lịch.</p>
            <ul class="mt-4 divide-y divide-zen-border rounded border border-zen-border">
              <li class="flex flex-wrap items-center justify-between gap-3 p-4" data-booking-service-row data-service-name="Cắt tóc nam cao cấp" data-service-price="150000">
                <label class="flex flex-1 cursor-pointer items-start gap-3">
                  <input type="checkbox" checked name="service_ids[]" value="cut" class="mt-0.5 size-4 rounded border-zen-border-dark text-zen-primary focus:ring-zen-primary/30">
                  <span>
        <div class="mx-auto mt-5 grid max-w-6xl gap-5 px-4 sm:mt-6 sm:px-6 lg:grid-cols-12 lg:gap-6">
            <div class="space-y-5 lg:col-span-8">
                {{-- Số lượng khách (EasySalon có bước này) --}}
                <section class="rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen sm:p-6">
                    <h2 class="text-base font-semibold text-zen-text">Số lượng khách</h2>
                    <p class="mt-1 text-sm text-zen-muted">Số người sử dụng dịch vụ trong buổi hẹn.</p>
                    <div class="mt-4 inline-flex items-center rounded border border-zen-border">
                        <button type="button" data-booking-guest-minus class="px-4 py-2 text-sm text-zen-muted transition hover:bg-zen-bg-soft hover:text-zen-text focus:outline-none focus-visible:ring-2 focus-visible:ring-zen-primary/40" aria-label="Giảm số khách">−</button>
                        <span data-booking-guest-value class="min-w-[3rem] border-x border-zen-border py-2 text-center text-sm font-medium text-zen-text tabular-nums">1</span>
                        <button type="button" data-booking-guest-plus class="px-4 py-2 text-sm text-zen-muted transition hover:bg-zen-bg-soft hover:text-zen-text focus:outline-none focus-visible:ring-2 focus-visible:ring-zen-primary/40" aria-label="Tăng số khách">+</button>
                    </div>
                </section>

                {{-- Ngày + lịch tuần (nút) + khung giờ --}}
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
                @endphp
                <section class="rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen sm:p-6">
                    <h2 class="text-base font-semibold text-zen-text">Chọn ngày &amp; giờ</h2>
                    <p class="mt-1 text-sm text-zen-muted">Chọn ngày trong tuần và khung giờ bắt đầu.</p>

                    <div class="mt-4">
                        <label for="booking-date" class="mb-2 block text-sm font-medium text-zen-muted">Hoặc chọn ngày</label>
                        <input
                            id="booking-date"
                            type="date"
                            value="{{ $bookingToday->toDateString() }}"
                            min="{{ $bookingToday->toDateString() }}"
                            class="h-10 max-w-xs rounded border border-zen-border bg-white px-3 text-sm text-zen-text outline-none ring-zen-primary focus:border-zen-primary focus:ring-2 focus:ring-zen-primary/20"
                        >
                    </div>

                    <p class="mb-2 mt-6 text-sm font-medium text-zen-muted">Tuần này</p>
                    <div class="flex flex-wrap gap-2" role="radiogroup" aria-label="Chọn ngày trong tuần">
                        @foreach ($bookingDays as $day)
                            <button
                                type="button"
                                data-booking-day
                                data-date="{{ $day['iso'] }}"
                                data-summary="{{ $day['summary'] }}"
                                aria-pressed="{{ $day['selected'] ? 'true' : 'false' }}"
                                class="min-w-[4.5rem] rounded border px-3 py-2 text-left text-sm transition-colors border-zen-border bg-white text-zen-muted hover:border-zen-primary/40"
                            >
                                <span class="block text-xs text-zen-muted">{{ $day['label'] }}</span>
                                <span class="block tabular-nums">{{ $day['display'] }}</span>
                            </button>
                        @endforeach
                    </div>

                    <p class="mb-2 mt-6 text-sm font-medium text-zen-muted">Khung giờ trống</p>
                    <div class="grid grid-cols-3 gap-2 sm:grid-cols-4 md:grid-cols-6" role="radiogroup" aria-label="Giờ bắt đầu">
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

                @php
                    $bookingStylists = [
                        [
                            'id' => 'quach-tung-duong',
                            'name' => 'Quách Tùng Dương',
                            'role' => 'Stylist tóc',
                            'experience' => '7 năm kinh nghiệm',
                            'featured_service' => 'Cắt tóc nam cao cấp, tư vấn tạo kiểu',
                            'rating' => '4.9/5',
                            'status' => 'Đang rảnh',
                            'status_class' => 'bg-zen-success/10 text-zen-success ring-zen-success/20',
                            'image' => asset('images/tailadmin/user/user-01.jpg'),
                            'is_available' => true,
                            'checked' => true,
                        ],
                        [
                            'id' => 'dinh-van-hai',
                            'name' => 'Đinh Văn Hải',
                            'role' => 'Kỹ thuật viên spa',
                            'experience' => '5 năm kinh nghiệm',
                            'featured_service' => 'Massage da đầu, treatment phục hồi',
                            'rating' => '4.8/5',
                            'status' => 'Có thể đặt lịch',
                            'status_class' => 'bg-zen-accent-soft text-zen-primary ring-zen-primary/20',
                            'image' => asset('images/tailadmin/user/user-02.jpg'),
                            'is_available' => true,
                            'checked' => false,
                        ],
                        [
                            'id' => 'le-hoang-nam',
                            'name' => 'Lê Hoàng Nam',
                            'role' => 'Chuyên viên gội đầu dưỡng sinh',
                            'experience' => '4 năm kinh nghiệm',
                            'featured_service' => 'Gội thư giãn, massage cổ vai gáy',
                            'rating' => '4.7/5',
                            'status' => 'Bận',
                            'status_class' => 'bg-zen-warning/10 text-zen-warning ring-zen-warning/20',
                            'image' => asset('images/tailadmin/user/user-03.jpg'),
                            'is_available' => false,
                            'checked' => false,
                        ],
                    ];
                @endphp

                {{-- Nhân viên --}}
                <section class="rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen sm:p-6">
                    <h2 class="text-base font-semibold text-zen-text">Chọn nhân viên</h2>
                    <p class="mt-1 text-sm text-zen-muted">Để salon sắp xếp lịch hoặc chọn stylist yêu thích.</p>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-3" role="radiogroup" aria-label="Chọn nhân viên phụ trách">
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
                                    'group relative flex min-h-full flex-col rounded-zen-md border-2 border-zen-border bg-white p-4 text-left shadow-sm transition duration-200 has-[:focus-visible]:ring-2 has-[:focus-visible]:ring-zen-primary/40',
                                    'cursor-pointer hover:-translate-y-0.5 hover:border-zen-primary/50 hover:shadow-zen has-[:checked]:border-zen-primary has-[:checked]:bg-zen-accent-soft has-[:checked]:shadow-zen-md' => $stylistAvailable,
                                    'cursor-not-allowed opacity-60 grayscale-[.15]' => ! $stylistAvailable,
                                ])
                            >
                                <input
                                    type="radio"
                                    name="booking_stylist"
                                    value="{{ $stylist['id'] }}"
                                    data-stylist-name="{{ $stylist['name'] }}"
                                    data-stylist-available="{{ $stylistAvailable ? 'true' : 'false' }}"
                                    class="peer sr-only"
                                    @checked($stylist['checked'] && $stylistAvailable)
                                    @disabled(! $stylistAvailable)
                                >

                                <span class="flex items-start gap-3">
                                    <img
                                        src="{{ $stylist['image'] }}"
                                        alt="Ảnh đại diện {{ $stylist['name'] }}"
                                        class="size-16 shrink-0 rounded-full border-2 border-white object-cover shadow-sm ring-1 ring-zen-border"
                                        loading="lazy"
                                    >
                                    <span class="min-w-0 flex-1">
                                        <span data-stylist-label class="block text-sm font-semibold text-zen-text">{{ $stylist['name'] }}</span>
                                        <span class="mt-1 block text-xs font-medium text-zen-primary">{{ $stylist['role'] }}</span>
                                        <span class="mt-2 inline-flex rounded-full px-2.5 py-1 text-xs font-medium ring-1 {{ $stylist['status_class'] }}">
                                            {{ $stylist['status'] }}
                                        </span>
                                    </span>
                                </span>

                                <span class="mt-4 grid gap-2 text-xs text-zen-muted">
                                    <span class="flex items-center justify-between gap-3">
                                        <span>Kinh nghiệm</span>
                                        <span class="text-right font-semibold text-zen-text">{{ $stylist['experience'] }}</span>
                                    </span>
                                    <span class="flex items-center justify-between gap-3">
                                        <span>Đánh giá</span>
                                        <span class="text-right font-semibold text-zen-primary">{{ $stylist['rating'] }}</span>
                                    </span>
                                    <span class="rounded-zen-sm bg-zen-bg-soft px-3 py-2 leading-relaxed text-zen-text">
                                        <span class="block text-[11px] font-medium uppercase tracking-wide text-zen-muted">Dịch vụ nổi bật</span>
                                        <span class="mt-0.5 block font-medium">{{ $stylist['featured_service'] }}</span>
                                    </span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </section>

                {{-- Dịch vụ --}}
                <section class="rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen sm:p-6">
                    <h2 class="text-base font-semibold text-zen-text">Chọn dịch vụ</h2>
                    <p class="mt-1 text-sm text-zen-muted">Có thể chọn nhiều dịch vụ trong một lịch.</p>
                    <ul class="mt-4 divide-y divide-zen-border rounded border border-zen-border">
                        <li class="flex flex-wrap items-center justify-between gap-3 p-4" data-booking-service-row data-service-name="Cắt tóc nam cao cấp" data-service-price="150000">
                            <label class="flex flex-1 cursor-pointer items-start gap-3">
                                <input type="checkbox" checked name="booking_services[]" value="cut" class="mt-0.5 size-4 rounded border-zen-border-dark text-zen-primary focus:ring-zen-primary/30">
                                <span>
                                    <span class="block text-sm font-medium text-zen-text">Cắt tóc nam cao cấp</span>
                                    <span class="mt-0.5 block text-xs text-zen-muted">Khoảng 45 phút</span>
                                </span>
                </label>
                <span class="text-sm font-semibold text-zen-primary">150.000đ</span>
              </li>
              <li class="flex flex-wrap items-center justify-between gap-3 p-4" data-booking-service-row data-service-name="Gội + massage da đầu" data-service-price="120000">
                <label class="flex flex-1 cursor-pointer items-start gap-3">
                  <input type="checkbox" checked name="service_ids[]" value="wash" class="mt-0.5 size-4 rounded border-zen-border-dark text-zen-primary focus:ring-zen-primary/30">
                  <span>
                                    <span class="block text-sm font-medium text-zen-text">Gội + massage da đầu</span>
                                    <span class="mt-0.5 block text-xs text-zen-muted">30 phút</span>
                                </span>
                </label>
                <span class="text-sm font-semibold text-zen-primary">120.000đ</span>
              </li>
              <li class="flex flex-wrap items-center justify-between gap-3 p-4" data-booking-service-row data-service-name="Uốn / nhuộm cơ bản" data-service-price="650000">
                <label class="flex flex-1 cursor-pointer items-start gap-3">
                  <input type="checkbox" checked name="service_ids[]" value="perm" class="mt-0.5 size-4 rounded border-zen-border-dark text-zen-primary focus:ring-zen-primary/30">
                  <span>
                                    <span class="block text-sm font-medium text-zen-text">Uốn / nhuộm cơ bản</span>
                                    <span class="mt-0.5 block text-xs text-zen-muted">~120 phút</span>
                                </span>
                </label>
                <span class="text-sm font-semibold text-zen-primary">650.000đ</span>
              </li>
              <li class="flex flex-wrap items-center justify-between gap-3 p-4" data-booking-service-row data-service-name="Treatment phục hồi" data-service-price="320000">
                <label class="flex flex-1 cursor-pointer items-start gap-3">
                  <input type="checkbox" checked name="service_ids[]" value="treatment" class="mt-0.5 size-4 rounded border-zen-border-dark text-zen-primary focus:ring-zen-primary/30">
                  <span>
                                    <span class="block text-sm font-medium text-zen-text">Treatment phục hồi</span>
                                    <span class="mt-0.5 block text-xs text-zen-muted">60 phút</span>
                                </span>
                </label>
                <span class="text-sm font-semibold text-zen-primary">320.000đ</span>
              </li>
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
              <div class="sm:col-span-1">
                <label for="full-name" class="mb-1.5 block text-sm font-medium text-zen-muted">Họ và tên</label>
                <input
                  id="full-name"
                  name="full_name"
                  type="text"
                  placeholder="Nguyễn Văn A"
                  class="h-10 w-full rounded-zen-sm border border-zen-border px-3 text-sm outline-none focus:border-zen-primary focus:ring-2 focus:ring-zen-primary/20"
                >
              </div>
              <div class="sm:col-span-1">
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

          {{-- Thanh hành động dưới (kiểu wizard) --}}
          <div class="flex flex-col-reverse gap-3 border-t border-zen-border pt-2 sm:flex-row sm:justify-end">
            <button
              type="submit"
              class="h-10 rounded-zen-sm border border-zen-border bg-zen-bg px-5 text-sm font-medium text-zen-muted hover:border-zen-primary/40 hover:text-zen-primary"
            >
              Quay lại
            </button>
            <button
              type="submit"
              class="h-10 rounded-zen-sm bg-zen-primary px-8 text-sm font-medium text-white shadow-sm transition hover:bg-zen-primary-dark"
            >
              Tiếp tục / Xác nhận đặt lịch
            </button>
          </div>
        </form>
      </div>

      {{-- Sidebar tóm tắt --}}
      <aside class="lg:col-span-4">
        <div class="sticky top-24 rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen sm:p-6">
          <h2 class="text-base font-semibold text-zen-text">Tóm tắt đặt lịch</h2>
          <dl class="mt-4 space-y-3 text-sm">
            <div class="flex justify-between gap-3 border-b border-dashed border-zen-border pb-3">
              <dt class="text-zen-muted">Salon</dt>
              <dd id="booking-summary-branch" class="text-right font-medium text-zen-text">ZenStyle FPT Aptech</dd>
            </div>
            <div class="flex justify-between gap-3 border-b border-dashed border-zen-border pb-3">
              <dt class="text-zen-muted">Thời gian</dt>
              <dd class="text-right font-medium text-zen-text">
                <span id="booking-summary-time-line" class="block">—</span>
                <span id="booking-summary-date-line" class="text-xs font-normal text-zen-muted">{{ $bookingDaySummaries[$bookingToday->dayOfWeekIso - 1] }}, {{ $bookingToday->format('d/m/Y') }}</span>
              </dd>
            </div>
            <div class="flex justify-between gap-3 border-b border-dashed border-zen-border pb-3">
              <dt class="text-zen-muted">Khách</dt>
              <dd id="booking-summary-guests" class="text-right font-medium text-zen-text">1 người</dd>
            </div>
            <div class="flex justify-between gap-3 border-b border-dashed border-zen-border pb-3">
              <dt class="text-zen-muted">Nhân viên</dt>
              <dd id="booking-summary-stylist" class="text-right font-medium text-zen-text">Bất kỳ nhân viên</dd>
            </div>
            <div>
              <dt class="text-zen-muted">Dịch vụ</dt>
              <dd id="booking-summary-services" class="mt-2 space-y-1 text-right font-medium text-zen-text"></dd>
            </div>
          </dl>

          <div class="my-4 border-t border-zen-border"></div>

          <div class="flex items-baseline justify-between">
            <span class="text-sm text-zen-muted">Tạm tính</span>
            <span id="booking-summary-total" class="text-xl font-semibold text-zen-primary">150.000đ</span>
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
    </div>
  </div>

  @if(session('otp_pending'))
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
      <div class="w-full max-w-md rounded bg-white p-6">
        <h2 class="text-xl font-bold">Xác nhận OTP</h2>

        <p class="mt-3 rounded bg-yellow-100 p-3 text-sm">
          OTP TEST: <strong>{{ session('otp_demo') }}</strong>
        </p>

        <form method="POST" action="{{ route('booking.verify.otp') }}">
          @csrf

          <input name="otp" maxlength="6" class="h-11 w-full rounded border px-3">

          <button type="submit" class="mt-4 h-10 w-full rounded bg-blue-500 text-white">
            Xác nhận OTP
          </button>
        </form>
      </div>
    </div>
  @endif
</x-frontend.layout>
