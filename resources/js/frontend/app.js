import './navbar.js';
import './slider.js';
import { initBookingIfPresent } from './booking.js';
import { initServiceDetailsIfPresent } from './services.js';
import { initFrontendAnimations } from './animations.js';
import { initServiceCarousel } from './service-carousel.js';

initFrontendAnimations();
initBookingIfPresent();
initServiceDetailsIfPresent();
initServiceCarousel();

