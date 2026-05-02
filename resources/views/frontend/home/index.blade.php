@extends('layouts.frontend.app')

@section('main_class', 'pt-0')

@section('title', 'ZenStyle — Trang chủ')

@section('content')
    {{--
        =====================================================================
        HERO / SLIDER TĨNH
        ---------------------------------------------------------------------
        - Đây là "banner đầu trang" theo AC.
        - Slider này là slider tĩnh: dữ liệu slide viết cứng trong Blade (không lấy DB).
        - JS chỉ điều khiển chuyển slide thủ công (Prev/Next + dot).
        =====================================================================
    --}}
    @php
        $heroSlides = [
            [
                'image' => 'https://images.unsplash.com/photo-1562322140-8baeececf3df?auto=format&fit=crop&w=1600&q=80',
                'alt' => 'ZenStyle Hair Service',
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=1600&q=80',
                'alt' => 'ZenStyle Spa Service',
            ],
        ];
    @endphp

    <section
        id="site-banner"
        class="relative min-h-screen w-full overflow-hidden bg-stone-900"
        aria-label="ZenStyle Banner">
        {{-- Overlay gradient để text dễ đọc --}}
        <div class="pointer-events-none absolute inset-0 z-10 bg-gradient-to-b from-stone-900/40 via-stone-900/20 to-stone-900/60"></div>

        {{-- Khối chứa toàn bộ slide --}}
        <div class="relative h-screen">
            @foreach ($heroSlides as $index => $slide)
                <article
                    data-slide
                    class="absolute inset-0 transition-opacity duration-700 ease-out {{ $index === 0 ? 'opacity-100' : 'pointer-events-none opacity-0' }}"
                    aria-hidden="{{ $index === 0 ? 'false' : 'true' }}"
                >
                    <img
                        src="{{ $slide['image'] }}"
                        alt="{{ $slide['alt'] }}"
                        class="h-full w-full object-cover"
                        loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                    />
                </article>
            @endforeach
        </div>
        {{-- Navigation dots (dưới cùng) --}}
        <div class="absolute inset-x-0 bottom-8 z-30 flex justify-center gap-3">
            @foreach ($heroSlides as $index => $slide)
                <button
                    type="button"
                    data-slide-dot
                    data-slide-index="{{ $index }}"
                    class="h-3 rounded-full transition-all {{ $index === 0 ? 'w-8 bg-white' : 'w-3 bg-white/50 hover:bg-white/75' }}"
                    aria-label="Chuyển đến slide {{ $index + 1 }}"
                    aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                ></button>
            @endforeach
        </div>

        {{-- Wave separator --}}
        <div class="pointer-events-none absolute bottom-0 left-0 right-0 text-stone-50" aria-hidden="true">
            <svg class="block h-12 w-full sm:h-16" viewBox="0 0 1440 100" preserveAspectRatio="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path fill="currentColor" d="M0,48 C240,95 480,5 720,58 C960,112 1200,18 1440,52 L1440,100 L0,100 Z"/>
            </svg>
        </div>
    </section>

    {{--
        =====================================================================
        SECTION GIỚI THIỆU
        =====================================================================
    --}}
    <section id="gioi-thieu" class="scroll-mt-24 bg-rose-50 px-4 py-20 sm:px-6">
        <div class="mx-auto max-w-6xl">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-stone-900">Về ZenStyle</h2>
                <p class="mt-4 text-lg text-stone-600 max-w-2xl mx-auto">
                    Chúng tôi là điểm đến tin cậy cho dịch vụ tóc, da, và spa chuyên nghiệp.
                    Với đội ngũ stylist tận tâm, chúng tôi mang đến trải nghiệm thư giãn tuyệt vời.
                </p>
            </div>

            <div class="grid gap-8 md:grid-cols-3">
                <div class="rounded-2xl bg-white p-8 shadow-sm hover:shadow-md transition">
                    <div class="mb-4 h-12 w-12 rounded-lg bg-rose-100 flex items-center justify-center">
                        <span class="text-2xl">✨</span>
                    </div>
                    <h3 class="text-xl font-semibold text-stone-900">Chất lượng cao</h3>
                    <p class="mt-3 text-stone-600">Sử dụng sản phẩm cao cấp và kỹ thuật chuyên nghiệp.</p>
                </div>

                <div class="rounded-2xl bg-white p-8 shadow-sm hover:shadow-md transition">
                    <div class="mb-4 h-12 w-12 rounded-lg bg-rose-100 flex items-center justify-center">
                        <span class="text-2xl">👥</span>
                    </div>
                    <h3 class="text-xl font-semibold text-stone-900">Đội ngũ tận tâm</h3>
                    <p class="mt-3 text-stone-600">Stylist có kinh nghiệm, tư vấn phù hợp với bạn.</p>
                </div>

                <div class="rounded-2xl bg-white p-8 shadow-sm hover:shadow-md transition">
                    <div class="mb-4 h-12 w-12 rounded-lg bg-rose-100 flex items-center justify-center">
                        <span class="text-2xl">🌿</span>
                    </div>
                    <h3 class="text-xl font-semibold text-stone-900">Không gian thư giãn</h3>
                    <p class="mt-3 text-stone-600">Môi trường sạch sẽ, yên tĩnh, thư giãn tối đa.</p>
                </div>
            </div>
        </div>
    </section>

    {{--
        =====================================================================
        SECTION DỊCH VỤ NỔI BẬT
        =====================================================================
        - Đáp ứng AC: có layout hiển thị dịch vụ nổi bật.
        - Dữ liệu hiện tại viết cứng, sau này có thể thay bằng DB.
        =====================================================================
    --}}
    <section id="dich-vu" class="scroll-mt-24 bg-stone-50 px-4 py-16 sm:px-6">
        <div class="mx-auto max-w-6xl">
            <div class="text-center">
                <h2 class="text-2xl font-semibold text-stone-800 sm:text-3xl">Dịch vụ nổi bật</h2>
                <p class="mt-2 text-stone-600">Chọn gói phù hợp — đội ngũ tư vấn tận tâm.</p>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    ['Tóc', 'Cắt, uốn, nhuộm với xu hướng mới nhất.'],
                    ['Da & mặt', 'Chăm sóc da chuyên sâu, làm sáng và căng mịn.'],
                    ['Spa & thư giãn', 'Massage, gói trị liệu giúp phục hồi năng lượng.'],
                ] as $item)
                    <article class="rounded-2xl border border-rose-100/90 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-stone-900">{{ $item[0] }}</h3>
                        <p class="mt-2 text-sm text-stone-600">{{ $item[1] }}</p>
                    </article>
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <a href="#dat-lich"
                   class="inline-flex rounded-full bg-rose-400 px-8 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-rose-500">
                    Đặt lịch ngay
                </a>
            </div>
        </div>
    </section>

    {{--
        =====================================================================
        ANCHOR "ĐẶT LỊCH NGAY"
        =====================================================================
        - Trước đó navbar/CTA trỏ tới #dat-lich nhưng chưa có section tương ứng.
        - Bổ sung section mẫu để không còn link chết.
        =====================================================================
    --}}
    <section id="dat-lich" class="scroll-mt-24 bg-rose-50 px-4 py-16 sm:px-6">
        <div class="mx-auto max-w-6xl rounded-3xl border border-rose-100 bg-rose-50/70 p-8 sm:p-10">
            <h2 class="text-2xl font-semibold text-stone-900 sm:text-3xl">Đặt lịch nhanh cùng ZenStyle</h2>
            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-stone-600 sm:text-base">
                Đây là block giữ chỗ cho module đặt lịch ở task sau. Hiện tại bạn có thể đổi nút này sang route thật
                (ví dụ: <code>/booking/create</code>) khi hoàn thiện chức năng đặt lịch.
            </p>
            <div class="mt-6">
                <a
                    href="#"
                    class="inline-flex rounded-full bg-stone-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-stone-800"
                >
                    Mở form đặt lịch (sẽ làm ở task sau)
                </a>
            </div>
        </div>
    </section>
@endsection
