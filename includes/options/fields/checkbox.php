<?php
if ( ! class_exists('npf_field_checkbox')):
	class npf_field_checkbox extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'checkbox';

			// do not delete!
	  	parent::__construct();
		}

		function render_field($args)
		{

			if (isset($args['field']['choices'])) {
				foreach ($args['field']['choices'] as $key => $choice) {
					$checked_text = '';
					if (is_array($args['field_value']) && in_array($key, $args['field_value'])) {
						$checked_text = ' checked="checked" ';
					}
					echo '<input type="checkbox" name="'.$args['field_name'].'[]" id="'.$args['field_id'].'-'.esc_attr($key).'" '.$checked_text.' value="'.esc_attr($key).'" class="stylish-checkbox" />';
					echo '<label for="'.$args['field_id'].'-'.esc_attr($key).'">'.$choice.'</label><br />';
				}
			}


		}

	}

endif;
