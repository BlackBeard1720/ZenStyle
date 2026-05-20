@if (! request()->routeIs('booking'))
    <a
        href="{{ route('booking') }}"
        class="booking-cta pointer-events-none fixed z-40 flex translate-y-2 items-center justify-center rounded-full px-3 py-2 text-[11px] font-semibold opacity-0 shadow-md shadow-black/15 transition hover:-translate-y-0.5 hover:shadow-zen-md sm:px-3.5 sm:py-2.5 sm:text-xs right-[max(1rem,env(safe-area-inset-right,0px))] bottom-[max(1.25rem,env(safe-area-inset-bottom,0px))] md:right-[max(1.25rem,env(safe-area-inset-right,0px))] md:bottom-[max(1.5rem,env(safe-area-inset-bottom,0px))] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#1677ff]/60 focus-visible:ring-offset-2"
        data-floating-booking
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
