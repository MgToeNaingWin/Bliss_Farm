import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
export default defineConfig({
//     theme: {
//     extend: {
//       fontFamily: {
//         // Tailwind ရဲ့ မူလ sans font နေရာမှာ Helvetica ကို အစားထိုးလိုက်တာပါ
//         sans: ['Helvetica', 'Arial', 'sans-serif'],
//       },
//     },
//   },
    plugins: [
        tailwindcss(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
