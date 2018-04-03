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
if ( ! defined( 'WPINC' ) ) {
	 die;
}

// 定义常量
define( 'JADE_VERSION', '0.1' );
define( 'MINIMUM_WP_VERSION', '4.8' );
define( 'JADE_NAME', plugin_basename( __FILE__ ) );
define( 'JADE_DIR', plugin_dir_path( __FILE__ ) );
define( 'JADE_URL', plugin_dir_url( __FILE__ ) );

// 检查Jetpack模块是否启用
if ( ! class_exists( 'WPCom_Markdown' ) ) {
	include_once JADE_DIR . 'includes/Easy_Markdown.php';
}

// 加载Markdown类
include_once JADE_DIR . 'includes/Markdown_Editor.php';

// 获取类实例
Markdown_Editor::get_instance();
