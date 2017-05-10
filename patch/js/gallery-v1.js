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
			// var frame = '<iframe id="frameDemo" class="infoit" src="'+href+'" frameborder="0" scrolling="yes"/>';
			// if($(window).width() < 1024){				
			// 	clearDown();
			// 	$('body').append(frame);
			// 	$('body').append('<div id="demoOverlay"></div>');
			// 	$('body').append('<div id="closegal">Back</div>');				
			// } else {
			// 	location.href = href;
			// }
			location.href = href;
		});

		$(document).on('click', '.demo-it', function(e){
			var href = location.href;
			var it = $(this);
			var code = it.attr('data-code');
			var state = 'demo';
			var kind = it.parents('.gallery-post').find('.product.info-it').text();
			kind = kind.replace(/\s/g,'').toLowerCase();
			console.log(kind);
			clearDown();			
			if(code.indexOf('uploads') !== -1){
				var frame = '<div id="overAll"><iframe id="frameDemo" class="demoit" frameborder="0"/></div>';
				var codeLower = code.toLowerCase(), mod = 'allow-same-origin allow-scripts';
				if(codeLower.includes('tchibo')){
					// mod = 'allow-scripts';
				}
				if(codeLower.includes('verizon')){
					// mod = 'allow-scripts';
				}
				var pend = '<style type="text/css">body{margin:0;}body>div{top: 0!important;}iframe{display:block;width:100%;height:100%;}</style><iframe src="'+code+'" frameborder="0" scrolling="yes" sandbox="'+mod+'"/>';
				$('body').append(frame);
				$('#frameDemo').ready(function() {
			    	$('#frameDemo').contents().find("body").append(pend);
			    });
				$('body').append('<div id="demoOverlay"></div>');
			} else {
				var frame = '<div id="overAll"><iframe id="frameDemo" class="demoit" frameborder="0"/></div>';
				var pend = '<style type="text/css">body{margin:0;}body>div{top: 0!important;}iframe{display:block;width:100%;height:100%;}</style><iframe src="'+code+'" frameborder="0" scrolling="yes" sandbox="allow-same-origin allow-scripts"/>';
				$('body').append(frame);
				$('#frameDemo').ready(function() {
			    	$('#frameDemo').contents().find("body").append(pend);
			    });
				$('body').append('<div id="demoOverlay" class="opaque"></div>');
			}
			if(kind == 'expandableteaser' || kind == 'expandableadhesion'){
				$('body').append('<div id="closegal" class="band">close X</div>');
			} else {
				$('body').append('<div id="closegal">X</div>');
			}			
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
			$('#overAll').remove();
			$('#demoOverlay').remove();
			$('body > div').each(function(){
				var me = $(this);
				if(me.is('[id="sky"]') || me.is('[id="wpadminbar"]')){
					
				} else {
					me.remove();
				}
			});
			$('body').attr('style', '');
			$('html').attr('style', '');
		}		

		// window.history.pushState("object or string", "Title", "/new-url");

	}

})($);