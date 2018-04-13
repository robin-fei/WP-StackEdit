<?php
/**
 * 包含Editor的主要插件类
 */

// 如果直接调用该文件，则中止
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * 主要插件类
 */
class stackedit_init {

	/**
	 * 默认实例
	 *
	 * @since 0.1
	 * @var string $instance .
	 */
	private static $instance;

	/**
     * 获取值选项
	 * @param $name
	 *
	 * @return mixed
	 */
	public function opt($name) {
		return get_option( STACKEDIT_OPTION_NAME )[$name];
    }

	/**
	 * 设置Markdown编辑器.
	 *
	 * @since 0.1
	 */
	private function __construct() {

		// 加载Markdown编辑器
		add_action( 'edit_form_advanced', array( $this, 'enqueue_scripts_styles' ) );
		add_action( 'edit_page_form', array( $this, 'enqueue_scripts_styles' ) );

		// 加载前端静态资源
		//add_action('wp_enqueue_scripts', array($this, 'frontend_scripts_styles'));

		//加载编辑器默认选择text类型
		add_filter( 'wp_default_editor', array( $this, 'stackedit_default_editor' ) );

		//自定义按钮
		add_action( 'post_submitbox_misc_actions', array( $this, 'stackedit_submitbox_misc_actions' ) );

		//插件通知
		add_action( 'admin_notices', array( $this, 'stackedit_notice' ) );
		add_action( 'admin_init', array( $this, 'stackedit_notice_ignore' ) );

		//添加插件设置链接
		add_filter( 'plugin_action_links_' . STACKEDIT_NAME, array( $this, 'stackedit_settings_link' ), 10, 5 );
		add_filter( 'plugin_row_meta', array( $this, 'stackedit_plugin_row_meta' ), 10, 2 );

		//启用激活的函数
		register_activation_hook( STACKEDIT_NAME, array($this, 'stackedit_activate') );

		//停用激活的函数
		register_deactivation_hook( STACKEDIT_NAME, array($this, 'stackedit_deactivator') );

		//加载国际化资源
        load_plugin_textdomain( 'stackedit', false, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/' );
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

	/**
	 * 防止克隆
	 *
	 * @since 0.1
	 * @return void
	 */
	public function __clone() {
		trigger_error( 'Clone is not allowed.', E_USER_ERROR );
	}

	/**
	 * 在后台页面加载脚本和样式
	 *
	 * @since 0.1
	 * @return void
	 */
	public function enqueue_scripts_styles() {
		wp_enqueue_script( 'stackedit-js', STACKEDIT_URL . '/assets/stackedit/stackedit.min.js', array(), STACKEDIT_VERSION, false );
		wp_enqueue_script( 'turndown-js', STACKEDIT_URL . '/assets/turndown/turndown.min.js', array(), STACKEDIT_VERSION, false );
		wp_enqueue_script( 'jade-js', STACKEDIT_URL . '/assets/jade/jade.min.js', array(), STACKEDIT_VERSION, false );

		wp_enqueue_style( 'typo-css', STACKEDIT_URL . '/assets/typo/typo.min.css', array(), STACKEDIT_VERSION, 'all' );
		wp_enqueue_style( 'jade-css', STACKEDIT_URL . '/assets/jade/jade.min.css', array(), STACKEDIT_VERSION, 'all' );

		$stackedit_url = $this->opt( 'stackedit_url' );
		$load_stackedit   = $this->opt( 'load_stackedit' );

		$stackeditData = array(
			'stackEditUrl' => isset( $stackedit_url ) ? $stackedit_url : 'https://stackedit.io/app',
			'openEdit'     => isset( $load_stackedit ) ? $load_stackedit : 'no',
            'disabled'     => __( 'Disabled', 'stackedit' ),
            'enable'       => __( 'Enable', 'stackedit' ),
		);
		wp_localize_script( 'jade-js', 'stackedit', $stackeditData );
	}

	/**
	 * 插件设置按钮链接
	 *
	 * @param $actions
	 *
	 * @return array
	 */
	public function stackedit_settings_link( $actions ) {
		return array_merge(
			array(
				'<a href="'. admin_url("plugins.php?page=wp-stackedit") .'" rel="nofollow">' . __( 'Settings', 'stackedit' ) . '</a>',
				'<a href="https://github.com/JaxsonWang/WP-StackEdit" target="_blank" rel="nofollow">' . __( 'Github', 'stackedit' ) . '</a>',
				'<a href="https://github.com/JaxsonWang/WP-StackEdit/blob/master/docs/Notes.md" target="_blank" rel="nofollow">' . __( 'Docs', 'stackedit' ) . '</a>',
			),
			$actions
		);
	}

	/**
	 * 插件设置标签链接
	 *
	 * @param $links
	 * @param $file
	 *
	 * @return array
	 */
	public function stackedit_plugin_row_meta( $links, $file ) {
		if ( strpos( $file, STACKEDIT_NAME ) !== false ) {
			$new_links = array(
				'Blog'   => '<a href="https://iiong.com" target="_blank" rel="nofollow">' . __( 'Blog', 'stackedit' ) . '</a>',
				'Issues' => '<a href="https://github.com/JaxsonWang/WP-StackEdit/issues" target="_blank" rel="nofollow">' . __( 'Issues', 'stackedit' ) . '</a>',
                'StackEdit WebStie' => '<a href="https://stackedit.io" target="_blank" rel="nofollow">' . __( 'StackEdit WebStie', 'stackedit' ) . '</a>',
			);

			$links = array_merge( $links, $new_links );
		}

		return $links;
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
	function stackedit_default_editor() {
		return 'html';
	}

	/**
	 * 自定义按钮
	 *
	 * @param $post
	 */
	function stackedit_submitbox_misc_actions( $post ) {
		?>
        <div class="misc-pub-section stackedit-status">
            <span class="dashicons dashicons-editor-code"></span>
            <span class="stackedit-title">StackEdit: </span>
            <a href="javascript:" id="stackedit-status"><?php _e( 'Disabled', 'stackedit' ) ?></a>
        </div>
		<?php
	}

	/**
	 * 通知显示
	 */
	public function stackedit_notice() {
		global $pagenow;
		if ( ! is_multisite() && ( $pagenow == 'plugins.php' || $pagenow == 'themes.php' ) ) {
			global $current_user;
			$user_id = $current_user->ID;
			if ( ! get_user_meta( $user_id, 'stackedit_ignore_notice' ) ) {
				echo '<div class="updated stackedit_setup_nag"><p>';
				printf( __( 'Please Update Your Favorite Options In Settings.  <a href="%1$s">Options</a> | <a href="%2$s">Hide Notice</a>', 'stackedit' ), admin_url( 'plugins.php?page=wp-stackedit' ), '?stackedit_nag_ignore=0' );
				echo "</p></div>";
			}
		}
	}

	/**
	 * 允许用户隐藏通知
	 */
	public function stackedit_notice_ignore() {
		global $current_user;
		$user_id = $current_user->ID;
		if ( isset( $_GET['stackedit_nag_ignore'] ) && '0' == $_GET['stackedit_nag_ignore'] ) {
			add_user_meta( $user_id, 'stackedit_ignore_notice', 'true', true );
		}
	}

	/**
	 * 启用插件激活的函数
	 */
	public function stackedit_activate() {
		require_once STACKEDIT_DIR . '/includes/core/stackedit_activator.php';
		stackedit_activator::activate();
	}

	/**
	 * 停用插件激活的函数
     * 删除usermeta表信息：stackedit_ignore_notice
	 */
	public function stackedit_deactivator() {
		require_once STACKEDIT_DIR . '/includes/core/stackedit_deactivator.php';
		stackedit_deactivator::deactivator();
    }
}