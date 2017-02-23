!(function($){

	var gallery = $('.gallery-contents');
	var isGallery = gallery.length;

	if(isGallery){

		$('.ico.tile').on('click', function(){
			gallery.removeClass('listed');
			// $('.ico.reset').trigger('click');
			app.templates.gallery.init();
			// $('.gallery-post').each(function(){
			// 	var it = $(this).find('.gallery-post-content');
			// 	it.height($(this).height());
			// });
		});
		$('.ico.list').on('click', function(){
			gallery.addClass('listed');
			// $('.ico.reset').trigger('click');
			app.templates.gallery.init();
			// $('.gallery-post').each(function(){
			// 	var it = $(this).find('.gallery-post-content');
			// 	it.height($(this).outerHeight());
			// });
		});

		$(window).load(function(){
			setTimeout(function(){
				$('.gallery-post').off();
				$('.gallery-post-content').off();
			}, 100)				
		});

		var getLocation = function(href) {
			var l = document.createElement("a");
			l.href = href;
			return l;
		};

		// var frame = '<div id="campaign"><iframe width="100%" height="100%" src="" frameborder="0"></iframe></div>';
		// $('body').append(frame);

		$(document).on('click', '.info-it', function(e){	
			var it = $(this);
			var href = it.attr('data-perm');
			var path = getLocation(href).pathname;
			var state = path.split('/').pop();
			var frame = '<div id="campaign"><iframe width="100%" height="100%" src="'+href+'" frameborder="0"></iframe></div>';
			$('body').append(frame);
			// $('#campaign iframe').attr('src', href);
			$('#campaign').addClass('show');
			window.history.pushState({a: state}, '', path);		
		});

		$(document).on('click', '.demo-it', function(e){	
			var it = $(this);
			var code = it.attr('data-code');
			var state = 'demo';			
			var frame = '<div id="campaign"><iframe width="100%" height="100%" frameborder="0"></iframe></div>';
			$('body').append(frame);
			// $('#campaign iframe').attr('src', href);			
			var $iframe = $('#campaign iframe');
			$iframe.ready(function() {
				$iframe.contents().find("body").append(code);
				// $iframe.get(0).contentWindow.location.reload(true);
				$('#campaign').addClass('show');
			});
			// $('body').append('<div id="campaign">'+code+'</div>');
			$('#campaign').addClass('show');
			window.history.pushState({a: state}, '', '#demo');		
		});

		// $('#campaign iframe').load(function(){
		// 	if(!$('#campaign').hasClass('show') && $('#campaign iframe').attr('src') != ''){
		// 		$('#campaign').addClass('show');
		// 	}			
		// });

		window.onpopstate = function(event) {
			// console.log(event.state);
			if(event.state.a == 'gallery'){
				// console.log('gallery');
				$('#campaign').remove();
				// $('#campaign').removeClass('show');
				// $('#campaign iframe').attr('src', '');
				// $('#campaign').removeClass('show');
				// $('#campaign').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', 
				// function(){
				// 	$('#campaign iframe').attr('src', '');
				// });				
			} else {
				// console.log('campaign');
			}			
		}

		var path = location.pathname;		
		var state = path.split('/').pop();
		window.history.replaceState({a: 'gallery'}, '', path);

		// window.history.pushState("object or string", "Title", "/new-url");

	}

})(jQuery);