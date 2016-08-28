var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

	elixir(function(mix) {
	    mix.sass([
	        '../../../node_modules/foundation-sites/dist/foundation.min.css',
	        '../../../node_modules/font-awesome/css/font-awesome.min.css',
	        'style.scss'
	    ]);
	});

	// mix.sass('app.scss');
	// Sass
	// var options = {
	// 	includePaths: [
	// 		'node_modules/foundation-sites/scss',
	// 		'node_modules/motion-ui/src'
	// 	]
	// };

	// mix.sass('app.scss', null, options);

	// Javascript
	var jQuery = '../../../node_modules/jquery/dist/jquery.min.js';
	// var foundationJsFolder = '../../../node_modules/foundation-sites/js/';
	var foundationJsMin = '../../../node_modules/foundation-sites/dist/foundation.min.js';
	var lazyloadJs = '../../../node_modules/jquery-lazyload/jquery.lazyload.js';

	mix.babel([
		jQuery,
		foundationJsMin,
		lazyloadJs,
		// foundationJsFolder+'foundation.core.js',
		// Include any needed components here. The following are just examples.
		// foundationJsFolder + 'foundation.util.mediaquery.js',
		// foundationJsFolder + 'foundation.util.keyboard.js',
		// foundationJsFolder + 'foundation.util.timerAndImageLoader.js',
		// foundationJsFolder + 'foundation.tabs.js',
		// This file initializes foundation
		'script.js',
	]);

	mix.version(['css/app.css', 'js/all.js']);
	mix.browserSync();

});
