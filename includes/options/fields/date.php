<?php
if ( ! class_exists('npf_field_date')):
	class npf_field_date extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'date';

			// do not delete!
	  	parent::__construct();
		}


		function render_field($args)
		{

			$field_value = $this->get_value($args);
			echo '<input type="text" name="'.$args['field_name'].'" id="'.$args['field_id'].'" value="'.$field_value.'" class="regular-text code select-date" />';

		}

	}
endif;
