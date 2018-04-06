<?php
/**
 * Plugin Name: WP Jade Markdown
 * Plugin URI:
 * Description:
 * Version:     0.1
 * Author:      淮城一只猫
 * Author URI:  https://www.iiong.com
 * License:     GPLv3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @package wp-jade.md.php
 */

// 如果直接调用该文件，则中止
if (!defined('WPINC')) {
    die;
}

// 定义常量
define('JADE_VERSION', '0.1');
define('MINIMUM_WP_VERSION', '4.8');
define('JADE_DIR', dirname(__FILE__)); //相对路径
define('JADE_URL', plugins_url('', __FILE__)); //资源路径

// 检查并且加载Jetpack模块
if (!class_exists('WPCom_Markdown')) {
    require_once JADE_DIR . '/includes/class-markdown/Easy_Markdown.php';
}

// 检查并且加载Markdown类
if (!class_exists('Markdown_Editor')) {
    require_once JADE_DIR . '/includes/class-markdown/Markdown_Editor.php';
}

// 检查并且加载后台选项框架
if (!function_exists('optionsframework_init')) {
    require_once JADE_DIR . '/includes/options/options-framework.php';
}

// 获取类实例
Markdown_Editor::get_instance();
