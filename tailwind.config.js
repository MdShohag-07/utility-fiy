import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js', // Good to add JS path too
    ],

    theme: {
        extend: {
            fontFamily: {
                // Prioritize Poppins if that's your main font
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
                // Or keep Figtree as fallback:
                // sans: ['Poppins', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};