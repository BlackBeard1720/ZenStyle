<x-frontend.layout title="ZenStyle — Contact Us" main-class="bg-zen-bg pt-20">
    @php
        $googleFormUrl = 'https://forms.gle/CQn7soz85KCEsj1HA';
        $googleFormOpenUrl = 'https://forms.gle/CQn7soz85KCEsj1HA';
    @endphp

    <section class="bg-gradient-to-b from-zen-bg to-zen-accent-soft/45 px-4 py-12 sm:px-6 sm:py-14">
        <div class="mx-auto flex max-w-6xl flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary-dark">Contact form</p>
                <h1 class="mt-3 font-heading text-3xl font-semibold text-zen-text sm:text-4xl">
                    Contact Form
                </h1>
                <p class="mt-4 text-sm leading-relaxed text-zen-muted sm:text-base">
                    Submit your consultation request, booking details, or feedback to ZenStyle. Our salon team will contact you back via the phone number or email you provide.
                </p>
            </div>

            <a
                href="{{ $googleFormOpenUrl }}"
                target="_blank"
                rel="noopener noreferrer"
                class="zen-btn-primary"
            >
                Open in Google
            </a>
        </div>
    </section>

    <section class="bg-gradient-to-b from-zen-accent-soft/45 via-zen-bg-soft/70 to-white px-4 py-10 sm:px-6 sm:py-12 lg:pb-20">
        <div class="mx-auto max-w-6xl">
            <div class="overflow-hidden rounded-zen-lg border border-zen-border bg-zen-bg shadow-zen ring-1 ring-zen-border">
                <div class="flex flex-col gap-3 border-b border-zen-border bg-zen-bg px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">
                    <p class="text-sm font-semibold text-zen-text">ZenStyle Google Form</p>
                    <a
                        href="{{ $googleFormOpenUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-sm font-medium text-zen-primary hover:text-zen-primary-dark"
                    >
                        Open in new tab
                    </a>
                </div>

                <iframe
                    title="ZenStyle Contact Form"
                    src="{{ $googleFormUrl }}"
                    class="h-[760px] w-full border-0 bg-white sm:h-[860px]"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
            </div>
        </div>
    </section>

    <!-- Visit ZenStyle Section -->
    <x-frontend.contact-section />
</x-frontend.layout>
