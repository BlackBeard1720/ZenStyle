@if (! request()->routeIs('booking'))
    <a
        href="{{ route('booking') }}"
        class="booking-cta fixed z-40 flex items-center justify-center rounded-full px-3 py-2.5 text-xs font-semibold shadow-lg shadow-black/20 transition hover:-translate-y-1 hover:shadow-zen-md sm:px-4 sm:py-3 sm:text-sm right-[max(1rem,env(safe-area-inset-right,0px))] bottom-[max(1.5rem,env(safe-area-inset-bottom,0px))] md:right-[max(1.5rem,env(safe-area-inset-right,0px))] md:bottom-[max(1.75rem,env(safe-area-inset-bottom,0px))] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#1677ff]/60 focus-visible:ring-offset-2"
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
