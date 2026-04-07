 jQuery(document).ready(function($) {
	
	// var meta_image_frame;
	$('#cat_icon_button').live('click', function(e){
		e.preventDefault();

		if( meta_image_frame ){
			wp.media.editor.open();
			return;
		}

		var meta_image_frame = wp.media.frames.file_frame = wp.media({
			title: 'About Taxonomy Image',
			button: {text: 'Add Image'},
			library: { type: 'image'},
			multiple: false
		});

		meta_image_frame.on('select', function(){
			var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
			$('[id^=term_meta]').val(media_attachment.url);
			$('.prw_img').attr('src',media_attachment.url);
			$('#cat_icon_reset_button').show();
		});

		meta_image_frame.open();

	});

	$('#cat_icon_reset_button').click(function(e){
		e.preventDefault();
		$('#term_meta').val('');
		$('img.prw_img').attr('src', 'https://devserverhost.com/wp-content/plugins/woocommerce/assets/images/placeholder.png');
		$(this).hide();
	});

});