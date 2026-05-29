<x-frontend.layout title="ZenStyle — Trang chủ" main-class="pt-0">
  {{--
      Redesign: Chuyển từ "ép booking" sang "tham quan salon"
      Cấu trúc: Hero → Greeting → Services Discovery → Salon Space → Hot Trend → Experience Flow → Final CTA
  --}}
  @php
    $heroSlides = [
        [
            'image' => asset('images/frontend/banner/banner01.png'),
            'alt' => 'ZenStyle Spa Service',
        ],
        [
            'image' => asset('images/frontend/banner/banner02.png'),
            'alt' => 'ZenStyle Hair Service',
        ],
        [
            'image' => asset('images/frontend/banner/banner03.png'),
            'alt' => 'ZenStyle Salon Space',
        ],
    ];



    $salonImages = [
        asset('images/frontend/space/space-main.png'),
        asset('images/frontend/space/space-detail.png'),
    ];


    $experienceSteps = [
        ['title' => 'Choose Your Service', 'desc' => 'Explore services and select what fits your needs.'],
        ['title' => 'Book Your Time', 'desc' => 'Pick a suitable time slot and submit your appointment request.'],
        ['title' => 'Visit the Salon', 'desc' => 'Arrive at ZenStyle and check in with our team.'],
        ['title' => 'Get Consultation & Care', 'desc' => 'Our staff will consult, perform the service, and guide aftercare.'],
    ];
  @endphp

  {{-- ===== HERO / BANNER ===== --}}
  <section
    id="site-banner"
    class="relative min-h-screen w-full overflow-hidden bg-zen-dark"
    aria-label="ZenStyle Banner">
    <div
      class="pointer-events-none absolute inset-0 z-10 bg-gradient-to-b from-black/45 via-black/20 to-black/60"></div>

    <div class="relative h-screen">
      @foreach ($heroSlides as $index => $slide)
        <article
          data-slide
          class="absolute inset-0 transition-opacity duration-700 ease-out {{ $index === 0 ? 'opacity-100' : 'pointer-events-none opacity-0' }}"
          aria-hidden="{{ $index === 0 ? 'false' : 'true' }}"
        >
          <img
            src="{{ $slide['image'] }}"
            alt="{{ $slide['alt'] }}"
            class="h-full w-full object-cover"
            loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
          />
        </article>
      @endforeach
    </div>

    <div class="absolute inset-x-0 bottom-8 z-30 flex justify-center gap-3 pointer-events-auto">
      @foreach ($heroSlides as $index => $slide)
        <button
          type="button"
          data-slide-dot
          data-slide-index="{{ $index }}"
          class="h-3 rounded-full transition-all cursor-pointer pointer-events-auto {{ $index === 0 ? 'w-8 bg-white' : 'w-3 bg-white/50 hover:bg-white/75' }}"
          aria-label="Chuyển đến slide {{ $index + 1 }}"
          aria-current="{{ $index === 0 ? 'true' : 'false' }}"
        ></button>
      @endforeach
    </div>

    <div class="pointer-events-none absolute bottom-0 left-0 right-0 text-zen-bg" aria-hidden="true">
      <svg class="block h-12 w-full sm:h-16" viewBox="0 0 1440 100" preserveAspectRatio="none"
           xmlns="http://www.w3.org/2000/svg">
        <path fill="currentColor" d="M0,48 C240,95 480,5 720,58 C960,112 1200,18 1440,52 L1440,100 L0,100 Z"/>
      </svg>
    </div>
  </section>

  {{-- Section 1: lời chào trên nền trắng sạch theo nhận diện black-white. --}}
  <section class="scroll-mt-24 bg-zen-bg px-4 py-12 sm:px-6 lg:py-16">
    <div class="mx-auto max-w-6xl">
      <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">ZenStyle Salon</p>
      <h2 class="mt-3 font-heading text-3xl font-semibold leading-tight text-zen-text sm:text-4xl">
        A peaceful space to relax and renew your look
      </h2>
      <p class="mt-4 max-w-2xl text-sm leading-7 text-zen-muted sm:text-base">
        ZenStyle combines hair care, nourishing shampoo, and spa treatments in a gentle, tranquil atmosphere. Explore our services, view our space, and meet our team before booking.
      </p>
      <div class="mt-6 flex flex-wrap gap-3 sm:gap-4">
        <a href="#dich-vu" class="zen-btn-primary">
          Explore Services
        </a>
        <a href="#khong-gian" class="zen-btn-secondary">
          View Our Space
        </a>
      </div>
    </div>
  </section>

  {{-- ===== SECTION 2: SERVICE DISCOVERY ===== --}}
  <section id="dich-vu" class="scroll-mt-24 bg-zen-bg px-4 py-12 sm:px-6 lg:py-14">
    <div class="mx-auto max-w-6xl">
      <div class="max-w-2xl">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Services</p>
        <h2 class="mt-3 font-heading text-3xl font-semibold leading-tight text-zen-text sm:text-4xl">
          Discover Services at ZenStyle
        </h2>
        <p class="mt-4 text-sm leading-7 text-zen-muted sm:text-base">
          From premium hair care and nourishing scalp massage to relaxing spa treatments, explore our signature selections.
        </p>
      </div>

      @if ($featuredServices->isNotEmpty())
        <div class="mt-10 overflow-hidden relative w-full" data-service-carousel>
          <div class="flex" data-service-track>
            <!-- Original slides -->
            @foreach ($featuredServices as $service)
              <article class="w-[280px] sm:w-[320px] md:w-[360px] shrink-0 px-3">
                <div class="flex h-full flex-col border border-zen-border bg-zen-bg transition hover:shadow-zen duration-300 rounded-none">
                  <div class="relative overflow-hidden bg-zen-bg-soft shrink-0">
                    <a href="{{ route('services.show', $service) }}" class="block w-full">
                      <img
                        src="{{ $service->thumbnail ? asset($service->thumbnail) : asset('images/default-news.jpg') }}"
                        alt="{{ $service->name }}"
                        class="h-60 w-full object-cover transition duration-300 hover:scale-102"
                        loading="lazy"
                      >
                    </a>
                  </div>
                  <div class="p-6 flex flex-1 flex-col">
                    <div>
                      <span class="text-[10px] font-bold uppercase tracking-wider text-zen-primary bg-zen-primary/10 px-2.5 py-1">
                        {{ $service->category?->name ?? 'Service' }}
                      </span>
                      <h3 class="mt-3 text-lg font-semibold text-zen-text line-clamp-1">
                        <a href="{{ route('services.show', $service) }}" class="hover:text-zen-accent transition-colors">
                          {{ $service->name }}
                        </a>
                      </h3>
                      <p class="mt-2 text-sm leading-relaxed text-zen-muted line-clamp-3">
                        {{ Str::limit(strip_tags($service->description), 100) }}
                      </p>
                    </div>
                  </div>
                </div>
              </article>
            @endforeach

            <!-- Duplicated slides for seamless loop -->
            @foreach ($featuredServices as $service)
              <article class="w-[280px] sm:w-[320px] md:w-[360px] shrink-0 px-3" aria-hidden="true">
                <div class="flex h-full flex-col border border-zen-border bg-zen-bg transition hover:shadow-zen duration-300 rounded-none">
                  <div class="relative overflow-hidden bg-zen-bg-soft shrink-0">
                    <a href="{{ route('services.show', $service) }}" class="block w-full">
                      <img
                        src="{{ $service->thumbnail ? asset($service->thumbnail) : asset('images/default-news.jpg') }}"
                        alt="{{ $service->name }}"
                        class="h-60 w-full object-cover transition duration-300 hover:scale-102"
                        loading="lazy"
                      >
                    </a>
                  </div>
                  <div class="p-6 flex flex-1 flex-col">
                    <div>
                      <span class="text-[10px] font-bold uppercase tracking-wider text-zen-primary bg-zen-primary/10 px-2.5 py-1">
                        {{ $service->category?->name ?? 'Service' }}
                      </span>
                      <h3 class="mt-3 text-lg font-semibold text-zen-text line-clamp-1">
                        <a href="{{ route('services.show', $service) }}" class="hover:text-zen-accent transition-colors">
                          {{ $service->name }}
                        </a>
                      </h3>
                      <p class="mt-2 text-sm leading-relaxed text-zen-muted line-clamp-3">
                        {{ Str::limit(strip_tags($service->description), 100) }}
                      </p>
                    </div>
                  </div>
                </div>
              </article>
            @endforeach
          </div>
        </div>
      @else
        <div class="mt-10 w-full py-12 text-center border border-zen-border">
          <p class="text-base text-zen-muted">No active services are available right now. Please check back later.</p>
        </div>
      @endif
    </div>
  </section>

  {{-- ===== SECTION 3: SALON SPACE GALLERY ===== --}}
  <section id="khong-gian" class="scroll-mt-24 bg-zen-bg-soft px-4 py-12 sm:px-6 lg:py-16">
    <div class="mx-auto max-w-6xl">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-stretch">
        <!-- Left: Large premium primary space image -->
        <div class="lg:col-span-7 w-full h-full min-h-[350px] lg:min-h-[520px] relative overflow-hidden border border-zen-border rounded-none shadow-sm shrink-0">
          <img
            src="{{ $salonImages[0] }}"
            alt="ZenStyle Premium Salon Space"
            class="absolute inset-0 w-full h-full object-cover transition duration-500 hover:scale-[1.02]"
            loading="lazy"
            decoding="async"
          >
        </div>

        <!-- Right: Section details + supportive secondary space image -->
        <div class="lg:col-span-5 flex flex-col justify-between gap-8">
          <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Salon Space</p>
            <h2 class="mt-3 font-heading text-3xl font-semibold leading-tight text-zen-text sm:text-4xl">
              A Calm Space for Self-Care
            </h2>
            <p class="mt-4 text-sm leading-relaxed text-zen-muted sm:text-base">
              ZenStyle is designed to feel clean, quiet, and relaxing throughout every appointment.
            </p>
          </div>

          <div class="w-full h-[240px] sm:h-[300px] lg:h-[280px] relative overflow-hidden border border-zen-border rounded-none shadow-sm shrink-0">
            <img
              src="{{ $salonImages[1] }}"
              alt="ZenStyle Treatment Environment"
              class="absolute inset-0 w-full h-full object-cover transition duration-500 hover:scale-[1.02]"
              loading="lazy"
              decoding="async"
            >
          </div>
        </div>
      </div>
    </div>
  </section>


  {{-- ===== SECTION 5: EXPERIENCE FLOW (Premium Timeline) ===== --}}
  <section class="bg-zen-bg px-4 py-16 sm:px-6 lg:py-24 border-t border-b border-zen-border/40">
    <div class="mx-auto max-w-6xl">
      <div class="max-w-2xl mx-auto text-center mb-16">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Process</p>
        <h2 class="mt-3 font-heading text-3xl font-semibold leading-tight text-zen-text sm:text-4xl">
          How does an appointment at ZenStyle work?
        </h2>
      </div>

      <div class="relative max-w-5xl mx-auto mt-12">
        <!-- Connecting Line for Desktop (Horizontal) -->
        <div class="absolute top-6 left-[12.5%] right-[12.5%] h-[1px] bg-zen-border/80 z-0 hidden md:block"></div>
        
        <!-- Connecting Line for Mobile (Vertical) -->
        <div class="absolute top-6 bottom-6 left-6 w-[1px] bg-zen-border/80 z-0 md:hidden"></div>

        <ol class="grid grid-cols-1 md:grid-cols-4 gap-10 md:gap-8 relative z-10">
          @foreach ($experienceSteps as $step)
            <li class="relative pl-16 pb-10 last:pb-0 md:pl-0 md:pb-0 md:text-center group">
              <!-- Number Circle -->
              <div class="absolute left-0 top-0 md:relative md:left-auto md:top-auto md:mx-auto w-12 h-12 rounded-full border border-zen-border bg-zen-surface flex items-center justify-center font-mono font-bold text-sm text-zen-muted transition-all duration-300 z-10 group-hover:border-zen-primary group-hover:text-zen-primary group-hover:bg-zen-bg-soft">
                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
              </div>
              
              <!-- Content -->
              <div class="mt-1 md:mt-6">
                <h3 class="font-heading text-base font-semibold text-zen-text tracking-tight group-hover:text-zen-primary transition-colors duration-300">
                  {{ $step['title'] }}
                </h3>
                <p class="mt-2 text-sm leading-relaxed text-zen-muted max-w-xs md:mx-auto">
                  {{ $step['desc'] }}
                </p>
              </div>
            </li>
          @endforeach
        </ol>
      </div>
    </div>
  </section>

  {{-- ===== SECTION 6: FINAL CTA ===== --}}
  <section class="bg-zen-bg px-4 py-14 sm:px-6 lg:py-16">
    <div class="mx-auto max-w-6xl overflow-hidden rounded-none border border-zen-border bg-zen-bg-soft p-8 sm:p-10 lg:p-12 shadow-none">
      <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-center">
        <div>
          <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">ZenStyle booking</p>
          <h2 class="mt-3 font-heading text-3xl font-semibold text-zen-text sm:text-4xl">
            Sẵn sàng làm mới diện mạo của bạn?
          </h2>
          <p class="mt-3 max-w-2xl text-sm leading-relaxed text-zen-muted sm:text-base">
            Chọn dịch vụ, thời gian và stylist phù hợp. ZenStyle sẽ ghi nhận lịch hẹn và liên hệ xác nhận nếu cần.
          </p>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row">
          <a href="{{ route('booking') }}" class="zen-btn-primary">
            Book Now
          </a>
          <a href="{{ route('services') }}" class="zen-btn-secondary">
            Xem dịch vụ
          </a>
        </div>
      </div>
    </div>
  </section>
  <x-frontend.contact-section/>
</x-frontend.layout>
