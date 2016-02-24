jQuery(function(jQuery) {

	var uploadID = '';
	
	jQuery('#upload_image_button').click(function(){
	   uploadID = jQuery(this).prev('input');
	   formfield = jQuery('.upload_field').attr('name');
	   preview = jQuery(this).parent().find('.preview_image');
	   tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
	   return false;
	});
	
	window.send_to_editor = function(html) {
		imgurl = jQuery('img',html).attr('src');
		uploadID.val(imgurl);
	   preview.attr('src', imgurl).addClass('loaded');
	   tb_remove();
	   window.send_to_editor = window.restore_send_to_editor;
	}
	
	jQuery('.clear_image_button').click(function() {
	   var defaultImage = jQuery(this).parent().find('.default_image').text();
	   jQuery(this).parent().find('.upload_field').val('');
	   jQuery(this).parent().find('.preview_image').attr('src', defaultImage).removeClass('loaded');
	   return false;
	});

});