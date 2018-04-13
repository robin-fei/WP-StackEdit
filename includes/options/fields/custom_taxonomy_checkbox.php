<?php
if ( ! class_exists('npf_field_custom_taxonomy_checkbox')):
	class npf_field_custom_taxonomy_checkbox extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'custom_taxonomy_checkbox';

			// do not delete!
	  	parent::__construct();
		}


		function render_field($args)
		{

			$pargs = array(
				'selected'   => $args['field_value'],
				'name'       => $args['field_name'],
				'id'         => $args['field_id'],
				'taxonomy'   => $args['field']['taxonomy'],
				'hide_empty' => 1,
				'orderby'    => 'name',
				'order'      => 'asc',

				);
			if (isset($args['field']['extra_args']) && !empty($args['field']['extra_args']) && is_array($args['field']['extra_args']) ) {
				$pargs = array_merge($pargs,$args['field']['extra_args']);
			}
			$all_cats = get_terms( $args['field']['taxonomy'], $pargs );
			if (!empty($all_cats)) {
				foreach ($all_cats as $key => $choice) {
					$checked_text = '';
					if (is_array($args['field_value']) && in_array($choice->term_id, $args['field_value'])) {
						$checked_text = ' checked="checked" ';
					}
					echo '<input type="checkbox" name="'.$args['field_name'].'[]" id="'.$args['field_id'].'-'.esc_attr($choice->term_id).'" value="'.esc_attr($choice->term_id).'"';
					checked( is_array($args['field_value']) && in_array($choice->term_id, $args['field_value']), true, true );
					echo ' class="stylish-checkbox" ';
					echo ' />';
					echo '<label for="'.$args['field_id'].'-'.esc_attr($choice->term_id).'">'.esc_attr($choice->name).'</label><br />';

				}
			}

		}

	}
endif;
