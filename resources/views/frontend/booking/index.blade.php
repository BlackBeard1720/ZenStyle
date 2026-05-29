<x-frontend.layout title="ZenStyle — Book Appointment" main-class="bg-zen-bg-soft pt-20">
  {{--
      EasySalon flow (Ant-style). Tailwind v4 + JS (frontend/booking.js): select date/time/service/stylist/customer and update the booking summary.
  --}}
  @php
    $bookingToday = now()->startOfDay();
    $bookingWeekStart = $bookingToday->copy()->startOfWeek(\Carbon\CarbonInterface::MONDAY);
    $bookingDayLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    $bookingDaySummaries = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    $bookingDays = collect(range(0, 6))->map(function ($offset) use ($bookingWeekStart, $bookingToday, $bookingDayLabels, $bookingDaySummaries) {
        $date = $bookingWeekStart->copy()->addDays($offset);

        return [
            'label' => $bookingDayLabels[$offset],
            'display' => $date->format('d/m'),
            'iso' => $date->toDateString(),
            'summary' => $bookingDaySummaries[$offset].', '.$date->format('d/m/Y'),
            'selected' => $date->isSameDay($bookingToday),
        ];
    });

    $bookingStylists = $staff->map(function ($s, $index) {

        $isActive = $s->status === 'active';

        return [
            'id'           => $s->id,
            'name'         => $s->full_name,
            'status'       => $isActive ? 'Available' : 'Busy',
            'status_class' => $isActive
                ? 'bg-zen-accent-soft text-zen-primary ring-zen-primary/20'
                : 'bg-zen-warning/10 text-zen-warning ring-zen-warning/20',
            'image'        => asset('images/tailadmin/user/user-0' . (($index % 3) + 1) . '.jpg'),
            'is_available' => $isActive,
            'checked'      => $index === 0 && $isActive,
        ];
    })->all();

    $serviceTypes = $services
        ->map(fn ($service) => $service->category?->name ?? 'Other')
        ->unique()
        ->values();

    $selectedServiceIds = collect(session()->hasOldInput()
        ? old('service_ids', [])
        : (request('service_id') ? [request('service_id')] : []))
        ->map(fn ($id) => (string) $id)
        ->all();
  @endphp

  <div id="booking-page" data-booking-busy-staff-url="{{ route('booking.busy-staff') }}" class="pb-12 pt-6 sm:pt-8">
    <div class="mx-auto max-w-7xl px-4 sm:px-6">
      <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
          <p class="text-xs font-medium uppercase tracking-wide text-zen-muted">Booking online</p>
          <h1 class="mt-1 text-xl font-semibold text-zen-text sm:text-2xl">Book Appointment</h1>
        </div>
        <p class="max-w-xl text-sm text-zen-muted sm:text-right">Complete the steps below to reserve your slot at the
          salon.</p>
      </div>
    </div>

    <form
      id="booking-form"
      method="POST"
      action="{{ route('booking.store') }}"
      class="mx-auto mt-5 grid max-w-7xl gap-5 px-4 sm:mt-6 sm:px-6 lg:grid-cols-[minmax(0,1fr)_minmax(21rem,24rem)] lg:items-start lg:gap-6 xl:grid-cols-[minmax(0,1fr)_minmax(23rem,26rem)]"
    >
      @csrf

      <input type="hidden" name="appointment_time" value="" data-booking-time-input>

      <div class="min-w-0 space-y-5">
        @if($errors->any() && ! $errors->has('otp'))
          <div class="rounded-zen-md border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-700">
            {{ $errors->first() }}
          </div>
        @endif

        {{-- 1. Select Services --}}
        <section class="rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen sm:p-6">
          <h2 class="text-base font-semibold text-zen-text">Select Services</h2>
          <p class="mt-1 text-sm text-zen-muted">Search, sort, and select one or more services for your appointment.</p>

          @if($serviceTypes->isNotEmpty())
            <div class="mt-4 border border-zen-border bg-zen-bg-soft p-4">
              <div class="mb-3 flex items-center gap-2 text-sm font-medium text-zen-text">
                <svg class="size-4 text-zen-primary" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                  <path d="M4 6h16M7 12h10M10 18h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <span>Filter</span>
              </div>

              <div class="grid gap-3 md:grid-cols-[minmax(0,1fr)_12rem]">
                <input
                  type="text"
                  id="service-search"
                  placeholder="Search service..."
                  class="h-10 w-full rounded-zen-sm border border-zen-border bg-white px-3 text-sm outline-none focus:border-zen-primary focus:ring-2 focus:ring-zen-primary/20"
                >

                <select
                  id="service-sort"
                  class="h-10 w-full rounded-zen-sm border border-zen-border bg-white px-3 text-sm outline-none focus:border-zen-primary focus:ring-2 focus:ring-zen-primary/20"
                >
                  <option value="default">Default</option>
                  <option value="price-asc">Price Low to High</option>
                  <option value="price-desc">Price High to Low</option>
                  <option value="name-asc">Name A-Z</option>
                  <option value="name-desc">Name Z-A</option>
                </select>
              </div>

              <div class="mt-3 flex flex-wrap gap-x-5 gap-y-2 text-sm text-zen-muted"
                   aria-label="Filter services by type">
                <label class="inline-flex cursor-pointer items-center gap-2">
                  <input
                    type="checkbox"
                    value="all"
                    class="size-4 rounded border-zen-border-dark text-zen-primary focus:ring-zen-primary/30"
                    data-service-type-filter
                    checked
                  >
                  <span>All</span>
                </label>

                @foreach($serviceTypes as $type)
                  <label class="inline-flex cursor-pointer items-center gap-2">
                    <input
                      type="checkbox"
                      value="{{ $type }}"
                      class="size-4 rounded border-zen-border-dark text-zen-primary focus:ring-zen-primary/30"
                      data-service-type-filter
                    >
                    <span>{{ $type }}</span>
                  </label>
                @endforeach
              </div>
            </div>
          @endif

          <ul class="mt-4 max-h-80 overflow-y-auto divide-y divide-zen-border rounded border border-zen-border" data-service-list>
            @forelse ($services as $service)
              @php
                $serviceCategoryName = $service->category?->name ?? 'Other';
              @endphp

              <li
                class="grid gap-3 p-4 sm:grid-cols-[minmax(0,1fr)_auto] sm:items-center"
                data-booking-service-row
                data-service-name="{{ $service->name }}"
                data-service-category="{{ $serviceCategoryName }}"
                data-service-price="{{ (float) $service->price }}"
                data-service-order="{{ $loop->index }}"
              >
                <label class="flex min-w-0 cursor-pointer items-start gap-3">
                  <input
                    type="checkbox"
                    name="service_ids[]"
                    value="{{ $service->id }}"
                    class="mt-0.5 size-4 shrink-0 rounded border-zen-border-dark text-zen-primary focus:ring-zen-primary/30"
                    @checked(in_array((string) $service->id, $selectedServiceIds, true))
                  >
                  <span class="min-w-0">
                    <span class="block break-words text-sm font-medium text-zen-text">{{ $service->name }}</span>
                    <span class="mt-0.5 block text-xs text-zen-muted">
                      <span class="font-medium text-zen-primary">{{ $serviceCategoryName }}</span>
                      <span class="mx-1">•</span>
                      {{ $service->duration }} minutes
                      @if($service->description)
                        - {{ $service->description }}
                      @endif
                    </span>
                  </span>
                </label>

                <span class="text-sm font-semibold text-zen-primary sm:text-right">
                  ${{ number_format((float) $service->price, 2, '.', ',') }}
                </span>
              </li>
            @empty
              <li class="p-4 text-sm text-zen-muted">
                There are currently no active services.
              </li>
            @endforelse
          </ul>

          <p class="mt-3 rounded-zen-sm border border-zen-border bg-zen-bg-soft p-3 text-sm text-zen-muted"
             data-service-filter-empty hidden>
            No services match your filter.
          </p>
        </section>

        {{-- 2. Date + weekly calendar + time slots --}}
        <section class="rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen sm:p-6">
          <h2 class="text-base font-semibold text-zen-text">Select Date &amp; Time</h2>
          <p class="mt-1 text-sm text-zen-muted">Choose a day of the week and a starting time slot.</p>

          <div class="mt-4">
            <label for="booking-date" class="mb-2 block text-sm font-medium text-zen-muted">Or choose a date</label>
            <input
              id="booking-date"
              name="appointment_date"
              type="date"
              value="{{ $bookingToday->toDateString() }}"
              min="{{ $bookingToday->toDateString() }}"
              class="h-10 w-full max-w-xs rounded border border-zen-border bg-white px-3 text-sm text-zen-text outline-none ring-zen-primary focus:border-zen-primary focus:ring-2 focus:ring-zen-primary/20"
            >
          </div>

          <p class="mb-2 mt-6 text-sm font-medium text-zen-muted">This Week</p>
          <div class="grid grid-cols-2 gap-2 sm:grid-cols-4 xl:grid-cols-7" role="radiogroup"
               aria-label="Choose a day of the week">
            @foreach ($bookingDays as $day)
              <button
                type="button"
                data-booking-day
                data-date="{{ $day['iso'] }}"
                data-summary="{{ $day['summary'] }}"
                aria-pressed="{{ $day['selected'] ? 'true' : 'false' }}"
                class="rounded border px-3 py-2 text-left text-sm transition-colors border-zen-border bg-white text-zen-muted hover:border-zen-primary/40"
              >
                <span class="block text-xs text-zen-muted">{{ $day['label'] }}</span>
                <span class="block tabular-nums">{{ $day['display'] }}</span>
              </button>
            @endforeach
          </div>

          <p class="mb-2 mt-6 text-sm font-medium text-zen-muted">Available Time Slots</p>
          <div class="grid grid-cols-2 gap-2 sm:grid-cols-4 lg:grid-cols-6" role="radiogroup" aria-label="Start time">
            @foreach (['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '14:00', '14:30', '15:00', '15:30', '16:00', '17:00'] as $slot)
              <button
                type="button"
                data-booking-slot
                data-slot="{{ $slot }}"
                aria-pressed="false"
                class="rounded border px-2 py-2 text-sm transition-colors border-zen-border bg-white text-zen-muted hover:border-zen-primary/50"
              >
                {{ $slot }}
              </button>
            @endforeach
          </div>
        </section>

        {{-- 3. Staff --}}
        <section class="rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen sm:p-6">
          <h2 class="text-base font-semibold text-zen-text">Select Staff</h2>
          <p class="mt-1 text-sm text-zen-muted">Let the salon arrange your appointment or choose your preferred
            stylist.</p>

          {{-- Vertical scroll dong bo voi service list --}}
          <div class="mt-4 max-h-80 overflow-y-auto grid grid-cols-2 gap-3" role="radiogroup"
               aria-label="Select staff member in charge">
            @foreach ($bookingStylists as $stylist)
              @php
                $stylistAvailable = $stylist['is_available'] ?? true;
              @endphp

              <label
                data-booking-stylist-card
                data-staff-id="{{ $stylist['id'] }}"
                data-staff-base-available="{{ $stylistAvailable ? 'true' : 'false' }}"
                data-booking-stylist-available="{{ $stylistAvailable ? 'true' : 'false' }}"
                role="radio"
                aria-disabled="{{ $stylistAvailable ? 'false' : 'true' }}"
                @class([
                  'group relative flex flex-col overflow-hidden rounded border-2 border-zen-border bg-white p-4 text-left shadow-sm transition duration-150 has-[:focus-visible]:ring-2 has-[:focus-visible]:ring-zen-primary/40',
                  'cursor-pointer hover:border-zen-primary/50 hover:bg-zen-accent-soft/30 has-[:checked]:border-zen-primary has-[:checked]:bg-zen-accent-soft' => $stylistAvailable,
                  'cursor-not-allowed opacity-60 grayscale-[.15]' => ! $stylistAvailable,
                ])
              >
                <input
                  type="radio"
                  name="staff_id"
                  value="{{ $stylist['id'] }}"
                  data-booking-stylist-radio
                  data-staff-id="{{ $stylist['id'] }}"
                  data-stylist-name="{{ $stylist['name'] }}"
                  data-staff-base-available="{{ $stylistAvailable ? 'true' : 'false' }}"
                  data-stylist-available="{{ $stylistAvailable ? 'true' : 'false' }}"
                  class="peer sr-only"
                  @checked($stylist['checked'] && $stylistAvailable)
                  @disabled(! $stylistAvailable)
                >

                <span class="flex min-w-0 items-start gap-3">
                  <img
                    src="{{ $stylist['image'] }}"
                    alt="Profile photo of {{ $stylist['name'] }}"
                    class="size-12 shrink-0 rounded-full border border-zen-border object-cover"
                    loading="lazy"
                  >
                  <span class="min-w-0 flex-1">
                    <span data-stylist-label
                          class="block break-words text-sm font-semibold text-zen-text">{{ $stylist['name'] }}</span>
                    <span
                      data-stylist-status-label
                      class="mt-2 inline-flex rounded px-2 py-0.5 text-xs font-medium ring-1 {{ $stylist['status_class'] }}">
                      {{ $stylist['status'] }}
                    </span>
                  </span>
                </span>
              </label>
            @endforeach
          </div>
        </section>

        {{-- 4. Contact Information --}}
        <section class="rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen sm:p-6">
          <h2 class="text-base font-semibold text-zen-text">Contact Information</h2>
          <p class="mt-1 text-sm text-zen-muted">The salon uses this information to confirm your appointment.</p>

          <div class="mt-4 grid gap-4 sm:grid-cols-2">
            <div>
              <label for="full-name" class="mb-1.5 block text-sm font-medium text-zen-muted">
                Full Name <span class="text-red-500">*</span>
              </label>
              <input
                id="full-name"
                name="full_name"
                type="text"
                placeholder="John Doe"
                required
                class="h-10 w-full rounded-zen-sm border border-zen-border px-3 text-sm outline-none focus:border-zen-primary focus:ring-2 focus:ring-zen-primary/20"
              >
            </div>

            <div>
              <label for="phone" class="mb-1.5 block text-sm font-medium text-zen-muted">
                Phone Number <span class="text-red-500">*</span>
              </label>
              <input
                id="phone"
                name="phone"
                type="tel"
                placeholder="09xx xxx xxx"
                required
                class="h-10 w-full rounded-zen-sm border border-zen-border px-3 text-sm outline-none focus:border-zen-primary focus:ring-2 focus:ring-zen-primary/20"
              >
            </div>

            <div>
              <label for="email" class="mb-1.5 block text-sm font-medium text-zen-muted">
                Email <span class="text-red-500">*</span>
              </label>
              <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="example@gmail.com"
                required
                class="h-10 w-full rounded-zen-sm border border-zen-border px-3 text-sm outline-none focus:border-zen-primary focus:ring-2 focus:ring-zen-primary/20"
              >
              @error('email')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div class="sm:col-span-2">
              <label for="note" class="mb-1.5 block text-sm font-medium text-zen-muted">Notes (optional)</label>
              <textarea
                id="note"
                name="notes"
                rows="4"
                placeholder="Example: preferred hair color consultation, hair condition..."
                class="w-full resize-y rounded-zen-sm border border-zen-border px-3 py-2 text-sm outline-none focus:border-zen-primary focus:ring-2 focus:ring-zen-primary/20"
              ></textarea>
            </div>
          </div>
        </section>
      </div>

      {{-- Summary sidebar --}}
      <aside class="min-w-0 lg:sticky lg:top-24">
        <div id="booking-summary-card"
             class="scroll-mt-24 rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen sm:p-6">
          <h2 class="text-base font-semibold text-zen-text">Booking Summary</h2>

          <dl class="mt-4 space-y-3 text-sm">
            <div class="grid grid-cols-[6rem_minmax(0,1fr)] gap-3 border-b border-dashed border-zen-border pb-3">
              <dt class="text-zen-muted">Salon</dt>
              <dd id="booking-summary-branch" class="min-w-0 text-right font-medium text-zen-text">ZenStyle FPT Aptech
              </dd>
            </div>

            <div class="grid grid-cols-[6rem_minmax(0,1fr)] gap-3 border-b border-dashed border-zen-border pb-3">
              <dt class="text-zen-muted">Time</dt>
              <dd class="min-w-0 text-right font-medium text-zen-text">
                <span id="booking-summary-time-line" class="block">—</span>
                <span id="booking-summary-date-line" class="block text-xs font-normal text-zen-muted">
                  {{ $bookingDaySummaries[$bookingToday->dayOfWeekIso - 1] }}, {{ $bookingToday->format('d/m/Y') }}
                </span>
              </dd>
            </div>

            <div class="grid grid-cols-[6rem_minmax(0,1fr)] gap-3 border-b border-dashed border-zen-border pb-3">
              <dt class="text-zen-muted">Staff</dt>
              <dd id="booking-summary-stylist" class="min-w-0 break-words text-right font-medium text-zen-text">Any
                staff member
              </dd>
            </div>

            <div>
              <dt class="text-zen-muted">Services</dt>
              <dd id="booking-summary-services"
                  class="mt-2 max-h-36 overflow-y-auto min-w-0 space-y-1 break-words pr-1 text-right font-medium text-zen-text">
                <p class="text-xs font-normal text-zen-muted">No services selected</p>
              </dd>
            </div>
          </dl>

          <div class="my-4 border-t border-zen-border"></div>

          <div class="flex items-baseline justify-between gap-4">
            <span class="text-sm text-zen-muted">Subtotal</span>
            <span id="booking-summary-total" class="text-xl font-semibold text-zen-primary">$0.00</span>
          </div>

          {{-- Nút xác nhận — khớp zen-btn-primary: nền đen, chữ trắng, hover vàng champagne --}}
          <button
            type="submit"
            class="mt-5 flex h-10 w-full items-center justify-center rounded-zen-sm bg-zen-dark text-sm font-semibold text-zen-text-light transition hover:bg-zen-primary hover:text-zen-dark active:scale-[0.98]"
          >
            Complete Booking
          </button>

          <p class="mt-4 text-center text-xs leading-relaxed text-zen-muted">
            By confirming, you agree to ZenStyle appointment rules and policies.
            Your appointment will be held for up to 15 minutes after confirmation.
          </p>
        </div>
      </aside>
    </form>
  </div>

  @include('frontend.booking.partials.otp-modal')
</x-frontend.layout>
