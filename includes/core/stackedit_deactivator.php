<?php

class stackedit_deactivator {

	public static function deactivator() {

		global $current_user;
		$user_id = $current_user->ID;
		delete_user_meta( $user_id, 'stackedit_ignore_notice','true' );

		flush_rewrite_rules();
	}

}
