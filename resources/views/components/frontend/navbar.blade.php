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
        $isFaqRoute = request()->routeIs('faq');
        $isContactRoute = request()->routeIs('contact');
    @endphp

    <div class="relative mx-auto flex max-w-6xl items-center px-4 py-4 sm:px-6">
        <a
            href="{{ route('home') }}"
            class="site-nav-brand relative z-10 flex shrink-0 items-center gap-1 font-heading text-2xl font-bold tracking-tight text-zen-text transition-colors duration-300"
            aria-label="ZenStyle — Home"
        >
            <span class="text-zen-primary transition-colors duration-300">Z</span><span class="transition-colors duration-300">enStyle</span>
        </a>

        <nav
            aria-label="Main menu"
            class="site-nav-menu pointer-events-none absolute inset-x-0 top-1/2 z-0 hidden -translate-y-1/2 justify-center sm:flex"
        >
            <div class="pointer-events-auto flex items-center gap-6 text-sm font-medium">
                <a
                    href="{{ route('home') }}"
                    data-nav-key="home"
                    class="site-nav-link relative pb-1 transition-colors after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:origin-left after:rounded-full after:bg-zen-accent after:transition-transform after:duration-200 {{ $isHomeRoute ? 'is-active text-zen-accent after:scale-x-100' : 'text-zen-muted hover:text-zen-accent after:scale-x-0 hover:after:scale-x-100' }}"
                >
                    Home
                </a>
                <a
                    href="{{ route('about') }}"
                    data-nav-key="about"
                    class="site-nav-link relative pb-1 transition-colors after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:origin-left after:rounded-full after:bg-zen-accent after:transition-transform after:duration-200 {{ $isAboutRoute ? 'is-active text-zen-accent after:scale-x-100' : 'text-zen-muted hover:text-zen-accent after:scale-x-0 hover:after:scale-x-100' }}"
                >
                    About
                </a>
                <a
                    href="{{ route('services') }}"
                    data-nav-key="services"
                    class="site-nav-link relative pb-1 transition-colors after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:origin-left after:rounded-full after:bg-zen-accent after:transition-transform after:duration-200 {{ $isServicesRoute ? 'is-active text-zen-accent after:scale-x-100' : 'text-zen-muted hover:text-zen-accent after:scale-x-0 hover:after:scale-x-100' }}"
                >
                    Services
                </a>
                <a
                    href="{{ route('faq') }}"
                    data-nav-key="faq"
                    class="site-nav-link relative pb-1 transition-colors after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:origin-left after:rounded-full after:bg-zen-accent after:transition-transform after:duration-200 {{ $isFaqRoute ? 'is-active text-zen-accent after:scale-x-100' : 'text-zen-muted hover:text-zen-accent after:scale-x-0 hover:after:scale-x-100' }}"
                >
                    FAQ
                </a>
                <a
                    href="{{ route('news') }}"
                    data-nav-key="news"
                    class="site-nav-link relative pb-1 transition-colors after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:origin-left after:rounded-full after:bg-zen-accent after:transition-transform after:duration-200 {{ $isNewsRoute ? 'is-active text-zen-accent after:scale-x-100' : 'text-zen-muted hover:text-zen-accent after:scale-x-0 hover:after:scale-x-100' }}"
                >
                    News
                </a>
                <a
                    href="{{ route('contact') }}"
                    data-nav-key="contact"
                    class="site-nav-link relative pb-1 transition-colors after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:origin-left after:rounded-full after:bg-zen-accent after:transition-transform after:duration-200 {{ $isContactRoute ? 'is-active text-zen-accent after:scale-x-100' : 'text-zen-muted hover:text-zen-accent after:scale-x-0 hover:after:scale-x-100' }}"
                >
                    Contact
                </a>
            </div>
        </nav>

        <a
            href="{{ route('booking') }}"
            class="site-nav-cta booking-cta relative z-10 ml-auto shrink-0 rounded-full px-4 py-2 text-sm font-semibold focus:outline-none focus-visible:ring-2 focus-visible:ring-zen-primary focus-visible:ring-offset-2 hidden sm:inline-flex"
        >
            Book Appointment
        </a>

        <!-- Hamburger Button for Mobile -->
        <button
            id="mobile-menu-toggle"
            type="button"
            class="relative z-10 ml-auto flex h-10 w-10 items-center justify-center rounded-full border border-zen-border bg-zen-bg text-zen-text transition-all duration-300 hover:bg-zen-bg-soft focus:outline-none sm:hidden"
            aria-expanded="false"
            aria-controls="mobile-menu"
            aria-label="Toggle navigation menu"
        >
            <svg class="h-5 w-5 fill-none stroke-current stroke-2 transition-transform duration-300" viewBox="0 0 24 24" id="hamburger-icon">
                <line x1="4" y1="6" x2="20" y2="6" class="origin-center transition-all duration-300" id="hamburger-line-top"></line>
                <line x1="4" y1="12" x2="20" y2="12" class="origin-center transition-all duration-300" id="hamburger-line-middle"></line>
                <line x1="4" y1="18" x2="20" y2="18" class="origin-center transition-all duration-300" id="hamburger-line-bottom"></line>
            </svg>
        </button>
    </div>

    <!-- Mobile Menu Panel -->
    <div
        id="mobile-menu"
        class="pointer-events-none absolute inset-x-0 top-full z-40 max-h-[85vh] origin-top scale-y-95 overflow-y-auto border-b border-zen-border bg-zen-bg/95 px-6 py-6 opacity-0 shadow-zen-md backdrop-blur-md transition-all duration-300 ease-out sm:hidden"
    >
        <div class="flex flex-col gap-4">
            <a
                href="{{ route('home') }}"
                data-nav-key="home"
                class="mobile-nav-link text-base font-semibold transition-colors hover:text-zen-text py-2 border-b border-zen-border/40 {{ $isHomeRoute ? 'is-active text-zen-primary' : 'text-zen-muted' }}"
            >
                Home
            </a>
            <a
                href="{{ route('about') }}"
                data-nav-key="about"
                class="mobile-nav-link text-base font-semibold transition-colors hover:text-zen-text py-2 border-b border-zen-border/40 {{ $isAboutRoute ? 'is-active text-zen-primary' : 'text-zen-muted' }}"
            >
                About
            </a>
            <a
                href="{{ route('services') }}"
                data-nav-key="services"
                class="mobile-nav-link text-base font-semibold transition-colors hover:text-zen-text py-2 border-b border-zen-border/40 {{ $isServicesRoute ? 'is-active text-zen-primary' : 'text-zen-muted' }}"
            >
                Services
            </a>
            <a
                href="{{ route('faq') }}"
                data-nav-key="faq"
                class="mobile-nav-link text-base font-semibold transition-colors hover:text-zen-text py-2 border-b border-zen-border/40 {{ $isFaqRoute ? 'is-active text-zen-primary' : 'text-zen-muted' }}"
            >
                FAQ
            </a>
            <a
                href="{{ route('news') }}"
                data-nav-key="news"
                class="mobile-nav-link text-base font-semibold transition-colors hover:text-zen-text py-2 border-b border-zen-border/40 {{ $isNewsRoute ? 'is-active text-zen-primary' : 'text-zen-muted' }}"
            >
                News
            </a>
            <a
                href="{{ route('contact') }}"
                data-nav-key="contact"
                class="mobile-nav-link text-base font-semibold transition-colors hover:text-zen-text py-2 border-b border-zen-border/40 {{ $isContactRoute ? 'is-active text-zen-primary' : 'text-zen-muted' }}"
            >
                Contact
            </a>
            <a
                href="{{ route('booking') }}"
                class="mobile-nav-cta booking-cta mt-2 flex items-center justify-center rounded-full py-3 text-center text-sm font-semibold"
            >
                Book Appointment
            </a>
        </div>
    </div>
</header>
