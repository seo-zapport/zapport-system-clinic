const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/site.scss', 'public/css') //Stlye of front page
    .sass('resources/sass/backend.scss', 'public/css');

mix.browserSync({
	proxy: 'http://clinic/'
	// proxy: 'http://www.sandbox.clinic.com/'
})