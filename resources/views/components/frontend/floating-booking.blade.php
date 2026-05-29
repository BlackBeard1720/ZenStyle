@if (! request()->routeIs('booking'))
    <a
        href="{{ route('booking') }}"
        class="zen-btn-primary pointer-events-none fixed z-50 translate-y-2 !px-4 !py-2.5 opacity-0 transition-[opacity,transform,background-color,border-color,color] duration-200 right-[max(1rem,env(safe-area-inset-right,0px))] bottom-[max(1.25rem,env(safe-area-inset-bottom,0px))] md:right-[max(1.25rem,env(safe-area-inset-right,0px))] md:bottom-[max(1.5rem,env(safe-area-inset-bottom,0px))] shadow-sm"
        data-floating-booking
        data-floating-action
        aria-label="Book Now"
    >
        Book Now
    </a>
@endif
<button
    type="button"
    class="scroll-top-btn"
    data-scroll-top
    data-floating-action
    aria-label="Scroll to top"
    title="Scroll to top"
>
    <x-heroicon-o-arrow-up class="w-5 h-5" />
</button>
