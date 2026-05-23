<x-frontend.layout title="ZenStyle — Chính sách bảo mật" main-class="bg-zen-bg-soft pt-20">
    <section class="border-b border-zen-border bg-white px-4 py-12 sm:px-6 sm:py-14">
        <div class="mx-auto max-w-4xl">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Privacy policy</p>
            <h1 class="mt-3 font-heading text-3xl font-semibold text-zen-text sm:text-4xl">
                Chính sách bảo mật
            </h1>
            <p class="mt-4 text-sm leading-relaxed text-zen-muted sm:text-base">
                ZenStyle cam kết bảo vệ thông tin cá nhân của khách hàng khi truy cập website và sử dụng các dịch vụ
                đặt lịch trực tuyến.
            </p>
            <p class="mt-2 text-xs text-zen-muted">Cập nhật lần cuối: {{ now()->format('d/m/Y') }}</p>
        </div>
    </section>

    <section class="px-4 py-10 sm:px-6 sm:py-12">
        <article class="mx-auto max-w-4xl rounded-zen-lg border border-zen-border bg-zen-bg p-6 shadow-zen sm:p-8">
            <div class="space-y-8 text-sm leading-relaxed text-zen-text sm:text-base">
                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">1. Phạm vi thu thập thông tin</h2>
                    <p class="mt-2">
                        Chúng tôi có thể thu thập các thông tin mà bạn cung cấp khi đặt lịch hoặc liên hệ, bao gồm:
                        họ tên, số điện thoại, email, thời gian hẹn và ghi chú dịch vụ.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">2. Mục đích sử dụng thông tin</h2>
                    <p class="mt-2">Thông tin cá nhân được sử dụng để:</p>
                    <ul class="mt-3 list-disc space-y-1.5 pl-5">
                        <li>Xác nhận, quản lý và nhắc lịch hẹn tại ZenStyle.</li>
                        <li>Hỗ trợ tư vấn dịch vụ phù hợp với nhu cầu của khách hàng.</li>
                        <li>Gửi thông báo về ưu đãi, chương trình chăm sóc khách hàng (nếu bạn đồng ý nhận).</li>
                        <li>Cải thiện chất lượng dịch vụ và trải nghiệm sử dụng website.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">3. Lưu trữ và bảo mật dữ liệu</h2>
                    <p class="mt-2">
                        ZenStyle áp dụng biện pháp quản lý phù hợp để hạn chế truy cập trái phép, mất mát hoặc sử dụng
                        sai mục đích đối với thông tin cá nhân. Dữ liệu chỉ được lưu trữ trong thời gian cần thiết cho
                        hoạt động vận hành và chăm sóc khách hàng.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">4. Chia sẻ thông tin với bên thứ ba</h2>
                    <p class="mt-2">
                        Chúng tôi không bán hoặc trao đổi thông tin cá nhân của khách hàng cho bên thứ ba vì mục đích
                        thương mại. Thông tin chỉ có thể được cung cấp khi có yêu cầu từ cơ quan nhà nước có thẩm quyền
                        theo quy định pháp luật.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">5. Quyền của khách hàng</h2>
                    <p class="mt-2">
                        Bạn có quyền yêu cầu kiểm tra, cập nhật, chỉnh sửa hoặc xóa thông tin cá nhân đã cung cấp cho
                        ZenStyle bằng cách liên hệ qua email hoặc số điện thoại hỗ trợ.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">6. Liên hệ</h2>
                    <p class="mt-2">
                        Nếu có câu hỏi liên quan đến chính sách bảo mật, vui lòng liên hệ:
                        <a href="mailto:hello@zenstyle.vn" class="font-medium text-zen-primary hover:text-zen-primary-dark">
                            hello@zenstyle.vn
                        </a>
                        hoặc
                        <a href="tel:+84901234567" class="font-medium text-zen-primary hover:text-zen-primary-dark">
                            0901 234 567
                        </a>.
                    </p>
                </section>
            </div>
        </article>
    </section>
</x-frontend.layout>
