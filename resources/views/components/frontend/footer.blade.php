{{--
    Footer: liên hệ + bản đồ (zen-bg-soft) + 4 cột tối + bar cuối.
    #lien-he nằm trong footer. Bản đồ: Google embed (không dùng OSM iframe — tránh thanh attribution dày).
--}}
<footer class="border-t border-zen-border">
  <div id="lien-he" class="bg-zen-bg-soft text-zen-text scroll-mt-24 px-4 py-14 sm:px-6 lg:py-16">
    <div class="mx-auto max-w-6xl lg:grid lg:grid-cols-2 lg:items-stretch lg:gap-12">
      <div class="flex flex-col justify-center">
        <p class="text-zen-primary-dark text-xs font-semibold uppercase tracking-[0.2em]">Liên hệ</p>
        <h2 class="text-zen-text mt-3 font-['Playfair_Display',serif] text-3xl font-semibold leading-tight sm:text-4xl">
          Ghé thăm ZenStyle
        </h2>
        <p class="text-zen-muted mt-4 max-w-md text-sm leading-relaxed">
          Hệ thống chi nhánh ZenStyle có mặt tại các khu vực trung tâm. Chọn địa chỉ gần bạn nhất để được phục vụ nhanh chóng.
        </p>

        <ul class="mt-8 space-y-6">
          <li class="flex gap-3">
                        <span class="mt-0.5 shrink-0 text-zen-primary" aria-hidden="true">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 7a2.5 2.5 0 0 1 0 4.5z" />
                            </svg>
                        </span>
            <div>
              <p class="font-semibold text-zen-text">ZenStyle FPT Aptech</p>
              <p class="text-zen-muted mt-1 text-sm">
                FPT Aptech, Hà Nội
                <span class="text-zen-border-dark"> · </span>
                <a href="tel:+84901234567" class="text-zen-primary hover:text-zen-primary-dark underline decoration-zen-border-dark underline-offset-2">0901 234 567</a>
              </p>
            </div>
          </li>
        </ul>

        <div class="mt-10 flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-center">
          <a
            href="mailto:hello@zenstyle.vn"
            class="border-zen-border-dark bg-zen-secondary text-zen-text hover:bg-zen-primary-light inline-flex w-fit items-center gap-2 rounded-full border px-4 py-2.5 text-sm font-medium shadow-sm transition"
          >
            <svg class="h-4 w-4 text-zen-primary-dark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
              <path d="m22 6-10 7L2 6" />
            </svg>
            hello@zenstyle.vn
          </a>
          <a
            href="{{ route('contact') }}"
            class="bg-zen-primary text-zen-text-light hover:bg-zen-primary-dark inline-flex w-fit items-center gap-2 rounded-full px-4 py-2.5 text-sm font-semibold shadow-sm transition"
          >
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M9 12h6" />
              <path d="M9 16h6" />
              <path d="M8 4h8l2 2v14H6V6l2-2Z" />
              <path d="M16 4v4h4" />
            </svg>
            Biểu mẫu liên hệ
          </a>
          <div class="text-zen-muted flex flex-wrap items-center gap-4 text-sm">
            <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer" class="text-zen-primary hover:text-zen-primary-dark font-medium">Facebook</a>
            <span class="text-zen-border-dark">·</span>
            <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" class="text-zen-primary hover:text-zen-primary-dark font-medium">Instagram</a>
          </div>
        </div>
      </div>

      <!-- PHẦN BẢN ĐỒ ĐÃ ĐƯỢC CẬP NHẬT Ở ĐÂY -->
      <div class="relative mt-10 min-h-[280px] overflow-hidden rounded-zen-lg border border-zen-border bg-zen-bg shadow-zen ring-1 ring-zen-border lg:mt-0 lg:min-h-[360px]">
        <a
          href="https://www.google.com/maps/search/?api=1&amp;query={{ rawurlencode('Trường Cao đẳng FPT Polytechnic') }}"
          target="_blank"
          rel="noopener noreferrer"
          class="absolute right-3 top-3 z-10 rounded-zen-sm bg-zen-bg px-3 py-2 text-xs font-semibold text-zen-text shadow-md ring-1 ring-zen-border backdrop-blur-sm transition hover:bg-zen-accent-soft"
        >
          Mở trong Maps
        </a>
        <iframe
          title="Bản đồ ZenStyle"
          class="absolute inset-0 h-full w-full border-0"
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          allowfullscreen
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d553.5558370163218!2d105.74746568218576!3d21.038088948474012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313455e940879933%3A0xcf10b34e9f1a03df!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYw!5e0!3m2!1sen!2s!4v1778012474809!5m2!1sen!2s"
        ></iframe>
      </div>
    </div>
  </div>

  <div class="bg-zen-bg-dark text-zen-text-light">
    <div class="mx-auto grid max-w-6xl grid-cols-1 gap-10 px-4 py-14 sm:px-6 md:grid-cols-2 lg:grid-cols-4 lg:gap-12">
      <div class="lg:col-span-1">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5">
                    <span class="grid h-10 w-10 place-items-center rounded-full bg-zen-primary-light text-lg font-semibold text-zen-bg-dark shadow-lg">
                        Z
                    </span>
          <span class="text-xl font-semibold tracking-tight">ZenStyle</span>
        </a>
        <p class="mt-4 max-w-xs text-sm leading-relaxed text-white/75">
          ZenStyle — làm đẹp tóc, da &amp; spa. Phong cách của bạn là ưu tiên của chúng tôi.
        </p>
        <div class="mt-6 space-y-2 text-sm text-white/80">
          <p class="font-medium text-white">Liên hệ nhanh</p>
          <p class="flex gap-2">
            <span aria-hidden="true">📍</span>
            <span>FPT Aptech, Hà Nội</span>
          </p>
          <p class="flex flex-wrap items-center gap-2">
            <span aria-hidden="true">📞</span>
            <a href="tel:+84901234567" class="hover:text-zen-secondary">0901 234 567</a>
          </p>
          <p class="flex gap-2">
            <span aria-hidden="true">✉</span>
            <a href="mailto:hello@zenstyle.vn" class="hover:text-zen-secondary">hello@zenstyle.vn</a>
          </p>
        </div>
        <p class="mt-6 text-xs text-white/50">© {{ date('Y') }} ZenStyle. All rights reserved.</p>
      </div>

      <div>
        <h4 class="text-sm font-semibold uppercase tracking-wide text-white">Dịch vụ</h4>
        <ul class="mt-4 space-y-2.5 text-sm text-white/75">
          <li><a href="{{ route('services') }}#service-cat-toc-nam-cao-cap" class="transition hover:text-zen-secondary">Cắt tóc nam cao cấp</a></li>
          <li><a href="{{ route('services') }}#service-nhuom-tone-co-ban" class="transition hover:text-zen-secondary">Nhuộm tone cơ bản</a></li>
          <li><a href="{{ route('services') }}#service-goi-duong-sinh-chuyen-sau" class="transition hover:text-zen-secondary">Gội dưỡng sinh</a></li>
          <li><a href="{{ route('services') }}#service-cham-soc-da-co-ban" class="transition hover:text-zen-secondary">Chăm sóc da</a></li>
          <li><a href="{{ route('services') }}#service-list" class="transition hover:text-zen-secondary">Bảng dịch vụ</a></li>
        </ul>
      </div>

      <div>
        <h4 class="text-sm font-semibold uppercase tracking-wide text-white">Liên kết</h4>
        <ul class="mt-4 space-y-2.5 text-sm text-white/75">
          <li><a href="{{ route('home') }}" class="transition hover:text-zen-secondary">Trang chủ</a></li>
          <li><a href="{{ route('about') }}" class="transition hover:text-zen-secondary">Giới thiệu</a></li>
          <li><a href="{{ route('home') }}#hot-trend" class="transition hover:text-zen-secondary">Hottrend</a></li>
          <li><a href="{{ route('services') }}" class="transition hover:text-zen-secondary">Dịch vụ</a></li>
          <li><a href="{{ route('booking') }}" class="transition hover:text-zen-secondary">Đặt lịch</a></li>
          <li><a href="{{ route('contact') }}" class="transition hover:text-zen-secondary">Liên hệ</a></li>
        </ul>
      </div>

      <div>
        <h4 class="text-sm font-semibold uppercase tracking-wide text-white">Nhận ưu đãi</h4>
        <p class="mt-4 text-sm text-white/75">Đăng ký email để nhận khuyến mãi và tin mới.</p>
        <form action="#" method="post" class="mt-4 flex flex-col gap-2 sm:flex-row">
          @csrf
          <label class="sr-only" for="footer-email">Email</label>
          <input
            id="footer-email"
            name="email"
            type="email"
            required
            placeholder="Email của bạn"
            class="min-w-0 flex-1 rounded-full border border-white/15 bg-white/10 px-4 py-2.5 text-sm text-white placeholder:text-white/40 focus:border-zen-secondary focus:outline-none focus:ring-1 focus:ring-zen-secondary"
          />
          <button
            type="submit"
            class="bg-zen-primary text-zen-text-light hover:bg-zen-primary-dark shrink-0 rounded-full px-5 py-2.5 text-sm font-semibold transition"
          >
            Đăng ký
          </button>
        </form>
        <div class="mt-6 flex gap-3">
          <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer" class="text-xs text-white/60 hover:text-zen-secondary" aria-label="Facebook">Facebook</a>
          <span class="text-white/30">·</span>
          <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" class="text-xs text-white/60 hover:text-zen-secondary" aria-label="Instagram">Instagram</a>
          <span class="text-white/30">·</span>
          <a href="https://www.tiktok.com/" target="_blank" rel="noopener noreferrer" class="text-xs text-white/60 hover:text-zen-secondary" aria-label="TikTok">TikTok</a>
        </div>
      </div>
    </div>

    <div class="border-t border-white/10">
      <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-3 px-4 py-5 text-xs text-white/45 sm:flex-row sm:px-6">
        <span>ZenStyle — Aptech eProject.</span>
        <div class="flex flex-wrap items-center justify-center gap-4">
          <a href="{{ route('privacy-policy') }}" class="hover:text-white">Chính sách bảo mật</a>
          <a href="{{ route('terms-of-service') }}" class="hover:text-white">Điều khoản</a>
          <a href="{{ route('faq') }}" class="hover:text-white">FAQ</a>
        </div>
      </div>
    </div>
  </div>
</footer>
