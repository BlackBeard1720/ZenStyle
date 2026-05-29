@if (! request()->routeIs('booking'))
    <a
        href="{{ route('booking') }}"
        class="zen-btn-primary pointer-events-none fixed z-40 translate-y-2 !px-4 !py-2.5 opacity-0 transition right-[max(1rem,env(safe-area-inset-right,0px))] bottom-[max(1.25rem,env(safe-area-inset-bottom,0px))] md:right-[max(1.25rem,env(safe-area-inset-right,0px))] md:bottom-[max(1.5rem,env(safe-area-inset-bottom,0px))] shadow-md hover:shadow-zen-md"
        data-floating-booking
        aria-label="Book Now"
    >
        Book Now
    </a>
@endif
<button
    type="button"
    class="scroll-top-btn"
    data-scroll-top
    aria-label="Scroll to top"
    title="Scroll to top"
>
    <x-heroicon-o-arrow-up class="w-5 h-5" />
</button>
