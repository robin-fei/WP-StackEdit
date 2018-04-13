<?php

// 如果直接调用该文件，则中止
if ( ! defined( 'WPINC' ) ) {
	die;
}

class stackedit_options {

	/**
	 * 默认实例
	 *
	 * @since 0.1
	 * @var string $instance .
	 */
	private static $instance;

	function __construct() {

		require_once STACKEDIT_DIR . '/includes/options/init.php';

		$this->settings();
	}

	/**
	 * 获取实例.
	 *
	 * @return string $instance 插件实例
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			$c              = __CLASS__;
			self::$instance = new $c;
		}

		return self::$instance;
	}

	public function settings() {

		$my_settings = array(
			'page_title'  => esc_html__( 'Wp StackEdit', 'stackedit' ),
			'menu_title'  => esc_html__( 'Wp StackEdit', 'stackedit' ),
			'capability'  => 'edit_plugins',
			'menu_slug'   => STACKEDIT_OPTION_NAME,
			'option_slug' => STACKEDIT_OPTION_NAME,
			'parent_page' => 'plugins.php',

			// tab start
			'tabs'        => array(
				'basic'              => array(
					'id'          => 'basic',
					'title'       => esc_html__( 'Basic Options', 'stackedit' ),
					'sub_heading' => 'Basic sub heading here',
					'fields'      => array(
						'stackedit_url'  => array(
							'id'          => 'stackedit_url',
							'title'       => esc_html__( 'Custom StackEdit URL', 'stackedit' ),
							'type'        => 'text',
							'default'     => 'https://stackedit.io/app',
							'description' => esc_html__( 'You can customize the address', 'stackedit' )
						),
						'load_stackedit' => array(
							'id'      => 'load_stackedit',
							'title'   => esc_html__( 'Default loading StackEdit', 'stackedit' ),
							'type'    => 'on_off',
							'default' => 'OFF'
						)
					),

				),
				'syntax_highlighter' => array(
					'id'          => 'syntax_highlighter',
					'title'       => esc_html__( 'Syntax Highlighter', 'stackedit' ),
					'sub_heading' => 'Syntax Highlighter sub heading here',
					'fields'      => array(
						'prism_library' => array(
							'id'          => 'prism_library',
							'title'       => esc_html__( 'Prism.js CDN addres', 'stackedit' ),
							'type'        => 'text',
							'default'     => '//cdnjs.cloudflare.com/ajax/libs/prism/9000.0.1/',
							'description' => esc_html__( 'You cdn addres format must be is:"//example.com/prism/verison/"!Don\'t forget to end with a "/"', 'stackedit' ),
						),
						'prism_style'   => array(
							'id'         => 'prism_style',
							'title'      => esc_html__( 'Prism Theme Style', 'stackedit' ),
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
		new NPF_Options( $my_settings );
	}
}