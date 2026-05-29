export default {
    theme: {
        extend: {
            colors: {
                zen: {
                    // === Brand palette: minimal black-white luxury with slate-teal accent ===
                    bg:              '#FFFFFF',
                    'bg-soft':       '#F4F7F7',
                    surface:         '#FFFFFF',

                    text:            '#111111',
                    muted:           '#667275',
                    'text-light':    '#FFFFFF',

                    primary:         '#111111',
                    'primary-light': '#2A2A2A',
                    'primary-dark':  '#050505',

                    accent:          '#5F777A',
                    'accent-light':  '#DDE8E8',
                    'accent-soft':   '#EEF5F5',
                    'accent-dark':   '#344E52',

                    border:          '#E1E7E7',
                    'border-dark':   '#A8B6B8',

                    dark:            '#050505',
                    'dark-soft':     '#151515',

                    // === System colors ===
                    success: '#15803D',
                    warning: '#B45309',
                    danger:  '#B91C1C',
                    info:    '#0369A1',
                },
            },
            borderRadius: {
                'zen-sm': '8px',
                'zen-md': '14px',
                'zen-lg': '24px',
            },
            boxShadow: {
                zen:      '0 4px 20px rgba(5, 5, 5, 0.06)',
                'zen-md': '0 12px 36px rgba(5, 5, 5, 0.10)',
            },
            fontFamily: {
                heading: ['Sora', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                body:    ['Manrope', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
        },
    },
};
