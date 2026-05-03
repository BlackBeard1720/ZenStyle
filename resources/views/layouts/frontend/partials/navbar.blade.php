<header
    id="site-header"
    class="fixed inset-x-0 top-0 z-50 border-b border-stone-200/80 bg-white/90 backdrop-blur
        transition-[transform,background-color,border-color,backdrop-filter,text-color] duration-300 ease-out will-change-transform
        data-[on-banner='true']:bg-black/20 data-[on-banner='true']:border-stone-900/20 data-[on-banner='true']:backdrop-blur-md"
>
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
        <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-2" aria-label="ZenStyle — Trang chủ">
            <img
                src="{{ asset('images/logos/zenstyle-wordmark.png') }}"
                alt="ZenStyle"
                class="site-nav-logo h-9 w-auto max-w-[200px] object-contain sm:h-10"
                loading="eager"
            />
        </a>
        <nav class="hidden items-center gap-6 text-sm font-medium sm:flex [&.on-banner_a]:text-white [&.on-banner_a]:hover:text-stone-100">
            <a href="{{ route('home') }}" class="site-nav-link text-stone-600 hover:text-stone-900 transition-colors">Trang chủ</a>
            <a href="{{route('about')}}" class="site-nav-link text-stone-600 hover:text-stone-900 transition-colors">Giới thiệu</a>
            <a href="{{route('news')}}" class="site-nav-link text-stone-600 hover:text-stone-900 transition-colors">Tin Tức</a>
            <a href="#dich-vu" class="site-nav-link text-stone-600 hover:text-stone-900 transition-colors">Dịch vụ</a>
            <a href="#lien-he" class="site-nav-link text-stone-600 hover:text-stone-900 transition-colors">Liên hệ</a>
        </nav>
        <a href="#dat-lich" class="site-nav-cta rounded-full bg-stone-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-stone-800
            data-[on-banner='true']:bg-rose-400 data-[on-banner='true']:hover:bg-rose-500">
            Đặt lịch ngay
        </a>
    </div>
</header>
