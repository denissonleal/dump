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
	mix.sass('app.scss');
	// mix.scripts(["controller.js"]);
	// mix.scripts(["./node_modules/jquery/"]);
	// mix.scripts(["./node_modules/selectize/src/selectize.js"]);
	mix.copy('node_modules/jquery/dist/jquery.min.js', 'public/lib/js/jquery.min.js');
	mix.copy('node_modules/selectize/dist/js/standalone/selectize.min.js', 'public/lib/js');
	mix.copy('node_modules/axios/dist/axios.min.js', 'public/lib/js');
	mix.copy('node_modules/selectize/dist/css/selectize.default.css', 'public/lib/css');
	mix.copy('resources/assets/js/controller.js', 'public/js/controller.js');
});


