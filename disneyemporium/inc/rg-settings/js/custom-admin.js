jQuery(function($) {

	$('.rg_type select').bind('change', function () {
	    if ($(this).val() == 'soundclouduser' ) {
	      $('.rg_soundcloud_options, .rg_soundcloud').show();
	      $('.rg_mp_options, .rg_tracks, .rg_cover, .rg_audio_format').hide();
	  //     $('.rg_tracks .r-row input[type="text"]').val('');
	  //     $('.rg_audio_format input[type="checkbox"]').val('');
	  //    var defaultImage = $('.clear_image_button').parent().find('.default_image').text();
			// $('.clear_image_button').parent().find('.upload_field').val('');
			// $('.clear_image_button').parent().find('.preview_image').attr('src', defaultImage).removeClass('loaded');
	  //     $('.rg-media_repeatable_remove:not(.rg-media_repeatable tr:first-child .rg-media_repeatable_remove)').closest('tr').remove();
	    } else if($(this).val() == 'mp3url') {
	      $('.rg_mp_options, .rg_tracks, .rg_cover, .rg_audio_format').show();
	      $('.rg_soundcloud_options, .rg_soundcloud').hide();
	      $('.rg_soundcloud input[type="text"]').val('');
	    } else {
	       $('.rg_soundcloud_options, .rg_soundcloud, .rg_mp_options, .rg_tracks, .rg_cover, .rg_audio_format').hide();
	   //     $('.rg_soundcloud input[type="text"]').val('');
	   //     $('.rg_tracks .r-row input[type="text"]').val('');
	   //     $('.rg_audio_format input[type="checkbox"]').val('');
	   //     var defaultImage = $('.clear_image_button').parent().find('.default_image').text();
			 // $('.clear_image_button').parent().find('.upload_field').val('');
			 // $('.clear_image_button').parent().find('.preview_image').attr('src', defaultImage).removeClass('loaded');
	   //     $('.rg-media_repeatable_remove:not(.rg-media_repeatable tr:first-child .rg-media_repeatable_remove)').closest('tr').remove();
	    }
	  }).change();
	  
	  $('#media-items').bind('DOMNodeInserted',function(){
		   $('input[value="Insert into Post"]').each(function(){
		   		$(this).attr('value','Use This Image');
		   });
		});	

// REPEATABLE FIELD

	$('.rg-media_repeatable_add').live('click', function() {
		// clone
		var row = $(this).closest('.rg-media_repeatable').find('tbody tr:last-child');
		var clone = row.clone();
		clone.find('select.chosen').removeAttr('style', '').removeAttr('id', '').removeClass('chzn-done').data('chosen', null).next().remove();
		clone.find('input.regular-text, textarea, select').val('');
		clone.find('input[type=checkbox], input[type=radio]').attr('checked', false);
		row.after(clone);
		// increment name and id
		clone.find('input, textarea, select').attr('name', function(index, name) {
		   return name.replace(/(\d+)/, function(fullMatch, n) {
		   	return Number(n) + 1;
		   });
		});
		var arr = [];
		$('input.repeatable_id:text').each(function(){ arr.push($(this).val()); }); 
		clone.find('input.repeatable_id').val(Number(Math.max.apply( Math, arr )) + 1);
		if (!!$.prototype.chosen) {
			clone.find('select.chosen')
				.chosen({allow_single_deselect: true});
		}
		return false;
	});
	
	$('.rg-media_repeatable_remove').live('click', function(){
		$(this).closest('tr').remove();
		return false;
	});
		
	$('.rg-media_repeatable tbody').sortable({
		opacity: 0.6,
		revert: true,
		cursor: 'move',
		handle: '.hndle'
	});

	

});