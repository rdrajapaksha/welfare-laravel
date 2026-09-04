import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                brand: {
                    50: '#fef2f2',
                    100: '#fee2e2',
                    200: '#fecaca',
                    300: '#f7a3a3',
                    400: '#f06b6b',
                    500: '#e83f40',
                    600: '#ec2a2b',
                    700: '#c91f20',
                    800: '#a71c1d',
                    900: '#8a1c1d',
                    950: '#4c0b0c',
                },
                ink: {
                    50: '#f7f7f7',
                    100: '#eeeeee',
                    200: '#dcdcdc',
                    300: '#bdbdbd',
                    400: '#8f8f8f',
                    500: '#6b6b6b',
                    600: '#525252',
                    700: '#3d3d3d',
                    800: '#262626',
                    900: '#141414',
                    950: '#0a0a0a',
                },
                gold: {
                    50: '#faf8f2',
                    100: '#f1ead6',
                    200: '#e2d2a6',
                    300: '#cdb06c',
                    400: '#b89445',
                    500: '#9f7a32',
                    600: '#846129',
                    700: '#6a4d25',
                    800: '#574024',
                    900: '#493622',
                },
                teal: {
                    50: '#f1f7f6',
                    100: '#dceceb',
                    200: '#b8d8d5',
                    300: '#88bbb7',
                    400: '#5a9a96',
                    500: '#407e7a',
                    600: '#326562',
                    700: '#2b5250',
                    800: '#254342',
                    900: '#213937',
                },
                canvas: '#f7f7f8',
                'canvas-alt': '#efefef',
            },
            fontFamily: {
                sans: ['Inter', 'Noto Sans Sinhala', 'Noto Sans Tamil', ...defaultTheme.fontFamily.sans],
                display: ['Plus Jakarta Sans', 'Inter', ...defaultTheme.fontFamily.sans],
                times: ['Times New Roman', 'Times', 'Liberation Serif', 'Georgia', 'serif'],
            },
            boxShadow: {
                soft: '0 1px 2px rgb(10 10 10 / 0.05), 0 8px 24px -12px rgb(10 10 10 / 0.14)',
                lift: '0 2px 4px rgb(10 10 10 / 0.06), 0 18px 40px -18px rgb(10 10 10 / 0.22)',
                glow: '0 20px 56px -24px rgb(236 42 43 / 0.45)',
            },
            keyframes: {
                'hla-logo-rotate': {
                    from: { transform: 'rotate(0deg)' },
                    to: { transform: 'rotate(360deg)' },
                },
                'soft-rise': {
                    from: { opacity: '0', transform: 'translate3d(0, 12px, 0)' },
                    to: { opacity: '1', transform: 'none' },
                },
                'mesh-drift': {
                    '0%, 100%': { opacity: '1', transform: 'scale(1)' },
                    '50%': { opacity: '0.88', transform: 'scale(1.04)' },
                },
                'float-soft': {
                    '0%, 100%': { transform: 'translate3d(0, 0, 0)' },
                    '50%': { transform: 'translate3d(0, -8px, 0)' },
                },
            },
            animation: {
                'logo-spin': 'hla-logo-rotate 8s linear infinite',
                'soft-rise': 'soft-rise 0.65s cubic-bezier(0.22, 1, 0.36, 1) both',
                'mesh-drift': 'mesh-drift 18s ease-in-out infinite',
                'float-soft': 'float-soft 7s ease-in-out infinite',
            },
        },
    },

    plugins: [forms],
};
