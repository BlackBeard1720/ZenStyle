@extends('layouts.frontend.app')

@section('title', 'ZenStyle — Tin tức')

@section('main_class', 'pt-0')

@section('content')
    @php
        /** Tin tức & ưu đãi — dữ liệu tĩnh mẫu */
        $posts = [
            [
                'slug' => 'uu-dai-thang-5-2026',
                'date' => '2026-05-01',
                'date_label' => '01/05/2026',
                'title' => 'Ưu đãi tháng 5: Combo cắt + treatment giảm 20%',
                'excerpt' => 'Áp dụng cuối tuần tại ZenStyle Triều Khúc. Đặt lịch trước 48 giờ để giữ suất stylist yêu thích.',
                'image' => 'https://images.unsplash.com/photo-1562322140-8baeececf3df?auto=format&fit=crop&w=900&q=80',
                'tag' => 'Ưu đãi',
            ],
            [
                'slug' => 'xu-huong-layer-mullet-2026',
                'date' => '2026-04-18',
                'date_label' => '18/04/2026',
                'title' => 'Xu hướng layer & mullet: cá nhân hoá theo gương mặt',
                'excerpt' => 'Team ZenStyle gợi ý độ dài mái và layer phù hợp từng form mặt — không copy nguyên mẫu mạng.',
                'image' => 'https://images.unsplash.com/photo-1599351431202-1e0f0137899a?auto=format&fit=crop&w=900&q=80',
                'tag' => 'Xu hướng',
            ],
            [
                'slug' => 'balayage-giu-mau-lau',
                'date' => '2026-04-02',
                'date_label' => '02/04/2026',
                'title' => 'Balayage bền màu: checklist chăm sóc tại nhà',
                'excerpt' => 'Dầu gội sulfate-free, nhiệt độ nước và lịch dặm màu mà Color Specialist khuyên dùng.',
                'image' => 'https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f?auto=format&fit=crop&w=900&q=80',
                'tag' => 'Mẹo làm đẹp',
            ],
            [
                'slug' => 'zenstyle-nang-cap-phong-treatment',
                'date' => '2026-03-15',
                'date_label' => '15/03/2026',
                'title' => 'ZenStyle nâng cấp phòng liệu trình phục hồi tóc',
                'excerpt' => 'Ghế massage, hấp dưỡng ozone và bộ sản phẩm Olaplex/K18 — trải nghiệm spa cho tóc ngay tại Triều Khúc.',
                'image' => 'https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?auto=format&fit=crop&w=900&q=80',
                'tag' => 'Tin salon',
            ],
            [
                'slug' => 'thanh-vien-tich-diem-2026',
                'date' => '2026-03-01',
                'date_label' => '01/03/2026',
                'title' => 'Chương trình thành viên: tích điểm đổi voucher',
                'excerpt' => 'Mỗi 500k tích 1 điểm; đổi gội dưỡng, treatment hoặc giảm giá % cho lần làm tiếp theo.',
                'image' => 'https://images.unsplash.com/photo-1519415943484-9fa1873496d4?auto=format&fit=crop&w=900&q=80',
                'tag' => 'Ưu đãi',
            ],
            [
                'slug' => 'open-day-stylist-trien-khai-2026',
                'date' => '2026-02-10',
                'date_label' => '10/02/2026',
                'title' => 'Open Day: gặp stylist, tư vấn miễn phí 15 phút',
                'excerpt' => 'Sự kiện cuối tuần dành cho khách mới — book slot “tư vấn gu” trước để không phải chờ.',
                'image' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?auto=format&fit=crop&w=900&q=80',
                'tag' => 'Sự kiện',
            ],
        ];
    @endphp

    <section id="site-banner" class="relative bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1520975911166-3e1d6b1ff9b9?auto=format&fit=crop&w=1600&q=80');">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative mx-auto max-w-6xl px-4 py-20 sm:py-28">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-rose-100/90">Blog &amp; ưu đãi</p>
            <h1 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold text-white sm:text-4xl">Tin tức &amp; ưu đãi</h1>
            <p class="mt-3 max-w-2xl text-sm text-white/85">
                Cập nhật khuyến mãi, xu hướng làm đẹp và hoạt động tại ZenStyle Triều Khúc.
            </p>
        </div>
    </section>
    <script>document.addEventListener('DOMContentLoaded', function(){ var h = document.getElementById('site-header'); if(h) h.setAttribute('data-on-banner','true'); });</script>

    <section class="px-4 py-12 sm:px-6">
        <div class="mx-auto max-w-6xl">
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($posts as $post)
                    <article
                        class="flex flex-col overflow-hidden rounded-2xl border border-stone-200/90 bg-white shadow-sm ring-1 ring-stone-900/5 transition hover:shadow-md"
                    >
                        <div class="relative">
                            <img
                                src="{{ $post['image'] }}"
                                alt=""
                                class="h-44 w-full object-cover"
                                loading="lazy"
                            />
                            <span
                                class="absolute left-3 top-3 rounded-full bg-white/95 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-rose-800 ring-1 ring-stone-200/80"
                            >
                                {{ $post['tag'] }}
                            </span>
                        </div>
                        <div class="flex flex-1 flex-col p-5">
                            <time class="text-xs font-medium uppercase tracking-wide text-stone-500" datetime="{{ $post['date'] }}">
                                {{ $post['date_label'] }}
                            </time>
                            <h2 class="mt-2 text-lg font-semibold leading-snug text-stone-900">{{ $post['title'] }}</h2>
                            <p class="mt-2 flex-1 text-sm leading-relaxed text-stone-600">{{ $post['excerpt'] }}</p>
                            <a href="#" class="mt-4 inline-flex text-sm font-semibold text-rose-700 hover:text-rose-800">Đọc thêm</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
