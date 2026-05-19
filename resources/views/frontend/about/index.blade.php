<x-frontend.layout title="ZenStyle — Giới thiệu" main-class="pt-0">
    @php
        /** Dữ liệu tĩnh mẫu — có thể chuyển sang Model/Seeder sau */
        $storyIntro = [
            'label' => 'Câu chuyện ZenStyle',
            'headline' => 'Từ một studio nhỏ đến điểm hẹn làm đẹp tại FPT Aptech',
            'lead' => 'ZenStyle ra đời với mong muốn mang phong cách salon hiện đại, gần gũi và tận tâm đến từng khách hàng. Chúng tôi tin làm đẹp không chỉ là một dịch vụ — đó là trải nghiệm được lắng nghe và được chăm sóc trọn vẹn.',
        ];

        $storyTimeline = [
            [
                'year' => '2022',
                'title' => 'Khởi đầu',
                'body' => 'ZenStyle mở cửa tại FPT Aptech với đội ngũ 3 stylist, tập trung cắt tạo kiểu và chăm sóc tóc cơ bản. Không gian nhỏ nhưng ấm cúng, đặt nền móng cho triết lý “chậm mà chắc, đẹp mà bền”.',
            ],
            [
                'year' => '2023',
                'title' => 'Mở rộng dịch vụ',
                'body' => 'Bổ sung nhuộm – uốn chuyên sâu, liệu trình phục hồi tóc hư tổn và gói combo cuối tuần. ZenStyle bắt đầu xây dựng lịch đặt trực tuyến nội bộ để giảm chờ đợi và phục vụ đúng giờ.',
            ],
            [
                'year' => '2024',
                'title' => 'Chuẩn salon cao cấp',
                'body' => 'Đầu tư phòng liệu trình riêng, mỹ phẩm chọn lọc và đào tạo định kỳ cho toàn team. ZenStyle giới thiệu chương trình thành viên – tích điểm đổi ưu đãi, đồng hành cùng khách hàng trung thành.',
            ],
            [
                'year' => '2025',
                'title' => 'ZenStyle hôm nay',
                'body' => 'Hệ thống quản lý tập trung (đặt lịch, nhắc lịch, lưu sở thích khách) giúp đội ngũ tập trung vào tay nghề và trải nghiệm. Chúng tôi tiếp tục cập nhật xu hướng — từ layer mullet đến phục hồi da đầu — để bạn luôn tự tin với phong cách của riêng mình.',
            ],
        ];

        $team = [
            [
                'name' => 'Nguyễn Minh An',
                'role' => 'Salon Director',
                'bio' => '15 năm trong nghề, dẫn dắt phong cách tổng thể và đào tạo nội bộ.',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Trần Lan Chi',
                'role' => 'Senior Stylist',
                'bio' => 'Chuyên tạo kiểu layer, mullet và cá nhân hoá theo gương mặt.',
                'image' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Lê Hoàng Nam',
                'role' => 'Color Specialist',
                'bio' => 'Nhuộm balayage, bleach an toàn và giữ màu bền sau nhiều tuần.',
                'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Phạm Thu Hà',
                'role' => 'Spa & Treatment',
                'bio' => 'Liệu trình phục hồi tóc, gội massage và chăm sóc da đầu.',
                'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Đỗ Quốc Bảo',
                'role' => 'Barber / Fade',
                'bio' => 'Fade sharp, tỉa râu và phối style streetwear–classic.',
                'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Vũ Mai Linh',
                'role' => 'Reception & Style Advisor',
                'bio' => 'Tư vấn gói dịch vụ, lịch hẹn và chăm sóc khách trước–trong–sau giờ làm.',
                'image' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=800&q=80',
            ],
        ];
    @endphp

    {{-- Hero --}}
    <section id="site-banner" class="relative bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1511988617509-a57c8a288659?auto=format&fit=crop&w=1600&q=80');">
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/20 to-transparent"></div>
        <div class="relative mx-auto max-w-6xl px-4 py-32 sm:py-40">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-accent-soft">{{ $storyIntro['label'] }}</p>
            <h1 class="mt-3 max-w-3xl font-['Playfair_Display',serif] text-3xl font-semibold leading-tight text-white sm:text-4xl lg:text-[3rem]">
                {{ $storyIntro['headline'] }}
            </h1>
            <p class="mt-5 max-w-2xl text-sm leading-relaxed text-white/85">
                {{ $storyIntro['lead'] }}
            </p>
            <div class="mt-8">
                <a href="{{ route('services') }}" class="inline-flex rounded-full bg-zen-primary px-5 py-3 text-sm font-semibold text-white shadow hover:bg-zen-primary-dark">Khám phá dịch vụ</a>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function(){ var h = document.getElementById('site-header'); if(h) h.setAttribute('data-on-banner','true'); });
    </script>

    {{-- STORY — timeline --}}
    <section class="border-b border-zen-border bg-white px-4 py-16 sm:px-6">
        <div class="mx-auto max-w-6xl">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="font-['Playfair_Display',serif] text-2xl font-semibold text-zen-text sm:text-3xl">Hành trình ZenStyle</h2>
                <p class="mt-3 text-sm text-zen-muted">Từ 2022 đến 2025 — những mốc đáng nhớ.</p>
            </div>

            <ol class="relative mx-auto mt-12 max-w-3xl border-l border-zen-border pl-8">
                @foreach ($storyTimeline as $item)
                    <li class="mb-12 last:mb-0">
                        <span
                            class="absolute -left-[9px] mt-1.5 h-[11px] w-[11px] rounded-full border-2 border-white bg-zen-primary shadow ring-2 ring-zen-border"
                            aria-hidden="true"
                        ></span>
                        <p class="text-xs font-bold uppercase tracking-wider text-zen-primary">{{ $item['year'] }}</p>
                        <h3 class="mt-1 text-lg font-semibold text-zen-text">{{ $item['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-zen-muted">{{ $item['body'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{--
        Đội ngũ — lưới 12 cột: cột nhãn ~2/12 + nội dung ~8/12 (bố cục 2–8, kiểu trang about salon quốc tế).
        Mobile: xếp dọc; lg+: sidebar trái + lưới thẻ bên phải.
    --}}
    <section class="bg-gradient-to-b from-zen-accent-soft/45 via-zen-bg-soft to-white px-4 py-16 sm:px-6 lg:pb-20">
        <div class="mx-auto max-w-6xl">
            <div class="grid grid-cols-1 gap-10 lg:grid-cols-12 lg:gap-12">
                <aside class="lg:col-span-2 lg:pt-2">
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-zen-primary-dark">Our team</p>
                    <h2
                        class="mt-3 font-['Playfair_Display',serif] text-2xl font-semibold leading-none text-zen-text sm:text-3xl lg:[writing-mode:vertical-rl] lg:rotate-180 lg:text-4xl"
                    >
                        Đội ngũ
                    </h2>
                    <p class="mt-4 max-w-xs text-sm leading-relaxed text-zen-muted lg:mt-8">
                        Stylists và chuyên gia ZenStyle — luôn lắng nghe để tạo kiểu đúng người, đúng gu.
                    </p>
                </aside>

                <div class="lg:col-span-8">
                    <div class="grid gap-8 sm:grid-cols-2 lg:gap-10">
                        @foreach ($team as $member)
                            <article
                                class="group overflow-hidden rounded-zen-lg border border-zen-border bg-zen-bg shadow-zen ring-1 ring-zen-border transition hover:shadow-md"
                            >
                                <div class="aspect-[4/3] overflow-hidden bg-zen-bg-soft">
                                    <img
                                        src="{{ $member['image'] }}"
                                        alt="{{ $member['name'] }}"
                                        class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]"
                                        loading="lazy"
                                    />
                                </div>
                                <div class="p-5 sm:p-6">
                                    <h3 class="text-lg font-semibold text-zen-text">{{ $member['name'] }}</h3>
                                    <p class="mt-1 text-sm font-medium text-zen-primary">{{ $member['role'] }}</p>
                                    <p class="mt-3 text-sm leading-relaxed text-zen-muted">{{ $member['bio'] }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-frontend.layout>
