import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                'koperasi': {
                    'bg':      '#FCFCFC',
                    'primary': '#F6F930',
                    'accent':  '#D2F898',
                    'dark':    '#2F2F2F',
                    'black':   '#000000',
                },
            },
            fontFamily: {
                sans: ['Inter', 'Outfit', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                'xs':   ['0.75rem',  { lineHeight: '1rem' }],
                'sm':   ['0.8125rem', { lineHeight: '1.25rem' }],
                'base': ['0.875rem', { lineHeight: '1.375rem' }],
                'lg':   ['1rem',     { lineHeight: '1.5rem' }],
                'xl':   ['1.125rem', { lineHeight: '1.625rem' }],
                '2xl':  ['1.25rem',  { lineHeight: '1.75rem' }],
                '3xl':  ['1.5rem',   { lineHeight: '2rem' }],
                '4xl':  ['1.875rem', { lineHeight: '2.25rem' }],
                '5xl':  ['2.25rem',  { lineHeight: '2.5rem' }],
            },
            borderRadius: {
                'DEFAULT': '0.5rem',
                'lg':      '0.75rem',
                'xl':      '1rem',
                '2xl':     '1.25rem',
                '3xl':     '1.5rem',
            },
            boxShadow: {
                'card':    '0 1px 3px 0 rgba(0,0,0,0.06)',
                'card-hover': '0 4px 12px 0 rgba(0,0,0,0.1)',
                'brutal':  '3px 3px 0px 0px #000000',
                'brutal-sm': '2px 2px 0px 0px #000000',
            },
            spacing: {
                '0.75': '0.1875rem',
                '1.25': '0.3125rem',
                '4.5':  '1.125rem',
                '13':   '3.25rem',
                '15':   '3.75rem',
                '18':   '4.5rem',
            },
            maxWidth: {
                '8xl': '88rem',
            },
            animation: {
                'fade-in':       'fadeIn 0.4s ease-out forwards',
                'fade-in-up':    'fadeInUp 0.5s ease-out forwards',
                'slide-in-left': 'slideInLeft 0.3s ease-out forwards',
                'slide-in-right':'slideInRight 0.3s ease-out forwards',
                'pulse-soft':    'pulseSoft 2s ease-in-out infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                fadeInUp: {
                    '0%': { opacity: '0', transform: 'translateY(12px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideInLeft: {
                    '0%': { opacity: '0', transform: 'translateX(-100%)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
                slideInRight: {
                    '0%': { opacity: '0', transform: 'translateX(100%)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
                pulseSoft: {
                    '0%, 100%': { opacity: '1' },
                    '50%': { opacity: '0.6' },
                },
            },
        },
    },

    plugins: [forms],
};
