<?php
/**
 * 包含Markdown Editor的主要插件类
 */

// 如果直接调用该文件，则中止
if (!defined('WPINC')) {
    die;
}

/**
 * 主要插件类
 */
class Markdown_Editor {

    /**
     * 默认实例
     *
     * @since 0.1
     * @var string $instance .
     */
    private static $instance;

    /**
     * 设置Markdown编辑器.
     *
     * @since 0.1
     */
    private function __construct() {

        // 加载Markdown编辑器
        add_action('edit_form_advanced', array($this, 'enqueue_scripts_styles'));
        add_action('edit_page_form', array($this, 'enqueue_scripts_styles'));

        add_filter( 'wp_default_editor', array($this, 'jade_default_editor') );

        // 加载前端静态资源
        //add_action('wp_enqueue_scripts', array($this, 'frontend_scripts_styles'));

        add_action( 'post_submitbox_misc_actions', array($this, 'jade_submitbox_misc_actions') );

	    //插件通知
	    add_action('admin_notices', array($this, 'jade_notice'));
	    //插件通知
	    add_action('admin_init', array($this, 'jade_notice_ignore'));

    }

    /**
     * 获取实例.
     *
     * @since 0.1
     * @return string $instance 插件实例
     */
    public static function get_instance() {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    /**
     * 防止克隆
     *
     * @since 0.1
     * @return void
     */
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    /**
     * 在后台页面加载脚本和样式
     *
     * @since 0.1
     * @return void
     */
    function enqueue_scripts_styles() {
        wp_enqueue_script( 'stackedit-js', JADE_URL . '/assets/stackedit/stackedit.min.js',array(),JADE_VERSION,false );
        wp_enqueue_script( 'turndown-js', JADE_URL . '/assets/turndown/turndown.js',array(),JADE_VERSION,false );
        wp_enqueue_script( 'jade-js', JADE_URL . '/assets/jade/jade.js',array(),JADE_VERSION,false );

        wp_enqueue_style( 'typo-css', JADE_URL . '/assets/typo/typo.css',array(),JADE_VERSION,'all' );
        wp_enqueue_style( 'jade-css', JADE_URL . '/assets/jade/jade.css',array(),JADE_VERSION,'all' );

	    $jadeData = array(
		    'stackEditUrl' => j_opt('stackedit_url'),
		    'openEdit' => j_opt('load_stackedit')
	    );
	    wp_localize_script( 'jade-js', 'jade', $jadeData );
    }

    /**
     * 在前端页面加载脚本和样式
     *
     * @since 0.1
     * @return void
     */
    function frontend_scripts_styles() {
        //预加载编辑器资源

    }

    /**
     * 加载编辑器默认选择文本框
     *
     * @return string 'html' or 'tinymce'
     */
    function jade_default_editor() {
        return 'html';
    }

    /**
     * 自定义按钮
     *
     * @param $post
     */
    function jade_submitbox_misc_actions($post){
        ?>
        <div class="misc-pub-section stackedit-status">
            <span class="dashicons dashicons-editor-code"></span>
            <span class="stackedit-title">StackEdit: </span>
            <a href="javascript:" id="stackedit-status"><?php _e( '禁用状态' ) ?></a>
        </div>
        <?php
    }

	/**
	 * 通知显示
	 */
	public function jade_notice() {
		global $pagenow;
		if ( !is_multisite() && ( $pagenow == 'plugins.php' || $pagenow == 'themes.php' ) ) {
			global $current_user ;
			$user_id = $current_user->ID;
			if ( ! get_user_meta($user_id, 'jade_ignore_notice') ) {
				echo '<div class="updated jade_setup_nag"><p>';
				printf( __('Please Update Your Favorite Options In Settings.  <a href="%1$s" target="_blank">Options</a> | <a href="%2$s">Hide Notice</a>', 'wp-stackedit-options' ), admin_url('plugins.php?page=wp-stackedit-options'), '?optionsframework_nag_ignore=0');
				echo "</p></div>";
			}
		}
	}

	/**
	 * 允许用户隐藏通知
	 */
	public function jade_notice_ignore() {
		global $current_user;
		$user_id = $current_user->ID;
		if ( isset( $_GET['jade_nag_ignore'] ) && '0' == $_GET['jade_nag_ignore'] ) {
			add_user_meta( $user_id, 'jade_ignore_notice', 'true', true );
		}
	}
}
