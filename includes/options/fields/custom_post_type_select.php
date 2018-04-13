<?php
if ( ! class_exists('npf_field_custom_post_type_select')):
	class npf_field_custom_post_type_select extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'custom_post_type_select';

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
				echo '<select name="'.$args['field_name'].'" id="'.$args['field_id'].'">';

				if ( isset($args['field']['allow_null']) && true == $args['field']['allow_null'] ) {
					echo '<option value="">Select</option>';
				}

				foreach ($all_posts as $k => $p) {
					echo '<option value="'.esc_attr($p->ID).'" ';
					selected($p->ID, $args['field_value'], true );
					echo '>'.esc_attr($p->post_title).'</option>';
				}
				echo '</select>';
			}

		}

	}
endif;
