<?php
if ( ! class_exists('npf_field_upload')):
	class npf_field_upload extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'upload';

			// do not delete!
	  	parent::__construct();
		}


		function render_field($args)
		{

			$field_value = $this->get_value($args);
			echo '<input type="text" name="'.$args['field_name'].'" id="'.$args['field_id'].'" value="'.$field_value.'" class="regular-text code img" />';
			echo '<input type="button" class="select-img button button-primary" value="Upload" data-uploader_button_text="Select" data-uploader_title="'.$args['field']['title'].'" />';
			echo '<div class="image-preview-wrap" >';
				echo '<div class="image-preview-left-part">';
					echo '<img src="'.$field_value.'" alt="Preview" class="img-preview" />';
				echo '</div><!-- .image-preview-left-part -->';
				echo '<div class="image-preview-right-part">';
					echo '<input type="button" class="button btn-remove-upload" value="Remove" />';
				echo '</div><!-- .image-preview-right-part -->';
			echo '</div><!-- .image-preview-wrap -->';

		}

	}
endif;
