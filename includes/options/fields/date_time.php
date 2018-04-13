<?php
if ( ! class_exists('npf_field_date_time')):
	class npf_field_date_time extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'date_time';

			// do not delete!
	  	parent::__construct();
		}


		function render_field($args)
		{

			// nspre($args);
			$field_value = $this->get_value($args);
			echo '<input type="text" name="'.$args['field_name'].'" id="'.$args['field_id'].'" value="'.$field_value.'" class="regular-text code select-datetime" />';

		}

	}
endif;
