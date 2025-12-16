import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Swiss Style Color Palette
                'swiss': {
                    red: '#FF4040',
                    blue: '#0055AA',
                    black: '#1A1A1A',
                    gray: {
                        50: '#F8F9FA',
                        100: '#F1F3F5',
                        200: '#E9ECEF',
                        300: '#DEE2E6',
                        400: '#CED4DA',
                        500: '#ADB5BD',
                        600: '#6C757D',
                        700: '#495057',
                        800: '#343A40',
                        900: '#212529',
                    }
                }
            },
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
                '128': '32rem',
            },
            gridTemplateColumns: {
                '16': 'repeat(16, minmax(0, 1fr))',
            },
        },
    },

    plugins: [forms, typography],
};
