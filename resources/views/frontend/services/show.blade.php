@php
    $categoryLabel = collect($service['badges'])->contains('Phù hợp tóc nam')
        ? 'Dịch vụ tóc nam'
        : (str_contains($service['stylist'], 'Treatment') || str_contains($service['title'], 'Gội') ? 'Chăm sóc tóc' : 'Dịch vụ ZenStyle');

    $stepTitles = ['Tư vấn tóc', 'Thực hiện dịch vụ', 'Hoàn thiện styling'];
    $processCards = collect($service['process'])->values()->map(function ($step, $index) use ($stepTitles) {
        return [
            'number' => $index + 1,
            'title' => $stepTitles[$index] ?? 'Bước '.($index + 1),
            'description' => preg_replace('/^Bước\s*\d+:\s*/u', '', $step),
        ];
    });
@endphp

<x-frontend.layout :title="$service['title'].' - Dịch vụ ZenStyle'" main-class="bg-gradient-to-b from-zen-bg via-zen-bg-soft to-white pt-20">
    <article class="mx-auto max-w-6xl px-4 pb-14 sm:px-6 md:pb-20">
        <nav class="flex flex-wrap items-center gap-2 text-xs font-medium text-zen-muted" aria-label="Breadcrumb">
            <a href="{{ route('services') }}" class="text-zen-primary transition hover:text-zen-primary-dark">Dịch vụ</a>
            <span aria-hidden="true">›</span>
            <span class="text-zen-text">{{ $service['title'] }}</span>
        </nav>

        <section class="mt-6 grid gap-8 lg:grid-cols-[minmax(0,1fr)_24rem] lg:items-start">
            <div class="min-w-0" data-service-gallery>
                <div class="overflow-hidden rounded-zen-lg border border-zen-border bg-white shadow-zen-md">
                    <img
                        data-service-gallery-main
                        src="{{ $service['images'][0] }}"
                        alt="{{ $service['title'] }}"
                        class="aspect-[4/3] w-full object-cover sm:aspect-[16/10]"
                        decoding="async"
                    >
                </div>

                <div class="mt-3 grid grid-cols-3 gap-3">
                    @foreach ($service['images'] as $index => $image)
                        <button
                            type="button"
                            data-service-gallery-thumb
                            data-image-src="{{ $image }}"
                            class="overflow-hidden rounded-zen-sm border border-zen-border bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-zen focus:outline-none focus-visible:ring-2 focus-visible:ring-zen-primary/40 {{ $index === 0 ? 'ring-2 ring-zen-primary' : 'opacity-75' }}"
                            aria-label="Xem ảnh {{ $index + 1 }} của {{ $service['title'] }}"
                            aria-pressed="{{ $index === 0 ? 'true' : 'false' }}"
                        >
                            <img
                                src="{{ $image }}"
                                alt="{{ $service['title'] }} - ảnh {{ $index + 1 }}"
                                class="aspect-[4/3] w-full object-cover"
                                loading="lazy"
                            >
                        </button>
                    @endforeach
                </div>
            </div>

            <aside class="rounded-zen-lg border border-zen-border bg-white p-5 shadow-zen-md lg:sticky lg:top-24">
                <span class="inline-flex rounded-full bg-zen-accent-soft px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-zen-primary-dark ring-1 ring-zen-border">
                    {{ $categoryLabel }}
                </span>

                <h1 class="mt-4 font-heading text-3xl font-semibold leading-tight text-zen-text sm:text-4xl">
                    {{ $service['title'] }}
                </h1>
                <p class="mt-4 text-sm leading-relaxed text-zen-muted sm:text-base">
                    {{ $service['longDescription'] }}
                </p>

                <div class="mt-5 flex flex-wrap gap-2">
                    @foreach ($service['badges'] as $badge)
                        <span class="rounded-full border border-zen-border bg-zen-bg px-3 py-1 text-xs font-semibold text-zen-primary">
                            {{ $badge }}
                        </span>
                    @endforeach
                </div>

                <dl class="mt-6 grid gap-3">
                    <div class="grid grid-cols-[6.5rem_minmax(0,1fr)] items-center gap-4 rounded-zen-sm bg-zen-bg-soft px-4 py-3">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-zen-muted">Thời lượng</dt>
                        <dd class="text-right text-lg font-semibold text-zen-text">{{ $service['duration'] }}</dd>
                    </div>
                    <div class="grid grid-cols-[6.5rem_minmax(0,1fr)] items-center gap-4 rounded-zen-sm bg-zen-accent-soft px-4 py-3">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-zen-primary-dark">Giá</dt>
                        <dd class="text-right text-lg font-semibold text-zen-primary">{{ $service['price'] }}</dd>
                    </div>
                    <div class="rounded-zen-sm border border-zen-border bg-white px-4 py-3">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-zen-muted">Stylist gợi ý</dt>
                        <dd class="mt-1 font-semibold text-zen-text">{{ $service['stylist'] }}</dd>
                    </div>
                </dl>

                <p class="mt-4 rounded-zen-sm bg-zen-bg px-4 py-3 text-sm leading-relaxed text-zen-muted">
                    Giá có thể thay đổi tùy tình trạng tóc và tư vấn tại salon.
                </p>

                <div class="mt-5 grid gap-3">
                    <a
                        href="{{ $service['bookingUrl'] }}"
                        class="booking-cta inline-flex w-full items-center justify-center rounded-full px-6 py-3 text-sm font-semibold"
                    >
                        Đặt lịch dịch vụ này
                    </a>
                    <a
                        href="{{ route('services') }}"
                        class="inline-flex w-full items-center justify-center rounded-full border border-zen-primary bg-white px-6 py-3 text-sm font-semibold text-zen-primary transition hover:bg-zen-accent-soft"
                    >
                        Quay lại bảng dịch vụ
                    </a>
                </div>
            </aside>
        </section>

        <section class="mt-10 rounded-zen-lg border border-zen-border/70 bg-white/70 p-5 sm:p-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zen-primary">Quy trình</p>
                    <h2 class="mt-2 font-heading text-2xl font-semibold text-zen-text sm:text-3xl">
                        Quy trình thực hiện
                    </h2>
                </div>
                <p class="max-w-md text-sm leading-relaxed text-zen-muted sm:text-right">
                    Mỗi bước được điều chỉnh theo chất tóc, mục tiêu tạo kiểu và thời gian bạn chọn.
                </p>
            </div>

            <div class="mt-6 grid gap-5 md:grid-cols-3 md:gap-0">
                @foreach ($processCards as $step)
                    <article class="relative flex gap-4 rounded-zen-md bg-zen-bg/60 p-4 md:block md:rounded-none md:bg-transparent md:px-5 md:py-2">
                        @if (! $loop->last)
                            <span class="absolute left-5 top-12 h-[calc(100%-1.5rem)] w-px bg-zen-border md:left-[calc(50%+1.5rem)] md:top-5 md:h-px md:w-[calc(100%-3rem)]" aria-hidden="true"></span>
                        @endif

                        <span class="relative z-10 grid size-9 shrink-0 place-items-center rounded-full border border-zen-primary/25 bg-white text-xs font-semibold text-zen-primary shadow-sm md:mx-auto">
                            {{ str_pad($step['number'], 2, '0', STR_PAD_LEFT) }}
                        </span>
                        <div class="min-w-0 md:mt-4 md:text-center">
                            <h3 class="text-sm font-semibold text-zen-text">{{ $step['title'] }}</h3>
                            <p class="mt-1.5 text-sm leading-relaxed text-zen-muted">{{ $step['description'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="mt-6 grid gap-4 md:grid-cols-3">
            <article class="h-full rounded-zen-lg border border-zen-border bg-white p-5 shadow-zen">
                <h2 class="font-semibold text-zen-text">Phù hợp với ai?</h2>
                <ul class="mt-4 space-y-3 text-sm leading-relaxed text-zen-muted">
                    @foreach ($service['suitableFor'] as $item)
                        <li class="flex gap-2">
                            <span class="mt-2 size-1.5 shrink-0 rounded-full bg-zen-primary"></span>
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </article>
            <article class="h-full rounded-zen-lg border border-zen-border bg-white p-5 shadow-zen">
                <h2 class="font-semibold text-zen-text">Kết quả mong đợi</h2>
                <ul class="mt-4 space-y-3 text-sm leading-relaxed text-zen-muted">
                    @foreach ($service['expectedResults'] as $item)
                        <li class="flex gap-2">
                            <span class="mt-2 size-1.5 shrink-0 rounded-full bg-zen-primary"></span>
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </article>
            <article class="h-full rounded-zen-lg border border-zen-border bg-white p-5 shadow-zen">
                <h2 class="font-semibold text-zen-text">Chăm sóc sau dịch vụ</h2>
                <ul class="mt-4 space-y-3 text-sm leading-relaxed text-zen-muted">
                    @foreach ($service['aftercare'] as $item)
                        <li class="flex gap-2">
                            <span class="mt-2 size-1.5 shrink-0 rounded-full bg-zen-primary"></span>
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </article>
        </section>

        <section class="mt-6 rounded-zen-lg border border-zen-border bg-white p-5 shadow-zen sm:p-6">
            <h2 class="font-heading text-2xl font-semibold text-zen-text">Lưu ý trước/sau khi làm</h2>
            <ul class="mt-4 grid gap-3 text-sm leading-relaxed text-zen-text sm:grid-cols-2">
                @foreach ($service['notes'] as $note)
                    <li class="flex gap-3 rounded-zen-sm bg-zen-bg px-4 py-3">
                        <span class="mt-2 size-1.5 shrink-0 rounded-full bg-zen-primary"></span>
                        <span>{{ $note }}</span>
                    </li>
                @endforeach
            </ul>
        </section>

        <section class="mt-12 border-t border-zen-border pt-8">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="font-heading text-2xl font-semibold text-zen-text">Dịch vụ liên quan</h2>
                    <p class="mt-2 text-sm leading-relaxed text-zen-muted">
                        Bạn có thể tham khảo thêm các dịch vụ phù hợp khác tại ZenStyle.
                    </p>
                </div>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($relatedServices as $related)
                    <article class="group flex h-full flex-col overflow-hidden rounded-zen-md border border-zen-border bg-white shadow-zen transition hover:-translate-y-1 hover:shadow-zen-md">
                        <a href="{{ $related['showUrl'] }}" class="block overflow-hidden bg-zen-bg-soft">
                            <img
                                src="{{ $related['images'][0] }}"
                                alt="{{ $related['title'] }}"
                                class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                                loading="lazy"
                            >
                        </a>

                        <div class="flex flex-1 flex-col p-4">
                            <h3 class="font-semibold text-zen-text transition group-hover:text-zen-primary">
                                <a href="{{ $related['showUrl'] }}">{{ $related['title'] }}</a>
                            </h3>
                            <p class="mt-2 truncate text-sm text-zen-muted" title="{{ $related['description'] }}">
                                {{ $related['description'] }}
                            </p>

                            <div class="mt-4 grid grid-cols-2 gap-2 border-t border-zen-border pt-3 text-xs font-semibold text-zen-primary">
                                <span>{{ $related['duration'] }}</span>
                                <span class="text-right">{{ $related['price'] }}</span>
                            </div>

                            <div class="mt-4 grid grid-cols-2 gap-2">
                                <a
                                    href="{{ $related['showUrl'] }}"
                                    class="inline-flex items-center justify-center rounded-full bg-zen-primary px-3 py-2 text-xs font-semibold text-white transition hover:bg-zen-primary-dark"
                                >
                                    Xem chi tiết
                                </a>
                                <a
                                    href="{{ $related['bookingUrl'] }}"
                                    class="inline-flex items-center justify-center rounded-full border border-zen-primary bg-white px-3 py-2 text-xs font-semibold text-zen-primary transition hover:bg-zen-accent-soft"
                                >
                                    Đặt lịch
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    </article>
</x-frontend.layout>
