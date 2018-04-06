<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * @return string
 */
function optionsframework_option_name() {
	// Change this to use your theme slug
	return 'wp-jade-md-options';
}

/**
 * 配置菜单
 * @param $menu
 * @return mixed
 */
function jade_optionsframework_menu( $menu ) {
    // Modes: submenu, menu
    $menu['mode'] = 'submenu';
    // Submenu default settings
    $menu['page_title'] = 'WordPress Jade Markdown Options';
    $menu['menu_title'] = 'WP Jade.md';
    $menu['capability'] = 'edit_plugins';
    $menu['menu_slug'] = 'wp-jade.md-options';
    $menu['parent_slug'] = 'plugins.php';

    return $menu;
};
add_filter( 'optionsframework_menu', 'jade_optionsframework_menu');

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

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options-framework'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// Test data
	$test_array = array(
		'one' => __( 'One', 'options-framework' ),
		'two' => __( 'Two', 'options-framework' ),
		'three' => __( 'Three', 'options-framework' ),
		'four' => __( 'Four', 'options-framework' ),
		'five' => __( 'Five', 'options-framework' )
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __( 'French Toast', 'options-framework' ),
		'two' => __( 'Pancake', 'options-framework' ),
		'three' => __( 'Omelette', 'options-framework' ),
		'four' => __( 'Crepe', 'options-framework' ),
		'five' => __( 'Waffle', 'options-framework' )
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );

	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	$options = array();

	$options[] = array(
		'name' => __( 'Basic Settings', 'options-framework' ),
		'type' => 'heading'
	);

	$options[] = array(
		'name' => __( 'Input Text Mini', 'options-framework' ),
		'desc' => __( 'A mini text input field.', 'options-framework' ),
		'id' => 'example_text_mini',
		'std' => 'Default',
		'class' => 'mini',
		'type' => 'text'
	);

	return $options;
}