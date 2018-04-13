<?php
if ( ! class_exists('npf_field_nav_menu_select')):
	class npf_field_nav_menu_select extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'nav_menu_select';

			// do not delete!
	  	parent::__construct();
		}


		function render_field($args)
		{

			$all_menus = get_registered_nav_menus();

			if ( ! empty($all_menus) ) {
				echo '<select name="'.$args['field_name'].'" id="'.$args['field_id'].'">';
				if ( isset($args['field']['allow_null']) && true == $args['field']['allow_null'] ) {
					echo '<option value="">Select</option>';
				}

				foreach ($all_menus as $k => $m) {
					echo '<option value="'.esc_attr($k).'" ';
					selected($k, $args['field_value'], true );
					echo '>'.esc_attr($m).'</option>';
				}
				echo '</select>';
			}
			else{
				echo 'No nav menu registered';
			}



		}

	}
endif;
