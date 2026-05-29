@php
    $faqs = [
        [
            'question' => 'Do I need to book an appointment in advance?',
            'answer' => 'We highly recommend booking in advance so that ZenStyle can reserve the perfect time slot and prepare your stylist. Walk-ins are still welcome if slots are available.',
        ],
        [
            'question' => 'How do I receive confirmation after booking online?',
            'answer' => 'Once you submit your booking, the system will verify it via OTP. Our team may reach out to confirm or adjust your slot details if necessary.',
        ],
        [
            'question' => 'Can I book multiple services for a single appointment?',
            'answer' => 'Yes. On the booking page, you can select multiple services for the same slot. The estimated total price will update accordingly.',
        ],
        [
            'question' => 'Can I reschedule or cancel my appointment?',
            'answer' => 'Yes, please contact our hotline or message us as early as possible. We will happily help you reschedule to another available slot.',
        ],
        [
            'question' => 'Are the prices shown on the website final?',
            'answer' => 'Website prices are standard references. Services like hair coloring, perming, or specialty treatments may vary based on your hair condition and direct consultation.',
        ],
        [
            'question' => 'What should I prepare before coming to the salon?',
            'answer' => 'Just arrive on time! Feel free to bring reference photos of haircuts, colors, or styles you would like to discuss with our stylists.',
        ],
    ];
@endphp

<x-frontend.layout title="ZenStyle - FAQ" main-class="bg-zen-bg-soft pt-20">
    <section class="border-b border-zen-border bg-white px-4 py-12 sm:px-6 sm:py-14">
        <div class="mx-auto max-w-4xl">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">FAQ</p>
            <h1 class="mt-3 font-heading text-3xl font-semibold text-zen-text sm:text-4xl">
                Frequently Asked Questions
            </h1>
            <p class="mt-4 text-sm leading-relaxed text-zen-muted sm:text-base">
                Quick answers to common questions about appointments, services, and the ZenStyle experience.
            </p>
        </div>
    </section>

    <section class="px-4 py-10 sm:px-6 sm:py-12">
        <div class="mx-auto max-w-4xl space-y-3">
            @foreach ($faqs as $faq)
                <details class="group rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-sm font-semibold text-zen-text sm:text-base">
                        <span>{{ $faq['question'] }}</span>
                        <span class="shrink-0 text-lg leading-none text-zen-primary transition group-open:rotate-45">+</span>
                    </summary>
                    <p class="mt-3 text-sm leading-relaxed text-zen-muted sm:text-base">
                        {{ $faq['answer'] }}
                    </p>
                </details>
            @endforeach
        </div>
    </section>
</x-frontend.layout>
