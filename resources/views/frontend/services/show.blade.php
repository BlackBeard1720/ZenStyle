<x-frontend.layout :title="$service->name.' - Services'" main-class="bg-gradient-to-b from-zen-bg via-zen-bg-soft to-white pt-20">
    @php
        $placeholderImage = 'https://placehold.co/1200x800/ece8df/6f6656?text=ZenStyle+Service';
    @endphp

    <article class="mx-auto max-w-6xl px-4 pb-14 sm:px-6 md:pb-20">
        <nav class="flex flex-wrap items-center gap-2 text-xs font-medium text-zen-muted" aria-label="Breadcrumb">
            <a href="{{ route('services') }}" class="text-zen-primary transition hover:text-zen-primary-dark">Services</a>
            <span aria-hidden="true">›</span>
            <span class="text-zen-text">{{ $service->name }}</span>
        </nav>

        <section class="mt-6 grid gap-8 lg:grid-cols-[minmax(0,1fr)_24rem] lg:items-start">
            <div class="overflow-hidden rounded-zen-lg border border-zen-border bg-white shadow-zen-md">
                <img src="{{ $service->thumbnail ?: $placeholderImage }}" alt="{{ $service->name }}" class="aspect-[4/3] w-full object-cover sm:aspect-[16/10]" decoding="async">
            </div>

            <aside class="rounded-zen-lg border border-zen-border bg-white p-5 shadow-zen-md lg:sticky lg:top-24">
                <span class="inline-flex rounded-full bg-zen-accent-soft px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-zen-primary-dark ring-1 ring-zen-border">
                    {{ $service->category?->name ?? 'Services' }}
                </span>

                <h1 class="mt-4 font-heading text-3xl font-semibold leading-tight text-zen-text sm:text-4xl">{{ $service->name }}</h1>
                <p class="mt-4 text-sm leading-relaxed text-zen-muted sm:text-base">{{ $service->description }}</p>

                <dl class="mt-6 grid gap-3">
                    <div class="grid grid-cols-[6.5rem_minmax(0,1fr)] items-center gap-4 rounded-zen-sm bg-zen-bg-soft px-4 py-3">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-zen-muted">Duration</dt>
                        <dd class="text-right text-lg font-semibold text-zen-text">{{ (int) $service->duration }} minutes</dd>
                    </div>
                    <div class="grid grid-cols-[6.5rem_minmax(0,1fr)] items-center gap-4 rounded-zen-sm bg-zen-accent-soft px-4 py-3">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-zen-primary-dark">Price</dt>
                        <dd class="text-right text-lg font-semibold text-zen-primary">{{ number_format((float) $service->price, 0) }} VND</dd>
                    </div>
                </dl>

                <div class="mt-5 grid gap-3">
                    <a href="{{ route('booking') }}" class="booking-cta inline-flex w-full items-center justify-center rounded-full px-6 py-3 text-sm font-semibold">Book Now</a>
                    <a href="{{ route('services') }}" class="inline-flex w-full items-center justify-center rounded-full border border-zen-primary bg-white px-6 py-3 text-sm font-semibold text-zen-primary transition hover:bg-zen-accent-soft">Back to Services</a>
                </div>
            </aside>
        </section>

        @if($relatedServices->isNotEmpty())
            <section class="mt-12 border-t border-zen-border pt-8">
                <h2 class="font-heading text-2xl font-semibold text-zen-text">Related Services</h2>
                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($relatedServices as $related)
                        <article class="group flex h-full flex-col overflow-hidden rounded-zen-md border border-zen-border bg-white shadow-zen transition hover:-translate-y-1 hover:shadow-zen-md">
                            <a href="{{ route('services.show', ['slug' => \Illuminate\Support\Str::slug($related->name)]) }}" class="block overflow-hidden bg-zen-bg-soft">
                                <img src="{{ $related->thumbnail ?: $placeholderImage }}" alt="{{ $related->name }}" class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-[1.04]" loading="lazy">
                            </a>
                            <div class="flex flex-1 flex-col p-4">
                                <h3 class="font-semibold text-zen-text transition group-hover:text-zen-primary">
                                    <a href="{{ route('services.show', ['slug' => \Illuminate\Support\Str::slug($related->name)]) }}">{{ $related->name }}</a>
                                </h3>
                                <p class="mt-2 text-sm text-zen-muted">{{ $related->description }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </article>
</x-frontend.layout>
