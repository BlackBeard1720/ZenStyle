<header
    id="site-header"
    @if (request()->is('/') || request()->is('home') || request()->routeIs('services'))
        data-on-banner="true"
    @endif
    class="fixed inset-x-0 top-0 z-50 border-b border-zen-border bg-zen-bg backdrop-blur
        transition-[transform,background-color,border-color,backdrop-filter,text-color] duration-300 ease-out will-change-transform
        data-[on-banner='true']:border-transparent data-[on-banner='true']:!border-b-transparent data-[on-banner='true']:!bg-transparent data-[on-banner='true']:!backdrop-blur-none data-[on-banner='true']:shadow-none"
>
    @php
        $isHomeRoute = request()->routeIs('home');
        $isAboutRoute = request()->routeIs('about');
        $isNewsRoute = request()->routeIs('news');
        $isServicesRoute = request()->routeIs('services');
        $isContactRoute = request()->routeIs('contact');
    @endphp

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
                <a
                    href="{{ route('home') }}"
                    data-nav-key="home"
                    class="site-nav-link relative pb-1 transition-colors after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:origin-left after:rounded-full after:bg-zen-primary after:transition-transform after:duration-200 {{ $isHomeRoute ? 'is-active text-zen-text after:scale-x-100' : 'text-zen-muted hover:text-zen-text after:scale-x-0 hover:after:scale-x-100' }}"
                >
                    Trang chủ
                </a>
                <a
                    href="{{ route('about') }}"
                    data-nav-key="about"
                    class="site-nav-link relative pb-1 transition-colors after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:origin-left after:rounded-full after:bg-zen-primary after:transition-transform after:duration-200 {{ $isAboutRoute ? 'is-active text-zen-text after:scale-x-100' : 'text-zen-muted hover:text-zen-text after:scale-x-0 hover:after:scale-x-100' }}"
                >
                    Giới thiệu
                </a>
                <a
                    href="{{ route('news') }}"
                    data-nav-key="news"
                    class="site-nav-link relative pb-1 transition-colors after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:origin-left after:rounded-full after:bg-zen-primary after:transition-transform after:duration-200 {{ $isNewsRoute ? 'is-active text-zen-text after:scale-x-100' : 'text-zen-muted hover:text-zen-text after:scale-x-0 hover:after:scale-x-100' }}"
                >
                    Tin Tức
                </a>
                <a
                    href="{{ route('services') }}"
                    data-nav-key="services"
                    class="site-nav-link relative pb-1 transition-colors after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:origin-left after:rounded-full after:bg-zen-primary after:transition-transform after:duration-200 {{ $isServicesRoute ? 'is-active text-zen-text after:scale-x-100' : 'text-zen-muted hover:text-zen-text after:scale-x-0 hover:after:scale-x-100' }}"
                >
                    Dịch vụ
                </a>
                <a
                    href="{{ route('contact') }}"
                    data-nav-key="contact"
                    class="site-nav-link relative pb-1 transition-colors after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:origin-left after:rounded-full after:bg-zen-primary after:transition-transform after:duration-200 {{ $isContactRoute ? 'is-active text-zen-text after:scale-x-100' : 'text-zen-muted hover:text-zen-text after:scale-x-0 hover:after:scale-x-100' }}"
                >
                    Liên hệ
                </a>
            </div>
        </nav>

        <a
            href="{{ route('booking') }}"
            class="site-nav-cta booking-cta relative z-10 ml-auto shrink-0 rounded-full px-4 py-2 text-sm font-semibold focus:outline-none focus-visible:ring-2 focus-visible:ring-zen-primary focus-visible:ring-offset-2"
        >
            Đặt lịch ngay
        </a>
    </div>
</header>
