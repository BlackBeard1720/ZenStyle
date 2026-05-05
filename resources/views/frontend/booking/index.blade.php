@extends('layouts.frontend.app')

@section('title', 'ZenStyle — Đặt lịch')

@section('main_class', 'pt-20')

@section('content')
    {{--
        =========================================================================
        BOOKING PAGE (VIEW ONLY)
        -------------------------------------------------------------------------
        - Mục tiêu: dựng giao diện đặt lịch tương tự flow của EasySalon.
        - Phạm vi: chỉ UI tĩnh bằng Tailwind (chưa có submit backend).
        - Bố cục: 2 cột (form + tóm tắt), mobile tự co về 1 cột.
        =========================================================================
    --}}
    <section class="border-b border-stone-200 bg-gradient-to-b from-rose-50 to-white px-4 py-10 sm:px-6">
        <div class="mx-auto max-w-6xl">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-rose-700">Booking online</p>
            <h1 class="mt-2 text-3xl font-bold text-stone-900 sm:text-4xl">Đặt lịch với ZenStyle</h1>
            <p class="mt-3 max-w-2xl text-sm text-stone-600 sm:text-base">
                Chọn dịch vụ, stylist và khung giờ phù hợp. ZenStyle sẽ giữ lịch cho bạn trong 15 phút sau khi xác nhận.
            </p>

            {{--
                Step bar hiển thị trạng thái quy trình đặt lịch (UI mô phỏng).
            --}}
            <ol class="mt-8 grid gap-3 sm:grid-cols-4">
                <li class="rounded-xl border border-rose-200 bg-rose-100 px-4 py-3 text-sm font-semibold text-rose-800">
                    1. Dịch vụ
                </li>
                <li class="rounded-xl border border-stone-200 bg-white px-4 py-3 text-sm font-medium text-stone-600">
                    2. Thời gian
                </li>
                <li class="rounded-xl border border-stone-200 bg-white px-4 py-3 text-sm font-medium text-stone-600">
                    3. Thông tin
                </li>
                <li class="rounded-xl border border-stone-200 bg-white px-4 py-3 text-sm font-medium text-stone-600">
                    4. Hoàn tất
                </li>
            </ol>
        </div>
    </section>

    <section class="px-4 py-10 sm:px-6">
        <div class="mx-auto grid max-w-6xl gap-6 lg:grid-cols-12">
            {{--
                Cột trái: form đặt lịch (chiếm 8/12 trên desktop)
            --}}
            <div class="space-y-6 lg:col-span-8">
                <article class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-stone-900">Chi nhánh</h2>
                    <p class="mt-1 text-sm text-stone-600">Chọn salon bạn muốn đặt lịch.</p>

                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        <label class="cursor-pointer rounded-xl border border-rose-200 bg-rose-50 p-4">
                            <input type="radio" name="branch" class="sr-only" checked>
                            <p class="font-semibold text-stone-900">ZenStyle Triều Khúc</p>
                            <p class="mt-1 text-sm text-stone-600">123 Triều Khúc, Thanh Xuân, Hà Nội</p>
                        </label>
                        <label class="cursor-pointer rounded-xl border border-stone-200 bg-white p-4 hover:border-stone-300">
                            <input type="radio" name="branch" class="sr-only">
                            <p class="font-semibold text-stone-900">ZenStyle Hà Đông</p>
                            <p class="mt-1 text-sm text-stone-600">58 Nguyễn Văn Lộc, Hà Đông, Hà Nội</p>
                        </label>
                    </div>
                </article>

                <article class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-stone-900">Dịch vụ</h2>
                    <p class="mt-1 text-sm text-stone-600">Chọn một hoặc nhiều dịch vụ bạn cần.</p>

                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        <label class="rounded-xl border border-stone-200 p-4 hover:border-rose-300">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="font-semibold text-stone-900">Cắt tóc nam cao cấp</p>
                                    <p class="mt-1 text-sm text-stone-600">45 phút</p>
                                </div>
                                <span class="text-sm font-semibold text-rose-700">150.000đ</span>
                            </div>
                            <input type="checkbox" class="mt-3 h-4 w-4 rounded border-stone-300 text-rose-500 focus:ring-rose-400" checked>
                        </label>

                        <label class="rounded-xl border border-stone-200 p-4 hover:border-rose-300">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="font-semibold text-stone-900">Gội + massage da đầu</p>
                                    <p class="mt-1 text-sm text-stone-600">30 phút</p>
                                </div>
                                <span class="text-sm font-semibold text-rose-700">120.000đ</span>
                            </div>
                            <input type="checkbox" class="mt-3 h-4 w-4 rounded border-stone-300 text-rose-500 focus:ring-rose-400">
                        </label>

                        <label class="rounded-xl border border-stone-200 p-4 hover:border-rose-300">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="font-semibold text-stone-900">Uốn/nhuộm cơ bản</p>
                                    <p class="mt-1 text-sm text-stone-600">120 phút</p>
                                </div>
                                <span class="text-sm font-semibold text-rose-700">650.000đ</span>
                            </div>
                            <input type="checkbox" class="mt-3 h-4 w-4 rounded border-stone-300 text-rose-500 focus:ring-rose-400">
                        </label>

                        <label class="rounded-xl border border-stone-200 p-4 hover:border-rose-300">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="font-semibold text-stone-900">Treatment phục hồi</p>
                                    <p class="mt-1 text-sm text-stone-600">60 phút</p>
                                </div>
                                <span class="text-sm font-semibold text-rose-700">320.000đ</span>
                            </div>
                            <input type="checkbox" class="mt-3 h-4 w-4 rounded border-stone-300 text-rose-500 focus:ring-rose-400">
                        </label>
                    </div>
                </article>

                <article class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-stone-900">Ngày &amp; khung giờ</h2>
                    <p class="mt-1 text-sm text-stone-600">Chọn ngày và giờ bắt đầu mong muốn.</p>

                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="booking-date" class="mb-2 block text-sm font-medium text-stone-700">Ngày</label>
                            <input
                                id="booking-date"
                                type="date"
                                class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-rose-400 focus:outline-none focus:ring-2 focus:ring-rose-100"
                                value="2026-05-06"
                            >
                        </div>
                        <div>
                            <label for="booking-time" class="mb-2 block text-sm font-medium text-stone-700">Giờ</label>
                            <select
                                id="booking-time"
                                class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-rose-400 focus:outline-none focus:ring-2 focus:ring-rose-100"
                            >
                                <option>09:00</option>
                                <option>09:30</option>
                                <option selected>10:00</option>
                                <option>10:30</option>
                                <option>11:00</option>
                            </select>
                        </div>
                    </div>

                    <p class="mt-4 text-xs text-stone-500">* Khung giờ có thể thay đổi theo lịch trống của stylist.</p>
                </article>

                <article class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-stone-900">Stylist ưu tiên</h2>
                    <p class="mt-1 text-sm text-stone-600">Bạn có thể chọn bất kỳ hoặc stylist cụ thể.</p>

                    <div class="mt-4 grid gap-3 sm:grid-cols-3">
                        <label class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm font-medium text-stone-900">
                            <input type="radio" name="stylist" class="sr-only" checked>
                            Bất kỳ stylist
                        </label>
                        <label class="rounded-xl border border-stone-200 p-4 text-sm font-medium text-stone-900 hover:border-stone-300">
                            <input type="radio" name="stylist" class="sr-only">
                            Trần Lan Chi
                        </label>
                        <label class="rounded-xl border border-stone-200 p-4 text-sm font-medium text-stone-900 hover:border-stone-300">
                            <input type="radio" name="stylist" class="sr-only">
                            Lê Hoàng Nam
                        </label>
                    </div>
                </article>

                <article class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-stone-900">Thông tin khách hàng</h2>
                    <p class="mt-1 text-sm text-stone-600">Thông tin để salon xác nhận lịch hẹn.</p>

                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="full-name" class="mb-2 block text-sm font-medium text-stone-700">Họ và tên</label>
                            <input id="full-name" type="text" placeholder="Nguyễn Văn A" class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-rose-400 focus:outline-none focus:ring-2 focus:ring-rose-100">
                        </div>
                        <div>
                            <label for="phone" class="mb-2 block text-sm font-medium text-stone-700">Số điện thoại</label>
                            <input id="phone" type="tel" placeholder="09xx xxx xxx" class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-rose-400 focus:outline-none focus:ring-2 focus:ring-rose-100">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="note" class="mb-2 block text-sm font-medium text-stone-700">Ghi chú (tuỳ chọn)</label>
                            <textarea id="note" rows="4" placeholder="Ví dụ: muốn tư vấn màu nâu lạnh, tóc mỏng..." class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-rose-400 focus:outline-none focus:ring-2 focus:ring-rose-100"></textarea>
                        </div>
                    </div>
                </article>
            </div>

            {{--
                Cột phải: tóm tắt đơn đặt lịch + CTA xác nhận
            --}}
            <aside class="space-y-4 lg:col-span-4">
                <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm lg:sticky lg:top-24">
                    <h2 class="text-lg font-semibold text-stone-900">Tóm tắt lịch hẹn</h2>

                    <dl class="mt-4 space-y-3 text-sm">
                        <div class="flex items-start justify-between gap-4">
                            <dt class="text-stone-500">Chi nhánh</dt>
                            <dd class="text-right font-medium text-stone-900">ZenStyle Triều Khúc</dd>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <dt class="text-stone-500">Dịch vụ</dt>
                            <dd class="text-right font-medium text-stone-900">Cắt tóc nam cao cấp</dd>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <dt class="text-stone-500">Stylist</dt>
                            <dd class="text-right font-medium text-stone-900">Bất kỳ</dd>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <dt class="text-stone-500">Thời gian</dt>
                            <dd class="text-right font-medium text-stone-900">10:00, 06/05/2026</dd>
                        </div>
                    </dl>

                    <div class="my-4 border-t border-dashed border-stone-200"></div>

                    <div class="flex items-center justify-between">
                        <p class="text-sm text-stone-500">Tạm tính</p>
                        <p class="text-xl font-bold text-rose-700">150.000đ</p>
                    </div>

                    <button
                        type="button"
                        class="mt-5 w-full rounded-xl bg-stone-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-stone-800"
                    >
                        Xác nhận đặt lịch
                    </button>

                    <p class="mt-3 text-center text-xs text-stone-500">
                        Khi bấm xác nhận, bạn đồng ý với chính sách đặt lịch của ZenStyle.
                    </p>
                </div>

                <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                    <p class="font-semibold">Lưu ý</p>
                    <p class="mt-1">
                        Vui lòng đến sớm 5-10 phút. Salon sẽ giữ lịch tối đa 15 phút nếu chưa thấy bạn check-in.
                    </p>
                </div>
            </aside>
        </div>
    </section>
@endsection
