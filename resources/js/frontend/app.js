import './navbar.js';
import './slider.js';
import { initBookingIfPresent } from './booking.js';
import { initServiceDetailsIfPresent } from './services.js';
import { initFrontendAnimations } from './animations.js';
import { initHotTrendIfPresent } from './hot-trend.js';

initFrontendAnimations();
initBookingIfPresent();
initServiceDetailsIfPresent();
initHotTrendIfPresent();
