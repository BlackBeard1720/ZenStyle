{{--
    Footer: liên hệ + 4 cột tối + bar cuối.
--}}
<footer id="site-footer" data-site-footer class="border-t border-zen-border">
{{-- Footer dùng zen-dark để giữ tông luxury đen-trắng nhất quán. --}}
  <div class="bg-zen-dark text-zen-text-light">
    <div class="mx-auto grid max-w-6xl grid-cols-1 gap-10 px-4 py-14 sm:px-6 md:grid-cols-2 lg:grid-cols-4 lg:gap-12">
      
      <!-- Column 1: Brand & Contact -->
      <div class="lg:col-span-1">
        <a
          href="{{ route('home') }}"
          class="flex shrink-0 items-center gap-1 font-heading text-2xl font-bold tracking-tight text-white transition-colors duration-300"
          aria-label="ZenStyle — Home"
        >
          <span class="text-zen-accent">Z</span><span>enStyle</span>
        </a>
        <p class="mt-4 max-w-xs text-sm leading-relaxed text-white/70">
          A calm salon and spa experience for hair, skin, and self-care.
        </p>
        
        <div class="mt-6 space-y-3.5 text-sm text-white/80">
          <p class="flex items-center gap-2.5">
            <x-heroicon-o-map-pin class="h-[18px] w-[18px] shrink-0 text-zen-accent" />
            <span>Hanoi, Vietnam</span>
          </p>
          <p class="flex items-center gap-2.5">
            <x-heroicon-o-phone class="h-[18px] w-[18px] shrink-0 text-zen-accent" />
            <a href="tel:+84901234567" class="hover:text-zen-accent transition-colors">0901 234 567</a>
          </p>
          <p class="flex items-center gap-2.5">
            <x-heroicon-o-envelope class="h-[18px] w-[18px] shrink-0 text-zen-accent" />
            <a href="mailto:hello@zenstyle.vn" class="hover:text-zen-accent transition-colors">hello@zenstyle.vn</a>
          </p>
        </div>
        <p class="mt-6 text-xs text-white/40">© {{ date('Y') }} ZenStyle. All rights reserved.</p>
      </div>

      <!-- Column 2: Explore -->
      <div>
        <h4 class="text-sm font-semibold uppercase tracking-wide text-white">Explore</h4>
        <ul class="mt-4 space-y-2.5 text-sm text-white/70">
          <li><a href="{{ route('home') }}" class="transition hover:text-zen-accent-light">Home</a></li>
          <li><a href="{{ route('about') }}" class="transition hover:text-zen-accent-light">About</a></li>
          <li><a href="{{ route('services') }}" class="transition hover:text-zen-accent-light">Services</a></li>
          <li><a href="{{ route('faq') }}" class="transition hover:text-zen-accent-light">FAQ</a></li>
          <li><a href="{{ route('contact') }}" class="transition hover:text-zen-accent-light">Contact</a></li>
        </ul>
      </div>

      <!-- Column 3: Services -->
      <div>
        <h4 class="text-sm font-semibold uppercase tracking-wide text-white">Services</h4>
        <ul class="mt-4 space-y-2.5 text-sm text-white/70">
          <li><a href="{{ route('services') }}" class="transition hover:text-zen-accent-light">Hair Services</a></li>
          <li><a href="{{ route('services') }}" class="transition hover:text-zen-accent-light">Nail Services</a></li>
          <li><a href="{{ route('services') }}" class="transition hover:text-zen-accent-light">Spa & Massage</a></li>
          <li><a href="{{ route('services') }}" class="transition hover:text-zen-accent-light">Combo Packages</a></li>
        </ul>
      </div>

      <!-- Column 4: Visit -->
      <div>
        <h4 class="text-sm font-semibold uppercase tracking-wide text-white">Visit</h4>
        <p class="mt-4 text-sm text-white/70">Ready to plan your visit?</p>
        <p class="mt-2 text-sm text-white/50">Book your appointment online in a few simple steps.</p>
        {{-- Nút trong footer — dùng secondary (nền trắng) để nổi rõ trên footer tối --}}
        <div class="mt-6">
          <a
            href="{{ route('booking') }}"
            class="zen-btn-secondary inline-flex shadow-sm"
          >
            Book Now
          </a>
        </div>
      </div>

    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-white/10">
      <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-3 px-4 py-5 text-xs text-white/45 sm:flex-row sm:px-6">
        <span>ZenStyle — eProject.</span>
        <div class="flex flex-wrap items-center justify-center gap-4">
          <a href="{{ route('privacy-policy') }}" class="hover:text-zen-accent-light transition-colors">Privacy Policy</a>
          <a href="{{ route('terms-of-service') }}" class="hover:text-zen-accent-light transition-colors">Terms of Service</a>
          <a href="{{ route('faq') }}" class="hover:text-zen-accent-light transition-colors">FAQ</a>
        </div>
      </div>
    </div>
  </div>
</footer>

