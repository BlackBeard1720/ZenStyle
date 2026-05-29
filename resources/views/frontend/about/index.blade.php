<x-frontend.layout title="ZenStyle - About" main-class="pt-0">
    @php
        $heroImage = asset('images/frontend/about-hero-img.png');
        $stats = [
            ['value' => '4+', 'label' => 'years of concept development'],
            ['value' => '6+', 'label' => 'featured services'],
            ['value' => '100%', 'label' => 'clear booking flow'],
        ];

        $values = [
            [
                'number' => '01',
                'title' => 'Thoughtful consultation',
                'body' => 'Every appointment starts with listening to the customer’s hair condition, preferences, and daily styling habits.',
            ],
            [
                'number' => '02',
                'title' => 'Transparent services',
                'body' => 'Service duration, pricing, and care notes are clearly presented before customers make a booking.',
            ],
            [
                'number' => '03',
                'title' => 'Convenient booking experience',
                'body' => 'The online booking flow helps customers choose services, time slots, and stylists with less waiting.',
            ],
        ];

        $timeline = [
            [
                'year' => '2023',
                'title' => 'The beginning',
                'body' => 'ZenStyle started as an idea to build a friendly salon experience with a clear and reliable service process.',
            ],
            [
                'year' => '2024',
                'title' => 'Service expansion',
                'body' => 'Hair coloring, texture perm, relaxing shampoo, and recovery treatment services were added to serve more customer needs.',
            ],
            [
                'year' => '2025',
                'title' => 'Process standardization',
                'body' => 'ZenStyle improved the online booking flow, service records, and appointment confirmation process.',
            ],
            [
                'year' => '2026',
                'title' => 'ZenStyle today',
                'body' => 'ZenStyle is growing as a beauty destination with stylists, spa specialists, and advisors supporting each customer journey.',
            ],
        ];

        $reasons = [
            ['title' => 'Fast appointment booking', 'body' => 'Choose your preferred date, time, and service directly on the website.'],
            ['title' => 'Clear service information', 'body' => 'Pricing, duration, and important notes are shown before confirmation.'],
            ['title' => 'Staff profiles from real data', 'body' => 'Stylists are displayed from the system database instead of static sample content.'],
            ['title' => 'Relaxing salon atmosphere', 'body' => 'A warm visual style and simple flow help customers feel comfortable from the first visit.'],
        ];
    @endphp

    <section
        id="about-hero"
        class="bg-white px-4 pb-12 pt-28 sm:px-6 sm:pt-32 lg:pb-20 lg:pt-40"
        aria-label="ZenStyle Story"
    >
        <div class="mx-auto max-w-6xl">
            <div class="grid gap-10 lg:grid-cols-2 lg:gap-16 lg:items-center">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-zen-primary">ZENSTYLE STORY</p>
                    <h1 class="mt-4 font-heading text-4xl font-semibold leading-tight text-zen-text sm:text-5xl lg:text-[3.5rem] lg:leading-[1.1]">
                        From a small studio to a beauty destination
                    </h1>
                    <p class="mt-6 text-base leading-relaxed text-zen-muted sm:text-lg">
                        ZenStyle combines stylist skills, a relaxing salon and spa atmosphere, and a clear booking process to make every beauty appointment gentle, professional, and reliable.
                    </p>
                </div>
                <div>
                    <div class="relative overflow-hidden rounded-2xl shadow-zen-md">
                        <img
                            src="{{ $heroImage }}"
                            alt="ZenStyle hair care space"
                            class="aspect-[4/3] w-full object-cover object-center sm:aspect-[3/2] lg:aspect-[4/5]"
                            loading="eager"
                        >
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white px-4 py-12 sm:px-6 lg:py-14">
        <div class="mx-auto max-w-5xl">
            <div class="max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">About Us</p>
                <h2 class="mt-3 font-heading text-3xl font-semibold text-zen-text sm:text-4xl">
                    What is ZenStyle?
                </h2>
                <p class="mt-4 text-sm leading-7 text-zen-muted sm:text-base">
                    ZenStyle is an experience-driven salon and spa model: clear services, transparent schedules, attentive stylists, and a personalized care process for each customer.
                </p>
                <blockquote class="mt-5 rounded-zen-md border border-zen-border bg-zen-bg px-5 py-4 text-sm font-medium leading-7 text-zen-text shadow-sm">
                    Beauty should begin with clear consultation, proper care, and leaving the salon with a more confident style.
                </blockquote>
            </div>

            <div class="mt-7 grid gap-4 sm:grid-cols-3">
                @foreach ($stats as $stat)
                    <div class="rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-sm">
                        <p class="font-heading text-4xl font-semibold leading-none text-zen-primary">{{ $stat['value'] }}</p>
                        <p class="mt-3 text-sm font-medium leading-snug text-zen-text">
                            {{ $stat['label'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-zen-bg-soft px-4 py-12 sm:px-6 lg:py-16">
        <div class="mx-auto max-w-6xl">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Core Values</p>
                <h2 class="mt-3 font-heading text-3xl font-semibold text-zen-text sm:text-4xl">
                    Values ZenStyle pursues
                </h2>
            </div>

            <div class="mt-8 grid gap-4 md:grid-cols-3">
                @foreach ($values as $value)
                    <article class="group rounded-zen-lg border border-zen-border bg-white p-5 shadow-zen">
                        <div class="flex items-start gap-4">
                            <span class="grid size-9 shrink-0 place-items-center rounded-full bg-zen-accent-soft text-xs font-semibold text-zen-primary ring-1 ring-zen-border">
                                {{ $value['number'] }}
                            </span>
                            <div>
                                <h3 class="text-lg font-semibold text-zen-text">{{ $value['title'] }}</h3>
                                <p class="mt-2 text-sm leading-6 text-zen-muted">{{ $value['body'] }}</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white px-4 py-12 sm:px-6 lg:py-16">
        <div class="mx-auto max-w-6xl">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Journey</p>
                <h2 class="mt-3 font-heading text-3xl font-semibold text-zen-text sm:text-4xl">
                    The ZenStyle Journey
                </h2>
                <p class="mt-3 text-sm leading-relaxed text-zen-muted">
                    Four key milestones that shape how ZenStyle serves customers today.
                </p>
            </div>

            <ol class="relative mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <span class="absolute left-0 right-0 top-6 hidden h-px bg-zen-border lg:block" aria-hidden="true"></span>
                @foreach ($timeline as $item)
                    <li class="relative">
                        <article class="relative h-full rounded-zen-lg border border-zen-border bg-zen-bg p-5 shadow-zen">
                            <div class="flex items-center gap-3">
                                <span class="grid size-8 place-items-center rounded-full border border-zen-primary/25 bg-white text-[11px] font-semibold text-zen-primary shadow-sm">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <p class="text-xs font-bold uppercase tracking-[0.2em] text-zen-primary">{{ $item['year'] }}</p>
                            </div>
                            <h3 class="mt-4 text-lg font-semibold text-zen-text">{{ $item['title'] }}</h3>
                            <p class="mt-2 text-sm leading-6 text-zen-muted">{{ $item['body'] }}</p>
                        </article>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <section class="bg-gradient-to-b from-zen-bg-soft to-white px-4 py-14 sm:px-6 lg:py-16">
        <div class="mx-auto max-w-6xl">
            <div class="max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Our team</p>
                <h2 class="mt-3 font-heading text-3xl font-semibold text-zen-text sm:text-4xl">
                    Meet the ZenStyle stylists
                </h2>
                <p class="mt-3 text-sm leading-relaxed text-zen-muted sm:text-base">
                    Each team member brings a clear specialty, with the same goal: thoughtful consultation, clean execution, and a comfortable salon experience.
                </p>
            </div>

            @if($teamMembers->isEmpty())
                <div class="mt-10 rounded-zen-lg border border-zen-border bg-zen-bg p-8 text-center shadow-sm">
                    <p class="text-sm font-medium text-zen-muted">Our stylist team will be updated soon.</p>
                </div>
            @else
                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($teamMembers as $member)
                        <article class="group overflow-hidden rounded-none border border-zen-border bg-white shadow-sm">
                            <div class="aspect-[4/3] overflow-hidden bg-zen-bg-soft">
                                <img
                                    src="{{ $member->avatar ? asset('storage/' . $member->avatar) : asset('images/tailadmin/user/user-01.jpg') }}"
                                    alt="{{ $member->full_name }}"
                                    class="h-full w-full object-cover"
                                    loading="lazy"
                                >
                            </div>
                            <div class="p-5">
                                <h3 class="text-lg font-semibold text-zen-text">{{ $member->full_name }}</h3>
                                <p class="mt-1 text-sm font-medium text-zen-primary">{{ $member->specialization ?? 'ZenStyle Stylist' }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="bg-white px-4 py-14 sm:px-6 lg:py-16">
        <div class="mx-auto max-w-6xl">
            <div class="grid gap-10 lg:grid-cols-[0.8fr_1.2fr] lg:items-start">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Why choose ZenStyle?</p>
                    <h2 class="mt-3 font-heading text-3xl font-semibold text-zen-text sm:text-4xl">
                        A clear beauty experience from start to finish.
                    </h2>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach ($reasons as $reason)
                        <article class="rounded-zen-lg border border-zen-border bg-zen-bg p-5">
                            <h3 class="font-semibold text-zen-text">{{ $reason['title'] }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-zen-muted">{{ $reason['body'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-frontend.layout>
