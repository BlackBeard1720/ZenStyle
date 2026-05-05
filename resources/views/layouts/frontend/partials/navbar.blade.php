<header
    id="site-header"
    {{-- Tránh flash nền trắng trước khi JS đo #site-banner — chỉ các URL trang chủ. --}}
    @if (request()->is('/') || request()->is('home'))
        data-on-banner="true"
    @endif
    class="fixed inset-x-0 top-0 z-50 border-b border-stone-200/80 bg-white/90 backdrop-blur
        transition-[transform,background-color,border-color,backdrop-filter,text-color] duration-300 ease-out will-change-transform
        data-[on-banner='true']:border-transparent data-[on-banner='true']:!border-b-transparent data-[on-banner='true']:!bg-transparent data-[on-banner='true']:!backdrop-blur-none data-[on-banner='true']:shadow-none"
>
    {{--
        Layout: logo trái | menu giữa (sm+) | nút đặt lịch phải.
        Nav căn giữa viewport của khối bằng absolute; logo & CTA z-10 để luôn bấm được.
    --}}
    <div class="relative mx-auto flex max-w-6xl items-center px-4 py-4 sm:px-6">
        <a
            href="{{ route('home') }}"
            class="site-nav-brand relative z-10 flex shrink-0 items-center gap-2"
            aria-label="ZenStyle — Trang chủ"
        >
            <img
                src="{{ asset('images/logos/zenstyle-wordmark.png') }}"
                alt="ZenStyle"
                class="site-nav-logo h-9 w-auto max-w-[200px] object-contain sm:h-10"
                loading="eager"
            />
        </a>

        <nav
            aria-label="Menu chính"
            class="site-nav-menu pointer-events-none absolute inset-x-0 top-1/2 z-0 hidden -translate-y-1/2 justify-center sm:flex"
        >
            <div class="pointer-events-auto flex items-center gap-6 text-sm font-medium">
                <a href="{{ route('home') }}" class="site-nav-link text-stone-600 transition-colors hover:text-stone-900">Trang chủ</a>
                <a href="{{ route('about') }}" class="site-nav-link text-stone-600 transition-colors hover:text-stone-900">Giới thiệu</a>
                <a href="{{ route('news') }}" class="site-nav-link text-stone-600 transition-colors hover:text-stone-900">Tin Tức</a>
                <a href="{{ route('home') }}#dich-vu" class="site-nav-link text-stone-600 transition-colors hover:text-stone-900">Dịch vụ</a>
                <a href="{{ route('home') }}#lien-he" class="site-nav-link text-stone-600 transition-colors hover:text-stone-900">Liên hệ</a>
            </div>
        </nav>

        <a
            href="{{ route('booking') }}"
            class="site-nav-cta booking-cta relative z-10 ml-auto shrink-0 rounded-full px-4 py-2 text-sm font-semibold focus:outline-none focus-visible:ring-2 focus-visible:ring-[#1677ff]/50 focus-visible:ring-offset-2"
        >
            Đặt lịch ngay
        </a>
    </div>
</header>
