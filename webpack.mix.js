let mix = require('laravel-mix');

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

mix
  // .js('resources/assets/js/app.js', 'public/js')
  // .js('resources/assets/js/admin.js', 'public/js')
  .sass('resources/assets/sass/app.scss', 'public/css')
  // .sass('resources/assets/sass/admin.scss', 'public/css')
  .webpackConfig({
    resolve: {
      extensions: ['.vue', '.js', '.sass', '.scss'],
      alias: {
        '@': path.resolve(__dirname, 'resources/assets/js')
      }
    }
  })
// mix.disableNotifications();
// mix.browserSync({
//   proxy: 'http://clean-helt-api.test',
//   ghostMode: false
// });