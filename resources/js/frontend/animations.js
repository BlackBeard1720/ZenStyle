const REDUCED_MOTION_QUERY = '(prefers-reduced-motion: reduce)';

const REVEAL_SELECTORS = [
    'main section:not(#site-banner):not(#about-hero) h1',
    'main section:not(#site-banner):not(#about-hero) h2',
    'main section:not(#site-banner):not(#about-hero) article',
    'main section:not(#site-banner):not(#about-hero) figure',
    'main section:not(#site-banner):not(#about-hero) blockquote',
    'main section:not(#site-banner):not(#about-hero) [class*="grid"] > [class*="rounded-zen"]',
    'main section:not(#site-banner):not(#about-hero) [class*="grid"] > a',
    'main section:not(#site-banner):not(#about-hero) [class*="grid"] > label',
    'main section:not(#site-banner):not(#about-hero) .booking-cta',
];

function prefersReducedMotion() {
    return window.matchMedia(REDUCED_MOTION_QUERY).matches;
}

function uniqueElements(selectors) {
    return [...new Set(selectors.flatMap((selector) => [...document.querySelectorAll(selector)]))];
}

function shouldSkipElement(element) {
    return (
        element.closest('#site-header, footer, [data-otp-modal], .hidden') ||
        element.matches('input, textarea, select, option, script, style')
    );
}

function setSiblingDelay(element) {
    const parent = element.parentElement;
    if (!parent) return;

    const siblings = [...parent.children].filter((child) => child.classList?.contains('reveal-up'));
    const index = siblings.indexOf(element);
    if (index <= 0) return;

    element.style.setProperty('--reveal-delay', `${Math.min(index, 4) * 90}ms`);
}

function initHeroMotion() {
    const heroes = [...document.querySelectorAll('#site-banner, #about-hero')];
    if (!heroes.length) return;

    heroes.forEach((hero) => {
        const items = [
            hero.querySelector('p'),
            hero.querySelector('h1'),
            hero.querySelector('h1 + p'),
            hero.querySelector('h1 ~ div'),
        ].filter(Boolean);

        items.forEach((item, index) => {
            item.classList.add('hero-reveal');
            item.style.setProperty('--hero-delay', `${index * 110}ms`);
        });
    });
}

function initScrollReveal() {
    const elements = uniqueElements(REVEAL_SELECTORS).filter((element) => !shouldSkipElement(element));
    if (!elements.length) return;

    elements.forEach((element) => {
        element.classList.add('reveal-up');
    });

    elements.forEach(setSiblingDelay);

    if (prefersReducedMotion() || !('IntersectionObserver' in window)) {
        elements.forEach((element) => element.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;

                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        },
        {
            threshold: 0.16,
            rootMargin: '0px 0px -8% 0px',
        },
    );

    elements.forEach((element) => observer.observe(element));
}

export function initFrontendAnimations() {
    initHeroMotion();
    initScrollReveal();
}
