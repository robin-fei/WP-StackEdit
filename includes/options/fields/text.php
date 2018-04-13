<?php

if ( ! class_exists('npf_field_text')):
	class npf_field_text extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'text';

			// do not delete!
	  	parent::__construct();
		}


		function render_field($args)
		{

			$text_class = 'regular-text';
			if (isset($args['field']['text_type']) && in_array($args['field']['text_type'], array('small','regular','large') )) {
				$text_class = $args['field']['text_type'] . '-text';
			}
			$field_value = $this->get_value($args);
			echo '<input type="text" name="'.$args['field_name'].'" id="'.$args['field_id'].'" value="'.$field_value.'" class="' . $text_class . ' code" />';

		}

	}
endif;
