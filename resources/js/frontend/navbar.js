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
        const navLinks = Array.from(header.querySelectorAll('.site-nav-link[data-nav-key], .mobile-nav-link[data-nav-key]'));
        if (!navLinks.length) {
            return;
        }

        navLinks.forEach((link) => {
            link.classList.remove('is-active', 'text-zen-accent', 'text-zen-primary', 'after:scale-x-100');
            if (!link.classList.contains('text-zen-muted')) {
                link.classList.add('text-zen-muted');
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
        } else if (path === '/dich-vu') {
            activeKey = 'services';
        } else if (path.startsWith('/news')) {
            activeKey = 'news';
        } else if (path === '/lien-he') {
            activeKey = 'contact';
        } else if (path === '/faq') {
            activeKey = 'faq';
        }

        if (!activeKey) {
            return;
        }

        const activeLinks = header.querySelectorAll(`.site-nav-link[data-nav-key="${activeKey}"], .mobile-nav-link[data-nav-key="${activeKey}"]`);
        activeLinks.forEach((activeLink) => {
            activeLink.classList.add('is-active');
            activeLink.classList.remove('text-zen-muted');
            if (activeLink.classList.contains('site-nav-link')) {
                activeLink.classList.add('text-zen-accent', 'after:scale-x-100');
            } else {
                activeLink.classList.add('text-zen-primary');
            }
        });
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

function initFloatingBookingButton() {
    const btn = document.querySelector('[data-floating-booking]');
    if (!btn) return;

    const banner = document.getElementById('site-banner');
    let ticking = false;

    function syncVisibility() {
        const bannerBottom = banner ? banner.offsetTop + banner.offsetHeight : 420;
        const shouldShow = window.scrollY > bannerBottom - 80;

        btn.classList.toggle('pointer-events-auto', shouldShow);
        btn.classList.toggle('pointer-events-none', !shouldShow);
        btn.classList.toggle('opacity-100', shouldShow);
        btn.classList.toggle('opacity-0', !shouldShow);
        btn.classList.toggle('translate-y-0', shouldShow);
        btn.classList.toggle('translate-y-2', !shouldShow);

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

    window.addEventListener('resize', syncVisibility, { passive: true });

    syncVisibility();
}

function initMobileMenu() {
    const header = document.getElementById('site-header');
    const toggleBtn = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    if (!toggleBtn || !mobileMenu || !header) {
        return;
    }

    toggleBtn.addEventListener('click', () => {
        const isOpen = toggleBtn.getAttribute('aria-expanded') === 'true';

        toggleBtn.setAttribute('aria-expanded', !isOpen);

        if (!isOpen) {
            mobileMenu.classList.remove('pointer-events-none', 'opacity-0', 'scale-y-95');
            mobileMenu.classList.add('pointer-events-auto', 'opacity-100', 'scale-y-100');
            header.classList.add('mobile-menu-open');
        } else {
            mobileMenu.classList.remove('pointer-events-auto', 'opacity-100', 'scale-y-100');
            mobileMenu.classList.add('pointer-events-none', 'opacity-0', 'scale-y-95');
            header.classList.remove('mobile-menu-open');
        }
    });

    const mobileLinks = mobileMenu.querySelectorAll('.mobile-nav-link');
    mobileLinks.forEach((link) => {
        link.addEventListener('click', () => {
            toggleBtn.setAttribute('aria-expanded', 'false');
            mobileMenu.classList.remove('pointer-events-auto', 'opacity-100', 'scale-y-100');
            mobileMenu.classList.add('pointer-events-none', 'opacity-0', 'scale-y-95');
            header.classList.remove('mobile-menu-open');
        });
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 640) {
            toggleBtn.setAttribute('aria-expanded', 'false');
            mobileMenu.classList.remove('pointer-events-auto', 'opacity-100', 'scale-y-100');
            mobileMenu.classList.add('pointer-events-none', 'opacity-0', 'scale-y-95');
            header.classList.remove('mobile-menu-open');
        }
    }, { passive: true });
}

document.addEventListener('DOMContentLoaded', () => {
    initNavbarAutoHide();
    initScrollTopButton();
    initFloatingBookingButton();
    initMobileMenu();
});
