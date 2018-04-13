<?php
if ( ! class_exists('npf_field_email')):
	class npf_field_email extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'email';

			// do not delete!
	  	parent::__construct();
		}


		function render_field($args)
		{

			$field_value = $this->get_value($args);
			echo '<input type="email" name="'.$args['field_name'].'" id="'.$args['field_id'].'" value="'.$field_value.'" class="regular-text code" />';

		}

	}
endif;
