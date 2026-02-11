import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/**
 * NOTA IMPORTANTE: Este projeto usa tanto Tailwind CSS quanto Bootstrap 5 (via CDN).
 * 
 * CONFLITO IDENTIFICADO:
 * Classes de utilidades idênticas podem gerar conflitos (mx-2, py-4, etc).
 * 
 * RECOMENDAÇÕES FUTURAS:
 * 1. Prefixar classes do Tailwind (ex: tw-) adicionando: prefix: 'tw-'
 * 2. Desativar preflight do Tailwind: corePlugins: { preflight: false }
 * 3. Considerar padronizar em apenas um framework (Bootstrap)
 * 
 * Referência: https://dev.to/...
 */

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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
