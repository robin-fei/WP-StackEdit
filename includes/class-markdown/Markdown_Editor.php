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
}
