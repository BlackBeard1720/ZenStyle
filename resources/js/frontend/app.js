import './navbar.js';
import './slider.js';
import { initBookingIfPresent } from './booking.js';
import { initServiceDetailsIfPresent } from './services.js';
import { initFrontendAnimations } from './animations.js';

initFrontendAnimations();
initBookingIfPresent();
initServiceDetailsIfPresent();
