<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once STACKEDIT_DIR . '/includes/options/init.php';

/////////////////

$my_settings = array(
	'page_title'  => 'Wp StackEdit',
	'menu_title'  => 'Wp StackEdit',
	'capability'  => 'edit_plugins',
	'menu_slug'   => STACKEDIT_OPTION_NAME,
	'option_slug' => STACKEDIT_OPTION_NAME,
	'parent_page' => 'plugins.php',

	// tab start
	'tabs'        => array(

		'basic'              => array(
			'id'          => 'basic',
			'title'       => 'Basic',
			'sub_heading' => 'Basic sub heading here',
			'fields'      => array(
				'stackedit_url'  => array(
					'id'          => 'stackedit_url',
					'title'       => 'Custom StackEdit URL',
					'type'        => 'text',
					'default'     => 'https://stackedit.io/app',
					'description' => 'You can customize the address',
				),
				'load_stackedit' => array(
					'id'      => 'load_stackedit',
					'title'   => 'Default loading StackEdit',
					'type'    => 'on_off',
					'default' => 'OFF'
				)
			),

		),
		'syntax_highlighter' => array(
			'id'          => 'syntax_highlighter',
			'title'       => 'Syntax Highlighter',
			'sub_heading' => 'Syntax Highlighter sub heading here',
			'fields'      => array(
				'prism_library' => array(
					'id'          => 'prism_library',
					'title'       => 'Prism.js CDN addres',
					'type'        => 'text',
					'default'     => '//cdnjs.cloudflare.com/ajax/libs/prism/9000.0.1/',
					'description' => esc_html__( 'You cdn addres format must be is:"//example.com/prism/verison/"!Don\'t forget to end with a "/"', '' ),
				),
				'prism_style'   => array(
					'id'         => 'prism_style',
					'title'      => esc_html__( 'Prism Theme Style', '' ),
					'type'       => 'select',
					'allow_null' => 'default',
					'default'    => 'default',
					'choices'    => array(
						'default'        => 'default',
						'dark'           => 'dark',
						'funky'          => 'funky',
						'okaidia'        => 'okaidia',
						'twilight'       => 'twilight',
						'coy'            => 'coy',
						'solarizedlight' => 'solarizedlight'
					),
				),
			),
		),

	),
	// tab end
);

$npf_demo_object = new NPF_Options( $my_settings );
