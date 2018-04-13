<?php
if ( ! class_exists('npf_field_custom_post_type_checkbox')):

	class npf_field_custom_post_type_checkbox extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'custom_post_type_checkbox';

			// do not delete!
	  	parent::__construct();
		}


		function render_field($args)
		{

			$pargs = array(
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'asc',
				'post_type'      => $args['field']['post_type'],
				);
			if (isset($args['field']['extra_args']) && !empty($args['field']['extra_args']) && is_array($args['field']['extra_args']) ) {
				$pargs = array_merge($pargs,$args['field']['extra_args']);
			}
			$all_posts = get_posts($pargs);
			if (!empty($all_posts)) {
				foreach ($all_posts as $key => $choice) {
					echo '<input type="checkbox" name="'.$args['field_name'].'[]" id="'.$args['field_id'].'-'.esc_attr($key).'"  value="'.esc_attr($choice->ID).'"';
					checked( is_array($args['field_value']) && in_array($choice->ID, $args['field_value']), true, true );
					echo ' class="stylish-checkbox" ';
					echo ' />';
					// echo esc_attr($choice->post_title).'<br/>';
					echo '<label for="'.$args['field_id'].'-'.esc_attr($key).'">'.esc_attr($choice->post_title).'</label><br />';

				}
			}

		}

	}

endif;
