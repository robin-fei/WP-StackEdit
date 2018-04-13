<?php

if ( ! class_exists('npf_field_numeric_slider')):
	class npf_field_numeric_slider extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'numeric_slider';

			// do not delete!
	  	parent::__construct();
		}

		function render_field($args)
		{

			$field_value = $this->get_value($args);
			$min_max_step = isset($args['field']['min_max_step']) ? $args['field']['min_max_step'] : array() ;
			if (empty($min_max_step) || 3 != count($min_max_step) ) {
				$min_max_step = array(1,10,1);
			}
			list($min,$max,$step) = $min_max_step;

			$attribute = array(
				'name'              => $args['field_name'],
				'id'                => $args['field_id'],
				'class'             => 'npf-numeric-slider',
				'value'             => $field_value,
				'data-slider'       => 'true',
				'data-slider-snap'  => 'true',
				'data-slider-step'  => abs($step),
				'data-slider-range' => $min.','.$max,
				);
			$attribute_text = '';
			foreach ($attribute as $key => $attr) {
				$attribute_text .= ' '.$key.'="'.esc_attr($attr).'" ';
			}
			echo '<input type="text"'.$attribute_text.' />';
			echo '<input type="text" readonly="readonly" value="'.$field_value.'" class="npf-slider-output small-text code" />';

		}

	}
endif;
