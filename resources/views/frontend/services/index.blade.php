<x-frontend.layout title="ZenStyle — Dịch vụ" main-class="pt-0">
    @php
        $heroImage = asset('images/frontend/banner/Gemini_Generated_Image_6hfrq56hfrq56hfr.png');

        $services = [
            [
                'slug' => 'cat-toc-nam-cao-cap',
                'name' => 'Cắt tóc nam cao cấp',
                'duration' => '45 phút',
                'price' => '150.000đ',
                'desc' => 'Tư vấn form tóc, cắt tạo kiểu và hoàn thiện styling phù hợp khuôn mặt.',
                'image' => asset('images/frontend/hottrend/hottrend-06.png'),
            ],
            [
                'slug' => 'tao-kieu-su-kien',
                'name' => 'Tạo kiểu sự kiện',
                'duration' => '45-60 phút',
                'price' => 'Từ 220.000đ',
                'desc' => 'Sấy, vuốt, tạo texture hoặc giữ nếp cho lịch gặp gỡ, chụp hình, tiệc.',
                'image' => asset('images/frontend/hottrend/hottrend-07.png'),
            ],
            [
                'slug' => 'cat-goi-thu-gian',
                'name' => 'Cắt + gội thư giãn',
                'duration' => '75 phút',
                'price' => '250.000đ',
                'desc' => 'Kết hợp cắt tóc, gội làm sạch và massage da đầu nhẹ trước khi styling.',
                'image' => asset('images/frontend/services/featured-spa.png'),
            ],
            [
                'slug' => 'nhuom-tone-co-ban',
                'name' => 'Nhuộm tone cơ bản',
                'duration' => '90-120 phút',
                'price' => 'Từ 650.000đ',
                'desc' => 'Tư vấn màu theo nền tóc, màu da và lịch chăm sóc tại nhà.',
                'image' => asset('images/frontend/banner/Gemini_Generated_Image_7sr4oq7sr4oq7sr4.png'),
            ],
            [
                'slug' => 'uon-texture',
                'name' => 'Uốn texture',
                'duration' => '120 phút',
                'price' => 'Từ 720.000đ',
                'desc' => 'Tạo độ phồng, lọn tự nhiên và form dễ chăm cho tóc nam hoặc tóc ngắn.',
                'image' => asset('images/frontend/banner/Gemini_Generated_Image_7w6kln7w6kln7w6k.png'),
            ],
            [
                'slug' => 'balayage-highlight',
                'name' => 'Balayage / highlight',
                'duration' => '150 phút+',
                'price' => 'Tư vấn tại salon',
                'desc' => 'Thiết kế mảng sáng tối theo tóc thật, tránh xử lý quá tay trong một lần.',
                'image' => asset('images/frontend/banner/Gemini_Generated_Image_os1lsdos1lsdos1l.png'),
            ],
            [
                'slug' => 'goi-massage-da-dau',
                'name' => 'Gội + massage da đầu',
                'duration' => '30 phút',
                'price' => '120.000đ',
                'desc' => 'Làm sạch nhẹ, massage da đầu và cổ vai gáy ngắn để giảm căng.',
                'image' => asset('images/frontend/services/featured-spa.png'),
            ],
            [
                'slug' => 'treatment-phuc-hoi',
                'name' => 'Treatment phục hồi',
                'duration' => '60 phút',
                'price' => '320.000đ',
                'desc' => 'Bổ sung dưỡng chất cho tóc khô, xơ hoặc vừa trải qua uốn nhuộm.',
                'image' => asset('images/frontend/banner/Gemini_Generated_Image_ympfunympfunympf.png'),
            ],
            [
                'slug' => 'goi-duong-sinh-chuyen-sau',
                'name' => 'Gội dưỡng sinh chuyên sâu',
                'duration' => '75 phút',
                'price' => 'Từ 360.000đ',
                'desc' => 'Kết hợp làm sạch da đầu, massage thư giãn và chăm sóc thân tóc.',
                'image' => asset('images/frontend/services/featured-goi.png'),
            ],
            [
                'slug' => 'massage-co-vai-gay',
                'name' => 'Massage cổ vai gáy',
                'duration' => '30-45 phút',
                'price' => 'Từ 220.000đ',
                'desc' => 'Tập trung vùng cổ, vai, gáy cho khách ngồi máy tính hoặc di chuyển nhiều.',
                'image' => asset('images/frontend/services/featured-goi.png'),
            ],
            [
                'slug' => 'cham-soc-da-co-ban',
                'name' => 'Chăm sóc da cơ bản',
                'duration' => '45 phút',
                'price' => 'Từ 300.000đ',
                'desc' => 'Làm sạch, cân bằng ẩm và tư vấn chu trình chăm sóc đơn giản tại nhà.',
                'image' => asset('images/frontend/banner/Gemini_Generated_Image_6hfrq56hfrq56hfr.png'),
            ],
            [
                'slug' => 'combo-thu-gian-cuoi-tuan',
                'name' => 'Combo thư giãn cuối tuần',
                'duration' => '120 phút',
                'price' => 'Từ 790.000đ',
                'desc' => 'Phối hợp gội thư giãn, treatment và massage để có trải nghiệm đầy đủ hơn.',
                'image' => asset('images/frontend/banner/Gemini_Generated_Image_7sr4oq7sr4oq7sr4.png'),
            ],
        ];

        $staff = [
            [
                'name' => 'Nguyễn Minh An',
                'role' => 'Salon Director',
                'focus' => 'Tư vấn form tóc và trải nghiệm tổng thể',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Trần Lan Chi',
                'role' => 'Senior Stylist',
                'focus' => 'Layer, mullet và tạo kiểu cá nhân hóa',
                'image' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Phạm Thu Hà',
                'role' => 'Spa & Treatment',
                'focus' => 'Gội thư giãn, treatment và chăm sóc da đầu',
                'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=800&q=80',
            ],
        ];

        $testimonials = [
            [
                'quote' => 'Tư vấn rất kỹ trước khi cắt, mình biết rõ tóc sẽ vào form thế nào sau khi về nhà.',
                'name' => 'Minh Khang',
                'service' => 'Cắt tóc nam cao cấp',
            ],
            [
                'quote' => 'Gói gội thư giãn vừa đủ lâu, không gian yên và tóc mềm hơn sau treatment.',
                'name' => 'Thu Nhi',
                'service' => 'Gội dưỡng sinh',
            ],
            [
                'quote' => 'Màu nhuộm lên vừa phải, team có dặn cách giữ màu nên sau vài tuần vẫn ổn.',
                'name' => 'Hoàng Anh',
                'service' => 'Nhuộm tone cơ bản',
            ],
        ];
    @endphp

    <section
        id="site-banner"
        class="relative min-h-[78vh] overflow-hidden bg-zen-bg-dark"
        aria-label="Dịch vụ ZenStyle"
    >
        <img
            src="{{ $heroImage }}"
            alt="Không gian salon ZenStyle"
            class="absolute inset-0 h-full w-full object-cover object-center"
            loading="eager"
        >
        <div class="absolute inset-0 bg-gradient-to-r from-zen-bg-dark/75 via-zen-bg-dark/30 to-transparent"></div>
        <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-zen-bg to-transparent"></div>

        <div class="relative mx-auto flex min-h-[78vh] max-w-6xl items-center px-4 pb-20 pt-32 sm:px-6 lg:pb-24">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-zen-accent-soft">Dịch vụ ZenStyle</p>
                <h1 class="mt-4 font-['Playfair_Display',serif] text-4xl font-semibold leading-tight text-white sm:text-5xl lg:text-6xl">
                    Dịch vụ ZenStyle
                </h1>
                <p class="mt-5 max-w-xl text-sm leading-relaxed text-white/85 sm:text-base">
                    Từ cắt tạo kiểu, màu tóc, phục hồi đến gội thư giãn, từng dịch vụ được tách riêng để bạn dễ xem thời lượng, giá và mô tả trước khi đặt lịch.
                </p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a
                        href="#service-list"
                        class="inline-flex w-fit items-center justify-center rounded-full bg-zen-bg px-5 py-3 text-sm font-semibold text-zen-text shadow-zen transition hover:bg-zen-accent-soft"
                    >
                        Xem bảng dịch vụ
                    </a>
                    <a
                        href="{{ route('booking') }}"
                        class="booking-cta inline-flex w-fit rounded-full px-6 py-3 text-sm font-semibold focus:outline-none focus-visible:ring-2 focus-visible:ring-zen-primary/50 focus-visible:ring-offset-2"
                    >
                        Đặt lịch ngay
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="service-list" class="scroll-mt-24 border-y border-zen-border bg-white px-4 py-16 sm:px-6 lg:py-20">
        <div class="mx-auto max-w-6xl">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary-dark">Bảng dịch vụ</p>
                    <h2 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold leading-tight text-zen-text sm:text-4xl">
                        Dịch vụ cung cấp
                    </h2>
                </div>
                <p class="max-w-md text-sm leading-relaxed text-zen-muted sm:text-right">
                    Giá có thể thay đổi tùy tình trạng tóc, độ dài và tư vấn tại salon.
                </p>
            </div>

            <div class="mt-10 grid gap-x-6 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $service)
                    <article
                        id="service-{{ $service['slug'] }}"
                        class="group scroll-mt-28"
                    >
                        <a href="{{ route('booking') }}" class="block h-full rounded-zen-lg outline-none transition duration-300 hover:-translate-y-1 focus-visible:ring-2 focus-visible:ring-zen-primary/40 focus-visible:ring-offset-4">
                            <div class="relative aspect-[4/3] overflow-hidden rounded-zen-lg bg-zen-bg-soft shadow-zen">
                                <img
                                    src="{{ $service['image'] }}"
                                    alt="{{ $service['name'] }}"
                                    class="h-full w-full object-cover transition duration-500 ease-out group-hover:scale-[1.04]"
                                    loading="lazy"
                                    decoding="async"
                                >
                                <svg class="pointer-events-none absolute -bottom-px left-0 h-16 w-full text-white" viewBox="0 0 420 80" preserveAspectRatio="none" aria-hidden="true">
                                    <path fill="currentColor" d="M0 55C58 38 98 24 154 35C209 46 257 78 315 68C358 61 386 39 420 31V80H0V55Z" />
                                </svg>
                            </div>
                            <div class="-mt-1 px-4 pb-2 pt-5 text-center">
                                <h3 class="mx-auto flex min-h-[3.5rem] max-w-xs items-center justify-center font-['Playfair_Display',serif] text-xl font-semibold uppercase leading-tight text-zen-text">
                                    {{ $service['name'] }}
                                </h3>
                                <p class="mx-auto mt-3 min-h-[4rem] max-w-xs text-sm leading-relaxed text-zen-muted">
                                    {{ $service['desc'] }}
                                </p>
                                <div class="mx-auto mt-5 grid max-w-xs grid-cols-[minmax(0,1fr)_auto_minmax(0,1fr)] items-center gap-4 border-t border-zen-border pt-3 text-sm font-semibold text-zen-primary">
                                    <span>{{ $service['duration'] }}</span>
                                    <span class="h-4 w-px bg-zen-border-dark" aria-hidden="true"></span>
                                    <span>{{ $service['price'] }}</span>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-gradient-to-b from-zen-bg-soft via-zen-bg-soft to-white px-4 py-16 sm:px-6 lg:py-20">
        <div class="mx-auto max-w-6xl">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary-dark">Đội ngũ</p>
                    <h2 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold text-zen-text sm:text-4xl">
                        Người đồng hành trong buổi hẹn của bạn.
                    </h2>
                </div>
                <a href="{{ route('about') }}" class="text-sm font-semibold text-zen-primary hover:text-zen-primary-dark">Tìm hiểu thêm</a>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3">
                @foreach ($staff as $member)
                    <article class="overflow-hidden rounded-zen-lg border border-zen-border bg-white shadow-zen transition hover:-translate-y-1 hover:shadow-zen-md">
                        <div class="aspect-[4/3] overflow-hidden bg-zen-bg-soft">
                            <img
                                src="{{ $member['image'] }}"
                                alt="{{ $member['name'] }}"
                                class="h-full w-full object-cover transition duration-500 hover:scale-[1.03]"
                                loading="lazy"
                            >
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-semibold text-zen-text">{{ $member['name'] }}</h3>
                            <p class="mt-1 text-sm font-medium text-zen-primary">{{ $member['role'] }}</p>
                            <p class="mt-3 text-sm leading-relaxed text-zen-muted">{{ $member['focus'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white px-4 py-16 sm:px-6 lg:py-20">
        <div class="mx-auto max-w-6xl">
            <div class="grid gap-10 lg:grid-cols-12 lg:items-start">
                <div class="lg:col-span-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary-dark">Cảm nhận khách hàng</p>
                    <h2 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold text-zen-text sm:text-4xl">
                        Những phản hồi sau buổi hẹn.
                    </h2>
                </div>
                <div class="grid gap-4 md:grid-cols-3 lg:col-span-8">
                    @foreach ($testimonials as $testimonial)
                        <figure class="rounded-zen-lg border border-zen-border bg-zen-bg p-5 shadow-zen">
                            <blockquote class="text-sm leading-relaxed text-zen-muted">
                                “{{ $testimonial['quote'] }}”
                            </blockquote>
                            <figcaption class="mt-5 border-t border-zen-border pt-4">
                                <p class="font-semibold text-zen-text">{{ $testimonial['name'] }}</p>
                                <p class="mt-1 text-xs font-medium uppercase tracking-[0.14em] text-zen-primary">{{ $testimonial['service'] }}</p>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

</x-frontend.layout>
