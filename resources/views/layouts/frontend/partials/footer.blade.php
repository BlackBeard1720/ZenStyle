{{--
    Footer: liên hệ + bản đồ (rose-50) + 4 cột tối + bar cuối.
    #lien-he nằm trong footer. Bản đồ: Google embed (không dùng OSM iframe — tránh thanh attribution dày).
--}}
<footer class="border-t border-stone-200/80">
    <div id="lien-he" class="scroll-mt-24 bg-rose-50 px-4 py-14 text-stone-800 sm:px-6 lg:py-16">
        <div class="mx-auto max-w-6xl lg:grid lg:grid-cols-2 lg:items-stretch lg:gap-12">
            <div class="flex flex-col justify-center">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-rose-900/80">Liên hệ</p>
                <h2 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold leading-tight text-stone-900 sm:text-4xl">
                    Ghé thăm ZenStyle
                </h2>
                <p class="mt-4 max-w-md text-sm leading-relaxed text-stone-600">
                    Hệ thống chi nhánh ZenStyle có mặt tại các khu vực trung tâm. Chọn địa chỉ gần bạn nhất để được phục vụ nhanh chóng.
                </p>

                <ul class="mt-8 space-y-6">
                    <li class="flex gap-3">
                        <span class="mt-0.5 shrink-0 text-rose-500" aria-hidden="true">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 7a2.5 2.5 0 0 1 0 4.5z" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-semibold text-stone-900">ZenStyle Triều Khúc</p>
                            <p class="mt-1 text-sm text-stone-600">
                                Triều Khúc, phường Tân Triều, Hà Nội
                                <span class="text-stone-400"> · </span>
                                <a href="tel:+84901234567" class="text-stone-700 underline decoration-stone-300 underline-offset-2 hover:text-rose-700">0901 234 567</a>
                            </p>
                        </div>
                    </li>
                </ul>

                <div class="mt-10 flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-center">
                    <a
                        href="mailto:hello@zenstyle.vn"
                        class="inline-flex w-fit items-center gap-2 rounded-full border border-stone-400/90 bg-white/60 px-4 py-2.5 text-sm font-medium text-stone-900 shadow-sm transition hover:border-stone-500 hover:bg-white"
                    >
                        <svg class="h-4 w-4 text-stone-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <path d="m22 6-10 7L2 6" />
                        </svg>
                        hello@zenstyle.vn
                    </a>
                    <div class="flex flex-wrap items-center gap-4 text-sm text-stone-600">
                        <a href="#" class="font-medium hover:text-rose-700">Facebook</a>
                        <span class="text-stone-300">·</span>
                        <a href="#" class="font-medium hover:text-rose-700">Instagram</a>
                    </div>
                </div>
            </div>

            <div class="relative mt-10 min-h-[280px] overflow-hidden rounded-2xl border border-stone-200/90 bg-stone-200 shadow-lg ring-1 ring-stone-900/5 lg:mt-0 lg:min-h-[360px]">
                <a
                    href="https://www.google.com/maps/search/?api=1&amp;query={{ rawurlencode('Trường Cao đẳng FPT Polytechnic') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="absolute left-3 top-3 z-10 rounded-lg bg-white/95 px-3 py-2 text-xs font-semibold text-stone-800 shadow-md ring-1 ring-stone-200/90 backdrop-blur-sm transition hover:bg-white"
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

    <div class="bg-stone-900 text-white">
        <div class="mx-auto grid max-w-6xl grid-cols-1 gap-10 px-4 py-14 sm:px-6 md:grid-cols-2 lg:grid-cols-4 lg:gap-12">
            <div class="lg:col-span-1">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5">
                    <span class="grid h-10 w-10 place-items-center rounded-full bg-rose-500 text-lg font-semibold text-white shadow-lg shadow-rose-900/30">
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
                        <span>Triều Khúc, phường Tân Triều, Hà Nội</span>
                    </p>
                    <p class="flex flex-wrap items-center gap-2">
                        <span aria-hidden="true">📞</span>
                        <a href="tel:+84901234567" class="hover:text-rose-300">0901 234 567</a>
                    </p>
                    <p class="flex gap-2">
                        <span aria-hidden="true">✉</span>
                        <a href="mailto:hello@zenstyle.vn" class="hover:text-rose-300">hello@zenstyle.vn</a>
                    </p>
                </div>
                <p class="mt-6 text-xs text-white/50">© {{ date('Y') }} ZenStyle. All rights reserved.</p>
            </div>

            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wide text-white">Dịch vụ</h4>
                <ul class="mt-4 space-y-2.5 text-sm text-white/75">
                    <li><a href="#dich-vu" class="transition hover:text-rose-300">Tạo kiểu &amp; cắt tóc</a></li>
                    <li><a href="#dich-vu" class="transition hover:text-rose-300">Nhuộm &amp; uốn</a></li>
                    <li><a href="#dich-vu" class="transition hover:text-rose-300">Spa &amp; phục hồi tóc</a></li>
                    <li><a href="#dich-vu" class="transition hover:text-rose-300">Chăm sóc da</a></li>
                    <li><a href="#dich-vu" class="transition hover:text-rose-300">Gói Bridal</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wide text-white">Liên kết</h4>
                <ul class="mt-4 space-y-2.5 text-sm text-white/75">
                    <li><a href="{{ route('home') }}" class="transition hover:text-rose-300">Trang chủ</a></li>
                    <li><a href="#site-banner" class="transition hover:text-rose-300">Giới thiệu</a></li>
                    <li><a href="#dich-vu" class="transition hover:text-rose-300">Hottrend</a></li>
                    <li><a href="#dich-vu" class="transition hover:text-rose-300">Dịch vụ</a></li>
                    <li><a href="#dat-lich" class="transition hover:text-rose-300">Đặt lịch</a></li>
                    <li><a href="#lien-he" class="transition hover:text-rose-300">Liên hệ</a></li>
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
                        class="min-w-0 flex-1 rounded-full border border-white/15 bg-white/10 px-4 py-2.5 text-sm text-white placeholder:text-white/40 focus:border-rose-400 focus:outline-none focus:ring-1 focus:ring-rose-400"
                    />
                    <button
                        type="submit"
                        class="shrink-0 rounded-full bg-rose-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-rose-400"
                    >
                        Đăng ký
                    </button>
                </form>
                <div class="mt-6 flex gap-3">
                    <a href="#" class="text-xs text-white/60 hover:text-rose-300" aria-label="Facebook">Facebook</a>
                    <span class="text-white/30">·</span>
                    <a href="#" class="text-xs text-white/60 hover:text-rose-300" aria-label="Instagram">Instagram</a>
                    <span class="text-white/30">·</span>
                    <a href="#" class="text-xs text-white/60 hover:text-rose-300" aria-label="TikTok">TikTok</a>
                </div>
            </div>
        </div>

        <div class="border-t border-white/10">
            <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-3 px-4 py-5 text-xs text-white/45 sm:flex-row sm:px-6">
                <span>ZenStyle — Aptech eProject.</span>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a href="#" class="hover:text-white">Chính sách bảo mật</a>
                    <a href="#" class="hover:text-white">Điều khoản</a>
                    <a href="#" class="hover:text-white">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</footer>