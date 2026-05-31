@php
    $displayDate = ! empty($booking['appointment_date'])
        ? \Illuminate\Support\Carbon::parse($booking['appointment_date'])->format('d/m/Y')
        : 'Not available';

    $displayTime = ! empty($booking['appointment_time'])
        ? substr((string) $booking['appointment_time'], 0, 5)
        : 'Not available';

    $staffName = $booking['staff_name'] ?? 'Any staff member';
    $notes = trim((string) ($booking['notes'] ?? ''));

    $summaryItems = [
        'Customer Name' => $booking['full_name'] ?? 'Not available',
        'Phone Number' => $booking['phone'] ?? 'Not available',
        'Appointment Date' => $displayDate,
        'Appointment Time' => $displayTime,
        'Selected Staff' => $staffName,
    ];
@endphp

<x-frontend.layout title="ZenStyle - Booking Successful" main-class="bg-zen-bg-soft pt-20">
    <section class="px-4 py-12 sm:px-6 sm:py-16">
        <div class="mx-auto max-w-3xl">
            <div class="rounded-zen-lg border border-zen-border bg-zen-bg p-6 text-center shadow-zen sm:p-8">
                <div class="mx-auto flex size-16 items-center justify-center rounded-full bg-zen-success/10 text-zen-success ring-1 ring-zen-success/20">
                    <svg class="size-8" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M20 6 9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>

                <p class="mt-5 text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Booking confirmed</p>
                <h1 class="mt-2 font-heading text-3xl font-semibold text-zen-text sm:text-4xl">
                    Booking successful!
                </h1>
                <p class="mx-auto mt-4 max-w-2xl text-sm leading-relaxed text-zen-muted sm:text-base">
                    Thank you for booking with ZenStyle. We have received your appointment request and will contact you if confirmation is needed.
                </p>

                <div class="mt-8 border-t border-zen-border pt-6 text-left">
                    <h2 class="text-base font-semibold text-zen-text">Booking Information</h2>
                    <dl class="mt-4 divide-y divide-zen-border rounded-zen-md border border-zen-border bg-white/60">
                        @foreach ($summaryItems as $label => $value)
                            <div class="grid gap-1 px-4 py-3 text-sm sm:grid-cols-[12rem_minmax(0,1fr)] sm:gap-4">
                                <dt class="text-zen-muted">{{ $label }}</dt>
                                <dd class="font-medium text-zen-text sm:text-right">{{ $value }}</dd>
                            </div>
                        @endforeach

                        @if ($notes !== '')
                            <div class="grid gap-1 px-4 py-3 text-sm sm:grid-cols-[12rem_minmax(0,1fr)] sm:gap-4">
                                <dt class="text-zen-muted">Notes</dt>
                                <dd class="whitespace-pre-line font-medium text-zen-text sm:text-right">{{ $notes }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
                    <a
                        href="{{ route('home') }}"
                        class="inline-flex h-11 items-center justify-center rounded-zen-sm bg-zen-primary px-5 text-sm font-semibold text-white transition hover:bg-zen-primary-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-zen-primary/40 focus-visible:ring-offset-2 cursor-pointer"
                    >
                        Back to Home
                    </a>
                    <a
                        href="{{ route('booking') }}"
                        class="inline-flex h-11 items-center justify-center rounded-zen-sm border border-zen-primary bg-zen-bg px-5 text-sm font-semibold text-zen-primary transition hover:bg-zen-accent-soft focus:outline-none focus-visible:ring-2 focus-visible:ring-zen-primary/40 focus-visible:ring-offset-2 cursor-pointer"
                    >
                        Book Another Appointment
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-frontend.layout>
