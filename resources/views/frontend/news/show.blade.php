@extends('layouts.frontend.app')

@section('title', $post['title'].' — Tin tức ZenStyle')

@section('content')
    <article itemscope itemtype="https://schema.org/Article" class="mx-auto max-w-3xl px-4 pb-14 sm:px-6 md:pb-16">
        <nav class="text-xs font-medium text-stone-500" aria-label="Breadcrumb">
            <a href="{{ route('news') }}" class="text-rose-700 transition hover:text-rose-900">← Tin tức &amp; ưu đãi</a>
        </nav>
        <span
            class="mt-6 inline-flex rounded-full bg-rose-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-rose-800 ring-1 ring-rose-200/70"
        >
            {{ $post['tag'] }}
        </span>
        <h1 itemprop="headline" class="mt-4 font-['Playfair_Display',serif] text-2xl font-semibold leading-snug text-stone-900 sm:text-3xl lg:text-4xl">
            {{ $post['title'] }}
        </h1>
        <time
            datetime="{{ $post['date'] }}"
            class="mt-3 block text-xs font-semibold uppercase tracking-wide text-stone-500 sm:text-sm"
            itemprop="datePublished"
        >
            {{ $post['date_label'] }}
        </time>

        <div class="mt-8 overflow-hidden rounded-2xl border border-stone-200/90 bg-white shadow-lg ring-1 ring-stone-900/5">
            <img
                src="{{ $post['image'] }}"
                alt="{{ $post['title'] }}"
                class="aspect-[21/9] w-full object-cover sm:aspect-[24/10]"
                itemprop="image"
                decoding="async"
            >
            <div itemprop="articleBody" class="border-t border-stone-100 px-6 py-8 text-stone-700 sm:px-8 sm:py-10">
                <p class="text-base leading-relaxed text-stone-600">{{ $post['excerpt'] }}</p>
                <div class="mt-8 space-y-5 text-[15px] leading-relaxed sm:text-base">
                    @foreach ($post['paragraphs'] as $p)
                        <p>{{ $p }}</p>
                    @endforeach
                </div>
            </div>
        </div>

        <p class="mt-10 flex flex-wrap items-center gap-4 border-t border-stone-200 pt-8 text-sm text-stone-500">
            <a href="{{ route('news') }}" class="inline-flex rounded-full bg-stone-900 px-4 py-2 font-semibold text-white transition hover:bg-stone-800">
                ← Về danh sách tin
            </a>
            <a href="{{ route('booking') }}" class="font-semibold text-rose-700 hover:text-rose-800">
                Đặt lịch ngay
            </a>
        </p>

        <!-- Navigation between posts -->
        <nav class="mt-12 grid gap-4 sm:grid-cols-2 border-t border-stone-200 pt-8">
            @if ($prevPost)
                <a 
                    href="{{ route('news.show', $prevPost['slug']) }}"
                    class="group flex flex-col gap-2 rounded-xl border border-stone-200 bg-white p-4 transition hover:border-rose-200 hover:shadow-md"
                >
                    <span class="text-xs font-semibold uppercase tracking-wide text-stone-500">← Bài trước</span>
                    <h3 class="font-semibold text-stone-900 group-hover:text-rose-700 line-clamp-2">{{ $prevPost['title'] }}</h3>
                    <span class="text-xs text-stone-500">{{ $prevPost['date_label'] }}</span>
                </a>
            @else
                <div></div>
            @endif

            @if ($nextPost)
                <a 
                    href="{{ route('news.show', $nextPost['slug']) }}"
                    class="group flex flex-col gap-2 rounded-xl border border-stone-200 bg-white p-4 transition hover:border-rose-200 hover:shadow-md sm:text-right"
                >
                    <span class="text-xs font-semibold uppercase tracking-wide text-stone-500">Bài tiếp theo →</span>
                    <h3 class="font-semibold text-stone-900 group-hover:text-rose-700 line-clamp-2">{{ $nextPost['title'] }}</h3>
                    <span class="text-xs text-stone-500">{{ $nextPost['date_label'] }}</span>
                </a>
            @endif
        </nav>
    </article>
@endsection
