{{--
    Footer: liên hệ + bản đồ (zen-bg-soft) + 4 cột tối + bar cuối.
    #lien-he nằm trong footer. Bản đồ: Google embed (không dùng OSM iframe — tránh thanh attribution dày).
--}}
<footer class="border-t border-zen-border">
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
          <li><a href="{{ route('hot-trend.index') }}" class="transition hover:text-zen-secondary">Hot Trend</a></li>
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
