<?php
if ( ! class_exists('npf_field_url')):
	class npf_field_url extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'url';

			// do not delete!
	  	parent::__construct();
		}


		function render_field($args)
		{

			$field_value = $this->get_value($args);
			echo '<input type="url" name="'.$args['field_name'].'" id="'.$args['field_id'].'" value="'.$field_value.'" class="regular-text code" />';

		}

	}
endif;
