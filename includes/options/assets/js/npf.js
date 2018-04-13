var file_frame;
jQuery(document).ready(function($){

	// Tabs
	$('#npf-tab-container').easytabs({
		defaultTab: "span:first-child",
    tabs: "> h2 > span ",
    tabActiveClass: "nav-tab-active",
    updateHash: false,
	});

	// Date picker
	$('input.select-date').datepicker();
	$('input.select-time').timepicker();
	$('input.select-datetime').datetimepicker();

  // Color picker
  $('input.select-color').each(function(){
      $(this).wpColorPicker();
  });

  // Numeric Slider
  $(".npf-numeric-slider").bind("slider:changed", function (event, data) {
    // The currently selected value of the slider
    $(this).parent().find('.npf-slider-output').val(data.value);

  });

  // Uploads
  jQuery(document).on('click', 'input.select-img', function( event ){

    var $this = $(this);

    event.preventDefault();

    // If the media frame already exists, reopen it.
    // if ( file_frame ) {
    //   file_frame.open();
    //   return;
    // }

    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: jQuery( this ).data( 'uploader_title' ),
      button: {
        text: jQuery( this ).data( 'uploader_button_text' ),
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });

    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
      // We set multiple to false so only get one image from the uploader
      attachment = file_frame.state().get('selection').first().toJSON();
      image_field = $this.siblings('.img');
      var imgurl = attachment.url;
      image_field.val(imgurl);
      image_field.parent().find('.image-preview-wrap').hide();
      image_field.parent().find('.img-preview').attr('src',imgurl);
      image_field.parent().find('.image-preview-wrap').fadeIn();

    });

    // Finally, open the modal
    file_frame.open();
  });
  $(document).on('click', 'input.btn-remove-upload', function(evt){
    evt.preventDefault();
    var $this = $(this);
    $this.siblings('.img-preview').hide();
    $this.parent().parent().find('.img-preview').fadeOut();
    $this.parent().parent().siblings('.img').val('');
    $this.fadeOut();
  });

});
