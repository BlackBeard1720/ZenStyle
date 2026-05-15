<x-frontend.layout title="ZenStyle — Trang chủ" main-class="pt-0">
    {{--
        Nền trang chủ — luồng hợp lý:
        zen-bg-soft (canvas đồng bộ body) → band sáng (#dịch-vụ, #đặt-lịch) → capsule zen-primary nhấn trong CTA.
    --}}
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
                'image' => asset('images/frontend/banner/Gemini_Generated_Image_kt0965kt0965kt09.png'),
                'alt' => 'ZenStyle Hair Service',
            ],
            [
                'image' => asset('images/frontend/banner/Gemini_Generated_Image_7sr4oq7sr4oq7sr4.png'),
                'alt' => 'ZenStyle Spa Service',
            ],
            [
                'image' => asset('images/frontend/banner/Gemini_Generated_Image_7w6kln7w6kln7w6k.png'),
                'alt' => 'ZenStyle Spa Service',
            ],
            [
                'image' => asset('images/frontend/banner/Gemini_Generated_Image_os1lsdos1lsdos1l.png'),
                'alt' => 'ZenStyle Spa Service',
            ],
            [
                'image' => asset('images/frontend/banner/Gemini_Generated_Image_ympfunympfunympf.png'),
                'alt' => 'ZenStyle Spa Service',
            ],
        ];
    @endphp

    <section
        id="site-banner"
        class="relative min-h-screen w-full overflow-hidden bg-zen-bg-dark"
        aria-label="ZenStyle Banner">
        {{-- Overlay gradient để text dễ đọc --}}
        <div class="pointer-events-none absolute inset-0 z-10 bg-gradient-to-b from-zen-bg-dark/40 via-zen-bg-dark/20 to-zen-bg-dark/60"></div>

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
        <div class="absolute inset-x-0 bottom-8 z-30 flex justify-center gap-3 pointer-events-auto">
            @foreach ($heroSlides as $index => $slide)
                <button
                    type="button"
                    data-slide-dot
                    data-slide-index="{{ $index }}"
                    class="h-3 rounded-full transition-all cursor-pointer pointer-events-auto {{ $index === 0 ? 'w-8 bg-white' : 'w-3 bg-white/50 hover:bg-white/75' }}"
                    aria-label="Chuyển đến slide {{ $index + 1 }}"
                    aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                ></button>
            @endforeach
        </div>

        {{-- Wave separator --}}
        <div class="pointer-events-none absolute bottom-0 left-0 right-0 text-zen-bg" aria-hidden="true">
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
    <section id="gioi-thieu" class="scroll-mt-24 bg-zen-bg-soft px-4 py-20 sm:px-6">
        <div class="mx-auto max-w-6xl">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-zen-text">Về ZenStyle</h2>
                <p class="mt-4 text-lg text-zen-muted max-w-2xl mx-auto">
                    Chúng tôi là điểm đến tin cậy cho dịch vụ tóc, da, và spa chuyên nghiệp.
                    Với đội ngũ stylist tận tâm, chúng tôi mang đến trải nghiệm thư giãn tuyệt vời.
                </p>
            </div>

            <div class="grid gap-8 md:grid-cols-3">
                <div class="rounded-zen-lg bg-zen-bg p-8 shadow-zen hover:shadow-zen-md transition">
                    <div class="mb-4 h-12 w-12 rounded-lg bg-zen-accent-soft flex items-center justify-center">
                        <span class="text-2xl">✨</span>
                    </div>
                    <h3 class="text-xl font-semibold text-zen-text">Chất lượng cao</h3>
                     <p class="mt-3 text-zen-muted">Sử dụng sản phẩm cao cấp và kỹ thuật chuyên nghiệp.</p>
                </div>

                <div class="rounded-zen-lg bg-zen-bg p-8 shadow-zen hover:shadow-zen-md transition">
                    <div class="mb-4 h-12 w-12 rounded-lg bg-zen-accent-soft flex items-center justify-center">
                        <span class="text-2xl">👥</span>
                    </div>
                    <h3 class="text-xl font-semibold text-zen-text">Đội ngũ tận tâm</h3>
                    <p class="mt-3 text-zen-muted">Stylist có kinh nghiệm, tư vấn phù hợp với bạn.</p>
                </div>

                <div class="rounded-zen-lg bg-zen-bg p-8 shadow-zen hover:shadow-zen-md transition">
                    <div class="mb-4 h-12 w-12 rounded-lg bg-zen-accent-soft flex items-center justify-center">
                        <span class="text-2xl">🌿</span>
                    </div>
                    <h3 class="text-xl font-semibold text-zen-text">Không gian thư giãn</h3>
                    <p class="mt-3 text-zen-muted">Môi trường sạch sẽ, yên tĩnh, thư giãn tối đa.</p>
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
    <section id="dich-vu" class="scroll-mt-24 border-y border-zen-border bg-white px-4 py-16 sm:px-6">
        <div class="mx-auto max-w-6xl">
            <div class="text-center">
                <h2 class="text-2xl font-semibold text-zen-text sm:text-3xl">Dịch vụ nổi bật</h2>
                <p class="mt-2 text-zen-muted">Chọn gói phù hợp — đội ngũ tư vấn tận tâm.</p>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 lg:gap-6">
                @foreach ([
                    [
                        'title' => 'Tóc',
                        'desc' => 'Cắt, uốn, nhuộm với xu hướng mới nhất.',
                        'image' => asset('images/frontend/services/featured-toc.png'),
                        'alt' => 'Stylist đang tạo kiểu tóc cho khách tại ZenStyle',
                    ],
                    [
                        'title' => 'Gội & dưỡng tóc',
                        'desc' => 'Gội massage thư giãn, sản phẩm chăm sóc chuyên nghiệp.',
                        'image' => asset('images/frontend/services/featured-spa.png'),
                        'alt' => 'Dịch vụ gội đầu và massage da đầu tại salon',
                    ],
                    [
                        'title' => 'Spa & thư giãn',
                        'desc' => 'Massage, gói trị liệu giúp phục hồi năng lượng.',
                        'image' => asset('images/frontend/services/featured-goi.png '),
                        'alt' => 'Phòng massage ZenStyle — không gian thư giãn',
                    ],
                ] as $item)
                    <article class="overflow-hidden rounded-zen-lg border border-zen-border bg-zen-bg shadow-zen transition hover:shadow-md">
                        <div class="aspect-[4/3] overflow-hidden bg-zen-bg-soft">
                            <img
                                src="{{ $item['image'] }}"
                                alt="{{ $item['alt'] }}"
                                class="h-full w-full object-cover transition duration-500 ease-out hover:scale-105"
                                loading="lazy"
                                decoding="async"
                            >
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-zen-text">{{ $item['title'] }}</h3>
                            <p class="mt-2 text-sm text-zen-muted">{{ $item['desc'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <a
                    href="{{ route('booking') }}"
                    class="booking-cta inline-flex rounded-full px-8 py-3 text-sm font-semibold focus:outline-none focus-visible:ring-2 focus-visible:ring-zen-primary/50 focus-visible:ring-offset-2"
                >
                    Đặt lịch ngay
                </a>
            </div>
        </div>
    </section>

    {{--
        =====================================================================
        HOT TREND — mẫu tóc hot, lưới 3 cột đều (tỉ lệ cột 1:1:1)
        =====================================================================
    --}}
    @php
        $hotTrendStyles = [
            [
                'image' => asset('images/frontend/hottrend/hottrend-01.png'),
                'alt' => 'Kiểu spike texture, kính gọng đen',
                'label' => 'Spike texture',
            ],
            [
                'image' => asset('images/frontend/hottrend/hottrend-02.png'),
                'alt' => 'Tóc nam gọn, phong cách công sở hiện đại',
                'label' => 'Lịch lãm office',
            ],
            [
                'image' => asset('images/frontend/hottrend/hottrend-03.png'),
                'alt' => 'Crop texture, kính không gọng, nền studio',
                'label' => 'Textured crop',
            ],
            [
                'image' => asset('images/frontend/hottrend/hottrend-04.png'),
                'alt' => 'Wolf cut mullet, layer messy',
                'label' => 'Wolf cut / Mullet',
            ],
            [
                'image' => asset('images/frontend/hottrend/hottrend-05.png'),
                'alt' => 'Skin fade cao, spike gọn, profile',
                'label' => 'Skin fade + spike',
            ],
            [
                'image' => asset('images/frontend/hottrend/hottrend-06.png'),
                'alt' => 'Undercut mái bạc khói, đường hard part',
                'label' => 'Undercut + hard part',
            ],
        ];
    @endphp

    <section id="hot-trend" class="scroll-mt-24 bg-gradient-to-b from-zen-bg-soft via-zen-bg-soft to-white px-4 py-16 sm:px-6">
        <div class="mx-auto max-w-6xl">
            <div class="text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">ZenStyle picks</p>
                <h2 class="mt-2 text-2xl font-semibold text-zen-text sm:text-3xl">Hot trend tóc</h2>
                <p class="mx-auto mt-2 max-w-2xl text-sm text-zen-muted sm:text-base">
                    Các kiểu mẫu đang được yêu thích — tham khảo và đặt lịch tư vấn cùng stylist.
                </p>
            </div>

            {{-- Hai hàng × 3 cột: chia đều 33% · 33% · 33% --}}
            <div class="mt-10 grid grid-cols-1 gap-4 sm:grid-cols-3 sm:gap-5">
                @foreach ($hotTrendStyles as $trend)
                    <figure class="group overflow-hidden rounded-zen-lg border border-zen-border bg-zen-bg-soft shadow-zen">
                        <div class="aspect-square overflow-hidden">
                            <img
                                src="{{ $trend['image'] }}"
                                alt="{{ $trend['alt'] }}"
                                class="h-full w-full object-cover transition duration-500 ease-out group-hover:scale-[1.03]"
                                loading="lazy"
                                decoding="async"
                                sizes="(min-width: 640px) 33vw, 100vw"
                            >
                        </div>
                        <figcaption class="border-t border-zen-border bg-white px-3 py-2.5 text-center text-sm font-medium text-zen-text">
                            {{ $trend['label'] }}
                        </figcaption>
                    </figure>
                @endforeach
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

</x-frontend.layout>
