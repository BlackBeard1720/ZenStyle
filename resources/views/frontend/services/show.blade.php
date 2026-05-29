<x-frontend.layout :title="$service->name.' - Services'" main-class="bg-gradient-to-b from-zen-bg via-zen-bg-soft to-zen-bg pt-20">
    @php
        $placeholderImage = 'https://placehold.co/1200x800/F4F7F7/667275?text=ZenStyle+Service';
    @endphp

    <article class="mx-auto max-w-6xl px-4 pb-14 sm:px-6 md:pb-20">
        <nav class="flex flex-wrap items-center gap-2 text-xs font-medium text-zen-muted" aria-label="Breadcrumb">
            <a href="{{ route('services') }}" class="text-zen-primary transition hover:text-zen-primary-dark">Services</a>
            <span aria-hidden="true">›</span>
            <span class="text-zen-text">{{ $service->name }}</span>
        </nav>

        <section class="mt-6 grid gap-8 lg:grid-cols-[minmax(0,1fr)_24rem] lg:items-start">
            <div class="overflow-hidden rounded-zen-lg border border-zen-border bg-zen-surface shadow-zen-md">
                <img src="{{ $service->thumbnail ?: $placeholderImage }}" alt="{{ $service->name }}" class="aspect-[4/3] w-full object-cover sm:aspect-[16/10]" decoding="async">
            </div>

            <aside class="rounded-zen-lg border border-zen-border bg-zen-surface p-5 shadow-zen-md lg:sticky lg:top-24">
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
                        <dd class="text-right text-lg font-semibold text-zen-primary">
                          ${{ number_format((float) $service->price, 0) }}
                        </dd>
                    </div>
                </dl>

                <div class="mt-5 grid gap-3">
                    <a href="{{ route('booking', ['service_id' => $service->id]) }}" class="zen-btn-primary w-full">Book Now</a>
                    <a href="{{ route('services') }}" class="zen-btn-secondary w-full">Back to Services</a>
                </div>
            </aside>
        </section>


        <section id="comments" class="mt-12 scroll-mt-24 border-t border-zen-border pt-8">
            <h2 class="font-heading text-2xl font-semibold text-zen-text">Comments</h2>

            @if (session('success'))
                <p class="mt-4 rounded-zen-sm border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</p>
            @endif

            <div class="mt-6 space-y-4">
                @forelse ($approvedComments as $comment)
                    <article class="rounded-zen-md border border-zen-border bg-zen-surface p-4 shadow-zen">
                        <p class="font-semibold text-zen-text">{{ $comment->name }}</p>
                        <p class="mt-2 text-sm text-zen-muted">{{ $comment->comment }}</p>
                    </article>
                @empty
                    <p class="text-sm text-zen-muted">No comments yet. Be the first to leave a comment.</p>
                @endforelse
            </div>

            <div class="mt-8 rounded-zen-lg border border-zen-border bg-zen-surface p-5 shadow-zen-md">
                <h3 class="font-heading text-xl font-semibold text-zen-text">Leave a Reply</h3>
                <form action="{{ route('services.comments.store', $service) }}" method="POST" class="mt-4 space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="mb-1 block text-sm font-medium text-zen-text">Name *</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" class="w-full rounded-zen-sm border border-zen-border px-3 py-2">
                        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="comment" class="mb-1 block text-sm font-medium text-zen-text">Comment</label>
                        <textarea id="comment" name="comment" rows="5" class="w-full rounded-zen-sm border border-zen-border px-3 py-2">{{ old('comment') }}</textarea>
                        @error('comment')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="zen-btn-primary">Post comment</button>
                </form>
            </div>
        </section>

        @if($relatedServices->isNotEmpty())
            <section class="mt-12 border-t border-zen-border pt-8">
                <h2 class="font-heading text-2xl font-semibold text-zen-text">Related Services</h2>
                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($relatedServices as $related)
                        <article class="group flex h-full flex-col overflow-hidden rounded-zen-md border border-zen-border bg-zen-surface shadow-sm transition-colors duration-200 hover:border-zen-accent/40">
                            <a href="{{ route('services.show', $related) }}" class="block overflow-hidden bg-zen-bg-soft">
                                <img src="{{ $related->thumbnail ?: $placeholderImage }}" alt="{{ $related->name }}" class="aspect-[4/3] w-full object-cover transition-transform duration-300 group-hover:scale-[1.01]" loading="lazy">
                            </a>
                            <div class="flex flex-1 flex-col p-4">
                                <h3 class="font-semibold text-zen-text transition-colors duration-200 group-hover:text-zen-primary">
                                    <a href="{{ route('services.show', $related) }}">{{ $related->name }}</a>
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
