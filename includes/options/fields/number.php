<?php
if ( ! class_exists('npf_field_number')):
	class npf_field_number extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'number';

			// do not delete!
	  	parent::__construct();
		}


		function render_field($args)
		{

			$field_value = $this->get_value($args);
			$min = ( isset( $args['field']['min'] ) ) ? intval($args['field']['min']) : 0 ;
			$max = ( isset( $args['field']['max'] ) ) ? intval($args['field']['max']) : 100 ;
			$step = ( isset( $args['field']['step'] ) ) ? intval($args['field']['step']) : 1 ;
			echo '<input type="number" name="'.$args['field_name'].'" id="'.$args['field_id'].'" value="'.$field_value.'" class="regular-text code" min="'.$min.'" max="'.$max.'" step="'.$step.'" />';

		}

	}
endif;
