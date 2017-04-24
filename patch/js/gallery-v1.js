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
			var frame = '<iframe id="frameDemo" class="infoit" src="'+href+'" frameborder="0" scrolling="yes"/>';
			if($(window).width() < 1024){				
				clearDown();
				$('body').append(frame);
				$('body').append('<div id="demoOverlay"></div>');
				$('body').append('<div id="closegal">Back</div>');
				// window.history.pushState({a: state}, '', path);
			} else {
				location.href = href;
			}
		});

		$(document).on('click', '.demo-it', function(e){
			var href = location.href;
			var it = $(this);
			var code = it.attr('data-code');
			var state = 'demo';
			var frame = '<iframe id="frameDemo" class="demoit" src="'+code+'" frameborder="0" scrolling="yes"/>';
			clearDown();
			$('body').append(frame);
			$('body').append('<div id="demoOverlay"></div>');
			$('body').append('<div id="closegal">Close Demo</div>');
			// window.history.pushState({a: state}, '', '#demo');
		});

		$(document).on('click', '.filter-view .ico', function(e){
			$('.filter-view .ico').removeClass('active');
			$(this).addClass('active');		
		});

		$(document).on('click', '.filter-view .reset', function(e){
			$('.filter-view .ico').removeClass('active');
		});

		$(document).on('click', '#closegal', function(e){
			clearDown();
		});

		window.onpopstate = function(event) {
			if(event.state.a == 'gallery'){
				clearDown();
			}			
		}

		function clearDown(){
			$('#closegal').remove();
			$('#frameDemo').remove();
			$('#demoOverlay').remove();
			$('body > div').each(function(){
				var me = $(this);
				if(me.is('[id="sky"]') || me.is('[id="wpadminbar"]')){
					
				} else {
					me.remove();
				}
			});
			$('body').attr('style', '');
		}

		var path = location.pathname;		
		var state = path.split('/').pop();
		window.history.replaceState({a: 'gallery'}, '', path);

		// window.history.pushState("object or string", "Title", "/new-url");

	}

})(jQuery);