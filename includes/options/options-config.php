<?php
function optionsframework_option_name() {
	return 'wp-stackedit-options';
}

/**
 * 配置菜单
 * @param $menu
 * @return mixed
 */
function stackedit_optionsframework_menu( $menu ) {
    // Modes: submenu, menu
    $menu['mode'] = 'submenu';
    // Submenu default settings
    $menu['page_title'] = 'WordPress StackEdit Options';
    $menu['menu_title'] = 'WP StackEdit';
    $menu['capability'] = 'edit_plugins';
    $menu['menu_slug'] = 'wp-stackedit-options';
    $menu['parent_slug'] = 'plugins.php';

    return $menu;
};
add_filter( 'optionsframework_menu', 'stackedit_optionsframework_menu');

/**
 *辅助函数返回主题选项值。
 *如果未保存任何值，则返回 $default。
 *因为选项需要被保存为序列化的字符串。
 *
 *不支持向下兼容主题。
 */
if ( ! function_exists( 'j_opt' ) ) :
    function j_opt( $name, $default = false ) {

        $option_name = '';

        // Gets option name as defined in the theme
        if ( function_exists( 'optionsframework_option_name' ) ) {
            $option_name = optionsframework_option_name();
        }

        // Fallback option name
        if ( '' == $option_name ) {
            $option_name = get_option( 'stylesheet' );
            $option_name = preg_replace( "/\W/", "_", strtolower( $option_name ) );
        }

        // Get option settings from database
        $options = get_option( $option_name );

        // Return specific option
        if ( isset( $options[$name] ) ) {
            return $options[$name];
        }

        return $default;
    }
endif;

function optionsframework_options() {

	$options = array();

	$options[] = array(
		'name' => __( 'Basic Settings', 'wp-stackedit' ),
		'type' => 'heading'
	);

	$options[] = array(
		'name' => __( 'Custom StackEdit URL', 'wp-stackedit' ),
		'desc' => __( 'The uses <b>https://stackedit.io/app</b> as the default StackEdit URL', 'wp-stackedit' ),
		'id' => 'stackedit_url',
		'std' => 'https://stackedit.io/app',
		'class' => '',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __( 'Default Loading StackEdit', 'wp-stackedit' ),
		'desc' => __( 'Open the post/page directly to load the StackEdit', 'wp-stackedit' ),
		'id' => 'load_stackedit',
		'std' => '0',
		'type' => 'checkbox'
	);

	return $options;
}