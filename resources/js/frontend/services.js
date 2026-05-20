const SEL = {
    gallery: '[data-service-gallery]',
    main: '[data-service-gallery-main]',
    thumb: '[data-service-gallery-thumb]',
};

function initServiceGallery(gallery) {
    const mainImage = gallery.querySelector(SEL.main);
    const thumbs = [...gallery.querySelectorAll(SEL.thumb)];
    if (!mainImage || thumbs.length === 0) return;

    function selectThumb(thumb) {
        const src = thumb.dataset.imageSrc;
        if (!src) return;

        if (mainImage.getAttribute('src') !== src) {
            mainImage.classList.add('is-fading');

            const showImage = () => {
                mainImage.classList.remove('is-fading');
            };

            mainImage.addEventListener('load', showImage, { once: true });
            window.setTimeout(showImage, 260);
            mainImage.src = src;
        }

        thumbs.forEach((item) => {
            const selected = item === thumb;
            item.setAttribute('aria-pressed', selected ? 'true' : 'false');
            item.classList.toggle('is-active', selected);
            item.classList.toggle('ring-2', selected);
            item.classList.toggle('ring-zen-primary', selected);
            item.classList.toggle('opacity-75', !selected);
        });
    }

    thumbs.forEach((thumb) => {
        thumb.addEventListener('click', () => selectThumb(thumb));
    });
}

export function initServiceDetailsIfPresent() {
    document.querySelectorAll(SEL.gallery).forEach(initServiceGallery);
}
