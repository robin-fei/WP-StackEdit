<?php
/**
 * Plugin Name: WP StackEdit
 * Plugin URI:  https://github.com/JaxsonWang/WP-StackEdit
 * Description: Add StackEdit To WordPress
 * Version:     0.4
 * Author:      淮城一只猫
 * Author URI:  https://www.iiong.com
 * License:     GPLv3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @package wp-stackedit.php
 */

// 如果直接调用该文件，则中止
if (!defined('WPINC')) {
    die;
}

// 定义常量
define('STACKEDIT_VERSION', '0.4');
define('MINIMUM_WP_VERSION', '4.8');
define('STACKEDIT_NAME', plugin_basename( __FILE__ ) ); //插件名称
define('STACKEDIT_DIR', dirname(__FILE__)); //相对路径
define('STACKEDIT_URL', plugins_url('', __FILE__)); //资源路径
define('STACKEDIT_OPTION_NAME', 'wp-stackedit'); //数据名

// 检查并且加载Markdown类
if (!class_exists( 'stackedit_init' )) {
    require_once STACKEDIT_DIR . '/includes/core/stackedit_init.php';
}

// 检查并且加载后台选项框架
if (!class_exists('stackedit_options')) {
	require_once STACKEDIT_DIR . '/includes/core/stackedit_options.php';
}

// 检查并且加载语法高亮
if (!class_exists('stackedit_prismjs')) {
	require_once STACKEDIT_DIR . '/includes/core/stackedit_prismjs.php';
}

// 实例化
stackedit_init::get_instance();
stackedit_options::get_instance();
stackedit_prismjs::get_instance();