<?php
/**
 * Options Framework
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

define('OPTIONS_FRAMEWORK_DIR', dirname(__FILE__));
define('OPTIONS_FRAMEWORK_URL', plugin_dir_url( __FILE__ ));

// Don't load if optionsframework_init is already defined
if (is_admin() && ! function_exists( 'optionsframework_init' ) ) :

    function optionsframework_init() {

        //  If user can't edit theme options, exit
        if ( ! current_user_can( 'edit_theme_options' ) ) {
            return;
        }

        // Load translation files
        load_plugin_textdomain( 'wp-stackedit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

        // Loads the required Options Framework classes.
        require OPTIONS_FRAMEWORK_DIR . '/includes/class-options-framework.php';
        require OPTIONS_FRAMEWORK_DIR . '/includes/class-options-framework-admin.php';
        require OPTIONS_FRAMEWORK_DIR . '/includes/class-options-interface.php';
        require OPTIONS_FRAMEWORK_DIR . '/includes/class-options-media-uploader.php';
        require OPTIONS_FRAMEWORK_DIR . '/includes/class-options-sanitization.php';

        // Instantiate the options page.
        $options_framework_admin = new Options_Framework_Admin;
        $options_framework_admin->init();

        // Instantiate the media uploader class
        $options_framework_media_uploader = new Options_Framework_Media_Uploader;
        $options_framework_media_uploader->init();

    }

    add_action( 'init', 'optionsframework_init', 20 );

endif;


