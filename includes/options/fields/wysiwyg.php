<?php
if ( ! class_exists('npf_field_wysiwyg')):
	class npf_field_wysiwyg extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'wysiwyg';

			// do not delete!
	  	parent::__construct();
		}


		function render_field($args)
		{

			$rows = (isset($args['field']['rows'])) ? intval($args['field']['rows']) : 10 ;
			$media_buttons = (isset($args['field']['media_buttons'])) ? intval($args['field']['media_buttons']) : true ;
			$settings = array(
				'textarea_name' => $args['field_name'],
				'textarea_rows' => $rows,
				'media_buttons' => $media_buttons,
				);
			$field_value = $this->get_value($args);
			wp_editor( $field_value, $args['field_id'], $settings );

		}

	}
endif;
