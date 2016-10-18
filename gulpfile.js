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

elixir(function(mix){
	mix.copy('node_modules/sweetalert/dist/sweetalert.css', 'resources/assets/sass/sweetalert.scss')

		.sass('app.scss')
		.sass('iblock_form.scss')

		.coffee('app.coffee')
		.coffee('a.you-can-change.coffee')
		.coffee('bitrix_module_admin_options.coffee')
		.coffee('bitrix_module_components_params.coffee')
		.coffee('translit.coffee')
		.coffee('bitrix_mail_event_create_form.coffee')
		.coffee('bitrix_mail_template_form.coffee')
		.coffee('bitrix_component_logic_wizard.coffee')
		.coffee('bitrix_iblock.coffee')
		.copy('node_modules/sweetalert/dist/sweetalert-dev.js', 'public/js/sweetalert.js')
});
