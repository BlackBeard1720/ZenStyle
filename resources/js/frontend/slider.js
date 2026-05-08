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
        console.warn('⚠️ #site-banner not found');
        return;
    }
    section.style.touchAction = 'pan-y';

    const slides = Array.from(section.querySelectorAll('[data-slide]'));
    const dots = Array.from(section.querySelectorAll('[data-slide-dot]'));
    const slideImages = slides
        .map((slide) => slide.querySelector('img'))
        .filter(Boolean);

    console.log('🎯 Slider init:', { slideCount: slides.length, dotCount: dots.length });

    // Nếu không đủ dữ liệu thì dừng để tránh lỗi JS.
    if (!slides.length) {
        console.warn('⚠️ No slides found');
        return;
    }

    slideImages.forEach((image) => {
        image.setAttribute('draggable', 'false');
        image.style.pointerEvents = 'none';
        image.style.userSelect = 'none';
        image.style.webkitUserDrag = 'none';
    });

    let currentIndex = 0;
    const total = slides.length;
    let autoSlideTimer = null;
    const AUTO_SLIDE_INTERVAL = 4000; // 4 giây
    const DRAG_THRESHOLD = 50;
    let dragStartX = 0;
    let dragCurrentX = 0;
    let dragging = false;
    let activePointerId = null;
    let dragStartedOnInteractiveElement = false;

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

    function startDrag(clientX) {
        dragStartX = clientX;
        dragCurrentX = clientX;
        dragging = true;
    }

    function moveDrag(clientX) {
        if (!dragging) {
            return;
        }
        dragCurrentX = clientX;
    }

    function endDrag() {
        if (!dragging) {
            return;
        }
        const deltaX = dragCurrentX - dragStartX;
        dragging = false;

        if (Math.abs(deltaX) < DRAG_THRESHOLD) {
            return;
        }

        if (deltaX < 0) {
            goTo(currentIndex + 1);
            return;
        }

        goTo(currentIndex - 1);
    }

    function handlePointerDown(event) {
        if (event.button !== undefined && event.button !== 0) {
            return;
        }
        const target = event.target instanceof Element ? event.target : null;
        dragStartedOnInteractiveElement = Boolean(
            target && target.closest('[data-slide-dot], button, a, input, textarea, select, [role="button"]'),
        );
        if (dragStartedOnInteractiveElement) {
            return;
        }
        activePointerId = event.pointerId;
        section.setPointerCapture(activePointerId);
        startDrag(event.clientX);
    }

    function handlePointerMove(event) {
        if (dragStartedOnInteractiveElement) {
            return;
        }
        if (activePointerId !== null && event.pointerId !== activePointerId) {
            return;
        }
        moveDrag(event.clientX);
    }

    function handlePointerEnd(event) {
        if (dragStartedOnInteractiveElement) {
            dragStartedOnInteractiveElement = false;
            return;
        }
        if (activePointerId !== null && event.pointerId !== activePointerId) {
            return;
        }
        if (activePointerId !== null && section.hasPointerCapture(activePointerId)) {
            section.releasePointerCapture(activePointerId);
        }
        activePointerId = null;
        endDrag();
    }

    dots.forEach((dot) => {
        dot.addEventListener('click', () => {
            console.log('🖱️ Dot clicked:', dot.getAttribute('data-slide-index'));
            const index = Number(dot.getAttribute('data-slide-index'));
            if (!Number.isNaN(index)) {
                console.log('➡️ Navigating to slide:', index);
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

    section.addEventListener('pointerdown', handlePointerDown);
    section.addEventListener('pointermove', handlePointerMove);
    section.addEventListener('pointerup', handlePointerEnd);
    section.addEventListener('pointercancel', handlePointerEnd);
    section.addEventListener('pointerleave', handlePointerEnd);

    // Chặn kéo ảnh mặc định của trình duyệt để ưu tiên swipe.
    section.addEventListener('dragstart', (event) => {
        event.preventDefault();
    });

    render(currentIndex);
    resetAutoSlide();
}

document.addEventListener('DOMContentLoaded', initHeroSlider);
