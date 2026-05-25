<x-frontend.layout title="ZenStyle - Services" main-class="pt-0">
  @php
    $placeholderImage = 'https://placehold.co/800x600/ece8df/6f6656?text=ZenStyle+Service';
  @endphp

  <section class="px-4 pb-8 pt-30 sm:px-6 lg:pt-35 bg-zen-accent-soft">
    <div class="mx-auto max-w-4xl text-center">
      <h1 class="font-heading text-3xl font-semibold text-zen-text sm:text-4xl">
        Our Services
      </h1>

      <p class="mx-auto mt-4 max-w-2xl text-sm leading-relaxed text-zen-muted sm:text-base">
        Discover our range of professional treatments. Find the perfect service for your needs and book your next
        appointment with us.
      </p>
    </div>
  </section>

  <section class="px-4 py-10 sm:px-6 lg:py-14">
    <div class="mx-auto max-w-6xl">
      <form action="{{ route('services') }}" method="GET" class="mb-10">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
          <div class="flex flex-wrap items-center gap-x-5 gap-y-3">
            @foreach ($categories as $category)
              <label class="flex cursor-pointer items-center gap-2 text-sm text-zen-text">
                <input
                  type="checkbox"
                  name="categories[]"
                  value="{{ $category->id }}"
                  onchange="this.form.submit()"
                  class="h-4 w-4 rounded"
                  {{ in_array((string) $category->id, $selectedCategories ?? [], true) ? 'checked' : '' }}
                >
                <span>{{ $category->name }}</span>
              </label>
            @endforeach
          </div>

          <select
            name="sort"
            onchange="this.form.submit()"
            class="w-full rounded-md border border-zen-border bg-white px-3 py-2 text-sm text-zen-text focus:border-zen-accent focus:outline-none sm:w-56"
          >
            <option value="" {{ $selectedSort === '' ? 'selected' : '' }}>Sort services</option>
            <option value="price_asc" {{ $selectedSort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_desc" {{ $selectedSort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
          </select>
        </div>
      </form>

      @if ($services->isEmpty())
        <div class="rounded-zen-lg border border-zen-border bg-zen-bg-soft px-6 py-14 text-center">
          <h2 class="text-xl font-semibold text-zen-text">No services found</h2>
          <p class="mt-2 text-sm text-zen-muted">Try changing your category filter.</p>
        </div>
      @else
        <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
          @foreach ($services as $service)
            <article class="overflow-hidden rounded-zen-lg border border-zen-border bg-white shadow-zen">
              <a
                href="{{ route('services.show', ['slug' => \Illuminate\Support\Str::slug($service->name)]) }}"
                class="block aspect-[4/3] overflow-hidden bg-zen-bg-soft"
              >
                <img
                  src="{{ $service->thumbnail ?: $placeholderImage }}"
                  alt="{{ $service->name }}"
                  class="h-full w-full object-cover transition duration-300 hover:scale-[1.03]"
                  loading="lazy"
                  decoding="async"
                >
              </a>

              <div class="p-4">
                <p class="text-xs font-medium uppercase tracking-wide text-zen-accent-dark">
                  {{ optional($service->category)->name ?? 'Uncategorized' }}
                </p>

                <h3 class="mt-1 text-lg font-semibold text-zen-text">
                  {{ $service->name }}
                </h3>

                <p class="mt-2 line-clamp-3 text-sm text-zen-muted">
                  {{ $service->description }}
                </p>

                <div class="mt-4 space-y-1 border-t border-zen-border pt-3 text-sm">
                  <p class="font-semibold text-zen-text">
                    {{ number_format((float) $service->price, 0) }} VND
                  </p>
                  <p class="text-zen-muted">
                    {{ (int) $service->duration }} minutes
                  </p>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-2">
                  <a
                    href="{{ route('booking') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-zen-primary px-3 py-2 text-sm font-semibold text-white transition hover:bg-zen-primary-dark"
                  >
                    Book Now
                  </a>

                  <a
                    href="{{ route('services.show', ['slug' => \Illuminate\Support\Str::slug($service->name)]) }}"
                    class="inline-flex items-center justify-center rounded-lg border border-zen-border px-3 py-2 text-sm font-semibold text-zen-text transition hover:border-zen-accent hover:text-zen-accent-dark"
                  >
                    View Detail
                  </a>
                </div>
              </div>
            </article>
          @endforeach
        </div>

        <div class="mt-8">
          {{ $services->withQueryString()->links() }}
        </div>
      @endif
    </div>
  </section>
</x-frontend.layout>
