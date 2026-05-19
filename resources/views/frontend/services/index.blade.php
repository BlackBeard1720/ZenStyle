<x-frontend.layout title="ZenStyle — Dịch vụ" main-class="pt-0">
    @php
        $heroImage = asset('images/frontend/banner/Gemini_Generated_Image_6hfrq56hfrq56hfr.png');

        $serviceGroups = [
            [
                'title' => 'Tóc & tạo kiểu',
                'summary' => 'Cắt, tạo form và hoàn thiện phong cách theo chất tóc thật.',
                'image' => asset('images/frontend/services/featured-toc.png'),
                'items' => [
                    ['name' => 'Cắt tóc nam cao cấp', 'duration' => '45 phút', 'price' => '150.000đ', 'desc' => 'Tư vấn form tóc, cắt tạo kiểu và hoàn thiện styling phù hợp khuôn mặt.'],
                    ['name' => 'Tạo kiểu sự kiện', 'duration' => '45-60 phút', 'price' => 'Từ 220.000đ', 'desc' => 'Sấy, vuốt, tạo texture hoặc giữ nếp cho lịch gặp gỡ, chụp hình, tiệc.'],
                    ['name' => 'Cắt + gội thư giãn', 'duration' => '75 phút', 'price' => '250.000đ', 'desc' => 'Kết hợp cắt tóc, gội làm sạch và massage da đầu nhẹ trước khi styling.'],
                ],
            ],
            [
                'title' => 'Màu & uốn',
                'summary' => 'Lên màu có kiểm soát, xử lý nền tóc và giữ độ bóng tự nhiên.',
                'image' => asset('images/frontend/banner/Gemini_Generated_Image_7sr4oq7sr4oq7sr4.png'),
                'items' => [
                    ['name' => 'Nhuộm tone cơ bản', 'duration' => '90-120 phút', 'price' => 'Từ 650.000đ', 'desc' => 'Tư vấn màu theo nền tóc, màu da và lịch chăm sóc tại nhà.'],
                    ['name' => 'Uốn texture', 'duration' => '120 phút', 'price' => 'Từ 720.000đ', 'desc' => 'Tạo độ phồng, lọn tự nhiên và form dễ chăm cho tóc nam hoặc tóc ngắn.'],
                    ['name' => 'Balayage / highlight', 'duration' => '150 phút+', 'price' => 'Tư vấn tại salon', 'desc' => 'Thiết kế mảng sáng tối theo tóc thật, tránh xử lý quá tay trong một lần.'],
                ],
            ],
            [
                'title' => 'Gội & phục hồi',
                'summary' => 'Làm sạch, thư giãn da đầu và phục hồi độ mềm của sợi tóc.',
                'image' => asset('images/frontend/services/featured-spa.png'),
                'items' => [
                    ['name' => 'Gội + massage da đầu', 'duration' => '30 phút', 'price' => '120.000đ', 'desc' => 'Làm sạch nhẹ, massage da đầu và cổ vai gáy ngắn để giảm căng.'],
                    ['name' => 'Treatment phục hồi', 'duration' => '60 phút', 'price' => '320.000đ', 'desc' => 'Bổ sung dưỡng chất cho tóc khô, xơ hoặc vừa trải qua uốn nhuộm.'],
                    ['name' => 'Gội dưỡng sinh chuyên sâu', 'duration' => '75 phút', 'price' => 'Từ 360.000đ', 'desc' => 'Kết hợp làm sạch da đầu, massage thư giãn và chăm sóc thân tóc.'],
                ],
            ],
            [
                'title' => 'Spa & chăm sóc',
                'summary' => 'Những khoảng nghỉ ngắn giúp cơ thể nhẹ hơn trước khi quay lại nhịp ngày.',
                'image' => asset('images/frontend/services/featured-goi.png'),
                'items' => [
                    ['name' => 'Massage cổ vai gáy', 'duration' => '30-45 phút', 'price' => 'Từ 220.000đ', 'desc' => 'Tập trung vùng cổ, vai, gáy cho khách ngồi máy tính hoặc di chuyển nhiều.'],
                    ['name' => 'Chăm sóc da cơ bản', 'duration' => '45 phút', 'price' => 'Từ 300.000đ', 'desc' => 'Làm sạch, cân bằng ẩm và tư vấn chu trình chăm sóc đơn giản tại nhà.'],
                    ['name' => 'Combo thư giãn cuối tuần', 'duration' => '120 phút', 'price' => 'Từ 790.000đ', 'desc' => 'Phối hợp gội thư giãn, treatment và massage để có trải nghiệm đầy đủ hơn.'],
                ],
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
                    Từ cắt tạo kiểu, màu tóc, phục hồi đến gội thư giãn, mỗi dịch vụ được sắp xếp thành nhóm rõ ràng để bạn dễ chọn trước khi đặt lịch.
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

    <section class="bg-zen-bg px-4 pb-14 pt-4 sm:px-6 lg:pb-20">
        <div class="mx-auto grid max-w-6xl gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($serviceGroups as $index => $group)
                <a
                    href="#service-group-{{ $index }}"
                    class="group rounded-zen-lg border border-zen-border bg-white p-5 shadow-zen transition hover:-translate-y-1 hover:border-zen-border-dark hover:shadow-zen-md"
                >
                    <span class="text-xs font-semibold uppercase tracking-[0.16em] text-zen-primary">Nhóm {{ $index + 1 }}</span>
                    <h2 class="mt-3 text-lg font-semibold text-zen-text">{{ $group['title'] }}</h2>
                    <p class="mt-2 text-sm leading-relaxed text-zen-muted">{{ $group['summary'] }}</p>
                    <span class="mt-5 inline-flex text-sm font-semibold text-zen-primary group-hover:text-zen-primary-dark">
                        Xem chi tiết
                    </span>
                </a>
            @endforeach
        </div>
    </section>

    <section id="service-list" class="scroll-mt-24 border-y border-zen-border bg-white px-4 py-16 sm:px-6 lg:py-20">
        <div class="mx-auto max-w-6xl">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary-dark">Bảng dịch vụ</p>
                    <h2 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold leading-tight text-zen-text sm:text-4xl">
                        Dịch vụ xếp ngang để dễ so sánh.
                    </h2>
                </div>
                <p class="max-w-md text-sm leading-relaxed text-zen-muted sm:text-right">
                    Kéo ngang để xem thêm nhóm dịch vụ. Giá có thể thay đổi tùy tình trạng tóc, độ dài và tư vấn tại salon.
                </p>
            </div>

            <div class="mt-10 flex snap-x snap-mandatory gap-5 overflow-x-auto pb-4 lg:grid lg:grid-cols-4 lg:overflow-visible lg:pb-0">
                @foreach ($serviceGroups as $index => $group)
                    <article
                        id="service-group-{{ $index }}"
                        class="flex min-w-[84vw] scroll-mt-28 snap-start flex-col overflow-hidden rounded-zen-lg border border-zen-border bg-zen-bg shadow-zen sm:min-w-[22rem] lg:min-w-0"
                    >
                        <div class="aspect-[4/3] overflow-hidden bg-zen-bg-soft">
                            <img
                                src="{{ $group['image'] }}"
                                alt="{{ $group['title'] }}"
                                class="h-full w-full object-cover transition duration-500 hover:scale-[1.03]"
                                loading="lazy"
                            >
                        </div>
                        <div class="flex flex-1 flex-col p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zen-primary">Nhóm {{ $index + 1 }}</p>
                            <h3 class="mt-2 text-xl font-semibold text-zen-text">{{ $group['title'] }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-zen-muted">{{ $group['summary'] }}</p>

                            <div class="mt-5 flex-1 divide-y divide-zen-border border-y border-zen-border bg-white">
                                @foreach ($group['items'] as $item)
                                    <div class="py-4">
                                        <div class="flex items-start justify-between gap-3">
                                            <h4 class="text-sm font-semibold leading-snug text-zen-text">{{ $item['name'] }}</h4>
                                            <span class="shrink-0 rounded-full bg-zen-accent-soft px-2.5 py-1 text-xs font-medium text-zen-primary-dark">{{ $item['duration'] }}</span>
                                        </div>
                                        <p class="mt-2 text-sm leading-relaxed text-zen-muted">{{ $item['desc'] }}</p>
                                        <p class="mt-2 text-sm font-semibold text-zen-primary">{{ $item['price'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
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

    <section class="bg-zen-bg-soft px-4 py-16 sm:px-6 lg:py-20">
        <div class="mx-auto grid max-w-6xl gap-8 lg:grid-cols-12 lg:items-center">
            <div class="lg:col-span-7">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary-dark">Đặt lịch</p>
                <h2 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold leading-tight text-zen-text sm:text-4xl">
                    Sẵn sàng giữ lịch cho buổi chăm sóc tiếp theo?
                </h2>
                <p class="mt-4 text-sm leading-relaxed text-zen-muted">
                    Chọn ngày, khung giờ, dịch vụ và nhân viên mong muốn. Form đặt lịch hiện tại vẫn giữ nguyên luồng thao tác của ZenStyle.
                </p>
            </div>
            <div class="space-y-4 lg:col-span-5">
                <div class="grid gap-3 sm:grid-cols-2">
                    <div class="rounded-zen-md border border-zen-border bg-white p-4">
                        <p class="text-sm font-semibold text-zen-text">Thứ 2 - Thứ 6</p>
                        <p class="mt-1 text-sm text-zen-muted">09:00 - 20:00</p>
                    </div>
                    <div class="rounded-zen-md border border-zen-border bg-white p-4">
                        <p class="text-sm font-semibold text-zen-text">Thứ 7 - Chủ nhật</p>
                        <p class="mt-1 text-sm text-zen-muted">09:30 - 21:00</p>
                    </div>
                </div>
                <a
                    href="{{ route('booking') }}"
                    class="booking-cta inline-flex w-full justify-center rounded-full px-8 py-3 text-sm font-semibold sm:w-auto focus:outline-none focus-visible:ring-2 focus-visible:ring-zen-primary/50 focus-visible:ring-offset-2"
                >
                    Đặt lịch ngay
                </a>
            </div>
        </div>
    </section>
</x-frontend.layout>
