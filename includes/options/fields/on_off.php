<?php
if ( ! class_exists('npf_field_on_off')):
	class npf_field_on_off extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'on_off';

			// do not delete!
	  	parent::__construct();
		}


		function render_field($args)
		{

			$field_value = $this->get_value($args);
			echo '<input type="checkbox" class="npf-on-off" name="'.$args['field_name'].'" id="'.$args['field_id'].'" '.checked( $field_value, 'ON', false).' value="ON" data-on="ON" data-off="OFF" />';
		}

	}
endif;
