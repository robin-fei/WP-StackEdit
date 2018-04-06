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
class Markdown_Editor
{

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

        // 添加默认文章类型支持
        add_post_type_support('post', 'wpcom-markdown');

        // 加载Markdown编辑器
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts_styles'));
        add_action('admin_footer', array($this, 'init_editor'));

        // 删除快速标签按钮.
        add_filter('quicktags_settings', array($this, 'quicktags_settings'), 'content');

        // 删除富文本编辑器
        add_filter('user_can_richedit', array($this, 'disable_rich_editing'));

        // 加载前端静态资源
        //add_action('wp_enqueue_scripts', array($this, 'frontend_scripts_styles'));

        // 加载Jetpack Markdown模块
        $this->load_jetpack_markdown_module();

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
     * 过滤Markdown文章类型
     *
     * @since  0.1
     * @return bool
     */
    function get_post_type() {
        return get_current_screen()->post_type;
    }

    /**
     * 在后台页面加载脚本和样式
     *
     * @since 0.1
     * @return void
     */
    function enqueue_scripts_styles() {

        // 仅在指定的文章类型中列队加载
        if (!post_type_supports($this->get_post_type(), 'wpcom-markdown')) {
            return;
        }

        wp_enqueue_script( 'stackedit', JADE_URL . '/assets/stackedit/stackedit.min.js' );
        //wp_enqueue_style( 'simplemde-css', PLUGIN_URL . 'assets/styles/simplemde.min.css' );

    }

    /**
     * 在前端页面加载脚本和样式
     *
     * @since 0.1
     * @return void
     */
    function frontend_scripts_styles() {

        // 仅在文章/页面类型列队加载
        if (!is_single()) {
            return;
        }

        //预加载编辑器资源

    }

    /**
     * 加载Jetpack Markdown模块
     *
     * @since 0.1
     * @return void
     */
    function load_jetpack_markdown_module() {

        // 如果模块处于活动状态，将其激活以发布，评论仍然是可选的
        if (class_exists('Easy_Markdown')) {
            add_filter('pre_option_' . Easy_Markdown::POST_OPTION, '__return_true');
        }
        add_action('admin_init', array($this, 'jetpack_markdown_posting_always_on'), 11);

    }

    /**
     * 将Jetpack写作模式设置为始终开启。
     *
     * @since 0.1
     * @return void
     */
    function jetpack_markdown_posting_always_on() {
        if (!class_exists('Easy_Markdown')) {
            return;
        }
        global $wp_settings_fields;
        if (isset($wp_settings_fields['writing']['default'][Easy_Markdown::POST_OPTION])) {
            unset($wp_settings_fields['writing']['default'][Easy_Markdown::POST_OPTION]);
        }
    }

    /**
     * 初始化编辑器
     *
     * @since 0.1
     * @return void
     */
    function init_editor() {

        // 仅在指定的文章类型中初始化
        if (!post_type_supports($this->get_post_type(), 'wpcom-markdown')) {
            return;
        }
        ?>
        <script type="text/javascript">
            // 初始化编辑器
            const el = document.getElementById( 'content' );
            const stackedit = new Stackedit();

            // 打开iframe
            stackedit.openFile({
                name: 'Filename', // TODO 初始化文章名
                content: {
                    text: el.value
                }
            },true);

            // 监听stackedit事件并将更改应用到textarea
            stackedit.on('fileChange', (file) => {
                //el.value = file.content.text;
                el.innerHTML = file.content.html;
                //el.value = file.content.text;
            });
            console.log("编辑器加载成功");
        </script>
        <?php
    }

    /**
     * 快速标签设置
     *
     * @since 0.1
     * @param  array $qt_init Quick tag args.
     * @return array
     */
    function quicktags_settings($qt_init) {

        // Only remove buttons on specified post types.
        if (!post_type_supports($this->get_post_type(), 'wpcom-markdown')) {
            return $qt_init;
        }

        $qt_init['buttons'] = ' ';
        return $qt_init;
    }

    /**
     * 禁用富文本编辑器
     *
     * @since  0.1
     * @param  array $default Default post types.
     * @return array
     */
    function disable_rich_editing($default) {

        if (post_type_supports($this->get_post_type(), 'wpcom-markdown')) {
            return false;
        }

        return $default;
    }
}
