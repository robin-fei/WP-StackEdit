<?php
if ( ! class_exists('npf_field_sidebar_select')):
	class npf_field_sidebar_select extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'sidebar_select';

			// do not delete!
	  	parent::__construct();
		}


		function render_field($args)
		{

			global $wp_registered_sidebars;
			if ( ! empty($wp_registered_sidebars) ) {
				echo '<select name="'.$args['field_name'].'" id="'.$args['field_id'].'">';

				if ( isset($args['field']['allow_null']) && true == $args['field']['allow_null'] ) {
					echo '<option value="">Select</option>';
				}

				foreach ( $wp_registered_sidebars as $key => $value ) {
					echo '<option value="'.esc_attr($key).'"'.selected( $args['field_value'], $key, false).'>'.esc_attr($value['name']).'</option>';
				}

				echo '</select>';
			}
			else{
				echo 'No sidebar available';
			}

		}

	}
endif;
