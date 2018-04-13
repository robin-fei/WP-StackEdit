<?php
if ( ! class_exists('npf_field_user_role_select')):
	class npf_field_user_role_select extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'user_role_select';

			// do not delete!
	  	parent::__construct();
		}


		function render_field($args)
		{

			$all_roles = get_editable_roles();
			if (!empty($all_roles)) {
				echo '<select name="'.$args['field_name'].'" id="'.$args['field_id'].'">';

				if ( isset($args['field']['allow_null']) && true == $args['field']['allow_null'] ) {
					echo '<option value="">Select</option>';
				}

				foreach ($all_roles as $k => $r) {
					echo '<option value="'.esc_attr($k).'" ';
					selected($k, $args['field_value'], true );
					echo '>'.esc_attr($r['name']).'</option>';
				}
				echo '</select>';
			}

		}

	}
endif;
