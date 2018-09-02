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

mix.version().sourceMaps().webpackConfig({
    resolve: {
		extensions: ['.vue', '.js', '.sass','.scss'],
    	alias: {
    		'@' : path.resolve(__dirname, 'resources/assets/js')
    	}
    }
})
	.js('resources/assets/js/app.js', 'public/js')
	.js('resources/assets/js/admin.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   // .sass('resources/assets/sass/admin.scss', 'public/css');;
// mix.disableNotifications();
mix.browserSync('http://localhost:88');
