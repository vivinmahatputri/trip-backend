let mix = require('laravel-mix');
const elixir = require('laravel-elixir');

require('laravel-elixir-env');
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

mix.js('resources/assets/js/app.js', 'public/js')
   .js('resources/assets/js/web.index.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

//layout coming soon
mix.copyDirectory('templates/admin/css', 'public/css/admin')
    .copyDirectory('templates/admin/js', 'public/js/admin')
    .copyDirectory('templates/admin/img', 'public/img')
    .copyDirectory('resources/assets/images', 'public/images/main')
    .copyDirectory('templates/admin/font', 'public/font')
    .copyDirectory('templates/svg', 'public/svg');

mix.copyDirectory('templates/goexplore/assets/css', 'public/css/main')
    .copyDirectory('templates/goexplore/assets/fonts', 'public/fonts')
    .copyDirectory('templates/goexplore/assets/js', 'public/js/main')
    .copyDirectory('templates/goexplore/assets/images', 'public/images/main');

mix.copy('templates/favicon.ico', 'public/favicon.ico');