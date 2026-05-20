<x-frontend.layout title="ZenStyle - Giới thiệu" main-class="pt-0">
    @php
        $heroImage = asset('images/frontend/banner/Gemini_Generated_Image_kt0965kt0965kt09.png');
        $stats = [
            ['value' => '4+', 'label' => 'năm phát triển ý tưởng'],
            ['value' => '6+', 'label' => 'dịch vụ nổi bật'],
            ['value' => '100%', 'label' => 'quy trình đặt lịch rõ ràng'],
        ];

        $values = [
            [
                'number' => '01',
                'title' => 'Tận tâm trong tư vấn',
                'body' => 'Mỗi buổi hẹn bắt đầu bằng việc lắng nghe tình trạng tóc, mong muốn và thói quen chăm sóc của khách.',
            ],
            [
                'number' => '02',
                'title' => 'Minh bạch về dịch vụ',
                'body' => 'Thời lượng, mức giá và lưu ý chăm sóc được trình bày rõ để khách chủ động trước khi đặt lịch.',
            ],
            [
                'number' => '03',
                'title' => 'Trải nghiệm đặt lịch tiện lợi',
                'body' => 'Luồng booking online giúp chọn ngày, giờ, dịch vụ và stylist nhanh hơn, hạn chế chờ đợi tại salon.',
            ],
        ];

        $timeline = [
            [
                'year' => '2023',
                'title' => 'Khởi đầu',
                'body' => 'Ý tưởng ZenStyle hình thành từ mong muốn tạo một studio chăm sóc tóc gần gũi nhưng có quy trình rõ ràng.',
            ],
            [
                'year' => '2024',
                'title' => 'Mở rộng dịch vụ',
                'body' => 'Bổ sung các nhóm dịch vụ màu tóc, uốn texture, gội thư giãn và treatment phục hồi.',
            ],
            [
                'year' => '2025',
                'title' => 'Chuẩn hóa quy trình',
                'body' => 'Xây dựng trải nghiệm đặt lịch online, ghi nhận thông tin dịch vụ và nhắc lịch thống nhất.',
            ],
            [
                'year' => '2026',
                'title' => 'ZenStyle hôm nay',
                'body' => 'Trở thành điểm hẹn làm đẹp tại FPT Aptech với đội ngũ stylist, spa và tư vấn viên đồng hành cùng khách.',
            ],
        ];

        $team = [
            [
                'name' => 'Nguyễn Minh An',
                'role' => 'Salon Director',
                'bio' => 'Định hướng trải nghiệm tổng thể, tư vấn form tóc và đào tạo chất lượng dịch vụ.',
                'image' => asset('images/tailadmin/user/user-01.jpg'),
                'badges' => ['Tư vấn', 'Cắt tóc'],
            ],
            [
                'name' => 'Trần Lan Chi',
                'role' => 'Senior Stylist',
                'bio' => 'Chuyên layer, mullet và tạo kiểu cá nhân hóa theo khuôn mặt.',
                'image' => asset('images/tailadmin/user/user-02.jpg'),
                'badges' => ['Cắt tóc', 'Styling'],
            ],
            [
                'name' => 'Lê Hoàng Nam',
                'role' => 'Color Specialist',
                'bio' => 'Tư vấn màu, highlight và kiểm soát quy trình màu tóc an toàn.',
                'image' => asset('images/tailadmin/user/user-04.jpg'),
                'badges' => ['Nhuộm tóc', 'Highlight'],
            ],
            [
                'name' => 'Phạm Thu Hà',
                'role' => 'Spa & Treatment',
                'bio' => 'Phụ trách gội dưỡng sinh, treatment phục hồi và chăm sóc da đầu.',
                'image' => asset('images/tailadmin/user/user-03.jpg'),
                'badges' => ['Spa', 'Gội đầu'],
            ],
            [
                'name' => 'Đỗ Quốc Bảo',
                'role' => 'Barber / Fade',
                'bio' => 'Tập trung fade, taper và các kiểu tóc nam gọn, sắc nét.',
                'image' => asset('images/tailadmin/user/user-05.jpg'),
                'badges' => ['Cắt tóc', 'Fade'],
            ],
            [
                'name' => 'Vũ Mai Linh',
                'role' => 'Reception & Style Advisor',
                'bio' => 'Hỗ trợ lịch hẹn, tư vấn gói dịch vụ và chăm sóc khách trước/sau buổi làm.',
                'image' => asset('images/tailadmin/user/user-06.jpg'),
                'badges' => ['Tư vấn', 'Booking'],
            ],
        ];

        $reasons = [
            ['title' => 'Đặt lịch nhanh chóng', 'body' => 'Chọn ngày, giờ và dịch vụ trực tiếp trên website.'],
            ['title' => 'Dịch vụ rõ giá và thời lượng', 'body' => 'Thông tin cần biết được trình bày trước khi xác nhận.'],
            ['title' => 'Stylist có hồ sơ rõ ràng', 'body' => 'Khách có thể chọn nhân viên phù hợp với nhu cầu.'],
            ['title' => 'Không gian salon thư giãn', 'body' => 'Tông màu ấm, nhịp phục vụ nhẹ nhàng và thân thiện.'],
        ];
    @endphp

    <section
        id="about-hero"
        class="relative min-h-[520px] overflow-hidden bg-zen-bg sm:min-h-[560px] lg:min-h-[620px]"
        aria-label="Câu chuyện ZenStyle"
    >
        <img
            src="{{ $heroImage }}"
            alt="Không gian chăm sóc tóc tại ZenStyle"
            class="absolute inset-0 h-full w-full object-cover object-center"
            loading="eager"
        >
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-zen-bg/95 via-zen-bg/72 to-zen-bg/15"></div>
        <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-zen-bg to-transparent"></div>

        <div class="relative mx-auto flex min-h-[520px] max-w-6xl items-center px-4 pb-14 pt-28 sm:min-h-[560px] sm:px-6 sm:pt-32 lg:min-h-[620px] lg:pb-16">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-zen-primary">Câu chuyện ZenStyle</p>
                <h1 class="mt-4 font-['Playfair_Display',serif] text-3xl font-semibold leading-tight text-zen-text sm:text-4xl lg:text-5xl">
                    Từ một studio nhỏ đến điểm hẹn làm đẹp tại FPT Aptech
                </h1>
                <p class="mt-4 max-w-xl text-base leading-7 text-zen-text/80">
                    ZenStyle kết hợp tay nghề stylist, không gian chăm sóc thư giãn và quy trình đặt lịch rõ ràng để mỗi buổi làm đẹp trở nên nhẹ nhàng, chuyên nghiệp và dễ tin cậy hơn.
                </p>
                <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('booking') }}" class="inline-flex w-fit items-center justify-center rounded-full bg-zen-primary px-6 py-3 text-sm font-semibold text-white shadow-zen transition hover:-translate-y-0.5 hover:bg-zen-primary-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-zen-primary/40 focus-visible:ring-offset-2">
                        Đặt lịch ngay
                    </a>
                    <a href="{{ route('services') }}" class="inline-flex w-fit items-center justify-center rounded-full border border-zen-primary bg-white/85 px-6 py-3 text-sm font-semibold text-zen-primary shadow-sm transition hover:-translate-y-0.5 hover:bg-zen-accent-soft">
                        Khám phá dịch vụ
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white px-4 py-12 sm:px-6 lg:py-14">
        <div class="mx-auto max-w-5xl">
            <div class="max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Về chúng tôi</p>
                <h2 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold text-zen-text sm:text-4xl">
                    ZenStyle là gì?
                </h2>
                <p class="mt-4 text-sm leading-7 text-zen-muted sm:text-base">
                    ZenStyle là mô hình salon/spa định hướng trải nghiệm: dịch vụ dễ hiểu, lịch hẹn rõ ràng, stylist lắng nghe và quy trình chăm sóc được cá nhân hóa theo từng khách.
                </p>
                <blockquote class="mt-5 rounded-zen-md border border-zen-border bg-zen-bg px-5 py-4 text-sm font-medium leading-7 text-zen-text shadow-sm">
                    Làm đẹp nên bắt đầu bằng cảm giác được tư vấn rõ ràng, được chăm sóc đúng nhu cầu và rời salon với phong cách tự tin hơn.
                </blockquote>
            </div>

            <div class="mt-7 grid gap-4 sm:grid-cols-3">
                @foreach ($stats as $stat)
                    <div class="rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-sm">
                        <p class="font-['Playfair_Display',serif] text-4xl font-semibold leading-none text-zen-primary">{{ $stat['value'] }}</p>
                        <p class="mt-3 text-sm font-medium leading-snug text-zen-text">
                            {{ $stat['label'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-zen-bg-soft px-4 py-12 sm:px-6 lg:py-16">
        <div class="mx-auto max-w-6xl">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Giá trị cốt lõi</p>
                <h2 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold text-zen-text sm:text-4xl">
                    Giá trị ZenStyle theo đuổi
                </h2>
            </div>

            <div class="mt-8 grid gap-4 md:grid-cols-3">
                @foreach ($values as $value)
                    <article class="group rounded-zen-lg border border-zen-border bg-white p-5 shadow-zen transition hover:-translate-y-1 hover:border-zen-border-dark hover:shadow-zen-md">
                        <div class="flex items-start gap-4">
                            <span class="grid size-9 shrink-0 place-items-center rounded-full bg-zen-accent-soft text-xs font-semibold text-zen-primary ring-1 ring-zen-border">
                                {{ $value['number'] }}
                            </span>
                            <div>
                                <h3 class="text-lg font-semibold text-zen-text">{{ $value['title'] }}</h3>
                                <p class="mt-2 text-sm leading-6 text-zen-muted">{{ $value['body'] }}</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white px-4 py-12 sm:px-6 lg:py-16">
        <div class="mx-auto max-w-6xl">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Hành trình</p>
                <h2 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold text-zen-text sm:text-4xl">
                    Hành trình ZenStyle
                </h2>
                <p class="mt-3 text-sm leading-relaxed text-zen-muted">
                    Bốn cột mốc chính định hình cách ZenStyle phục vụ khách hàng hôm nay.
                </p>
            </div>

            <ol class="relative mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <span class="absolute left-0 right-0 top-6 hidden h-px bg-zen-border lg:block" aria-hidden="true"></span>
                @foreach ($timeline as $item)
                    <li class="relative">
                        <article class="relative h-full rounded-zen-lg border border-zen-border bg-zen-bg p-5 shadow-zen">
                            <div class="flex items-center gap-3">
                                <span class="grid size-8 place-items-center rounded-full border border-zen-primary/25 bg-white text-[11px] font-semibold text-zen-primary shadow-sm">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <p class="text-xs font-bold uppercase tracking-[0.2em] text-zen-primary">{{ $item['year'] }}</p>
                            </div>
                            <h3 class="mt-4 text-lg font-semibold text-zen-text">{{ $item['title'] }}</h3>
                            <p class="mt-2 text-sm leading-6 text-zen-muted">{{ $item['body'] }}</p>
                        </article>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <section class="bg-gradient-to-b from-zen-bg-soft to-white px-4 py-14 sm:px-6 lg:py-16">
        <div class="mx-auto max-w-6xl">
            <div class="max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Đội ngũ</p>
                <h2 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold text-zen-text sm:text-4xl">
                    Gặp gỡ các stylist của ZenStyle
                </h2>
                <p class="mt-3 text-sm leading-relaxed text-zen-muted sm:text-base">
                    Mỗi thành viên phụ trách một thế mạnh riêng, nhưng cùng chung cách làm: tư vấn kỹ, thao tác gọn và chăm sóc khách rõ ràng trước, trong và sau buổi hẹn.
                </p>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($team as $member)
                    <article class="group overflow-hidden rounded-zen-lg border border-zen-border bg-white shadow-zen transition hover:-translate-y-1 hover:shadow-zen-md">
                        <div class="aspect-[4/3] overflow-hidden bg-zen-bg-soft">
                            <img
                                src="{{ $member['image'] }}"
                                alt="{{ $member['name'] }}"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]"
                                loading="lazy"
                            >
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-semibold text-zen-text">{{ $member['name'] }}</h3>
                            <p class="mt-1 text-sm font-medium text-zen-primary">{{ $member['role'] }}</p>
                            <p class="mt-3 text-sm leading-relaxed text-zen-muted">{{ $member['bio'] }}</p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach ($member['badges'] as $badge)
                                    <span class="rounded-full bg-zen-accent-soft px-3 py-1 text-xs font-semibold text-zen-primary">
                                        {{ $badge }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white px-4 py-14 sm:px-6 lg:py-16">
        <div class="mx-auto max-w-6xl">
            <div class="grid gap-10 lg:grid-cols-[0.8fr_1.2fr] lg:items-start">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Vì sao chọn ZenStyle?</p>
                    <h2 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold text-zen-text sm:text-4xl">
                        Một trải nghiệm làm đẹp dễ hiểu từ đầu đến cuối.
                    </h2>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach ($reasons as $reason)
                        <article class="rounded-zen-lg border border-zen-border bg-zen-bg p-5">
                            <h3 class="font-semibold text-zen-text">{{ $reason['title'] }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-zen-muted">{{ $reason['body'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="bg-zen-bg-soft px-4 py-14 sm:px-6 lg:py-16">
        <div class="mx-auto max-w-6xl overflow-hidden rounded-zen-lg border border-zen-border bg-zen-bg-dark p-8 shadow-zen-md sm:p-10 lg:p-12">
            <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-center">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-accent-soft">ZenStyle booking</p>
                    <h2 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold text-white sm:text-4xl">
                        Sẵn sàng làm mới diện mạo của bạn?
                    </h2>
                    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-white/75 sm:text-base">
                        Chọn dịch vụ, thời gian và stylist phù hợp. ZenStyle sẽ ghi nhận lịch hẹn và liên hệ xác nhận nếu cần.
                    </p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row lg:flex-col">
                    <a href="{{ route('booking') }}" class="booking-cta inline-flex items-center justify-center rounded-full px-6 py-3 text-sm font-semibold">
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
