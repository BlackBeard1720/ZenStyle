/**
 * HERO SLIDER (Trang chủ frontend)
 * --------------------------------------------------------------------
 * Mục tiêu:
 * - Điều khiển slider với Dot navigation.
 * - Autoplay sau 4 giây khi không có tương tác người dùng.
 *
 * Cách hoạt động tổng quan:
 * 1) Lấy danh sách ảnh slide: [data-slide]
 * 2) Lấy các dot để nhảy nhanh tới slide cụ thể: [data-slide-dot]
 * 3) Khi chuyển index -> cập nhật class/aria cho toàn bộ phần tử.
 * 4) Tự động chuyển slide sau 4 giây.
 */
function initHeroSlider() {
    const section = document.getElementById('site-banner');
    if (!section) {
        return;
    }

    const slides = Array.from(section.querySelectorAll('[data-slide]'));
    const dots = Array.from(section.querySelectorAll('[data-slide-dot]'));

    // Nếu không đủ dữ liệu thì dừng để tránh lỗi JS.
    if (!slides.length) {
        return;
    }

    let currentIndex = 0;
    const total = slides.length;
    let autoSlideTimer = null;
    const AUTO_SLIDE_INTERVAL = 4000; // 4 giây

    /**
     * Bật/tắt trạng thái hiển thị cho từng slide theo index hiện tại.
     */
    function render(index) {
        slides.forEach((slide, i) => {
            const active = i === index;
            slide.classList.toggle('opacity-100', active);
            slide.classList.toggle('opacity-0', !active);
            slide.classList.toggle('pointer-events-none', !active);
            slide.setAttribute('aria-hidden', active ? 'false' : 'true');
        });

        dots.forEach((dot, i) => {
            const active = i === index;
            dot.classList.toggle('w-8', active);
            dot.classList.toggle('w-3', !active);
            dot.classList.toggle('bg-white', active);
            dot.classList.toggle('bg-white/50', !active);
            dot.setAttribute('aria-current', active ? 'true' : 'false');
        });
    }

    // Chuẩn hóa index khi vượt biên (vd: -1 -> slide cuối, total -> slide đầu).
    function normalizeIndex(index) {
        return (index + total) % total;
    }

    /**
     * Hủy timer autoplay cũ và khởi tạo timer mới.
     * Gọi lại khi người dùng bấm dot.
     */
    function resetAutoSlide() {
        if (autoSlideTimer) {
            clearInterval(autoSlideTimer);
        }
        autoSlideTimer = setInterval(() => {
            goTo(currentIndex + 1);
        }, AUTO_SLIDE_INTERVAL);
    }

    function goTo(index) {
        currentIndex = normalizeIndex(index);
        render(currentIndex);
        resetAutoSlide();
    }

    dots.forEach((dot) => {
        dot.addEventListener('click', () => {
            const index = Number(dot.getAttribute('data-slide-index'));
            if (!Number.isNaN(index)) {
                goTo(index);
            }
        });
    });

    // Hỗ trợ phím mũi tên trái/phải
    section.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft') {
            goTo(currentIndex - 1);
        }
        if (event.key === 'ArrowRight') {
            goTo(currentIndex + 1);
        }
    });

    render(currentIndex);
    resetAutoSlide();
}

document.addEventListener('DOMContentLoaded', initHeroSlider);
