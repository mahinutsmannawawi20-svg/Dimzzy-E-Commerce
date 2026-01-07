import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/dimzzsnake.js',
        'resources/js/pingpong.js',        // <- sesuaikan kalau filenya di subfolder
        // 'resources/js/games/pingpong.js',
      ],
      refresh: true,
    }),
    tailwindcss(),
  ],
});
