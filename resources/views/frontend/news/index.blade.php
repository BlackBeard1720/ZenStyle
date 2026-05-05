@extends('layouts.frontend.app')

@section('title', 'ZenStyle — Tin tức')

@section('main_class', 'pt-0')

@section('content')
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var h = document.getElementById('site-header');
            if (h) h.setAttribute('data-on-banner', 'true');
        });
    </script>

    <section class="bg-stone-50 px-4 py-14 sm:px-6 md:py-16">
        <div class="mx-auto max-w-6xl">
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
        </div>
    </section>
@endsection
