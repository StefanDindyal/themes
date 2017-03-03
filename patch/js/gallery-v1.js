!(function($){

	var gallery = $('.gallery-contents');
	var isGallery = gallery.length;

	if(isGallery){

		$('.ico.tile').on('click', function(){
			gallery.removeClass('listed');
			app.templates.gallery.init();
		});

		$('.ico.list').on('click', function(){
			gallery.addClass('listed');			
			app.templates.gallery.init();
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

		$(document).on('click', '.info-it', function(e){	
			var it = $(this);
			var href = it.attr('data-perm');
			var path = getLocation(href).pathname;
			var state = path.split('/').pop();
			var frame = $('<iframe id="frameDemo" src="'+href+'" frameborder="0"/>');
			$('body').append(frame);
			$('#campaign').addClass('show');
			window.history.pushState({a: state}, '', path);		
		});

		$(document).on('click', '.demo-it', function(e){
			var href = location.href;
			var it = $(this);
			var code = it.attr('data-code');
			var state = 'demo';			
			var frame = $('<iframe id="frameDemo" frameborder="0"/>');
			$('body').append(frame);
			var iframe = $('#frameDemo');
			iframe.contents().find('body').append(code);		
			window.history.pushState({a: state}, '', '#demo');		
		});

		window.onpopstate = function(event) {
			if(event.state.a == 'gallery'){
				$('#frameDemo').remove();				
			}			
		}

		var path = location.pathname;		
		var state = path.split('/').pop();
		window.history.replaceState({a: 'gallery'}, '', path);

		// window.history.pushState("object or string", "Title", "/new-url");

	}

})(jQuery);