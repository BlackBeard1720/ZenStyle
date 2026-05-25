<x-frontend.layout title="ZenStyle - Services" main-class="pt-0">
    @php
        $placeholderImage = 'https://placehold.co/800x600/ece8df/6f6656?text=ZenStyle+Service';
    @endphp

    <section class="px-4 pb-8 pt-10 sm:px-6 lg:pt-12">
        <div class="mx-auto max-w-6xl rounded-zen-lg border border-zen-border bg-zen-bg-soft p-6 sm:p-8">
            <h1 class="font-heading text-3xl font-semibold text-zen-text sm:text-4xl">ZenStyle Service Catalog</h1>
            <p class="mt-3 max-w-3xl text-sm leading-relaxed text-zen-muted sm:text-base">
                Explore our salon services, compare prices and duration, then book the best option for you.
            </p>
        </div>
    </section>

    <section class="px-4 pb-16 sm:px-6 lg:pb-20">
        <div class="mx-auto grid max-w-6xl gap-6 lg:grid-cols-4 lg:gap-8">
            <aside class="lg:col-span-1">
                <form action="{{ route('services') }}" method="GET" class="rounded-zen-lg border border-zen-border bg-white p-5 shadow-zen">
                    <div>
                        <label for="keyword" class="text-sm font-semibold text-zen-text">Search</label>
                        <input
                            id="keyword"
                            type="text"
                            name="keyword"
                            value="{{ $keyword }}"
                            placeholder="Search by service name..."
                            class="mt-2 w-full rounded-lg border border-zen-border bg-zen-bg px-3 py-2 text-sm text-zen-text placeholder:text-zen-muted focus:border-zen-primary focus:outline-none"
                        >
                    </div>

                    <div class="mt-6">
                        <h2 class="text-sm font-semibold text-zen-text">Service Categories</h2>
                        <div class="mt-3 space-y-2">
                            <label class="flex cursor-pointer items-center gap-2 text-sm text-zen-muted">
                                <input type="radio" name="category" value="all" class="h-4 w-4 border-zen-border text-zen-primary focus:ring-zen-primary" {{ $selectedCategory === 'all' ? 'checked' : '' }}>
                                <span>All</span>
                            </label>
                            @foreach ($categories as $category)
                                <label class="flex cursor-pointer items-center gap-2 text-sm text-zen-muted">
                                    <input type="radio" name="category" value="{{ $category->id }}" class="h-4 w-4 border-zen-border text-zen-primary focus:ring-zen-primary" {{ (string) $selectedCategory === (string) $category->id ? 'checked' : '' }}>
                                    <span>{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="sort" class="text-sm font-semibold text-zen-text">Sort by Price</label>
                        <select
                            id="sort"
                            name="sort"
                            class="mt-2 w-full rounded-lg border border-zen-border bg-zen-bg px-3 py-2 text-sm text-zen-text focus:border-zen-primary focus:outline-none"
                        >
                            <option value="" {{ $selectedSort === '' ? 'selected' : '' }}>Default</option>
                            <option value="price_asc" {{ $selectedSort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ $selectedSort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-zen-primary px-4 py-2 text-sm font-semibold text-white transition hover:bg-zen-primary-dark">
                            Apply Filters
                        </button>
                        <a href="{{ route('services') }}" class="inline-flex items-center justify-center rounded-lg border border-zen-border bg-zen-bg px-4 py-2 text-sm font-semibold text-zen-text transition hover:bg-zen-bg-soft">
                            Clear Filters
                        </a>
                    </div>
                </form>
            </aside>

            <div class="lg:col-span-3">
                @if ($services->isEmpty())
                    <div class="rounded-zen-lg border border-zen-border bg-zen-bg-soft px-6 py-14 text-center">
                        <h2 class="text-xl font-semibold text-zen-text">No services found</h2>
                        <p class="mt-2 text-sm text-zen-muted">Try changing your keyword or category filter.</p>
                    </div>
                @else
                    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                        @foreach ($services as $service)
                            <article class="overflow-hidden rounded-zen-lg border border-zen-border bg-white shadow-zen">
                                <a href="{{ route('services.show', ['slug' => \Illuminate\Support\Str::slug($service->name)]) }}" class="block aspect-[4/3] overflow-hidden bg-zen-bg-soft">
                                    <img
                                        src="{{ $service->thumbnail ?: $placeholderImage }}"
                                        alt="{{ $service->name }}"
                                        class="h-full w-full object-cover transition duration-300 hover:scale-[1.03]"
                                        loading="lazy"
                                        decoding="async"
                                    >
                                </a>
                                <div class="p-4">
                                    <p class="text-xs font-medium uppercase tracking-wide text-zen-primary">{{ optional($service->category)->name ?? 'Uncategorized' }}</p>
                                    <h3 class="mt-1 text-lg font-semibold text-zen-text">{{ $service->name }}</h3>
                                    <p class="mt-2 line-clamp-3 text-sm text-zen-muted">{{ $service->description }}</p>
                                    <div class="mt-4 space-y-1 border-t border-zen-border pt-3 text-sm">
                                        <p class="font-semibold text-zen-text">{{ number_format((float) $service->price, 0) }} VND</p>
                                        <p class="text-zen-muted">{{ (int) $service->duration }} minutes</p>
                                    </div>
                                    <div class="mt-4 grid grid-cols-2 gap-2">
                                        <a href="{{ route('booking') }}" class="inline-flex items-center justify-center rounded-lg bg-zen-primary px-3 py-2 text-sm font-semibold text-white transition hover:bg-zen-primary-dark">Book Now</a>
                                        <a href="{{ route('services.show', ['slug' => \Illuminate\Support\Str::slug($service->name)]) }}" class="inline-flex items-center justify-center rounded-lg border border-zen-border px-3 py-2 text-sm font-semibold text-zen-text transition hover:bg-zen-bg-soft">View Detail</a>
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
        </div>
    </section>
</x-frontend.layout>
