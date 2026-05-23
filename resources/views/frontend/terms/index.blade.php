<x-frontend.layout title="ZenStyle — Điều khoản sử dụng" main-class="bg-zen-bg-soft pt-20">
    <section class="border-b border-zen-border bg-white px-4 py-12 sm:px-6 sm:py-14">
        <div class="mx-auto max-w-4xl">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">Terms of service</p>
            <h1 class="mt-3 font-heading text-3xl font-semibold text-zen-text sm:text-4xl">
                Điều khoản sử dụng
            </h1>
            <p class="mt-4 text-sm leading-relaxed text-zen-muted sm:text-base">
                Khi truy cập website hoặc sử dụng dịch vụ đặt lịch của ZenStyle, bạn đồng ý với các điều khoản dưới đây.
            </p>
            <p class="mt-2 text-xs text-zen-muted">Cập nhật lần cuối: {{ now()->format('d/m/Y') }}</p>
        </div>
    </section>

    <section class="px-4 py-10 sm:px-6 sm:py-12">
        <article class="mx-auto max-w-4xl rounded-zen-lg border border-zen-border bg-zen-bg p-6 shadow-zen sm:p-8">
            <div class="space-y-8 text-sm leading-relaxed text-zen-text sm:text-base">
                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">1. Phạm vi áp dụng</h2>
                    <p class="mt-2">
                        Điều khoản này áp dụng cho tất cả người dùng truy cập website ZenStyle và khách hàng sử dụng
                        các dịch vụ do ZenStyle cung cấp tại salon.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">2. Quy định đặt lịch</h2>
                    <ul class="mt-3 list-disc space-y-1.5 pl-5">
                        <li>Lịch hẹn chỉ được xác nhận khi bạn cung cấp đầy đủ thông tin liên hệ hợp lệ.</li>
                        <li>Vui lòng đến đúng giờ; ZenStyle có thể giữ lịch tối đa 15 phút sau giờ hẹn.</li>
                        <li>Nếu cần đổi hoặc hủy lịch, bạn nên thông báo trước để được hỗ trợ sắp xếp lại.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">3. Giá dịch vụ và thanh toán</h2>
                    <p class="mt-2">
                        Bảng giá hiển thị trên website chỉ mang tính tham khảo tại thời điểm đăng tải. Mức giá thực tế
                        có thể thay đổi tùy theo tình trạng tóc/da, gói dịch vụ lựa chọn và tư vấn trực tiếp tại salon.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">4. Khuyến mãi và ưu đãi</h2>
                    <p class="mt-2">
                        Mỗi chương trình khuyến mãi có điều kiện áp dụng riêng về thời gian, chi nhánh và dịch vụ.
                        ZenStyle có quyền điều chỉnh hoặc kết thúc chương trình mà không cần báo trước, trừ các ưu đãi
                        đã được xác nhận cho lịch hẹn hợp lệ.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">5. Trách nhiệm người dùng</h2>
                    <p class="mt-2">Người dùng cam kết:</p>
                    <ul class="mt-3 list-disc space-y-1.5 pl-5">
                        <li>Không cung cấp thông tin sai lệch khi đặt lịch hoặc liên hệ.</li>
                        <li>Không sử dụng website cho mục đích vi phạm pháp luật hoặc gây ảnh hưởng hệ thống.</li>
                        <li>Tôn trọng nhân viên và các quy định vận hành tại salon.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">6. Giới hạn trách nhiệm</h2>
                    <p class="mt-2">
                        ZenStyle luôn nỗ lực duy trì thông tin chính xác trên website. Tuy nhiên, chúng tôi không chịu
                        trách nhiệm với các gián đoạn kỹ thuật, lỗi đường truyền hoặc thiệt hại gián tiếp phát sinh ngoài
                        khả năng kiểm soát hợp lý.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">7. Thay đổi điều khoản</h2>
                    <p class="mt-2">
                        ZenStyle có thể cập nhật nội dung điều khoản để phù hợp với chính sách vận hành từng thời kỳ.
                        Phiên bản cập nhật sẽ được công bố tại trang này và có hiệu lực kể từ thời điểm đăng tải.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-zen-text sm:text-xl">8. Thông tin liên hệ</h2>
                    <p class="mt-2">
                        Mọi thắc mắc liên quan đến điều khoản sử dụng, vui lòng liên hệ:
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
