<header
    id="site-header"
    @if (request()->is('/') || request()->routeIs('home'))
        data-on-banner="true"
    @endif
    class="group fixed inset-x-0 top-0 z-50 border-b border-zen-border bg-zen-bg backdrop-blur
        transition-[transform,background-color,border-color,backdrop-filter,text-color] duration-300 ease-out will-change-transform
        data-[on-banner='true']:border-transparent data-[on-banner='true']:!border-b-transparent data-[on-banner='true']:!bg-transparent data-[on-banner='true']:!backdrop-blur-none data-[on-banner='true']:shadow-none"
>
    @php
        $isHomeRoute = request()->routeIs('home');
        $isAboutRoute = request()->routeIs('about');
        $isNewsRoute = request()->routeIs('news');
        $isServicesRoute = request()->routeIs('services') || request()->routeIs('services.show');
        $isBookingRoute = request()->routeIs('booking');
        $isContactRoute = request()->routeIs('contact');
        $isFaqRoute = request()->routeIs('faq');
        $isPrivacyRoute = request()->routeIs('privacy-policy');
        $isTermsRoute = request()->routeIs('terms-of-service');
        $isPagesActive = $isFaqRoute || $isPrivacyRoute || $isTermsRoute;
    @endphp

    <div class="relative mx-auto flex max-w-6xl items-center px-4 py-4 sm:px-6">
        <a
            href="{{ route('home') }}"
            class="site-nav-brand relative z-10 flex shrink-0 items-center gap-1 font-heading text-2xl font-bold tracking-tight text-zen-text group-data-[on-banner='true']:text-white transition-colors duration-300"
            aria-label="ZenStyle — Home"
        >
            <span class="text-zen-primary transition-colors duration-300 group-data-[on-banner='true']:text-white">Z</span><span class="transition-colors duration-300">enStyle</span>
        </a>

        <nav
            aria-label="Main menu"
            class="site-nav-menu pointer-events-none absolute inset-x-0 top-1/2 z-0 hidden -translate-y-1/2 justify-center sm:flex"
        >
            <div class="pointer-events-auto flex items-center gap-6 text-sm font-medium">
                <a
                    href="{{ route('home') }}"
                    data-nav-key="home"
                    class="site-nav-link relative pb-1 transition-colors after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:origin-left after:rounded-full after:bg-zen-accent after:transition-transform after:duration-200 {{ $isHomeRoute ? 'is-active text-zen-accent after:scale-x-100 group-data-[on-banner=\'true\']:text-white group-data-[on-banner=\'true\']:after:bg-white' : 'text-zen-muted hover:text-zen-accent after:scale-x-0 hover:after:scale-x-100 group-data-[on-banner=\'true\']:text-white/80 group-data-[on-banner=\'true\']:hover:text-white group-data-[on-banner=\'true\']:after:bg-white' }}"
                >
                    Home
                </a>
                <a
                    href="{{ route('about') }}"
                    data-nav-key="about"
                    class="site-nav-link relative pb-1 transition-colors after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:origin-left after:rounded-full after:bg-zen-accent after:transition-transform after:duration-200 {{ $isAboutRoute ? 'is-active text-zen-accent after:scale-x-100 group-data-[on-banner=\'true\']:text-white group-data-[on-banner=\'true\']:after:bg-white' : 'text-zen-muted hover:text-zen-accent after:scale-x-0 hover:after:scale-x-100 group-data-[on-banner=\'true\']:text-white/80 group-data-[on-banner=\'true\']:hover:text-white group-data-[on-banner=\'true\']:after:bg-white' }}"
                >
                    About
                </a>
                <a
                    href="{{ route('services') }}"
                    data-nav-key="services"
                    class="site-nav-link relative pb-1 transition-colors after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:origin-left after:rounded-full after:bg-zen-accent after:transition-transform after:duration-200 {{ $isServicesRoute ? 'is-active text-zen-accent after:scale-x-100 group-data-[on-banner=\'true\']:text-white group-data-[on-banner=\'true\']:after:bg-white' : 'text-zen-muted hover:text-zen-accent after:scale-x-0 hover:after:scale-x-100 group-data-[on-banner=\'true\']:text-white/80 group-data-[on-banner=\'true\']:hover:text-white group-data-[on-banner=\'true\']:after:bg-white' }}"
                >
                    Services
                </a>
                <a
                    href="{{ route('booking') }}"
                    data-nav-key="booking"
                    class="site-nav-link relative pb-1 transition-colors after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:origin-left after:rounded-full after:bg-zen-accent after:transition-transform after:duration-200 {{ $isBookingRoute ? 'is-active text-zen-accent after:scale-x-100 group-data-[on-banner=\'true\']:text-white group-data-[on-banner=\'true\']:after:bg-white' : 'text-zen-muted hover:text-zen-accent after:scale-x-0 hover:after:scale-x-100 group-data-[on-banner=\'true\']:text-white/80 group-data-[on-banner=\'true\']:hover:text-white group-data-[on-banner=\'true\']:after:bg-white' }}"
                >
                    Booking
                </a>
                <a
                    href="{{ route('news') }}"
                    data-nav-key="news"
                    class="site-nav-link relative pb-1 transition-colors after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:origin-left after:rounded-full after:bg-zen-accent after:transition-transform after:duration-200 {{ $isNewsRoute ? 'is-active text-zen-accent after:scale-x-100 group-data-[on-banner=\'true\']:text-white group-data-[on-banner=\'true\']:after:bg-white' : 'text-zen-muted hover:text-zen-accent after:scale-x-0 hover:after:scale-x-100 group-data-[on-banner=\'true\']:text-white/80 group-data-[on-banner=\'true\']:hover:text-white group-data-[on-banner=\'true\']:after:bg-white' }}"
                >
                    News
                </a>

                <!-- Pages Dropdown -->
                <div class="relative group" id="desktop-pages-dropdown">
                    <button
                        type="button"
                        id="desktop-pages-trigger"
                        data-nav-key="pages"
                        class="site-nav-link flex items-center gap-1 pb-1 transition-colors after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:origin-left after:rounded-full after:bg-zen-accent after:transition-transform after:duration-200 cursor-pointer {{ $isPagesActive ? 'is-active text-zen-accent after:scale-x-100 group-data-[on-banner=\'true\']:text-white group-data-[on-banner=\'true\']:after:bg-white' : 'text-zen-muted hover:text-zen-accent after:scale-x-0 hover:after:scale-x-100 group-data-[on-banner=\'true\']:text-white/80 group-data-[on-banner=\'true\']:hover:text-white group-data-[on-banner=\'true\']:after:bg-white' }}"
                    >
                        <span>Pages</span>
                        <svg class="h-3.5 w-3.5 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div
                        id="desktop-pages-menu"
                        class="absolute left-1/2 top-full z-50 mt-2 w-48 -translate-x-1/2 scale-95 opacity-0 pointer-events-none group-hover:scale-100 group-hover:opacity-100 group-hover:pointer-events-auto group-[.is-open]:scale-100 group-[.is-open]:opacity-100 group-[.is-open]:pointer-events-auto transition-all duration-300 ease-out origin-top"
                    >
                        <div class="rounded-zen-md border border-zen-border bg-zen-bg py-2 shadow-zen-md backdrop-blur-md">
                            <a
                                href="{{ route('faq') }}"
                                data-nav-key="faq"
                                class="block px-4 py-2 text-sm text-zen-muted hover:bg-zen-bg-soft hover:text-zen-accent transition-colors duration-150 {{ $isFaqRoute ? 'text-zen-accent font-semibold bg-zen-accent-soft' : '' }}"
                            >
                                FAQ
                            </a>
                            <a
                                href="{{ route('privacy-policy') }}"
                                data-nav-key="privacy-policy"
                                class="block px-4 py-2 text-sm text-zen-muted hover:bg-zen-bg-soft hover:text-zen-accent transition-colors duration-150 {{ $isPrivacyRoute ? 'text-zen-accent font-semibold bg-zen-accent-soft' : '' }}"
                            >
                                Privacy Policy
                            </a>
                            <a
                                href="{{ route('terms-of-service') }}"
                                data-nav-key="terms-of-service"
                                class="block px-4 py-2 text-sm text-zen-muted hover:bg-zen-bg-soft hover:text-zen-accent transition-colors duration-150 {{ $isTermsRoute ? 'text-zen-accent font-semibold bg-zen-accent-soft' : '' }}"
                            >
                                Terms of Service
                            </a>
                        </div>
                    </div>
                </div>

                <a
                    href="{{ route('contact') }}"
                    data-nav-key="contact"
                    class="site-nav-link relative pb-1 transition-colors after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:origin-left after:rounded-full after:bg-zen-accent after:transition-transform after:duration-200 {{ $isContactRoute ? 'is-active text-zen-accent after:scale-x-100 group-data-[on-banner=\'true\']:text-white group-data-[on-banner=\'true\']:after:bg-white' : 'text-zen-muted hover:text-zen-accent after:scale-x-0 hover:after:scale-x-100 group-data-[on-banner=\'true\']:text-white/80 group-data-[on-banner=\'true\']:hover:text-white group-data-[on-banner=\'true\']:after:bg-white' }}"
                >
                    Contact
                </a>
            </div>
        </nav>

        <a
            href="{{ route('booking') }}"
            class="zen-btn-primary relative z-10 ml-auto shrink-0 hidden sm:inline-flex"
        >
            Book Now
        </a>

        {{-- Nút hamburger: dùng text-zen-text thay vì text-black để giữ tông espresso ấm --}}
        <button
            id="mobile-menu-toggle"
            type="button"
            class="relative z-10 ml-auto flex h-10 w-10 items-center justify-center rounded-full border border-zen-border bg-zen-surface/95 text-zen-text shadow-sm transition-all duration-300 hover:bg-zen-bg-soft focus:outline-none sm:hidden group-data-[on-banner='true']:border-white/20 group-data-[on-banner='true']:text-white group-data-[on-banner='true']:shadow-md"
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
                href="{{ route('booking') }}"
                data-nav-key="booking"
                class="mobile-nav-link text-base font-semibold transition-colors hover:text-zen-text py-2 border-b border-zen-border/40 {{ $isBookingRoute ? 'is-active text-zen-primary' : 'text-zen-muted' }}"
            >
                Booking
            </a>
            <a
                href="{{ route('news') }}"
                data-nav-key="news"
                class="mobile-nav-link text-base font-semibold transition-colors hover:text-zen-text py-2 border-b border-zen-border/40 {{ $isNewsRoute ? 'is-active text-zen-primary' : 'text-zen-muted' }}"
            >
                News
            </a>

            <!-- Pages Collapsible Section for Mobile -->
            <div class="border-b border-zen-border/40 py-2">
                <button
                    type="button"
                    id="mobile-pages-toggle"
                    data-nav-key="pages"
                    class="mobile-nav-link flex w-full items-center justify-between text-base font-semibold transition-colors hover:text-zen-text py-1 {{ $isPagesActive ? 'is-active text-zen-primary' : 'text-zen-muted' }}"
                    aria-expanded="{{ $isPagesActive ? 'true' : 'false' }}"
                >
                    <span>Pages</span>
                    <svg
                        id="mobile-pages-arrow"
                        class="h-4 w-4 transition-transform duration-300 {{ $isPagesActive ? 'rotate-180' : '' }}"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div
                    id="mobile-pages-collapse"
                    class="overflow-hidden transition-all duration-300 {{ $isPagesActive ? 'max-h-40 opacity-100 mt-2' : 'max-h-0 opacity-0' }}"
                >
                    <div class="flex flex-col gap-2 pl-4 pb-2">
                        <a
                            href="{{ route('faq') }}"
                            data-nav-key="faq"
                            class="mobile-nav-link text-sm font-medium transition-colors hover:text-zen-text py-1.5 {{ $isFaqRoute ? 'is-active text-zen-primary' : 'text-zen-muted' }}"
                        >
                            FAQ
                        </a>
                        <a
                            href="{{ route('privacy-policy') }}"
                            data-nav-key="privacy-policy"
                            class="mobile-nav-link text-sm font-medium transition-colors hover:text-zen-text py-1.5 {{ $isPrivacyRoute ? 'is-active text-zen-primary' : 'text-zen-muted' }}"
                        >
                            Privacy Policy
                        </a>
                        <a
                            href="{{ route('terms-of-service') }}"
                            data-nav-key="terms-of-service"
                            class="mobile-nav-link text-sm font-medium transition-colors hover:text-zen-text py-1.5 {{ $isTermsRoute ? 'is-active text-zen-primary' : 'text-zen-muted' }}"
                        >
                            Terms of Service
                        </a>
                    </div>
                </div>
            </div>

            <a
                href="{{ route('contact') }}"
                data-nav-key="contact"
                class="mobile-nav-link text-base font-semibold transition-colors hover:text-zen-text py-2 border-b border-zen-border/40 {{ $isContactRoute ? 'is-active text-zen-primary' : 'text-zen-muted' }}"
            >
                Contact
            </a>
            <a
                href="{{ route('booking') }}"
                class="zen-btn-primary mt-2 flex justify-center w-full"
            >
                Book Now
            </a>
        </div>
    </div>
</header>
