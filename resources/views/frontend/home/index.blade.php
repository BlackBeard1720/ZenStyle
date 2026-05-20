<x-frontend.layout title="ZenStyle — Trang chủ" main-class="pt-0">
    {{--
        Nền trang chủ — luồng hợp lý:
        stone-50 (canvas đồng bộ body) → band trắng (#dịch vụ, #đặt-lịch) → capsule rose nhấn trong CTA.
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
        <div class="pointer-events-none absolute bottom-0 left-0 right-0 text-stone-50" aria-hidden="true">
            <svg class="block h-12 w-full sm:h-16" viewBox="0 0 1440 100" preserveAspectRatio="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path fill="currentColor" d="M0,48 C240,95 480,5 720,58 C960,112 1200,18 1440,52 L1440,100 L0,100 Z"/>
            </svg>
        </div>
    </section>

    @php
        $featuredServices = [
            [
                'slug' => 'cat-toc-nam-cao-cap',
                'title' => 'Cắt tóc nam cao cấp',
                'desc' => 'Tư vấn form tóc, xử lý độ dài và hoàn thiện styling phù hợp khuôn mặt.',
                'duration' => '45 phút',
                'price' => 'Từ 150.000đ',
                'image' => asset('images/frontend/services/featured-toc.png'),
                'alt' => 'Dịch vụ cắt tóc nam cao cấp tại ZenStyle',
            ],
            [
                'slug' => 'goi-duong-sinh-chuyen-sau',
                'title' => 'Gội dưỡng sinh chuyên sâu',
                'desc' => 'Làm sạch da đầu, massage thư giãn và chăm sóc thân tóc theo nhịp nhẹ.',
                'duration' => '75 phút',
                'price' => 'Từ 360.000đ',
                'image' => asset('images/frontend/services/featured-spa.png'),
                'alt' => 'Dịch vụ gội dưỡng sinh chuyên sâu tại ZenStyle',
            ],
            [
                'slug' => 'cham-soc-da-co-ban',
                'title' => 'Chăm sóc da cơ bản',
                'desc' => 'Làm sạch, cân bằng ẩm và tư vấn routine gọn cho da dễ chăm tại nhà.',
                'duration' => '45 phút',
                'price' => 'Từ 300.000đ',
                'image' => asset('images/frontend/services/featured-goi.png'),
                'alt' => 'Dịch vụ chăm sóc da cơ bản tại ZenStyle',
            ],
        ];

        $bookingSteps = [
            ['title' => 'Chọn dịch vụ', 'desc' => 'Xem nhanh thời lượng, giá và ghi chú trước khi quyết định.'],
            ['title' => 'Chọn ngày giờ', 'desc' => 'Lọc khung giờ phù hợp để giữ chỗ tại salon.'],
            ['title' => 'Chọn stylist', 'desc' => 'Ưu tiên stylist quen hoặc để ZenStyle sắp xếp.'],
            ['title' => 'Xác nhận lịch hẹn', 'desc' => 'Nhập thông tin, xác nhận OTP và nhận tóm tắt lịch.'],
        ];

        $hotTrendStyles = [
            [
                'image' => asset('images/frontend/hottrend/hottrend-01.png'),
                'alt' => 'Kiểu tóc spike texture',
                'label' => 'Spike texture',
            ],
            [
                'image' => asset('images/frontend/hottrend/hottrend-03.png'),
                'alt' => 'Kiểu tóc textured crop',
                'label' => 'Textured crop',
            ],
            [
                'image' => asset('images/frontend/hottrend/hottrend-04.png'),
                'alt' => 'Kiểu tóc wolf cut mullet',
                'label' => 'Wolf cut / Mullet',
            ],
            [
                'image' => asset('images/frontend/hottrend/hottrend-06.png'),
                'alt' => 'Kiểu tóc undercut hard part',
                'label' => 'Undercut hard part',
            ],
        ];

        $reasons = [
            ['title' => 'Lịch hẹn rõ ràng, hạn chế chờ đợi', 'desc' => 'Khung giờ được chọn trước để salon chuẩn bị nhân sự và ghế làm.'],
            ['title' => 'Dịch vụ có thời lượng và giá minh bạch', 'desc' => 'Mỗi dịch vụ đều có thông tin cơ bản để bạn dễ so sánh.'],
            ['title' => 'Stylist tư vấn theo tình trạng tóc', 'desc' => 'Form tóc, nền màu và thói quen chăm sóc được hỏi trước khi làm.'],
            ['title' => 'Không gian chăm sóc thư giãn', 'desc' => 'Nhịp phục vụ nhẹ, màu sắc ấm và khu vực gội/spa tách khỏi cảm giác vội.'],
        ];
    @endphp

    <section id="gioi-thieu" class="scroll-mt-24 bg-stone-50 px-4 py-14 sm:px-6 lg:py-16">
        <div class="mx-auto grid max-w-6xl gap-8 lg:grid-cols-[minmax(0,1fr)_26rem] lg:items-center">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-zen-primary">ZENSTYLE SALON</p>
                <h2 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold leading-tight text-zen-text sm:text-4xl">
                    Làm đẹp gọn gàng, đặt lịch rõ ràng
                </h2>
                <p class="mt-4 max-w-2xl text-sm leading-7 text-zen-muted sm:text-base">
                    ZenStyle kết hợp dịch vụ tóc, gội dưỡng và spa thư giãn trong một quy trình dễ chọn, dễ đặt và dễ theo dõi.
                </p>
                <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('booking') }}" class="inline-flex w-fit items-center justify-center rounded-full bg-zen-primary px-6 py-3 text-sm font-semibold text-white shadow-zen transition hover:bg-zen-primary-dark">
                        Đặt lịch ngay
                    </a>
                    <a href="{{ route('services') }}" class="inline-flex w-fit items-center justify-center rounded-full border border-zen-primary bg-white px-6 py-3 text-sm font-semibold text-zen-primary transition hover:bg-zen-accent-soft">
                        Xem dịch vụ
                    </a>
                </div>
            </div>

            <div class="rounded-zen-lg border border-zen-border bg-white/80 p-5 shadow-zen">
                <ul class="space-y-4">
                    @foreach ([
                        'Tư vấn theo tình trạng tóc',
                        'Hiển thị rõ thời lượng và giá',
                        'Chọn stylist và khung giờ phù hợp',
                    ] as $index => $item)
                        <li class="flex gap-3">
                            <span class="mt-0.5 grid size-7 shrink-0 place-items-center rounded-full bg-zen-accent-soft text-xs font-semibold text-zen-primary">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <span class="pt-1 text-sm font-medium text-zen-text">{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    <section id="dich-vu" class="scroll-mt-24 border-y border-zen-border bg-white px-4 py-14 sm:px-6 lg:py-16">
        <div class="mx-auto max-w-6xl">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Dịch vụ nổi bật</p>
                    <h2 class="mt-2 font-['Playfair_Display',serif] text-3xl font-semibold text-zen-text sm:text-4xl">
                        Những lựa chọn được đặt nhiều tại ZenStyle
                    </h2>
                </div>
                <p class="max-w-md text-sm leading-6 text-zen-muted sm:text-right">
                    Mỗi dịch vụ đều có thời lượng, giá tham khảo và trang chi tiết riêng để bạn xem trước khi đặt.
                </p>
            </div>

            <div class="mt-8 grid gap-5 md:grid-cols-3">
                @foreach ($featuredServices as $service)
                    <article class="group flex h-full flex-col overflow-hidden rounded-zen-lg border border-zen-border bg-zen-bg shadow-zen transition hover:-translate-y-1 hover:shadow-zen-md">
                        <a href="{{ route('services.show', $service['slug']) }}" class="block overflow-hidden bg-zen-bg-soft">
                            <img
                                src="{{ $service['image'] }}"
                                alt="{{ $service['alt'] }}"
                                class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-[1.035]"
                                loading="lazy"
                                decoding="async"
                            >
                        </a>
                        <div class="flex flex-1 flex-col p-5">
                            <h3 class="text-lg font-semibold text-zen-text">{{ $service['title'] }}</h3>
                            <p class="mt-2 text-sm leading-6 text-zen-muted">{{ $service['desc'] }}</p>
                            <div class="mt-5 grid grid-cols-2 gap-3 border-t border-zen-border pt-4 text-sm font-semibold text-zen-primary">
                                <span>{{ $service['duration'] }}</span>
                                <span class="text-right">{{ $service['price'] }}</span>
                            </div>
                            <a href="{{ route('services.show', $service['slug']) }}" class="mt-5 inline-flex text-sm font-semibold text-zen-primary transition hover:text-zen-primary-dark">
                                Xem chi tiết
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <a href="{{ route('services') }}" class="inline-flex rounded-full border border-zen-primary bg-white px-7 py-3 text-sm font-semibold text-zen-primary transition hover:bg-zen-accent-soft">
                    Xem bảng dịch vụ
                </a>
                <a href="{{ route('booking') }}" class="inline-flex rounded-full bg-zen-primary px-7 py-3 text-sm font-semibold text-white shadow-zen transition hover:bg-zen-primary-dark">
                    Đặt lịch ngay
                </a>
            </div>
        </div>
    </section>

    <section class="bg-zen-bg-soft px-4 py-14 sm:px-6 lg:py-16">
        <div class="mx-auto max-w-6xl">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Quy trình</p>
                <h2 class="mt-2 font-['Playfair_Display',serif] text-3xl font-semibold text-zen-text sm:text-4xl">
                    Đặt lịch tại ZenStyle như thế nào?
                </h2>
            </div>

            <ol class="relative mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <span class="absolute left-0 right-0 top-5 hidden h-px bg-zen-border lg:block" aria-hidden="true"></span>
                @foreach ($bookingSteps as $step)
                    <li class="relative rounded-zen-md border border-zen-border bg-white/80 p-5 shadow-sm">
                        <span class="grid size-9 place-items-center rounded-full border border-zen-primary/25 bg-zen-bg text-xs font-semibold text-zen-primary">
                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </span>
                        <h3 class="mt-4 font-semibold text-zen-text">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm leading-6 text-zen-muted">{{ $step['desc'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <section id="hot-trend" class="scroll-mt-24 bg-white px-4 py-14 sm:px-6 lg:py-16">
        <div class="mx-auto max-w-6xl">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Hot trend tóc</p>
                    <h2 class="mt-2 font-['Playfair_Display',serif] text-3xl font-semibold text-zen-text sm:text-4xl">
                        Gợi ý kiểu tóc trước buổi tư vấn
                    </h2>
                </div>
                <p class="max-w-md text-sm leading-6 text-zen-muted sm:text-right">
                    Tham khảo kiểu tóc trước khi đặt lịch tư vấn cùng stylist.
                </p>
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($hotTrendStyles as $trend)
                    <figure class="group overflow-hidden rounded-zen-lg border border-zen-border bg-zen-bg shadow-zen">
                        <div class="aspect-[4/5] overflow-hidden bg-zen-bg-soft">
                            <img
                                src="{{ $trend['image'] }}"
                                alt="{{ $trend['alt'] }}"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.035]"
                                loading="lazy"
                                decoding="async"
                            >
                        </div>
                        <figcaption class="border-t border-zen-border bg-white px-4 py-3 text-sm font-semibold text-zen-text">
                            {{ $trend['label'] }}
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-gradient-to-b from-zen-bg-soft to-white px-4 py-14 sm:px-6 lg:py-16">
        <div class="mx-auto grid max-w-6xl gap-8 lg:grid-cols-[0.85fr_1.15fr] lg:items-start">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Vì sao chọn ZenStyle?</p>
                <h2 class="mt-2 font-['Playfair_Display',serif] text-3xl font-semibold text-zen-text sm:text-4xl">
                    Một buổi hẹn rõ ràng từ lúc chọn dịch vụ
                </h2>
                <p class="mt-4 text-sm leading-7 text-zen-muted sm:text-base">
                    Trang chủ không cần nói quá nhiều. ZenStyle tập trung vào vài điều khách thật sự cần biết trước khi đến salon.
                </p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                @foreach ($reasons as $reason)
                    <article class="rounded-zen-md border border-zen-border bg-white p-5 shadow-sm">
                        <span class="text-xs font-semibold uppercase tracking-[0.18em] text-zen-primary">
                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </span>
                        <h3 class="mt-3 font-semibold text-zen-text">{{ $reason['title'] }}</h3>
                        <p class="mt-2 text-sm leading-6 text-zen-muted">{{ $reason['desc'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white px-4 py-14 sm:px-6 lg:py-16">
        <div class="mx-auto max-w-6xl overflow-hidden rounded-zen-lg border border-zen-border bg-zen-bg-dark p-8 shadow-zen-md sm:p-10 lg:p-12">
            <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-center">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-accent-soft">ZenStyle booking</p>
                    <h2 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold text-white sm:text-4xl">
                        Sẵn sàng làm mới diện mạo của bạn?
                    </h2>
                    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-white/75 sm:text-base">
                        Chọn dịch vụ, khung giờ và stylist phù hợp chỉ trong vài bước.
                    </p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row lg:flex-col">
                    <a href="{{ route('booking') }}" class="inline-flex items-center justify-center rounded-full bg-white px-6 py-3 text-sm font-semibold text-zen-bg-dark transition hover:bg-zen-accent-soft">
                        Đặt lịch ngay
                    </a>
                    <a href="{{ route('services') }}" class="inline-flex items-center justify-center rounded-full border border-white/35 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                        Xem dịch vụ
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-frontend.layout>
