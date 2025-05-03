import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/main.scss',
                'resources/sass/oneui/themes/modern.scss',
                'resources/js/oneui/app.js',
                'resources/js/app.js',
                'resources/js/datatables.js',
                'resources/js/js-validation.js',
                'resources/js/jsRequest.js',
                'resources/js/tfa-notification.js',
                'resources/js/password-toggle.js',
                'resources/js/pages/users/users.datatables.js',
                'resources/js/pages/users/edit.user.js',
                'resources/js/pages/users/accounts-profile.js',
            ],
            refresh: true,
        }),
    ],
});
