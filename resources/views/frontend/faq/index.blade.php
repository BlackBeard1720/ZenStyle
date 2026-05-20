@php
    $faqs = [
        [
            'question' => 'Tôi có cần đặt lịch trước không?',
            'answer' => 'Bạn nên đặt lịch trước để ZenStyle giữ khung giờ phù hợp và chuẩn bị stylist theo dịch vụ đã chọn. Salon vẫn hỗ trợ khách đến trực tiếp nếu còn chỗ trống.',
        ],
        [
            'question' => 'Sau khi đặt lịch online, tôi nhận xác nhận bằng cách nào?',
            'answer' => 'Sau khi gửi thông tin đặt lịch, hệ thống hiển thị bước xác nhận OTP. Team ZenStyle có thể liên hệ lại qua số điện thoại bạn cung cấp để chốt lịch khi cần.',
        ],
        [
            'question' => 'Tôi có thể chọn nhiều dịch vụ trong một lịch hẹn không?',
            'answer' => 'Có. Ở trang đặt lịch, bạn có thể chọn nhiều dịch vụ trong cùng một buổi hẹn. Tổng tạm tính sẽ cập nhật theo các dịch vụ được chọn.',
        ],
        [
            'question' => 'Tôi có thể đổi giờ hoặc hủy lịch không?',
            'answer' => 'Bạn vui lòng liên hệ hotline hoặc nhắn tin cho ZenStyle càng sớm càng tốt. Salon sẽ hỗ trợ đổi sang khung giờ còn trống phù hợp.',
        ],
        [
            'question' => 'Giá trên website có phải giá cuối cùng không?',
            'answer' => 'Giá trên website là mức tham khảo cho dịch vụ tiêu chuẩn. Một số dịch vụ màu, uốn hoặc phục hồi có thể thay đổi theo tình trạng tóc và tư vấn trực tiếp tại salon.',
        ],
        [
            'question' => 'Tôi cần chuẩn bị gì trước khi đến salon?',
            'answer' => 'Bạn chỉ cần đến đúng giờ hẹn và mang theo ảnh tham khảo nếu muốn tư vấn kiểu tóc, màu nhuộm hoặc phong cách cụ thể.',
        ],
    ];
@endphp

<x-frontend.layout title="ZenStyle - FAQ" main-class="bg-zen-bg-soft pt-20">
    <section class="border-b border-zen-border bg-white px-4 py-12 sm:px-6 sm:py-14">
        <div class="mx-auto max-w-4xl">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zen-primary">FAQ</p>
            <h1 class="mt-3 font-['Playfair_Display',serif] text-3xl font-semibold text-zen-text sm:text-4xl">
                Câu hỏi thường gặp
            </h1>
            <p class="mt-4 text-sm leading-relaxed text-zen-muted sm:text-base">
                Những thông tin nhanh về đặt lịch, dịch vụ và trải nghiệm tại ZenStyle.
            </p>
        </div>
    </section>

    <section class="px-4 py-10 sm:px-6 sm:py-12">
        <div class="mx-auto max-w-4xl space-y-3">
            @foreach ($faqs as $faq)
                <details class="group rounded-zen-md border border-zen-border bg-zen-bg p-5 shadow-zen">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-sm font-semibold text-zen-text sm:text-base">
                        <span>{{ $faq['question'] }}</span>
                        <span class="shrink-0 text-lg leading-none text-zen-primary transition group-open:rotate-45">+</span>
                    </summary>
                    <p class="mt-3 text-sm leading-relaxed text-zen-muted sm:text-base">
                        {{ $faq['answer'] }}
                    </p>
                </details>
            @endforeach
        </div>
    </section>
</x-frontend.layout>
