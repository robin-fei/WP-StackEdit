<?php
if ( ! class_exists('npf_field')):
	class npf_field
	{

		var $name;

		public static function getInstance()
		    {
		        static $instance = null;
		        if (null === $instance) {
		            $instance = new static();
		        }

		        return $instance;
		    }

		protected function __construct()
		{

		}

		function get_value($args){

			$output = '';
			if ( isset( $args['options'][$args['field']['id']] ) ) {
				$output = $args['options'][$args['field']['id']] ;
			}
			else{
				if ( isset( $args['field']['default'] ) ) {
					$output = $args['field']['default'];
				}
			}
			return $output;

		}

		function show_description($args){
			if (isset($args['field']['description'])&& !empty($args['field']['description'])) {
				echo sprintf('%s%s%s',
					'<p class="description">',
					esc_attr($args['field']['description']),
					'</p>'
					);
			}

		}


	}

endif;
