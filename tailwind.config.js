import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    darkMode: 'class',

    theme: {
        extend: {
            colors: {
                bg: 'rgb(var(--color-bg) / <alpha-value>)',
                secondarybg: 'rgb(var(--color-secondarybg) / <alpha-value>)',
                primarytext: 'rgb(var(--color-primarytext) / <alpha-value>)',
                secondarytext: 'rgb(var(--color-secondarytext) / <alpha-value>)',
                hovertext: 'rgb(var(--color-hovertext) / <alpha-value>)',
                focustext: 'rgb(var(--color-focustext) / <alpha-value>)',
                buttonbg: 'rgb(var(--color-buttonbg) / <alpha-value>)',
                border: 'rgb(var(--color-border) / <alpha-value>)',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
