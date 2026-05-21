<x-frontend.layout title="ZenStyle — Tin tức" main-class="pt-0">
    <section id="site-banner" class="relative bg-cover bg-center" style="background-image: url('{{ asset('images/frontend/banner/Gemini_Generated_Image_6hfrq56hfrq56hfr.png') }}'); background-position: center;">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative mx-auto max-w-6xl px-4 py-20 sm:py-28">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-accent-soft">Blog &amp; ưu đãi</p>
            <h1 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold text-white sm:text-4xl">Tin tức &amp; ưu đãi</h1>
            <p class="mt-3 max-w-2xl text-sm text-white/85">
                Cập nhật khuyến mãi, xu hướng làm đẹp và hoạt động tại ZenStyle FPT Aptech.
            </p>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var h = document.getElementById('site-header');
            if (h) h.setAttribute('data-on-banner', 'true');
        });
    </script>

    <section class="bg-gradient-to-b from-zen-accent-soft/45 via-zen-bg-soft to-white px-4 py-14 sm:px-6 md:py-16 lg:pb-20">
        <div class="mx-auto max-w-6xl">
            <!-- Category Filter -->
            <div class="mb-10 rounded-zen-md border border-zen-border bg-white p-6 shadow-zen">
                <form method="GET" action="{{ route('news') }}" class="flex flex-col gap-4 sm:flex-row sm:items-end sm:gap-3">
                    <div class="flex-1">
                        <label for="category" class="block text-sm font-semibold text-zen-text mb-2">
                            Danh mục
                        </label>
                        <select 
                            name="category" 
                            id="category"
                            class="w-full rounded-zen-sm border border-zen-border-dark bg-white px-4 py-2.5 text-zen-text transition focus:border-zen-primary focus:ring-2 focus:ring-zen-primary/20 focus:outline-none"
                        >
                            <option value="">-- Tất cả danh mục --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ $selectedCategory === $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="flex gap-2 sm:gap-3">
                        <a 
                            href="{{ route('news') }}"
                            class="inline-flex items-center rounded-zen-sm border border-zen-border-dark bg-white px-5 py-2.5 font-medium text-zen-text transition hover:bg-zen-bg-soft hover:border-zen-border-dark active:bg-zen-bg-soft focus:outline-none focus:ring-2 focus:ring-zen-muted/20"
                        >
                            Reset
                        </a>
                        <button 
                            type="submit"
                            class="inline-flex items-center rounded-zen-sm bg-zen-primary px-5 py-2.5 font-medium text-white transition hover:bg-zen-primary-dark active:bg-zen-primary-dark focus:outline-none focus:ring-2 focus:ring-zen-primary/50"
                        >
                            Lọc
                        </button>
                    </div>
                </form>
                
                <!-- Result Count -->
                <div class="mt-4 text-sm text-zen-muted">
                    <span class="font-medium text-zen-text">{{ $resultCount }}</span> kết quả
                    @if ($selectedCategory)
                        <span class="text-zen-muted">cho danh mục "<span class="font-medium text-zen-text">{{ $selectedCategory }}</span>"</span>
                    @endif
                </div>
            </div>

            <!-- Posts Grid -->
            @if (count($posts) > 0)
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $post)
                    <article
                        class="group relative flex cursor-pointer flex-col overflow-hidden rounded-zen-lg border border-zen-border bg-white shadow-zen ring-1 ring-zen-border transition hover:border-zen-border-dark hover:shadow-zen-md"
                    >
                        <img
                            src="{{ $post['image'] }}"
                            alt=""
                            class="h-44 w-full object-cover transition duration-300 group-hover:scale-[1.02]"
                            loading="lazy"
                            role="presentation"
                        >
                        <div class="relative flex flex-1 flex-col p-5">
                            <time class="text-xs font-medium uppercase tracking-wide text-zen-muted" datetime="{{ $post['date'] }}">
                                {{ $post['date_label'] }}
                            </time>
                            <h2 id="news-title-{{ $post['slug'] }}" class="mt-2 font-['Playfair_Display',serif] text-xl font-semibold leading-snug text-zen-text">
                                {{ $post['title'] }}
                            </h2>
                            <span
                                class="mr-auto mt-3 inline-flex rounded-full bg-zen-accent-soft px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-zen-primary-dark ring-1 ring-zen-border"
                            >
                                {{ $post['tag'] }}
                            </span>
                            <p class="mt-3 text-sm leading-relaxed text-zen-muted">{{ $post['summary'] }}</p>
                        </div>
                        <a
                            href="{{ route('news.show', $post['slug']) }}"
                            class="absolute inset-0 z-10 rounded-2xl outline-none ring-inset ring-zen-primary focus-visible:ring-2"
                            aria-labelledby="news-title-{{ $post['slug'] }}"
                        ></a>
                    </article>
                @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-zen-muted text-lg">Không có bài viết nào trong danh mục này.</p>
                </div>
            @endif
        </div>
    </section>
</x-frontend.layout>
