export default {
    theme: {
        extend: {
            colors: {
                zen: {
                    // === Màu nhấn vàng champagne / brown-gold (CHỈ dùng làm accent nhỏ) ===
                    primary:         '#B88945',
                    'primary-light': '#E7CF9D',
                    'primary-dark':  '#7A5526',

                    accent:          '#A66A3F',
                    'accent-dark':   '#6B3F22',
                    'accent-soft':   '#F1E1CB',

                    // === Nền trắng sạch (black-white luxury) ===
                    bg:              '#FFFFFF',
                    'bg-soft':       '#F7F4EF',

                    // === Bề mặt card / modal ===
                    surface:         '#FFFFFF',

                    // === Chữ gần đen ===
                    text:            '#111111',
                    muted:           '#6F6A63',
                    'text-light':    '#FFFFFF',

                    // === Viền tinh tế ===
                    border:          '#E7E2DA',
                    'border-dark':   '#B8AEA1',

                    // === Nền tối luxury (footer, dark sections) ===
                    dark:            '#050505',
                    'dark-soft':     '#171717',

                    // === Màu hệ thống (không đổi) ===
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
                // Bóng nhẹ, tinh tế — không dùng màu nóng
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
