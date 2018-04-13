<?php
if ( ! class_exists('npf_field_textarea')):
	class npf_field_textarea extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'textarea';

			// do not delete!
	  	parent::__construct();
		}

		function render_field($args)
		{

			$rows = (isset($args['field']['rows'])) ? intval($args['field']['rows']) : 5 ;
			$field_value = $this->get_value($args);

			echo '<textarea type="text" name="'.$args['field_name'].'" id="'.$args['field_id'].'" class="large-text code" rows="'.$rows.'" >';
			echo esc_textarea($field_value);
			echo '</textarea>';

		}

	}
endif;
