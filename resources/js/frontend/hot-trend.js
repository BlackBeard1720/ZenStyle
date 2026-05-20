export function initHotTrendIfPresent() {
    const page = document.querySelector('[data-hot-trend-page]');
    if (!page) return;

    const buttons = Array.from(document.querySelectorAll('[data-hot-trend-filter]'));
    const cards = Array.from(document.querySelectorAll('[data-hot-trend-card]'));
    const emptyState = document.querySelector('[data-hot-trend-empty]');
    const trendDataEl = document.querySelector('[data-hot-trend-data]');
    const modal = document.querySelector('[data-hot-trend-modal]');
    const modalMain = document.querySelector('[data-hot-trend-modal-main]');
    const modalThumbs = document.querySelector('[data-hot-trend-modal-thumbs]');
    const modalTags = document.querySelector('[data-hot-trend-modal-tags]');
    const modalTitle = document.querySelector('[data-hot-trend-modal-title]');
    const modalDescription = document.querySelector('[data-hot-trend-modal-description]');
    const modalSuitable = document.querySelector('[data-hot-trend-modal-suitable]');
    const modalTips = document.querySelector('[data-hot-trend-modal-tips]');
    const modalBooking = document.querySelector('[data-hot-trend-modal-booking]');
    const closeButtons = Array.from(document.querySelectorAll('[data-hot-trend-close]'));
    const trends = trendDataEl ? JSON.parse(trendDataEl.textContent || '[]') : [];

    function setMainImage(trend, imageUrl, activeThumb) {
        if (!modalMain) return;

        modalMain.src = imageUrl;
        modalMain.alt = trend.alt || trend.title || '';

        if (!modalThumbs) return;

        Array.from(modalThumbs.querySelectorAll('button')).forEach((button) => {
            const isActive = button === activeThumb;
            button.classList.toggle('ring-2', isActive);
            button.classList.toggle('ring-zen-primary', isActive);
            button.classList.toggle('opacity-100', isActive);
            button.classList.toggle('opacity-70', !isActive);
        });
    }

    function renderModal(trend) {
        if (!modal || !trend) return;

        if (modalTags) {
            modalTags.replaceChildren();
            trend.tags.forEach((tag) => {
                const span = document.createElement('span');
                span.className = 'rounded-full bg-zen-accent-soft px-2.5 py-1 text-[11px] font-semibold text-zen-primary';
                span.textContent = tag;
                modalTags.appendChild(span);
            });
        }

        if (modalTitle) modalTitle.textContent = trend.title;
        if (modalDescription) modalDescription.textContent = trend.longDescription;
        if (modalSuitable) modalSuitable.textContent = trend.suitableFor;

        if (modalTips) {
            modalTips.replaceChildren();
            trend.stylingTips.forEach((tip) => {
                const item = document.createElement('li');
                item.className = 'flex gap-2';
                item.innerHTML = '<span class="mt-2 size-1.5 shrink-0 rounded-full bg-zen-primary"></span><span></span>';
                item.querySelector('span:last-child').textContent = tip;
                modalTips.appendChild(item);
            });
        }

        if (modalThumbs) {
            modalThumbs.replaceChildren();
            trend.images.forEach((imageUrl, index) => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'overflow-hidden rounded-zen-sm border border-zen-border bg-white opacity-70 transition hover:opacity-100';

                const img = document.createElement('img');
                img.src = imageUrl;
                img.alt = `${trend.title} ${index + 1}`;
                img.className = 'aspect-square h-full w-full object-cover';
                img.loading = 'lazy';

                button.appendChild(img);
                button.addEventListener('click', () => setMainImage(trend, imageUrl, button));
                modalThumbs.appendChild(button);

                if (index === 0) {
                    setMainImage(trend, imageUrl, button);
                }
            });
        }

        if (modalBooking) {
            const bookingUrl = new URL(modalBooking.href);
            bookingUrl.searchParams.set('trend', trend.slug);
            modalBooking.href = bookingUrl.toString();
        }
    }

    function openModal(slug) {
        const trend = trends.find((item) => item.slug === slug);
        if (!modal || !trend) return;

        renderModal(trend);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        if (!modal) return;

        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
    }

    function setActiveButton(activeButton) {
        buttons.forEach((button) => {
            const isActive = button === activeButton;
            button.setAttribute('aria-pressed', String(isActive));
            button.classList.toggle('border-zen-primary', isActive);
            button.classList.toggle('bg-zen-primary', isActive);
            button.classList.toggle('text-white', isActive);
            button.classList.toggle('shadow-sm', isActive);
            button.classList.toggle('border-zen-border', !isActive);
            button.classList.toggle('bg-white', !isActive);
            button.classList.toggle('text-zen-muted', !isActive);
            button.classList.toggle('hover:border-zen-primary', !isActive);
            button.classList.toggle('hover:bg-zen-accent-soft', !isActive);
            button.classList.toggle('hover:text-zen-primary', !isActive);
        });
    }

    function applyFilter(category, activeButton) {
        let visibleCount = 0;

        cards.forEach((card) => {
            const categories = (card.dataset.categories || '').split(' ');
            const shouldShow = category === 'all' || categories.includes(category);
            card.classList.toggle('hidden', !shouldShow);
            if (shouldShow) visibleCount += 1;
        });

        if (emptyState) {
            emptyState.classList.toggle('hidden', visibleCount > 0);
        }

        setActiveButton(activeButton);
    }

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            applyFilter(button.dataset.hotTrendFilter || 'all', button);
        });
    });

    document.querySelectorAll('[data-hot-trend-open]').forEach((button) => {
        button.addEventListener('click', () => {
            openModal(button.dataset.hotTrendOpen);
        });
    });

    closeButtons.forEach((button) => {
        button.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
}
