<div id="lien-he" class="bg-zen-bg-soft text-zen-text scroll-mt-24 px-4 py-14 sm:px-6 lg:py-16">
  <div class="mx-auto max-w-6xl lg:grid lg:grid-cols-2 lg:items-stretch lg:gap-12">
    <div class="flex flex-col justify-center">
      <p class="text-zen-primary-dark text-xs font-semibold uppercase tracking-[0.2em]">Contact</p>
      <h2 class="text-zen-text mt-3 font-heading text-3xl font-semibold leading-tight sm:text-4xl">
        Visit ZenStyle
      </h2>
      <p class="text-zen-muted mt-4 max-w-md text-sm leading-relaxed">
        Our salon is located in the heart of the city. Select our primary branch below to plan your visit.
      </p>

      <ul class="mt-8 space-y-6">
        <li class="flex gap-3">
          <span class="mt-0.5 shrink-0 text-zen-primary" aria-hidden="true">
            <x-heroicon-s-map-pin class="h-5 w-5" />
          </span>
          <div>
            <p class="font-semibold text-zen-text">ZenStyle Salon</p>
            <p class="text-zen-muted mt-1 text-sm">
              Hanoi, Vietnam
              <span class="text-zen-border-dark"> · </span>
              <a href="tel:+84901234567" class="text-zen-primary hover:text-zen-primary-dark underline decoration-zen-border-dark underline-offset-2">0901 234 567</a>
            </p>
          </div>
        </li>
      </ul>

      <div class="mt-10 flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-center">
        <a
          href="mailto:testforcode36@gmail.com"
          class="border-zen-border-dark bg-zen-secondary text-zen-text-light hover:bg-zen-primary-light inline-flex w-fit items-center gap-2 rounded-full border px-4 py-2.5 text-sm font-medium shadow-sm transition"
        >
          <x-heroicon-o-envelope class="h-4 w-4 text-zen-text-light" />
          hello@zenstyle.vn
        </a>
        <a
          href="{{ route('contact') }}"
          class="bg-zen-primary text-zen-text-light hover:bg-zen-primary-dark inline-flex w-fit items-center gap-2 rounded-full px-4 py-2.5 text-sm font-semibold shadow-sm transition"
        >
          <x-heroicon-o-document-text class="h-4 w-4" />
          Contact Form
        </a>
      </div>
    </div>

    <!-- MAP SECTION -->
    <div class="relative mt-10 min-h-[280px] overflow-hidden rounded-zen-lg border border-zen-border bg-zen-bg shadow-zen ring-1 ring-zen-border lg:mt-0 lg:min-h-[360px]">
      <a
        href="https://www.google.com/maps/search/?api=1&amp;query={{ rawurlencode('Trường Cao đẳng FPT Polytechnic') }}"
        target="_blank"
        rel="noopener noreferrer"
        class="absolute right-3 top-3 z-10 rounded-zen-sm bg-zen-bg px-3 py-2 text-xs font-semibold text-zen-text shadow-md ring-1 ring-zen-border backdrop-blur-sm transition hover:bg-zen-accent-soft"
      >
        Open in Maps
      </a>
      <iframe
        title="ZenStyle Map"
        class="absolute inset-0 h-full w-full border-0"
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        allowfullscreen
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d553.5558370163218!2d105.74746568218576!3d21.038088948474012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313455e940879933%3A0xcf10b34e9f1a03df!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYw!5e0!3m2!1sen!2s!4v1778012474809!5m2!1sen!2s"
      ></iframe>
    </div>
  </div>
</div>
