<x-frontend.layout title="ZenStyle — Tin tức" main-class="pt-0">

  <section class="border-b border-zen-border bg-zen-surface px-4 pb-10 pt-30 sm:px-6 lg:pb-12 lg:pt-35">
    <div class="mx-auto max-w-4xl text-center">
      <h1 class="mt-3 font-heading text-3xl font-semibold text-zen-text sm:text-4xl">
        News & Beauty Tips
      </h1>

      <p class="mx-auto mt-4 max-w-2xl text-sm leading-relaxed text-zen-muted sm:text-base">
        Explore beauty trends, hair care tips, salon stories, and the latest updates from ZenStyle.
      </p>
    </div>
  </section>

  <section
    class="bg-linear-to-b from-zen-accent-soft/45 via-zen-bg-soft to-zen-bg px-4 py-14 sm:px-6 md:py-16 lg:pb-20">
    <div class="mx-auto max-w-6xl">
      <!-- Posts Grid -->
      @if ($posts->count() > 0)
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
          @foreach ($posts as $post)
            <article class="flex h-full flex-col bg-transparent">
              <a href="{{ $post['external_url'] }}" target="_blank" rel="noopener noreferrer">
                <img
                  src="{{ $post['image'] }}"
                  alt="{{ $post['title'] }}"
                  class="h-48 w-full object-cover"
                  loading="lazy"
                >
              </a>

              <div class="flex flex-1 flex-col pt-4">
                <h2 class="font-heading text-xl font-semibold leading-snug text-zen-text">
                  <a href="{{ $post['external_url'] }}" target="_blank" rel="noopener noreferrer">
                    {{ $post['title'] }}
                  </a>
                </h2>

                <time class="mt-2 block text-sm text-zen-muted" datetime="{{ $post['date'] }}">
                  {{ $post['date_label'] }}
                </time>

                <a
                  href="{{ $post['external_url'] }}"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="group mt-auto pt-4 inline-flex items-center gap-1 text-sm font-semibold text-zen-accent-dark transition hover:text-zen-primary"
                >
                  <span>Read more</span>
                  <x-heroicon-o-arrow-right class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-0.5" />
                </a>
              </div>
            </article>
          @endforeach
        </div>
        <div class="mt-10">
          {{ $posts->links() }}
        </div>
      @else
        <div class="text-center py-12">
          <p class="text-zen-muted text-lg">Không có bài viết nào trong danh mục này.</p>
        </div>
      @endif
    </div>
  </section>
</x-frontend.layout>
