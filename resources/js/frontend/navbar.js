function initNavbarAutoHide() {
    const header = document.getElementById('site-header');
    if (!header) {
        return;
    }

    const banner = document.getElementById('site-banner');

    const showAtTopPx = 24;
    const directionThreshold = 6;

    let lastY = window.scrollY;
    let ticking = false;

    function updateActiveNavByHash() {
        const navLinks = Array.from(header.querySelectorAll('.site-nav-link[data-nav-key]'));
        if (!navLinks.length) {
            return;
        }

        navLinks.forEach((link) => {
            link.classList.remove('is-active', 'text-stone-900', 'after:scale-x-100');
            if (!link.classList.contains('text-stone-600')) {
                link.classList.add('text-stone-600');
            }
        });

        const path = window.location.pathname.replace(/\/+$/, '') || '/';
        const hash = (window.location.hash || '').toLowerCase();

        let activeKey = null;

        if (path === '/' || path === '/home') {
            if (hash === '#dich-vu') {
                activeKey = 'services';
            } else if (hash === '#lien-he') {
                activeKey = 'contact';
            } else {
                activeKey = 'home';
            }
        } else if (path === '/about') {
            activeKey = 'about';
        } else if (path.startsWith('/news')) {
            activeKey = 'news';
        } else if (path === '/lien-he') {
            activeKey = 'contact';
        }

        if (!activeKey) {
            return;
        }

        const activeLink = header.querySelector(`.site-nav-link[data-nav-key="${activeKey}"]`);
        if (!activeLink) {
            return;
        }

        activeLink.classList.add('is-active', 'text-stone-900', 'after:scale-x-100');
        activeLink.classList.remove('text-stone-600');
    }

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
    window.addEventListener('hashchange', updateActiveNavByHash, { passive: true });

    applyState();
    updateHeroNavTheme();
    updateActiveNavByHash();
}

function initScrollTopButton() {
    const btn = document.querySelector('[data-scroll-top]');
    if (!btn) return;

    const showAtPx = 320;
    let ticking = false;

    function syncVisibility() {
        const shouldShow = window.scrollY > showAtPx;
        btn.classList.toggle('is-visible', shouldShow);
        ticking = false;
    }

    window.addEventListener(
        'scroll',
        () => {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(syncVisibility);
        },
        { passive: true },
    );

    btn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    syncVisibility();
}

document.addEventListener('DOMContentLoaded', () => {
    initNavbarAutoHide();
    initScrollTopButton();
});
