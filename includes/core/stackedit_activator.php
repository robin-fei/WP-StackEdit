<?php

// 如果直接调用该文件，则中止
if (!defined('WPINC')) {
	die;
}

class stackedit_activator {

	public static function activate() {

		flush_rewrite_rules();

	}

}
