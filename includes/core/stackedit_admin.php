<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://joe.szalai.org
 * @since      1.0.0
 *
 * @package    Exopite_Combiner_Minifier
 * @subpackage Exopite_Combiner_Minifier/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Exopite_Combiner_Minifier
 * @subpackage Exopite_Combiner_Minifier/admin
 * @author     Joe Szalai <joe@szalai.org>
 */
class stackedit_admin {

	public function create_menu() {

		/*
		 * Create a submenu page under Plugins.
		 * Framework also add "Settings" to your plugin in plugins list.
		 */
		$config_submenu = array(

			'type'            => 'menu',                          // Required, menu or metabox
			'id'              => 'wp-stackedit',                  // Required, meta box id, unique per page, to save: get_option( id )
			'menu'            => 'plugins.php',                   // Required, sub page to your options page
			'submenu'         => true,                            // Required for submenu
			'title'           => 'Wp StackEdit',                  // The name of this page
			'capability'      => 'manage_options',                // The capability needed to view the page
			'plugin_basename' => STACKEDIT_NAME,
			//'tabbed'            => false,

		);

		//普通设置
		$fields[] = array(
			'name'   => 'wp-stackedit',
			'title'  => 'Basic',
			'icon'   => 'dashicons-admin-home',
			'fields' => array(

				array(
					'id'          => 'stackedit_url',
					'type'        => 'text',
					'title'       => 'Custom StackEdit URL',
					'description' => esc_html__('You can customize the address',''),
					'default'     => 'https://stackedit.io/app',
					'attributes'  => array(
						'rows'        => 10,
						'cols'        => 5,
						'placeholder' => 'https://stackedit.io/app',
					)
				),

				array(
					'id'      => 'load_stackedit',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Default loading StackEdit', '' ),
					'default' => 'no',
				),

			)
		);
		//语法高亮设置
		$fields[] = array(
			'name'   => 'syntax_highlighter',
			'title'  => 'Syntax Highlighter',
			'icon'   => 'dashicons-admin-appearance',
			'fields' => array(

				array(
					'id'          => 'prism_library',
					'type'        => 'text',
					'title'       => esc_html__('Prism.js CDN addres',''),
					'before'      => esc_html__('You cdn addres format must be is:"//example.com/prism/verison/"!Don\'t forget to end with a "/"',''),
					'description' => esc_html__('You can customize the address',''),
					'default'     => '//cdnjs.cloudflare.com/ajax/libs/prism/9000.0.1/',
					'attributes'  => array(
						'rows'        => 10,
						'cols'        => 5,
						'placeholder' => '//cdnjs.cloudflare.com/ajax/libs/prism/9000.0.1/',
					)
				),

				array(
					'id'             => 'prism_style',
					'type'           => 'select',
					'title'          => esc_html__('Prism Theme Style',''),
					'options'        => array(
						'default'        => 'default',
						'dark'           => 'dark',
						'funky'          => 'funky',
						'okaidia'        => 'okaidia',
						'twilight'       => 'twilight',
						'coy'            => 'coy',
						'solarizedlight' => 'solarizedlight'
					),
					'default_option' => esc_html__('Select your favorite style',''),
					'default'     => 'default',
					'class'       => 'chosen',
				),

			)
		);

//		$fields[] = array(
//			'name'   => 'third',
//			'title'  => 'Third',
//			'icon'   => 'dashicons-portfolio',
//			'fields' => array(
//
//				array(
//					'type'    => 'content',
//					'content' => 'nothing',
//
//				),
//
//			),
//		);

		$options_panel = new Exopite_Simple_Options_Framework( $config_submenu, $fields );

	}


}
