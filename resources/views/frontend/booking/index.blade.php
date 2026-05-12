<x-frontend.layout title="ZenStyle — Đặt lịch" main-class="bg-stone-50 pt-20">
    {{--
        Flow EasySalon (Ant-style). Tailwind v4 + JS (frontend/booking.js): chọn salon/ngày/giờ/dịch vụ/stylist/khách, cập nhật tóm tắt.
        Chưa gửi form backend.
    --}}
    <div id="booking-page" class="pb-12 pt-6 sm:pt-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6">
            <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-black/45">Booking online</p>
                    <h1 class="mt-1 text-xl font-semibold text-black/85 sm:text-2xl">Đặt lịch hẹn</h1>
                </div>
                <p class="text-sm text-black/45">Hoàn tất các bước bên dưới để giữ chỗ tại salon.</p>
            </div>

            {{-- Step bar (kiểu Ant Design Steps) --}}

        </div>

        <div class="mx-auto mt-5 grid max-w-6xl gap-5 px-4 sm:mt-6 sm:px-6 lg:grid-cols-12 lg:gap-6">
            <div class="space-y-5 lg:col-span-8">
                {{-- Số lượng khách (EasySalon có bước này) --}}
                <section class="rounded border border-black/8 bg-white p-5 shadow-sm sm:p-6">
                    <h2 class="text-base font-semibold text-black/85">Số lượng khách</h2>
                    <p class="mt-1 text-sm text-black/45">Số người sử dụng dịch vụ trong buổi hẹn.</p>
                    <div class="mt-4 inline-flex items-center rounded border border-black/15">
                        <button type="button" data-booking-guest-minus class="px-4 py-2 text-sm text-black/65 transition hover:bg-black/5 hover:text-black/85 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#1677ff]/40" aria-label="Giảm số khách">−</button>
                        <span data-booking-guest-value class="min-w-[3rem] border-x border-black/15 py-2 text-center text-sm font-medium text-black/85 tabular-nums">1</span>
                        <button type="button" data-booking-guest-plus class="px-4 py-2 text-sm text-black/65 transition hover:bg-black/5 hover:text-black/85 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#1677ff]/40" aria-label="Tăng số khách">+</button>
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
                <section class="rounded border border-black/8 bg-white p-5 shadow-sm sm:p-6">
                    <h2 class="text-base font-semibold text-black/85">Chọn ngày &amp; giờ</h2>
                    <p class="mt-1 text-sm text-black/45">Chọn ngày trong tuần và khung giờ bắt đầu.</p>

                    <div class="mt-4">
                        <label for="booking-date" class="mb-2 block text-sm font-medium text-black/65">Hoặc chọn ngày</label>
                        <input
                            id="booking-date"
                            type="date"
                            value="{{ $bookingToday->toDateString() }}"
                            min="{{ $bookingToday->toDateString() }}"
                            class="h-10 max-w-xs rounded border border-black/15 bg-white px-3 text-sm text-black/85 outline-none ring-[#1677ff] focus:border-[#1677ff] focus:ring-2 focus:ring-[#1677ff]/20"
                        >
                    </div>

                    <p class="mb-2 mt-6 text-sm font-medium text-black/65">Tuần này</p>
                    <div class="flex flex-wrap gap-2" role="radiogroup" aria-label="Chọn ngày trong tuần">
                        @foreach ($bookingDays as $day)
                            <button
                                type="button"
                                data-booking-day
                                data-date="{{ $day['iso'] }}"
                                data-summary="{{ $day['summary'] }}"
                                aria-pressed="{{ $day['selected'] ? 'true' : 'false' }}"
                                class="min-w-[4.5rem] rounded border px-3 py-2 text-left text-sm transition-colors border-black/15 bg-white text-black/65 hover:border-[#1677ff]/40"
                            >
                                <span class="block text-xs text-black/45">{{ $day['label'] }}</span>
                                <span class="block tabular-nums">{{ $day['display'] }}</span>
                            </button>
                        @endforeach
                    </div>

                    <p class="mb-2 mt-6 text-sm font-medium text-black/65">Khung giờ trống</p>
                    <div class="grid grid-cols-3 gap-2 sm:grid-cols-4 md:grid-cols-6" role="radiogroup" aria-label="Giờ bắt đầu">
                        @foreach (['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '14:00', '14:30', '15:00', '15:30', '16:00', '17:00'] as $slot)
                            <button
                                type="button"
                                data-booking-slot
                                data-slot="{{ $slot }}"
                                aria-pressed="false"
                                class="rounded border px-2 py-2 text-sm transition-colors border-black/15 bg-white text-black/65 hover:border-[#1677ff]/50"
                            >
                                {{ $slot }}
                            </button>
                        @endforeach
                    </div>
                </section>

                {{-- Nhân viên --}}
                <section class="rounded border border-black/8 bg-white p-5 shadow-sm sm:p-6">
                    <h2 class="text-base font-semibold text-black/85">Chọn nhân viên</h2>
                    <p class="mt-1 text-sm text-black/45">Để salon sắp xếp lịch hoặc chọn stylist yêu thích.</p>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                        <label class="flex cursor-pointer items-center gap-3 rounded border border-black/15 bg-white p-3 transition-colors has-[:checked]:border-2 has-[:checked]:border-[#1677ff] has-[:checked]:bg-[#e6f4ff] hover:border-[#1677ff]/40">
                            <input type="radio" name="booking_stylist" value="any" class="peer sr-only" checked>

                            <span class="min-w-0 text-sm font-medium text-black/85"><span data-stylist-label>Quách Tùng Dương</span></span>
                        </label>
                        <label class="flex cursor-pointer items-center gap-3 rounded border border-black/15 bg-white p-3 transition-colors has-[:checked]:border-2 has-[:checked]:border-[#1677ff] has-[:checked]:bg-[#e6f4ff] hover:border-[#1677ff]/40">
                            <input type="radio" name="booking_stylist" value="lan-chi" class="peer sr-only">

                            <span class="min-w-0 text-sm font-medium text-black/85"><span data-stylist-label>Đinh Văn Hải</span></span>
                        </label>
                        <label class="flex cursor-pointer items-center gap-3 rounded border border-black/15 bg-white p-3 transition-colors has-[:checked]:border-2 has-[:checked]:border-[#1677ff] has-[:checked]:bg-[#e6f4ff] hover:border-[#1677ff]/40">
                            <input type="radio" name="booking_stylist" value="hoang-nam" class="peer sr-only">
                            <span class="min-w-0 text-sm font-medium text-black/85"><span data-stylist-label>Lê Hoàng Nam</span></span>
                        </label>
                    </div>
                </section>
                
                {{-- Dịch vụ --}}
                <section class="rounded border border-black/8 bg-white p-5 shadow-sm sm:p-6">
                    <h2 class="text-base font-semibold text-black/85">Chọn dịch vụ</h2>
                    <p class="mt-1 text-sm text-black/45">Có thể chọn nhiều dịch vụ trong một lịch.</p>
                    <ul class="mt-4 divide-y divide-black/6 rounded border border-black/8">
                        <li class="flex flex-wrap items-center justify-between gap-3 p-4" data-booking-service-row data-service-name="Cắt tóc nam cao cấp" data-service-price="150000">
                            <label class="flex flex-1 cursor-pointer items-start gap-3">
                                <input type="checkbox" checked name="booking_services[]" value="cut" class="mt-0.5 size-4 rounded border-black/20 text-[#1677ff] focus:ring-[#1677ff]/30">
                                <span>
                                    <span class="block text-sm font-medium text-black/85">Cắt tóc nam cao cấp</span>
                                    <span class="mt-0.5 block text-xs text-black/45">Khoảng 45 phút</span>
                                </span>
                            </label>
                            <span class="text-sm font-semibold text-[#1677ff]">150.000đ</span>
                        </li>
                        <li class="flex flex-wrap items-center justify-between gap-3 p-4" data-booking-service-row data-service-name="Gội + massage da đầu" data-service-price="120000">
                            <label class="flex flex-1 cursor-pointer items-start gap-3">
                                <input type="checkbox" name="booking_services[]" value="wash" class="mt-0.5 size-4 rounded border-black/20 text-[#1677ff] focus:ring-[#1677ff]/30">
                                <span>
                                    <span class="block text-sm font-medium text-black/85">Gội + massage da đầu</span>
                                    <span class="mt-0.5 block text-xs text-black/45">30 phút</span>
                                </span>
                            </label>
                            <span class="text-sm font-semibold text-[#1677ff]">120.000đ</span>
                        </li>
                        <li class="flex flex-wrap items-center justify-between gap-3 p-4" data-booking-service-row data-service-name="Uốn / nhuộm cơ bản" data-service-price="650000">
                            <label class="flex flex-1 cursor-pointer items-start gap-3">
                                <input type="checkbox" name="booking_services[]" value="perm" class="mt-0.5 size-4 rounded border-black/20 text-[#1677ff] focus:ring-[#1677ff]/30">
                                <span>
                                    <span class="block text-sm font-medium text-black/85">Uốn / nhuộm cơ bản</span>
                                    <span class="mt-0.5 block text-xs text-black/45">~120 phút</span>
                                </span>
                            </label>
                            <span class="text-sm font-semibold text-[#1677ff]">650.000đ</span>
                        </li>
                        <li class="flex flex-wrap items-center justify-between gap-3 p-4" data-booking-service-row data-service-name="Treatment phục hồi" data-service-price="320000">
                            <label class="flex flex-1 cursor-pointer items-start gap-3">
                                <input type="checkbox" name="booking_services[]" value="treatment" class="mt-0.5 size-4 rounded border-black/20 text-[#1677ff] focus:ring-[#1677ff]/30">
                                <span>
                                    <span class="block text-sm font-medium text-black/85">Treatment phục hồi</span>
                                    <span class="mt-0.5 block text-xs text-black/45">60 phút</span>
                                </span>
                            </label>
                            <span class="text-sm font-semibold text-[#1677ff]">320.000đ</span>
                        </li>
                    </ul>
                </section>

                {{-- Khuyến mãi --}}
                <section class="rounded border border-black/8 bg-white p-5 shadow-sm sm:p-6">
                    <h2 class="text-base font-semibold text-black/85">Mã khuyến mãi</h2>
                    <p class="mt-1 text-sm text-black/45">Nhập mã ưu đãi (nếu có).</p>
                    <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                        <input
                            type="text"
                            data-booking-promo-input
                            placeholder="VD: SUMMER2026"
                            class="h-10 flex-1 rounded border border-black/15 px-3 text-sm outline-none placeholder:text-black/35 focus:border-[#1677ff] focus:ring-2 focus:ring-[#1677ff]/20"
                        >
                        <button
                            type="button"
                            data-booking-promo-apply
                            class="h-10 shrink-0 rounded border border-[#1677ff] bg-white px-5 text-sm font-medium text-[#1677ff] transition hover:bg-[#e6f4ff]"
                        >
                            Áp dụng
                        </button>
                    </div>
                    <p data-booking-promo-hint class="mt-2 text-xs text-black/55" hidden></p>
                </section>

                {{-- Thông tin liên hệ --}}
                <section class="rounded border border-black/8 bg-white p-5 shadow-sm sm:p-6">
                    <h2 class="text-base font-semibold text-black/85">Thông tin liên hệ</h2>
                    <p class="mt-1 text-sm text-black/45">Salon dùng thông tin này để xác nhận lịch.</p>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <label for="full-name" class="mb-1.5 block text-sm font-medium text-black/65">Họ và tên</label>
                            <input
                                id="full-name"
                                type="text"
                                placeholder="Nguyễn Văn A"
                                class="h-10 w-full rounded border border-black/15 px-3 text-sm outline-none focus:border-[#1677ff] focus:ring-2 focus:ring-[#1677ff]/20"
                            >
                        </div>
                        <div class="sm:col-span-1">
                            <label for="phone" class="mb-1.5 block text-sm font-medium text-black/65">Số điện thoại</label>
                            <input
                                id="phone"
                                type="tel"
                                placeholder="09xx xxx xxx"
                                class="h-10 w-full rounded border border-black/15 px-3 text-sm outline-none focus:border-[#1677ff] focus:ring-2 focus:ring-[#1677ff]/20"
                            >
                        </div>
                        <div class="sm:col-span-2">
                            <label for="note" class="mb-1.5 block text-sm font-medium text-black/65">Ghi chú (tuỳ chọn)</label>
                            <textarea
                                id="note"
                                rows="4"
                                placeholder="Ví dụ: mong muốn tư vấn màu, tình trạng tóc..."
                                class="w-full resize-y rounded border border-black/15 px-3 py-2 text-sm outline-none focus:border-[#1677ff] focus:ring-2 focus:ring-[#1677ff]/20"
                            ></textarea>
                        </div>
                    </div>
                </section>

                {{-- Thanh hành động dưới (kiểu wizard) --}}
                <div class="flex flex-col-reverse gap-3 border-t border-black/8 pt-2 sm:flex-row sm:justify-end">
                    <button
                        type="button"
                        class="h-10 rounded border border-black/15 bg-white px-5 text-sm font-medium text-black/65 hover:border-[#1677ff]/40 hover:text-[#1677ff]"
                    >
                        Quay lại
                    </button>
                    <button
                        type="button"
                        class="h-10 rounded bg-[#1677ff] px-8 text-sm font-medium text-white shadow-sm transition hover:bg-[#4096ff]"
                    >
                        Tiếp tục / Xác nhận đặt lịch
                    </button>
                </div>
            </div>

            {{-- Sidebar tóm tắt --}}
            <aside class="lg:col-span-4">
                <div class="sticky top-24 rounded border border-black/8 bg-white p-5 shadow-sm sm:p-6">
                    <h2 class="text-base font-semibold text-black/85">Tóm tắt đặt lịch</h2>
                    <dl class="mt-4 space-y-3 text-sm">
                        <div class="flex justify-between gap-3 border-b border-dashed border-black/10 pb-3">
                            <dt class="text-black/45">Salon</dt>
                            <dd id="booking-summary-branch" class="text-right font-medium text-black/85">ZenStyle FPT Aptech</dd>
                        </div>
                        <div class="flex justify-between gap-3 border-b border-dashed border-black/10 pb-3">
                            <dt class="text-black/45">Thời gian</dt>
                            <dd class="text-right font-medium text-black/85">
                                <span id="booking-summary-time-line" class="block">—</span>
                                <span id="booking-summary-date-line" class="text-xs font-normal text-black/45">{{ $bookingDaySummaries[$bookingToday->dayOfWeekIso - 1] }}, {{ $bookingToday->format('d/m/Y') }}</span>
                            </dd>
                        </div>
                        <div class="flex justify-between gap-3 border-b border-dashed border-black/10 pb-3">
                            <dt class="text-black/45">Khách</dt>
                            <dd id="booking-summary-guests" class="text-right font-medium text-black/85">1 người</dd>
                        </div>
                        <div class="flex justify-between gap-3 border-b border-dashed border-black/10 pb-3">
                            <dt class="text-black/45">Nhân viên</dt>
                            <dd id="booking-summary-stylist" class="text-right font-medium text-black/85">Bất kỳ nhân viên</dd>
                        </div>
                        <div>
                            <dt class="text-black/45">Dịch vụ</dt>
                            <dd id="booking-summary-services" class="mt-2 space-y-1 text-right font-medium text-black/85"></dd>
                        </div>
                    </dl>

                    <div class="my-4 border-t border-black/10"></div>

                    <div class="flex items-baseline justify-between">
                        <span class="text-sm text-black/45">Tạm tính</span>
                        <span id="booking-summary-total" class="text-xl font-semibold text-[#1677ff]">150.000đ</span>
                    </div>

                    <button
                        type="button"
                        class="mt-5 flex h-10 w-full items-center justify-center rounded bg-[#1677ff] text-sm font-medium text-white transition hover:bg-[#4096ff]"
                    >
                        Hoàn tất đặt lịch
                    </button>

                    <p class="mt-4 text-center text-xs leading-relaxed text-black/45">
                        Bằng việc xác nhận, bạn đồng ý với quy định đặt lịch và chính sách của ZenStyle.
                        Lịch được giữ tối đa 15 phút sau xác nhận.
                    </p>
                </div>
            </aside>
        </div>
    </div>
</x-frontend.layout>
