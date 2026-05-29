<x-frontend.layout title="ZenStyle — Terms of Service" main-class="bg-zen-bg-soft pt-20">
    <section class="border-b border-zen-border bg-white px-4 py-12 sm:px-6 sm:py-14">
        <div class="mx-auto max-w-4xl">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Terms of service</p>
            <h1 class="mt-3 font-heading text-3xl font-semibold text-zen-text sm:text-4xl">
                Terms of Service
            </h1>
            <p class="mt-4 text-sm leading-relaxed text-zen-muted sm:text-base">
                By accessing our website or using ZenStyle's booking services, you agree to comply with the terms set forth below.
            </p>
            <p class="mt-2 text-xs text-zen-muted">Last updated: {{ now()->format('F j, Y') }}</p>
        </div>
    </section>

    <section class="px-4 py-10 sm:px-6 sm:py-12">
        <article class="mx-auto max-w-4xl rounded-zen-lg border border-zen-border bg-zen-bg p-6 shadow-zen sm:p-8">
            <div class="space-y-8 text-sm leading-relaxed text-zen-text sm:text-base">
                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">1. Scope of Application</h2>
                    <p class="mt-2">
                        These terms and conditions apply to all visitors accessing the ZenStyle website and clients utilizing the services provided by ZenStyle at our salon.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">2. Booking Regulations</h2>
                    <ul class="mt-3 list-disc space-y-1.5 pl-5">
                        <li>Appointments are only officially confirmed upon providing complete and valid contact information.</li>
                        <li>Please arrive on time; ZenStyle will hold your reservation for a maximum of 15 minutes past the scheduled time.</li>
                        <li>If you need to reschedule or cancel your appointment, please notify us in advance to facilitate optimal rearranging.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">3. Pricing and Payments</h2>
                    <p class="mt-2">
                        The price list displayed on the website is for reference purposes at the time of publication. The actual price may vary depending on the length or condition of your hair/skin, the package chosen, and direct consultation at the salon.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">4. Promotions and Offers</h2>
                    <p class="mt-2">
                        Each promotional campaign has its own specific eligibility terms regarding duration, branch location, and services. ZenStyle reserves the right to modify or terminate promotions without prior notice, except for offers already confirmed for a valid appointment.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">5. User Responsibilities</h2>
                    <p class="mt-2">Users agree and commit to:</p>
                    <ul class="mt-3 list-disc space-y-1.5 pl-5">
                        <li>Providing accurate and complete information when booking or contacting us.</li>
                        <li>Not utilizing the website for unlawful purposes or attempting to disrupt the system.</li>
                        <li>Respecting our salon staff, customers, and operational regulations at the salon.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">6. Limitation of Liability</h2>
                    <p class="mt-2">
                        ZenStyle makes every effort to maintain accurate information on our website. However, we do not assume liability for technical interruptions, connection errors, or any indirect losses arising outside of our reasonable control.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">7. Policy Modifications</h2>
                    <p class="mt-2">
                        ZenStyle reserves the right to update these terms at any time to adapt to operational changes. Updated versions will be published on this page and will take effect immediately upon upload.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">8. Contact Information</h2>
                    <p class="mt-2">
                        For any inquiries regarding these terms of service, please contact us at:
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
