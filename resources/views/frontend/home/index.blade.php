<x-frontend.layout title="ZenStyle — Trang chủ" main-class="pt-0">
    {{--
        Redesign: Chuyển từ "ép booking" sang "tham quan salon"
        Cấu trúc: Hero → Greeting → Services Discovery → Salon Space → Hot Trend → Experience Flow → Final CTA
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

        $serviceGroups = [
            [
                'title' => 'Tóc & tạo kiểu',
                'description' => 'Cắt, uốn texture, tạo kiểu sự kiện.',
                'image' => asset('images/frontend/services/featured-toc.png'),
                'alt' => 'Dịch vụ tóc và tạo kiểu tại ZenStyle',
                'items' => ['Cắt tóc nam', 'Uốn texture', 'Tạo kiểu sự kiện'],
            ],
            [
                'title' => 'Gội dưỡng & phục hồi',
                'description' => 'Gội thư giãn, massage da đầu, chăm sóc thân tóc.',
                'image' => asset('images/frontend/services/featured-spa.png'),
                'alt' => 'Dịch vụ gội dưỡng và phục hồi tại ZenStyle',
                'items' => ['Gội thư giãn', 'Massage da đầu', 'Chăm sóc thân tóc'],
            ],
            [
                'title' => 'Spa & chăm sóc da',
                'description' => 'Chăm sóc da cơ bản, thư giãn vùng vai gáy.',
                'image' => asset('images/frontend/services/featured-goi.png'),
                'alt' => 'Dịch vụ spa và chăm sóc da tại ZenStyle',
                'items' => ['Chăm sóc da cơ bản', 'Thư giãn vai gáy', 'Tư vấn routine'],
            ],
        ];

        $salonImages = [
            asset('images/frontend/banner/Gemini_Generated_Image_6hfrq56hfrq56hfr.png'),
            asset('images/frontend/banner/Gemini_Generated_Image_7sr4oq7sr4oq7sr4.png'),
            asset('images/frontend/banner/Gemini_Generated_Image_7w6kln7w6kln7w6k.png'),
            asset('images/frontend/banner/Gemini_Generated_Image_os1lsdos1lsdos1l.png'),
        ];

        $hotTrendImages = [
            asset('images/frontend/hottrend/hottrend-01.png'),
            asset('images/frontend/hottrend/hottrend-02.png'),
            asset('images/frontend/hottrend/hottrend-03.png'),
        ];

        $experienceSteps = [
            ['title' => 'Tham khảo dịch vụ', 'desc' => 'Xem nhóm dịch vụ, phong cách và đội ngũ phù hợp với nhu cầu.'],
            ['title' => 'Chọn thời gian phù hợp', 'desc' => 'Giữ khung giờ mà bạn muốn và chọn stylist nếu cần.'],
            ['title' => 'Đến salon và được tư vấn', 'desc' => 'Stylist sẽ tư vấn kỹ tình trạng tóc/da trước khi thực hiện.'],
        ];
    @endphp

    {{-- ===== HERO / BANNER ===== --}}
    <section
        id="site-banner"
        class="relative min-h-screen w-full overflow-hidden bg-stone-900"
        aria-label="ZenStyle Banner">
        <div class="pointer-events-none absolute inset-0 z-10 bg-gradient-to-b from-stone-900/40 via-stone-900/20 to-stone-900/60"></div>

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

        <div class="pointer-events-none absolute bottom-0 left-0 right-0 text-stone-50" aria-hidden="true">
            <svg class="block h-12 w-full sm:h-16" viewBox="0 0 1440 100" preserveAspectRatio="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path fill="currentColor" d="M0,48 C240,95 480,5 720,58 C960,112 1200,18 1440,52 L1440,100 L0,100 Z"/>
            </svg>
        </div>
    </section>

    {{-- ===== SECTION 1: GREETING ===== --}}
    <section class="scroll-mt-24 bg-stone-50 px-4 py-12 sm:px-6 lg:py-16">
        <div class="mx-auto max-w-6xl">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">ZenStyle Salon</p>
            <h2 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold leading-tight text-zen-text sm:text-4xl">
                Một không gian để bạn thư giãn và làm mới diện mạo
            </h2>
            <p class="mt-4 max-w-2xl text-sm leading-7 text-zen-muted sm:text-base">
                ZenStyle kết hợp dịch vụ tóc, gội dưỡng và spa trong một không gian nhẹ nhàng. Hãy khám phá dịch vụ, xem không gian và gặp gỡ đội ngũ trước khi đặt lịch.
            </p>
            <div class="mt-6 flex flex-wrap gap-3 sm:gap-4">
                <a href="#dich-vu" class="inline-flex items-center justify-center rounded-full bg-zen-primary px-6 py-3 text-sm font-semibold text-white transition hover:bg-zen-primary-dark">
                    Khám phá dịch vụ
                </a>
                <a href="#khong-gian" class="inline-flex items-center justify-center rounded-full border border-zen-primary px-6 py-3 text-sm font-semibold text-zen-primary transition hover:bg-zen-primary/5">
                    Xem không gian
                </a>
            </div>
        </div>
    </section>

    {{-- ===== SECTION 2: SERVICE DISCOVERY ===== --}}
    <section id="dich-vu" class="scroll-mt-24 bg-white px-4 py-12 sm:px-6 lg:py-16">
        <div class="mx-auto max-w-6xl">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Dịch vụ</p>
                <h2 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold leading-tight text-zen-text sm:text-4xl">
                    Khám phá dịch vụ tại ZenStyle
                </h2>
                <p class="mt-4 text-sm leading-7 text-zen-muted sm:text-base">
                    Từ chăm sóc tóc, gội dưỡng đến spa thư giãn, mỗi dịch vụ được trình bày rõ để bạn dễ tham khảo.
                </p>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3">
                @foreach ($serviceGroups as $group)
                    <article class="rounded-zen-lg border border-zen-border bg-stone-50 p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                        <img
                            src="{{ $group['image'] }}"
                            alt="{{ $group['alt'] }}"
                            class="aspect-video w-full rounded-zen-md object-cover"
                            loading="lazy"
                            decoding="async"
                        >
                        <h3 class="mt-4 text-lg font-semibold text-zen-text">{{ $group['title'] }}</h3>
                        <p class="mt-2 text-sm leading-6 text-zen-muted">{{ $group['description'] }}</p>
                        <ul class="mt-4 space-y-2">
                            @foreach ($group['items'] as $item)
                                <li class="flex gap-2 text-sm text-zen-muted">
                                    <span class="mt-1.5 size-1 flex-shrink-0 rounded-full bg-zen-primary/70"></span>
                                    <span>{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('services') }}" class="mt-4 inline-flex text-sm font-semibold text-zen-primary transition hover:text-zen-primary-dark">
                            Xem dịch vụ →
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== SECTION 3: SALON SPACE GALLERY ===== --}}
    <section id="khong-gian" class="scroll-mt-24 bg-zen-bg-soft px-4 py-12 sm:px-6 lg:py-14">
        <div class="mx-auto max-w-6xl">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Không gian</p>
                <h2 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold leading-tight text-zen-text sm:text-4xl">
                    Không gian chăm sóc nhẹ nhàng
                </h2>
                <p class="mt-4 text-sm leading-7 text-zen-muted sm:text-base">
                    ZenStyle hướng tới cảm giác sạch, yên tĩnh và dễ thư giãn trong từng buổi hẹn.
                </p>
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($salonImages as $image)
                    <div class="group relative overflow-hidden rounded-lg border border-zen-border/40 shadow-sm transition hover:shadow-md">
                        <img
                            src="{{ $image }}"
                            alt="Không gian ZenStyle"
                            class="aspect-[4/3] w-full object-cover transition duration-300 group-hover:scale-105"
                            loading="lazy"
                            decoding="async"
                        >
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== SECTION 4: HOT TREND / INSPIRATION ===== --}}
    <section class="bg-white px-4 py-12 sm:px-6 lg:py-16">
        <div class="mx-auto max-w-6xl">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Cảm hứng</p>
                <h2 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold leading-tight text-zen-text sm:text-4xl">
                    Cảm hứng kiểu tóc
                </h2>
                <p class="mt-4 text-sm leading-7 text-zen-muted sm:text-base">
                    Tham khảo một vài phong cách trước khi ghé salon.
                </p>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3">
                @foreach ($hotTrendImages as $image)
                    <div class="group relative overflow-hidden rounded-zen-lg border border-zen-border shadow-sm transition hover:shadow-md">
                        <img
                            src="{{ $image }}"
                            alt="Phong cách tóc ZenStyle"
                            class="aspect-square w-full object-cover transition group-hover:scale-105"
                            loading="lazy"
                            decoding="async"
                        >
                    </div>
                @endforeach
            </div>

            <div class="mt-6 text-center sm:text-left">
                <a href="{{ route('hot-trend.index') }}" class="inline-flex text-sm font-semibold text-zen-primary transition hover:text-zen-primary-dark">
                    Xem Hot Trend →
                </a>
            </div>
        </div>
    </section>

    {{-- ===== SECTION 5: EXPERIENCE FLOW ===== --}}
    <section class="bg-zen-bg-soft px-4 py-12 sm:px-6 lg:py-16">
        <div class="mx-auto max-w-6xl">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Quy trình</p>
                <h2 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold leading-tight text-zen-text sm:text-4xl">
                    Một buổi hẹn tại ZenStyle diễn ra thế nào?
                </h2>
            </div>

            <ol class="mt-10 grid gap-6 lg:grid-cols-3">
                @foreach ($experienceSteps as $step)
                    <li class="rounded-zen-lg border border-zen-border bg-white p-6">
                        <p class="text-2xl font-bold text-zen-primary/60">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</p>
                        <h3 class="mt-3 text-base font-semibold text-zen-text">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm leading-6 text-zen-muted">{{ $step['desc'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- ===== SECTION 6: FINAL CTA ===== --}}
    <section class="bg-white px-4 py-12 sm:px-6 lg:py-16">
        <div class="mx-auto max-w-6xl rounded-zen-lg border border-zen-border/50 bg-zen-bg-soft p-6 shadow-sm sm:p-8">
            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-center">
                <div>
                    <h2 class="font-['Playfair_Display',serif] text-3xl font-semibold text-zen-text sm:text-4xl">
                        Khi bạn đã sẵn sàng, ZenStyle luôn sẵn lịch hẹn
                    </h2>
                    <p class="mt-3 max-w-2xl text-sm leading-7 text-zen-muted sm:text-base">
                        Xem dịch vụ, chọn stylist và đặt lịch trong vài bước đơn giản.
                    </p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('booking') }}" class="inline-flex items-center justify-center rounded-full bg-zen-primary px-6 py-3 text-sm font-semibold text-white transition hover:bg-zen-primary-dark">
                        Đặt lịch ngay
                    </a>
                    <a href="{{ route('services') }}" class="inline-flex items-center justify-center rounded-full border border-zen-primary px-6 py-3 text-sm font-semibold text-zen-primary transition hover:bg-zen-primary/5">
                        Xem dịch vụ
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-frontend.layout>
