<?php
if ( ! class_exists('npf_field_radio_image')):
	class npf_field_radio_image extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'radio_image';

			// do not delete!
	  	parent::__construct();
		}


		function render_field($args)
		{
			$field_value = $this->get_value($args);
			if (isset($args['field']['choices'])) {
				foreach ($args['field']['choices'] as $key => $choice) {
					echo '<input type="radio" name="'.$args['field_name'].'" id="'.$args['field_id'].'-'.esc_attr($key).'" '.checked( $field_value, $key, false).' value="'.esc_attr($key).'" class="stylish-radio-image" />';
					echo '<label for="'.$args['field_id'].'-'.esc_attr($key).'">';
					echo '<img src="'.esc_url($choice).'" alt="" />';
					echo '</label>';
				}
			}

		}

	}
endif;
