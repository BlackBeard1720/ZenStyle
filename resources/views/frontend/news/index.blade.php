@extends('layouts.frontend.app')

@section('title', 'ZenStyle — Tin tức')

@section('main_class', 'pt-0')

@section('content')
    <section id="site-banner" class="relative bg-cover bg-center" style="background-image: url('{{ asset('images/frontend/banner/Gemini_Generated_Image_6hfrq56hfrq56hfr.png') }}'); background-position: center;">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative mx-auto max-w-6xl px-4 py-20 sm:py-28">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-rose-100/90">Blog &amp; ưu đãi</p>
            <h1 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold text-white sm:text-4xl">Tin tức &amp; ưu đãi</h1>
            <p class="mt-3 max-w-2xl text-sm text-white/85">
                Cập nhật khuyến mãi, xu hướng làm đẹp và hoạt động tại ZenStyle Triều Khúc.
            </p>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var h = document.getElementById('site-header');
            if (h) h.setAttribute('data-on-banner', 'true');
        });
    </script>

    <section class="bg-stone-50 px-4 py-14 sm:px-6 md:py-16">
        <div class="mx-auto max-w-6xl">
            <!-- Category Filter -->
            <div class="mb-10 rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
                <form method="GET" action="{{ route('news') }}" class="flex flex-col gap-4 sm:flex-row sm:items-end sm:gap-3">
                    <div class="flex-1">
                        <label for="category" class="block text-sm font-semibold text-stone-700 mb-2">
                            Danh mục
                        </label>
                        <select 
                            name="category" 
                            id="category"
                            class="w-full rounded-lg border border-stone-300 bg-white px-4 py-2.5 text-stone-900 transition focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 focus:outline-none"
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
                            class="inline-flex items-center rounded-lg border border-stone-300 bg-white px-5 py-2.5 font-medium text-stone-700 transition hover:bg-stone-50 hover:border-stone-400 active:bg-stone-100 focus:outline-none focus:ring-2 focus:ring-stone-500/20"
                        >
                            Reset
                        </a>
                        <button 
                            type="submit"
                            class="inline-flex items-center rounded-lg bg-rose-600 px-5 py-2.5 font-medium text-white transition hover:bg-rose-700 active:bg-rose-800 focus:outline-none focus:ring-2 focus:ring-rose-500/50"
                        >
                            Lọc
                        </button>
                    </div>
                </form>
                
                <!-- Result Count -->
                <div class="mt-4 text-sm text-stone-600">
                    <span class="font-medium text-stone-700">{{ $resultCount }}</span> kết quả
                    @if ($selectedCategory)
                        <span class="text-stone-500">cho danh mục "<span class="font-medium text-stone-700">{{ $selectedCategory }}</span>"</span>
                    @endif
                </div>
            </div>

            <!-- Posts Grid -->
            @if (count($posts) > 0)
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $post)
                    <article
                        class="group relative flex cursor-pointer flex-col overflow-hidden rounded-2xl border border-stone-200/90 bg-white shadow-sm ring-1 ring-stone-900/5 transition hover:border-rose-200/70 hover:shadow-md"
                    >
                        <img
                            src="{{ $post['image'] }}"
                            alt=""
                            class="h-44 w-full object-cover transition duration-300 group-hover:scale-[1.02]"
                            loading="lazy"
                            role="presentation"
                        >
                        <div class="relative flex flex-1 flex-col p-5">
                            <time class="text-xs font-medium uppercase tracking-wide text-stone-500" datetime="{{ $post['date'] }}">
                                {{ $post['date_label'] }}
                            </time>
                            <h2 id="news-title-{{ $post['slug'] }}" class="mt-2 font-['Playfair_Display',serif] text-xl font-semibold leading-snug text-stone-900">
                                {{ $post['title'] }}
                            </h2>
                            <span
                                class="mr-auto mt-3 inline-flex rounded-full bg-rose-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-rose-800 ring-1 ring-rose-200/70"
                            >
                                {{ $post['tag'] }}
                            </span>
                            <p class="mt-3 text-sm leading-relaxed text-stone-600">{{ $post['excerpt'] }}</p>
                        </div>
                        <a
                            href="{{ route('news.show', $post['slug']) }}"
                            class="absolute inset-0 z-10 rounded-2xl outline-none ring-inset ring-rose-500 focus-visible:ring-2"
                            aria-labelledby="news-title-{{ $post['slug'] }}"
                        ></a>
                    </article>
                @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-stone-500 text-lg">Không có bài viết nào trong danh mục này.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
