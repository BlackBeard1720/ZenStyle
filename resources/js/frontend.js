import './frontend/navbar.js';
import './frontend/slider.js';
import { initBookingIfPresent } from './frontend/booking.js';
import { initServiceDetailsIfPresent } from './frontend/services.js';
import { initFrontendAnimations } from './frontend/animations.js';

initFrontendAnimations();
initBookingIfPresent();
initServiceDetailsIfPresent();
