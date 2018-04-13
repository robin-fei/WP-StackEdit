<?php

if ( ! class_exists('npf_field_user_role_checkbox')):
	class npf_field_user_role_checkbox extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'user_role_checkbox';

			// do not delete!
	  	parent::__construct();
		}


		function render_field($args)
		{

			$all_roles = get_editable_roles();
			if (!empty($all_roles)) {

				foreach ($all_roles as $k => $r) {
					echo '<input type="checkbox" name="'.$args['field_name'].'[]" id="'.$args['field_id'].'-'.esc_attr($k).'"  value="'.esc_attr($k).'"  class="stylish-checkbox" ';
					checked( is_array($args['field_value']) && in_array($k, $args['field_value']), true, true );
					echo ' />';
					echo '<label for="'.$args['field_id'].'-'.esc_attr($k).'">'.esc_attr($r['name']).'</label><br />';
				}

			}

		}

	}
endif;
