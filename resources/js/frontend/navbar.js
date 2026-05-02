/**
 * THANH MENU — hai việc:
 * -------------------------------------------------------------
 * (A) Ẩn khi cuộn XUỐNG / hiện khi cuộn LÊN (class "-translate-y-full")
 * (B) Trong suốt khi còn "ở trên" vùng banner (class "nav-on-hero")
 *
 * "nav-on-hero": là class TA TỰ ĐẶT — được style trong app.css
 * (nền trong suốt, chữ trắng). Không phải class có sẵn của Tailwind.
 */

function initNavbarAutoHide() {
    const header = document.getElementById('site-header');
    if (!header) {
        return;
    }

    /** Phần banner trong Blade PHẢI có id="site-banner" — để đo chiều cao */
    const banner = document.getElementById('site-banner');

    const showAtTopPx = 24;
    const directionThreshold = 6;

    let lastY = window.scrollY;
    let ticking = false;

     /**
      * Khi scroll chưa vượt quá chiều cao banner → coi như đang "trên banner"
      * → thêm data-on-banner="true" (navbar với màu tối, chữ trắng).
      */
     function updateHeroNavTheme() {
         if (!banner) {
             header.removeAttribute('data-on-banner');
             return;
         }

         const y = window.scrollY;
         const bannerBottomPx = banner.offsetTop + banner.offsetHeight;
         const fadePx = 56;

         const stillOnHero = y < bannerBottomPx - fadePx;

         if (stillOnHero) {
             header.setAttribute('data-on-banner', 'true');
         } else {
             header.removeAttribute('data-on-banner');
         }
     }

    function applyState() {
        const y = window.scrollY;

        if (y < showAtTopPx) {
            header.classList.remove('-translate-y-full');
        } else {
            const delta = y - lastY;

            if (delta > directionThreshold) {
                header.classList.add('-translate-y-full');
            } else if (delta < -directionThreshold) {
                header.classList.remove('-translate-y-full');
            }
        }

        lastY = y;
        ticking = false;

        updateHeroNavTheme();
    }

    window.addEventListener(
        'scroll',
        () => {
            if (!ticking) {
                requestAnimationFrame(applyState);
                ticking = true;
            }
        },
        { passive: true },
    );

    window.addEventListener('resize', updateHeroNavTheme, { passive: true });

    applyState();
    updateHeroNavTheme();
}

document.addEventListener('DOMContentLoaded', initNavbarAutoHide);
