<x-frontend.layout title="ZenStyle — Privacy Policy" main-class="bg-zen-bg-soft pt-20">
    <section class="border-b border-zen-border bg-white px-4 py-12 sm:px-6 sm:py-14">
        <div class="mx-auto max-w-4xl">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Privacy policy</p>
            <h1 class="mt-3 font-heading text-3xl font-semibold text-zen-text sm:text-4xl">
                Privacy Policy
            </h1>
            <p class="mt-4 text-sm leading-relaxed text-zen-muted sm:text-base">
                ZenStyle is committed to protecting the personal information of our clients when they visit our website and use our online booking services.
            </p>
            <p class="mt-2 text-xs text-zen-muted">Last updated: {{ now()->format('F j, Y') }}</p>
        </div>
    </section>

    <section class="px-4 py-10 sm:px-6 sm:py-12">
        <article class="mx-auto max-w-4xl rounded-zen-lg border border-zen-border bg-zen-bg p-6 shadow-zen sm:p-8">
            <div class="space-y-8 text-sm leading-relaxed text-zen-text sm:text-base">
                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">1. Scope of Information Collection</h2>
                    <p class="mt-2">
                        We may collect the personal information that you provide when making an appointment or contacting us, including: full name, phone number, email address, appointment time, and service notes.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">2. Purpose of Information Use</h2>
                    <p class="mt-2">Personal information is used to:</p>
                    <ul class="mt-3 list-disc space-y-1.5 pl-5">
                        <li>Confirm, manage, and remind you of your appointments at ZenStyle.</li>
                        <li>Provide consultation on services tailored to your needs.</li>
                        <li>Send updates about promotions and customer care programs (only with your consent).</li>
                        <li>Improve our website service quality and user experience.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">3. Data Storage and Security</h2>
                    <p class="mt-2">
                        ZenStyle applies appropriate management and technical measures to restrict unauthorized access, loss, or misuse of your personal information. Your data is stored only for as long as necessary for operation and customer care activities.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">4. Third-Party Sharing</h2>
                    <p class="mt-2">
                        We do not sell, trade, or share your personal information with third parties for commercial purposes. Information may only be disclosed if required by competent state authorities in accordance with applicable laws.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">5. Client Rights</h2>
                    <p class="mt-2">
                        You have the right to inspect, update, modify, or request the deletion of the personal information you have provided to ZenStyle by contacting us via email or our support hotline.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">6. Contact Us</h2>
                    <p class="mt-2">
                        If you have any questions regarding this Privacy Policy, please contact us at:
                        <a href="mailto:hello@zenstyle.vn" class="font-medium text-zen-primary hover:text-zen-primary-dark">
                            hello@zenstyle.vn
                        </a>
                        or
                        <a href="tel:+84901234567" class="font-medium text-zen-primary hover:text-zen-primary-dark">
                            0901 234 567
                        </a>.
                    </p>
                </section>
            </div>
        </article>
    </section>
</x-frontend.layout>
