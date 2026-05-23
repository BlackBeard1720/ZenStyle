<x-frontend.layout :title="$post['title'].' — Tin tức ZenStyle'" main-class="bg-gradient-to-b from-zen-bg via-zen-bg-soft to-white pt-20">
    <article itemscope itemtype="https://schema.org/Article" class="mx-auto max-w-3xl px-4 pb-14 sm:px-6 md:pb-20">
        <nav class="text-xs font-medium text-zen-muted" aria-label="Breadcrumb">
            <a href="{{ route('news') }}" class="text-zen-primary transition hover:text-zen-primary-dark">← Tin tức &amp; ưu đãi</a>
        </nav>
        <span
            class="mt-6 inline-flex rounded-full bg-zen-accent-soft px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-zen-primary-dark ring-1 ring-zen-border"
        >
            {{ $post['tag'] }}
        </span>
        <h1 itemprop="headline" class="mt-4 font-heading text-2xl font-semibold leading-snug text-zen-text sm:text-3xl lg:text-4xl">
            {{ $post['title'] }}
        </h1>
        <time
            datetime="{{ $post['date'] }}"
            class="mt-3 block text-xs font-semibold uppercase tracking-wide text-zen-muted sm:text-sm"
            itemprop="datePublished"
        >
            {{ $post['date_label'] }}
        </time>

        <div class="mt-8 overflow-hidden rounded-zen-lg border border-zen-border bg-white shadow-zen-md ring-1 ring-zen-border">
            <img
                src="{{ $post['image'] }}"
                alt="{{ $post['title'] }}"
                class="aspect-[21/9] w-full object-cover sm:aspect-[24/10]"
                itemprop="image"
                decoding="async"
            >
            <div itemprop="articleBody" class="border-t border-zen-border px-6 py-8 text-zen-text sm:px-8 sm:py-10">
                @if($post['summary'])
                    <p class="text-base leading-relaxed text-zen-muted">{{ $post['summary'] }}</p>
                @endif
                <div class="mt-8 space-y-5 text-[15px] leading-relaxed sm:text-base">
                    {!! $post['body'] !!}
                </div>
            </div>
        </div>

        <p class="mt-10 flex flex-wrap items-center gap-4 border-t border-zen-border pt-8 text-sm text-zen-muted">
            <a href="{{ route('news') }}" class="inline-flex rounded-full bg-zen-bg-dark px-4 py-2 font-semibold text-white transition hover:bg-zen-primary-dark">
                ← Về danh sách tin
            </a>
            <a href="{{ route('booking') }}" class="font-semibold text-zen-primary hover:text-zen-primary-dark">
                Đặt lịch ngay
            </a>
        </p>

        <!-- Navigation between posts -->
        <nav class="mt-12 grid gap-4 sm:grid-cols-2 border-t border-zen-border pt-8">
            @if ($prevPost)
                <a
                    href="{{ route('news.show', $prevPost['slug']) }}"
                    class="group flex flex-col gap-2 rounded-zen-md border border-zen-border bg-white p-4 transition hover:border-zen-border-dark hover:shadow-zen-md"
                >
                    <span class="text-xs font-semibold uppercase tracking-wide text-zen-muted">← Bài trước</span>
                    <h3 class="font-semibold text-zen-text group-hover:text-zen-primary line-clamp-2">{{ $prevPost['title'] }}</h3>
                    <span class="text-xs text-zen-muted">{{ $prevPost['date_label'] }}</span>
                </a>
            @else
                <div></div>
            @endif

            @if ($nextPost)
                <a
                    href="{{ route('news.show', $nextPost['slug']) }}"
                    class="group flex flex-col gap-2 rounded-zen-md border border-zen-border bg-white p-4 transition hover:border-zen-border-dark hover:shadow-zen-md sm:text-right"
                >
                    <span class="text-xs font-semibold uppercase tracking-wide text-zen-muted">Bài tiếp theo →</span>
                    <h3 class="font-semibold text-zen-text group-hover:text-zen-primary line-clamp-2">{{ $nextPost['title'] }}</h3>
                    <span class="text-xs text-zen-muted">{{ $nextPost['date_label'] }}</span>
                </a>
            @endif
        </nav>
    </article>
</x-frontend.layout>
