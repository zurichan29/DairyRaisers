// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';
const { defineConfig } = require('vite');
const laravel = require('laravel-vite-plugin');

module.exports = defineConfig(({ mode }) => {
    return {
        plugins: [
            laravel({
                input: {
                    app: 'resources/js/app.js',
                    styles: 'resources/css/app.css',
                },
                output: {
                    publicPath: '/build/',
                    manifestPath: 'public/build/manifest.json',
                },
                resolveAliases: {
                    '~': __dirname,
                },
                hmr: {
                    protocol: 'ws',
                    host: 'localhost',
                    port: 3000,
                },
            }),
        ],
    };
});
