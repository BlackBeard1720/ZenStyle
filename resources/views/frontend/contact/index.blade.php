<x-frontend.layout title="ZenStyle — Liên hệ" main-class="bg-stone-50 pt-20">
    @php
        $googleFormUrl = 'https://forms.gle/CQn7soz85KCEsj1HA';
        $googleFormOpenUrl = 'https://forms.gle/CQn7soz85KCEsj1HA';
    @endphp

    <section class="border-b border-stone-200/70 bg-white px-4 py-12 sm:px-6 sm:py-14">
        <div class="mx-auto flex max-w-6xl flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-rose-700">Contact form</p>
                <h1 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold text-stone-900 sm:text-4xl">
                    Biểu mẫu liên hệ
                </h1>
                <p class="mt-4 text-sm leading-relaxed text-stone-600 sm:text-base">
                    Gửi thông tin tư vấn, đặt lịch hoặc phản hồi cho ZenStyle. Team salon sẽ liên hệ lại qua số điện thoại hoặc email bạn cung cấp.
                </p>
            </div>

            <a
                href="{{ $googleFormOpenUrl }}"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex w-fit items-center justify-center rounded-full bg-rose-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-rose-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-rose-400 focus-visible:ring-offset-2"
            >
                Mở trong Google
            </a>
        </div>
    </section>

    <section class="px-4 py-10 sm:px-6 sm:py-12">
        <div class="mx-auto max-w-6xl">
            <div class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
                <div class="flex flex-col gap-3 border-b border-stone-200 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">
                    <p class="text-sm font-semibold text-stone-900">ZenStyle Google Form</p>
                    <a
                        href="{{ $googleFormOpenUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-sm font-medium text-rose-700 hover:text-rose-800"
                    >
                        Mở tab mới
                    </a>
                </div>

                <iframe
                    title="Biểu mẫu liên hệ ZenStyle"
                    src="{{ $googleFormUrl }}"
                    class="h-[760px] w-full border-0 bg-white sm:h-[860px]"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
            </div>
        </div>
    </section>
</x-frontend.layout>
