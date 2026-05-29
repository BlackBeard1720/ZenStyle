<x-frontend.layout title="Hot Trend Tóc - ZenStyle" main-class="bg-zen-bg-soft pt-20">
    @php
        $filters = [
            ['label' => 'Tất cả', 'value' => 'all'],
            ['label' => 'Tóc nam', 'value' => 'nam'],
            ['label' => 'Tóc nữ', 'value' => 'nu'],
            ['label' => 'Công sở', 'value' => 'cong-so'],
            ['label' => 'Cá tính', 'value' => 'ca-tinh'],
            ['label' => 'Dễ chăm sóc', 'value' => 'de-cham-soc'],
        ];

        $trends = [
            [
                'title' => 'Spike texture',
                'slug' => 'spike-texture',
                'categories' => ['nam', 'ca-tinh'],
                'tags' => ['Tóc nam', 'Cá tính'],
                'images' => [
                    asset('images/frontend/hottrend/hottrend-01.png'),
                    asset('images/frontend/hottrend/hottrend-03.png'),
                    asset('images/frontend/hottrend/hottrend-06.png'),
                    asset('images/frontend/services/featured-toc.png'),
                ],
                'alt' => 'Kiểu tóc spike texture',
                'shortDescription' => 'Form dựng nhẹ, nhiều texture và tạo cảm giác năng động.',
                'longDescription' => 'Spike texture hợp với khách muốn tóc có độ chuyển động rõ nhưng không quá cầu kỳ. Stylist sẽ cân chỉnh độ dài hai bên, hướng mọc và độ phồng phần đỉnh để kiểu tóc dễ vuốt sau khi về nhà.',
                'suitableFor' => 'Khuôn mặt góc cạnh, tóc trung bình đến dày, khách thích phong cách năng động.',
                'stylingTips' => ['Sấy nâng chân tóc trước khi dùng sáp.', 'Dùng lượng sáp nhỏ, vuốt theo từng lọn.', 'Cắt dặm sau 3-4 tuần để giữ form.'],
            ],
            [
                'title' => 'Textured crop',
                'slug' => 'textured-crop',
                'categories' => ['nam', 'de-cham-soc'],
                'tags' => ['Tóc nam', 'Dễ chăm sóc'],
                'images' => [
                    asset('images/frontend/hottrend/hottrend-03.png'),
                    asset('images/frontend/hottrend/hottrend-01.png'),
                    asset('images/frontend/hottrend/hottrend-06.png'),
                    asset('images/frontend/services/featured-toc.png'),
                ],
                'alt' => 'Kiểu tóc textured crop',
                'shortDescription' => 'Kiểu tóc gọn, phần mái xử lý texture để giữ form tự nhiên.',
                'longDescription' => 'Textured crop là lựa chọn an toàn cho khách muốn gọn nhưng vẫn có điểm nhấn. Phần mái được cắt lớp nhẹ để tóc không bị nặng, phù hợp lịch học/làm dày mà vẫn dễ chăm.',
                'suitableFor' => 'Tóc dày, khuôn mặt tròn hoặc vuông nhẹ, khách muốn kiểu tóc gọn hằng ngày.',
                'stylingTips' => ['Sấy khô theo hướng tự nhiên của mái.', 'Dùng clay nhẹ nếu muốn tăng texture.', 'Không cần vuốt quá bóng.'],
            ],
            [
                'title' => 'Wolf cut / Mullet',
                'slug' => 'wolf-cut-mullet',
                'categories' => ['nam', 'ca-tinh'],
                'tags' => ['Tóc nam', 'Cá tính'],
                'images' => [
                    asset('images/frontend/hottrend/hottrend-04.png'),
                    asset('images/frontend/hottrend/hottrend-07.png'),
                    asset('images/frontend/hottrend/hottrend-01.png'),
                    asset('images/frontend/banner/Gemini_Generated_Image_6hfrq56hfrq56hfr.png'),
                ],
                'alt' => 'Kiểu tóc wolf cut mullet',
                'shortDescription' => 'Layer rõ ở phần gáy và hai bên, tạo chất riêng cho tổng thể.',
                'longDescription' => 'Wolf cut / Mullet cần được điều chỉnh theo độ dày tóc và chiều dài gáy. ZenStyle ưu tiên form vừa đủ nổi bật, tránh cắt quá nặng khiến tóc khó kiểm soát sau vài tuần.',
                'suitableFor' => 'Khách thích phong cách nổi bật, tóc có độ phồng tự nhiên và sẵn sàng chăm styling.',
                'stylingTips' => ['Dùng pre-styling để giữ độ phồng.', 'Sấy phần gáy theo hướng layer.', 'Nên tỉa lại sau 4-5 tuần.'],
            ],
            [
                'title' => 'Undercut hard part',
                'slug' => 'undercut-hard-part',
                'categories' => ['nam', 'cong-so'],
                'tags' => ['Tóc nam', 'Công sở'],
                'images' => [
                    asset('images/frontend/hottrend/hottrend-06.png'),
                    asset('images/frontend/hottrend/hottrend-03.png'),
                    asset('images/frontend/services/featured-toc.png'),
                    asset('images/frontend/hottrend/hottrend-01.png'),
                ],
                'alt' => 'Kiểu tóc undercut hard part',
                'shortDescription' => 'Đường ngôi rõ, hai bên gọn và phần đỉnh dễ tạo kiểu lịch sự.',
                'longDescription' => 'Undercut hard part phù hợp khi cần hình ảnh chỉn chu. Stylist sẽ xác định đường ngôi theo form đầu để đường chia tóc rõ nhưng không bị cứng hoặc lệch tỷ lệ khuôn mặt.',
                'suitableFor' => 'Khách cần kiểu tóc gọn, lịch sự, dễ phối với sơ mi hoặc môi trường công sở.',
                'stylingTips' => ['Dùng pomade hoặc wax độ giữ nếp vừa.', 'Chải theo đường ngôi khi tóc còn hơi ẩm.', 'Dặm fade định kỳ để giữ độ sắc nét.'],
            ],
            [
                'title' => 'Layer tự nhiên',
                'slug' => 'layer-tu-nhien',
                'categories' => ['nu', 'de-cham-soc'],
                'tags' => ['Tóc nữ', 'Dễ chăm sóc'],
                'images' => [
                    asset('images/frontend/hottrend/hottrend-02.png'),
                    asset('images/frontend/hottrend/hottrend-05.png'),
                    asset('images/frontend/services/featured-goi.png'),
                    asset('images/frontend/banner/banner02.png'),
                ],
                'alt' => 'Kiểu tóc layer tự nhiên',
                'shortDescription' => 'Các lớp tóc mềm, nhẹ phần đuôi và dễ vào nếp khi sấy nhanh.',
                'longDescription' => 'Layer tự nhiên giúp tóc nhẹ hơn mà không thay đổi quá mạnh. Kỹ thuật tập trung vào độ rơi của đuôi tóc và đường ôm mặt để tổng thể mềm hơn khi xõa hoặc buộc thấp.',
                'suitableFor' => 'Khách muốn tóc nhẹ, mềm hơn, dễ chăm và không cần styling cầu kỳ.',
                'stylingTips' => ['Sấy từ chân tóc để giữ độ phồng nhẹ.', 'Dùng dầu dưỡng ở phần đuôi.', 'Tỉa lại khi đuôi tóc bắt đầu nặng.'],
            ],
            [
                'title' => 'Uốn sóng nhẹ',
                'slug' => 'uon-song-nhe',
                'categories' => ['nu', 'cong-so'],
                'tags' => ['Tóc nữ', 'Công sở'],
                'images' => [
                    asset('images/frontend/hottrend/hottrend-05.png'),
                    asset('images/frontend/hottrend/hottrend-02.png'),
                    asset('images/frontend/hottrend/hottrend-07.png'),
                    asset('images/frontend/services/featured-spa.png'),
                ],
                'alt' => 'Kiểu tóc uốn sóng nhẹ',
                'shortDescription' => 'Sóng mềm vừa phải, nữ tính mà không cần styling cầu kỳ.',
                'longDescription' => 'Uốn sóng nhẹ tạo độ chuyển động vừa đủ cho tóc dài hoặc ngang vai. Trước khi làm, stylist sẽ kiểm tra nền tóc để chọn mức sóng và sản phẩm dưỡng phù hợp.',
                'suitableFor' => 'Khách muốn kiểu tóc nữ tính, dễ phối đồ, phù hợp đi học hoặc đi làm.',
                'stylingTips' => ['Không gội đầu ngay trong 24-48 giờ đầu.', 'Dùng sản phẩm dưỡng nhẹ cho tóc uốn.', 'Sấy theo lọn để sóng bền hơn.'],
            ],
            [
                'title' => 'Balayage nâu lạnh',
                'slug' => 'balayage-nau-lanh',
                'categories' => ['nu', 'ca-tinh'],
                'tags' => ['Tóc nữ', 'Cá tính'],
                'images' => [
                    asset('images/frontend/hottrend/hottrend-07.png'),
                    asset('images/frontend/hottrend/hottrend-05.png'),
                    asset('images/frontend/hottrend/hottrend-02.png'),
                    asset('images/frontend/banner/banner03.png'),
                ],
                'alt' => 'Kiểu tóc balayage nâu lạnh',
                'shortDescription' => 'Hiệu ứng màu chuyển nhẹ, giữ cảm giác sang và không quá chói.',
                'longDescription' => 'Balayage nâu lạnh phù hợp khi muốn đổi màu rõ nhưng vẫn giữ vẻ mềm. Mức nâng nền sẽ được tư vấn theo sức khỏe tóc để hạn chế khô xơ sau khi làm màu.',
                'suitableFor' => 'Khách muốn đổi màu tinh tế, tóc đủ khỏe và có thời gian chăm sóc sau nhuộm.',
                'stylingTips' => ['Dùng dầu gội giữ màu.', 'Hạn chế nước quá nóng.', 'Dặm gloss khi màu bắt đầu xuống tông.'],
            ],
            [
                'title' => 'Bob layer',
                'slug' => 'bob-layer',
                'categories' => ['nu', 'de-cham-soc'],
                'tags' => ['Tóc nữ', 'Dễ chăm sóc'],
                'images' => [
                    asset('images/frontend/services/featured-goi.png'),
                    asset('images/frontend/hottrend/hottrend-02.png'),
                    asset('images/frontend/hottrend/hottrend-05.png'),
                    asset('images/frontend/banner/Gemini_Generated_Image_ympfunympfunympf.png'),
                ],
                'alt' => 'Kiểu tóc bob layer',
                'shortDescription' => 'Độ dài gọn, layer nhẹ giúp tóc có form hiện đại hơn.',
                'longDescription' => 'Bob layer làm tổng thể gọn hơn nhưng vẫn có độ mềm ở phần đuôi. Kiểu này cần cân chỉnh độ dài theo cổ, vai và thói quen buộc tóc của từng khách.',
                'suitableFor' => 'Khách thích tóc ngắn, dễ chăm và muốn tổng thể trẻ, hiện đại hơn.',
                'stylingTips' => ['Sấy cụp nhẹ phần đuôi.', 'Dùng serum để tóc không bị xù.', 'Cắt dặm định kỳ để giữ form bob.'],
            ],
        ];
    @endphp

    <section class="relative overflow-hidden bg-gradient-to-br from-zen-bg via-zen-bg-soft to-[#ead8c6] px-4 py-10 sm:px-6 lg:py-12">
        <div class="mx-auto flex min-h-[260px] max-w-6xl items-center sm:min-h-[300px] lg:min-h-[340px]">
            <div class="max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-zen-primary">ZenStyle Picks</p>
                <h1 class="mt-3 font-heading text-4xl font-semibold leading-tight text-zen-text sm:text-5xl">
                    Hot Trend Tóc
                </h1>
                <p class="mt-4 max-w-2xl text-sm leading-7 text-zen-muted sm:text-base">
                    Tham khảo các kiểu tóc đang được yêu thích trước khi đặt lịch tư vấn cùng stylist.
                </p>
                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                    <a href="#trend-gallery" class="inline-flex w-fit items-center justify-center rounded-full bg-zen-primary px-6 py-3 text-sm font-semibold text-white shadow-zen transition hover:bg-zen-primary-dark">
                        Xem kiểu tóc
                    </a>
                    <a href="{{ route('services') }}" class="inline-flex w-fit items-center justify-center rounded-full border border-zen-primary bg-white/75 px-6 py-3 text-sm font-semibold text-zen-primary transition hover:bg-white">
                        Xem dịch vụ
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="trend-gallery" class="scroll-mt-24 bg-zen-bg-soft px-4 py-10 sm:px-6 lg:py-12" data-hot-trend-page>
        <div class="mx-auto max-w-6xl">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Trend gallery</p>
                    <h2 class="mt-2 font-heading text-3xl font-semibold text-zen-text sm:text-4xl">
                        Kiểu tóc đang được quan tâm
                    </h2>
                </div>
                <p class="max-w-md text-sm leading-6 text-zen-muted sm:text-right">
                    Lọc theo phong cách để chọn vài mẫu phù hợp trước khi đặt lịch tư vấn.
                </p>
            </div>

            <div class="mt-6 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-zen-primary">Lọc theo phong cách</p>
                <div class="-mx-4 flex gap-2 overflow-x-auto px-4 pb-1 sm:mx-0 sm:flex-wrap sm:px-0 lg:justify-end" role="tablist" aria-label="Bộ lọc kiểu tóc">
                    @foreach ($filters as $filter)
                        <button
                            type="button"
                            class="shrink-0 rounded-full border px-4 py-2 text-sm font-semibold transition {{ $loop->first ? 'border-zen-primary bg-zen-primary text-white shadow-sm' : 'border-zen-border bg-white text-zen-muted hover:border-zen-primary hover:bg-zen-accent-soft hover:text-zen-primary' }}"
                            data-hot-trend-filter="{{ $filter['value'] }}"
                            aria-pressed="{{ $loop->first ? 'true' : 'false' }}"
                        >
                            {{ $filter['label'] }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="mt-7 grid gap-5 sm:grid-cols-2 lg:grid-cols-4" data-hot-trend-grid>
                @foreach ($trends as $trend)
                    <article
                        class="group flex h-full cursor-pointer flex-col overflow-hidden rounded-zen-lg border border-zen-border bg-white shadow-zen transition duration-300 hover:-translate-y-1 hover:shadow-lg"
                        data-hot-trend-card
                        data-trend-slug="{{ $trend['slug'] }}"
                        data-categories="{{ implode(' ', $trend['categories']) }}"
                    >
                        <button
                            type="button"
                            class="flex h-full w-full flex-col text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-zen-primary/45 focus-visible:ring-offset-2"
                            data-hot-trend-open="{{ $trend['slug'] }}"
                        >
                            <div class="aspect-[4/5] overflow-hidden bg-zen-bg-soft">
                                <img
                                    src="{{ $trend['images'][0] }}"
                                    alt="{{ $trend['alt'] }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                                    loading="lazy"
                                    decoding="async"
                                >
                            </div>
                            <div class="flex flex-1 flex-col p-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($trend['tags'] as $tag)
                                        <span class="rounded-full bg-zen-accent-soft px-2.5 py-1 text-[11px] font-semibold text-zen-primary">
                                            {{ $tag }}
                                        </span>
                                    @endforeach
                                </div>
                                <h3 class="mt-3 text-lg font-semibold text-zen-text">{{ $trend['title'] }}</h3>
                                <p class="mt-2 text-sm leading-6 text-zen-muted">{{ $trend['shortDescription'] }}</p>
                                <span class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-zen-primary">
                                    Xem thêm ảnh
                                    <span aria-hidden="true">→</span>
                                </span>
                            </div>
                        </button>
                    </article>
                @endforeach
            </div>

            <p class="mt-8 hidden rounded-zen-md border border-zen-border bg-white px-4 py-3 text-sm text-zen-muted" data-hot-trend-empty>
                Chưa có kiểu tóc phù hợp với bộ lọc này.
            </p>
        </div>
    </section>

    <script type="application/json" data-hot-trend-data>
        {!! json_encode($trends, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>

    <div
        class="fixed inset-0 z-[90] hidden items-center justify-center px-4 py-6"
        data-hot-trend-modal
        role="dialog"
        aria-modal="true"
        aria-hidden="true"
    >
        <button
            type="button"
            class="absolute inset-0 bg-zen-bg-dark/55 backdrop-blur-sm"
            data-hot-trend-close
            aria-label="Đóng chi tiết kiểu tóc"
        ></button>

        <div class="relative z-10 max-h-[calc(100vh-2rem)] w-full max-w-5xl overflow-y-auto rounded-zen-lg border border-zen-border bg-white shadow-2xl">
            <button
                type="button"
                class="absolute right-4 top-4 z-20 grid size-10 place-items-center rounded-full bg-white/90 text-xl font-semibold text-zen-text shadow-sm ring-1 ring-zen-border transition hover:bg-zen-accent-soft"
                data-hot-trend-close
                aria-label="Đóng"
            >
                ×
            </button>

            <div class="grid gap-0 lg:grid-cols-[minmax(0,1fr)_24rem]">
                <div class="bg-zen-bg-soft p-4 sm:p-5">
                    <div class="overflow-hidden rounded-zen-md bg-white shadow-sm">
                        <img
                            src=""
                            alt=""
                            class="aspect-[4/5] w-full object-cover sm:aspect-[5/4] lg:aspect-[4/5]"
                            data-hot-trend-modal-main
                        >
                    </div>
                    <div class="mt-3 grid grid-cols-4 gap-2" data-hot-trend-modal-thumbs></div>
                </div>

                <div class="flex flex-col p-5 sm:p-6">
                    <div class="flex flex-wrap gap-2" data-hot-trend-modal-tags></div>
                    <h2 class="mt-4 font-heading text-3xl font-semibold leading-tight text-zen-text" data-hot-trend-modal-title></h2>
                    <p class="mt-3 text-sm leading-7 text-zen-muted" data-hot-trend-modal-description></p>

                    <div class="mt-6 rounded-zen-md border border-zen-border bg-zen-bg p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-zen-primary">Phù hợp với ai?</p>
                        <p class="mt-2 text-sm leading-6 text-zen-muted" data-hot-trend-modal-suitable></p>
                    </div>

                    <div class="mt-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-zen-primary">Gợi ý chăm sóc/styling</p>
                        <ul class="mt-3 space-y-2 text-sm leading-6 text-zen-muted" data-hot-trend-modal-tips></ul>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('booking') }}" class="inline-flex items-center justify-center rounded-full bg-zen-primary px-6 py-3 text-sm font-semibold text-white shadow-zen transition hover:bg-zen-primary-dark" data-hot-trend-modal-booking>
                            Đặt lịch tư vấn
                        </a>
                        <button type="button" class="inline-flex items-center justify-center rounded-full border border-zen-primary px-6 py-3 text-sm font-semibold text-zen-primary transition hover:bg-zen-accent-soft" data-hot-trend-close>
                            Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="bg-zen-bg-soft px-4 py-10 sm:px-6 lg:py-14">
        <div class="mx-auto max-w-6xl overflow-hidden rounded-zen-lg border border-zen-border bg-zen-bg-dark p-6 shadow-zen-md sm:p-8 lg:p-10">
            <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-center">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-accent-soft">ZenStyle booking</p>
                    <h2 class="mt-3 font-heading text-3xl font-semibold text-white sm:text-4xl">
                        Lưu kiểu tóc yêu thích và đặt lịch ngay
                    </h2>
                    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-white/75 sm:text-base">
                        Mang mẫu tóc bạn thích tới buổi tư vấn để stylist điều chỉnh theo khuôn mặt và chất tóc thực tế.
                    </p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row lg:flex-col">
                    <a href="{{ route('booking') }}" class="inline-flex items-center justify-center rounded-full bg-white px-6 py-3 text-sm font-semibold text-zen-bg-dark transition hover:bg-zen-accent-soft">
                        Đặt lịch ngay
                    </a>
                    <a href="{{ route('services') }}" class="inline-flex items-center justify-center rounded-full border border-white/35 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                        Xem bảng dịch vụ
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-frontend.layout>
