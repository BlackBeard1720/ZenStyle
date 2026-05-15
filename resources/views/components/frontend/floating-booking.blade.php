@if (! request()->routeIs('booking'))
    <a
        href="{{ route('booking') }}"
        class="booking-fab booking-cta px-3 py-2.5 text-xs font-semibold sm:px-4 sm:py-3 sm:text-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-zen-primary/60 focus-visible:ring-offset-2"
        aria-label="Đặt lịch ngay"
    >
        Đặt lịch ngay
    </a>
@endif
<button
    type="button"
    class="scroll-top-btn"
    data-scroll-top
    aria-label="Cuộn lên đầu trang"
    title="Lên đầu trang"
>
    <span aria-hidden="true">↑</span>
</button>
