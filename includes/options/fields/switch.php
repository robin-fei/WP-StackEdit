<?php
if ( ! class_exists('npf_field_switch')):
	class npf_field_switch extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'switch';

			// do not delete!
	  	parent::__construct();
		}


		function render_field($args)
		{

			$field_value = $this->get_value($args);
			$choices_on = array();
			$choices_off = array();
			if (isset($args['field']['choices_on'])) {
				$choices_on = $args['field']['choices_on'];
			}
			if (isset($args['field']['choices_off'])) {
				$choices_off = $args['field']['choices_off'];
			}
			if (empty($choices_on) || empty($choices_off) ) {
				echo 'Configuration error';
				return;
			}
			// nspre($args['field']);

			reset($choices_on);
			$first_key = key($choices_on);
			echo '<input type="checkbox" class="npf-on-off" name="'.$args['field_name'].'" id="'.$args['field_id'].'" '.checked( $field_value, $first_key, false).'  data-on="'.array_shift($choices_on).'" data-off="'.array_shift($choices_off).'" value="'.$first_key.'" />';


		}

	}
endif;
