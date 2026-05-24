<x-frontend.layout title="ZenStyle - Services" main-class="pt-0">
    @php
        $placeholderImage = 'https://placehold.co/800x600/ece8df/6f6656?text=ZenStyle+Service';
    @endphp

    <section id="site-banner" class="relative min-h-[78vh] overflow-hidden bg-zen-bg-dark" aria-label="ZenStyle Services">
        <img src="{{ $heroImage }}" alt="ZenStyle salon space" class="absolute inset-0 h-full w-full object-cover object-center" loading="eager">
        <div class="absolute inset-0 bg-gradient-to-r from-zen-bg-dark/75 via-zen-bg-dark/30 to-transparent"></div>
        <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-zen-bg to-transparent"></div>

        <div class="relative mx-auto flex min-h-[78vh] max-w-6xl items-center px-4 pb-20 pt-32 sm:px-6 lg:pb-24">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-zen-accent-soft">ZenStyle Services</p>
                <h1 class="mt-4 font-heading text-4xl font-semibold leading-tight text-white sm:text-5xl lg:text-6xl">Services</h1>
                <p class="mt-5 max-w-xl text-sm leading-relaxed text-white/85 sm:text-base">Browse all active service categories and offerings with clear descriptions, prices, and duration before booking.</p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="#service-list" class="inline-flex w-fit items-center justify-center rounded-full bg-zen-bg px-5 py-3 text-sm font-semibold text-zen-text shadow-zen transition hover:bg-zen-accent-soft">View Services</a>
                    <a href="{{ route('booking') }}" class="booking-cta inline-flex w-fit rounded-full px-6 py-3 text-sm font-semibold focus:outline-none focus-visible:ring-2 focus-visible:ring-zen-primary/50 focus-visible:ring-offset-2">Book Now</a>
                </div>
            </div>
        </div>
    </section>

    <section id="service-list" class="scroll-mt-24 border-y border-zen-border bg-white px-4 py-16 sm:px-6 lg:py-20">
        <div class="mx-auto max-w-6xl">
            <div class="mb-8 max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary-dark">Service Catalog</p>
                <h2 class="mt-3 font-heading text-3xl font-semibold leading-tight text-zen-text sm:text-4xl">Services</h2>
            </div>

            @forelse ($categories as $category)
                @if ($category->services->isNotEmpty())
                    <div class="mb-12 last:mb-0">
                        <h3 class="mb-5 font-heading text-2xl font-semibold text-zen-text">{{ $category->name }}</h3>

                        <div class="grid gap-x-6 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($category->services as $service)
                                <article id="service-{{ $service->id }}" class="group scroll-mt-28">
                                    <a href="{{ route('services.show', ['slug' => \Illuminate\Support\Str::slug($service->name)]) }}" class="block h-full cursor-pointer rounded-zen-lg outline-none transition duration-300 hover:-translate-y-1 focus-visible:ring-2 focus-visible:ring-zen-primary/40 focus-visible:ring-offset-4">
                                        <div class="relative aspect-[4/3] overflow-hidden rounded-zen-lg bg-zen-bg-soft shadow-zen">
                                            <img
                                                src="{{ $service->thumbnail ?: $placeholderImage }}"
                                                alt="{{ $service->name }}"
                                                class="h-full w-full object-cover transition duration-500 ease-out group-hover:scale-[1.05]"
                                                loading="lazy"
                                                decoding="async"
                                            >
                                            <svg class="pointer-events-none absolute -bottom-px left-0 h-16 w-full text-white" viewBox="0 0 420 80" preserveAspectRatio="none" aria-hidden="true">
                                                <path fill="currentColor" d="M0 55C58 38 98 24 154 35C209 46 257 78 315 68C358 61 386 39 420 31V80H0V55Z" />
                                            </svg>
                                        </div>
                                        <div class="-mt-1 px-4 pb-2 pt-5 text-center">
                                            <h4 class="mx-auto flex min-h-[3.5rem] max-w-xs items-center justify-center font-heading text-xl font-semibold uppercase leading-tight text-zen-text">{{ $service->name }}</h4>
                                            <p class="mx-auto mt-3 min-h-[4rem] max-w-xs text-sm leading-relaxed text-zen-muted">{{ $service->description }}</p>
                                            <div class="mx-auto mt-5 grid max-w-xs gap-2 border-t border-zen-border pt-3 text-sm text-zen-primary">
                                                <span class="font-semibold">Price: {{ number_format((float) $service->price, 0) }} VND</span>
                                                <span class="font-semibold">Duration: {{ (int) $service->duration }} minutes</span>
                                            </div>
                                        </div>
                                    </a>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
            @empty
                <div class="rounded-zen-lg border border-zen-border bg-zen-bg-soft px-8 py-16 text-center">
                    <h3 class="mt-4 font-semibold text-zen-text">No services found</h3>
                </div>
            @endforelse
        </div>
    </section>

    <section class="bg-gradient-to-b from-zen-bg-soft via-zen-bg-soft to-white px-4 py-16 sm:px-6 lg:py-20">
        <div class="mx-auto max-w-6xl">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary-dark">Our Team</p>
                    <h2 class="mt-3 font-heading text-3xl font-semibold text-zen-text sm:text-4xl">Your service companions.</h2>
                </div>
                <a href="{{ route('about') }}" class="text-sm font-semibold text-zen-primary hover:text-zen-primary-dark">Learn more</a>
            </div>
            <div class="mt-10 grid gap-6 md:grid-cols-3">
                @foreach ($staff as $member)
                    <article class="overflow-hidden rounded-zen-lg border border-zen-border bg-white shadow-zen transition hover:-translate-y-1 hover:shadow-zen-md">
                        <div class="aspect-[4/3] overflow-hidden bg-zen-bg-soft">
                            <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}" class="h-full w-full object-cover transition duration-500 hover:scale-[1.03]" loading="lazy">
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-semibold text-zen-text">{{ $member['name'] }}</h3>
                            <p class="mt-1 text-sm font-medium text-zen-primary">{{ $member['role'] }}</p>
                            <p class="mt-3 text-sm leading-relaxed text-zen-muted">{{ $member['focus'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</x-frontend.layout>
