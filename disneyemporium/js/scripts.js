soundManager.url = loc+'/swfs/';
soundManager.flashVersion = 9;
soundManager.useFlashBlock = false;
soundManager.useHighPerformance = true;
soundManager.wmode = 'transparent';
soundManager.useFastPolling = true;
soundManager.useConsole = false;
soundManager.debugMode = false;
jQuery(function($){	
	if(window.location.href.indexOf("#thankyou") > -1) {
		$.fancybox({
			type:'html',
			content:'<div class="thankyou">Thank you for signing up!</div>',
			padding: 3
		});
	}			
	$('#nav .list li.products > a').on('click',function(e){
		e.preventDefault();
		var $this = $(this).parent('li');
		if($this.hasClass('down')){
			$this.removeClass('down');
			$this.find('ul').slideUp(300);
		} else {
			$this.addClass('down');
			$this.find('ul').slideDown(300);
		}
	});
	// Product Slider	
	$('.product .slider .target').each(function(){
		var i = $(this);
		if(i.find('li').length > 1){
			i.bxSlider({
				mode: 'horizontal',
				controls: false,
				useCSS: false,
				onSlideAfter: function(){
					$('li.slide iframe').remove();
				}	
			});
		}
	});
	$('.page .videos .feature a.play').on('click',function(e){
		e.preventDefault();
		var rits = $('.videos .feature .post .rits');
		var id = $(this).attr('data-video');
		var frame = '<iframe width="640" height="360" src="//www.youtube.com/embed/'+id+'?wmode=transparent&autoplay=1" frameborder="0" allowfullscreen></iframe>';
		rits.append(frame);
	});
	$('.page .videos .list a.play').on('click',function(e){
		e.preventDefault();
		var me = $(this).parents('.post').contents().clone();
		var feature = $('.videos .feature .post');
		var id = $(this).attr('data-video');
		var frame = '<iframe width="640" height="360" src="//www.youtube.com/embed/'+id+'?wmode=transparent&autoplay=1" frameborder="0" allowfullscreen></iframe>';
		if($(window).width() <= 800){
			$("html:not(:animated),body:not(:animated)").animate({scrollTop: 215}, 500);
		} else {
			$("html:not(:animated),body:not(:animated)").animate({scrollTop: 315}, 500);
		}		
		feature.hide().empty().append(me).fadeIn(300).find('.rits').append(frame);
	});
	$('#side a.newsletter').on('click',function(e){
		e.preventDefault();
		var me = $(this).parents('#header');
		$('.blur').hide();
		$('div.products .product .buy-block').removeClass('buying');
		moveInstance();
		$('.list li.products').removeClass('down');
		$('ul.sub').slideUp(300);
		$('#burger').removeClass('navopen');
		$('.mobile #nav .list').slideUp(300);
		$('#m2-cart').removeClass('cartopen');
		$('.mini-cart').slideUp(300);
		if(me.hasClass('nlopen')){
			me.removeClass('nlopen');
			$('#newsletter').slideUp(300);			
		} else {
			me.removeClass('nlopen');
			me.addClass('nlopen');
			$('#newsletter').slideDown(300);
		}		
	});
	$('#newsletter a.view').on('click',function(e){
		e.preventDefault();
		var me = $(this).parents('#header');
		if(me.hasClass('nlopen')){
			me.removeClass('nlopen');
			$('#newsletter').slideUp(300);
		} else {
			me.removeClass('nlopen');
			me.addClass('nlopen');
			$('#newsletter').slideDown(300);
		}		
	});
	$('.product a.view').on('click',function(e){
		e.preventDefault();
		var me = $(this).parents('.product');
		$('.blur').hide();
		$('div.products .product .buy-block').removeClass('buying');
		$('div.products .product').removeClass('closer');
			moveInstance();
		if(me.hasClass('looking')){
			me.removeClass('looking');
		} else {
			$('.product').removeClass('looking');
			me.addClass('looking');
		}		
	});
	if($(window).width() <= 1024){
		$('.product a.play, .news .block a.play, .single .videos a.play').on('click', function(e){
			e.preventDefault();
			var url = $(this).attr('href');
			var videoid = url.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
			var ytID = videoid[1];
			var iframe = '<iframe width="640" height="360" src="//www.youtube.com/embed/'+ytID+'" frameborder="0" allowfullscreen></iframe>';
			var parentThumb = $(this).parents('.thumb');
			var parentSlide = $(this).parents('.slide');
			var parentRits = $(this).parents('.rits');
			var parent;
			if(parentThumb.length){
				parent = parentThumb;
			} else if(parentSlide.length){
				parent = parentSlide;
			} else if(parentRits.length){
				parent = parentRits;
			}
			parent.append(iframe);
		});
	} else {
		$('.product a.play, .news .block a.play, .single .videos a.play').fancybox({
			aspectRatio : true,
			width : 853,
			height : 480,
			helpers : {
				media : {}
			},
			beforeShow : function(){
				$('.blur').hide();
				$('div.products .product').removeClass('closer');
				$('div.products .product .buy-block').removeClass('buying');
				moveInstance();
			}
		});
	}
	$('.sort h2').on('click',function(e){
		e.preventDefault();
		var me = $(this).parents('.sort');		
		if(me.hasClass('looking')){
			me.removeClass('looking');
			me.find('ul').slideUp(300);
		} else {
			me.removeClass('looking');
			me.addClass('looking');
			me.find('ul').slideDown(300);
		}		
	});	
	$('div.products .product .buy-block .buy').on('click',function(e){
		e.preventDefault();		
		var me = $(this).parents('.buy-block');
		if($(this).hasClass('sold-out')){
			return false;
		}
		if(me.hasClass('buying')){
			$('.blur').hide();
			$('div.products .product').removeClass('closer');
			me.removeClass('buying');
			me.find('.instances').hide('slide', {direction: 'right'}, 300);
		} else {
			$('div.products .product .buy-block').removeClass('buying');
			moveInstance();			
			me.addClass('buying');
			me.find('.instances').show('slide', {direction: 'right'}, 300);
			$('div.products .product').addClass('closer');
			$('.blur').show();
		}		
	});
	$('.blur').on('click',function(e){
		e.preventDefault();		
		$('div.products .product .buy-block').removeClass('buying');
		$('div.products .product').removeClass('closer');
		moveInstance();
		$('.blur').hide();		
	});
	$('.closer .hold').live('click',function(e){
		e.preventDefault();				
		$('div.products .product .buy-block').removeClass('buying');
		$('div.products .product').removeClass('closer');
		moveInstance();
		$('.blur').hide();		
	});
	$('.single .commenter').on('click', function(e){
		e.preventDefault();
		var dest = $('#comment').offset().top;
		$("html:not(:animated),body:not(:animated)").animate({scrollTop: dest}, 500);
	});
	$('#cart-container .icon').live('click',function(e){
		e.preventDefault();
		$('.blur').hide();
		$('div.products .product .buy-block').removeClass('buying');
		moveInstance();
		$('.list li.products').removeClass('down');
		$('ul.sub').slideUp(300);
		$('#burger').removeClass('navopen');
		$('.mobile #nav .list').slideUp(300);
		$('#newsletter').slideUp(300);
		$('#header').removeClass('nlopen');
		if($('#m2-cart').hasClass('cartopen')){
			$('#m2-cart').removeClass('cartopen');
			$('#m2-cart').find('.mini-cart').slideUp(300);
		} else {						
			$('#m2-cart').addClass('cartopen');
			$('#m2-cart').find('.mini-cart').slideDown(300);
		}		
	});
	$('#burger').live('click',function(e){
		e.preventDefault();
		$('.blur').hide();
		$('div.products .product .buy-block').removeClass('buying');
		moveInstance();
		$('.list li.products').removeClass('down');
		$('ul.sub').slideUp(300);
		$('#newsletter').slideUp(300);
		$('#header').removeClass('nlopen');
		$('#m2-cart').removeClass('cartopen');
		$('.mini-cart').slideUp(300);
		if($('#burger').hasClass('navopen')){
			$('#burger').removeClass('navopen');
			$('.mobile #nav .list').slideUp(300);			
		} else {						
			$('#burger').addClass('navopen');
			$('.mobile #nav .list').slideDown(300);
		}		
	});	

	$('.share a.window').live('click', function(e){
		e.preventDefault();		
		var url = $(this).attr('href');
		var name = 'sharer';
		var settings = 'toolbar=0,status=0,width=580,height=325';
		window.open(url,name,settings);
	});	

	var opts = {
	  lines: 17, // The number of lines to draw
	  length: 28, // The length of each line
	  width: 14, // The line thickness
	  radius: 57, // The radius of the inner circle
	  corners: 1, // Corner roundness (0..1)
	  rotate: 18, // The rotation offset
	  direction: 1, // 1: clockwise, -1: counterclockwise
	  color: ['#f91609','#ffffff'], // #rgb or #rrggbb or array of colors
	  speed: 0.8, // Rounds per second
	  trail: 73, // Afterglow percentage
	  shadow: false, // Whether to render a shadow
	  hwaccel: false, // Whether to use hardware acceleration
	  className: 'spinner', // The CSS class to assign to the spinner
	  zIndex: 2e9, // The z-index (defaults to 2000000000)
	  top: '50%', // Top position relative to parent
	  left: '50%' // Left position relative to parent
	};
	var target = document.getElementById('loader');
	var spinner = new Spinner(opts).spin(target);
	var current = null;
	if($('.single .social.music .hold').length){
	$('.social.music .hold').each(function(){
		var list = $(this).find('ul.tracks');
		var sc_url = $(this).attr('data-url');		
		soundManager.onready(function() {		
			var consumer_key = "08a753e12396eb6afcff3167f17ca1e4",
				url = sc_url;
			$.getJSON('http://api.soundcloud.com/resolve?url=' + url + '&format=json&consumer_key=' + consumer_key + '&callback=?', function(playlist){
				if(playlist.kind == 'playlist'){
					$.each(playlist.tracks, function(index, track) {
						var time = millisToMinutesAndSeconds(track.duration);
						var title = track.title;
						var num = index+1;
						if(title.indexOf('-') === -1){
							title = title;							
						} else {
							title = title.split('-');
							title = title[1];
						}
						if($('.sound.yes-vid').length){
							if(title.length > 15){
								title = title.substr(0, 15)+' ... ';	
							} else {
								title = title;
							}						
						} else {
							title = title;
						}						
						$('<li><span>'+num+'</span>' + title + '</li>').data('track', {track:'track_'+track.id}).appendTo(list);
						url = track.stream_url;
						(url.indexOf("secret_token") == -1) ? url = url + '?' : url = url + '&';
						url = url + 'consumer_key=' + consumer_key;
						soundManager.createSound({
							id: 'track_' + track.id,
							url: url,
							onplay: function() {$('.sound .social.music').addClass('playing');},
							onresume: function() {$('.sound .social.music').addClass('playing');},
							onpause: function() {$('.sound .social.music').removeClass('playing');},
							onfinish: function() { nextTrack(); },
							whileplaying: function() {								
								// var when = this.duration;
								// var where = this.position;
								// var progress = (where/when) * 100;
								// $('.buffer').css({'width':progress+'%'});
							}		
						});					
					});
				}
				if(playlist.kind == 'track'){
					var time = millisToMinutesAndSeconds(playlist.duration);
					var title = playlist.title;
					if(title.indexOf('-') === -1){
						title = title;							
					} else {
						title = title.split('-');
						title = title[1];
					}
					if($('.sound.yes-vid').length){
						if(title.length > 15){
							title = title.substr(0, 15)+' ... ';	
						} else {
							title = title;
						}						
					} else {
						title = title;
					}
					$('<li>' + title + '</li>').data('track', {track:'track_'+playlist.id}).appendTo(list);
					url = playlist.stream_url;
					(url.indexOf("secret_token") == -1) ? url = url + '?' : url = url + '&';
					url = url + 'consumer_key=' + consumer_key;
					soundManager.createSound({
						id: 'track_' + playlist.id,
						url: url,
						onplay: function() {$('.sound .social.music').addClass('playing');},
						onresume: function() {$('.sound .social.music').addClass('playing');},
						onpause: function() {$('.sound .social.music').removeClass('playing');},
						onfinish: function() { },
						whileplaying: function() {
							// var when = this.duration;
							// var where = this.position;
							// var progress = (where/when) * 100;
							// $('.buffer').css({'width':progress+'%'});
						}		
					});					
				}
			}).always(function(){
				$('.sound .social.music .hold ul.tracks li:odd').addClass('odd');
				$('.sound .social.music .hold ul.tracks').bxSlider({
					nextSelector: '.social.music .controls a.right',
  					prevSelector: '.social.music .controls a.left',
  					nextText: '5',
  					prevText: '6',
					mode : 'vertical',
					pager : false,
					useCSS : false,
					minSlides : 5,
					maxSlides : 5,
					infiniteLoop : false,
					hideControlOnEnd : true
				});
			});
			var nextTrack = function(){
				soundManager.stopAll();
				var $track = $('.tracks li.playing').next(),
					id = $track.data("track").track;				
				if($track.length){
					$('.tracks li').removeClass('playing');
					$track.addClass('playing');
					soundManager.play(id);
					current = $('.tracks').find('.playing');
				} else {
					$('.tracks li').removeClass('playing');
					soundManager.stopAll();
				}				
			}
		});
	});
	}	
	$('.tracks li').live('click',function(){
		var $track = $(this),
			id = $track.data("track").track,
			playing = $track.is('.playing');		
		if (playing) {
			soundManager.pause(id);
			$('.tracks li').removeClass('playing');
			$('.sound .social.music .controls a.start span.in > span').text('g');
		} else {
			if ($('.tracks li').hasClass('playing')){ 
				$('.tracks li').removeClass('playing');
				soundManager.stopAll(); 
			}
			$('.sound .social.music .controls a.start span.in > span').text('h');		
			$(this).addClass('playing');
			soundManager.play(id);
			current = $('.tracks').find('.playing');
		}		
	});
	$('.sound .social.music .controls a.start').live('click',function(e){
		e.preventDefault();
		if(current == null){
			var $track = $('.sound .social.music .hold ul.tracks li').first();			
		} else {
			var $track = current;
		}
		console.log(current);
		var id = $track.data("track").track;		
		if ($('.tracks li').hasClass('playing')) {
			soundManager.pause(id);
			$('.tracks li').removeClass('playing');
			$('.sound .social.music .controls a.start span.in > span').text('g');
		} else {
			if ($('.tracks li').hasClass('playing')){ 
				$('.tracks li').removeClass('playing');
				soundManager.stopAll(); 
			}			
			$('.sound .social.music .controls a.start span.in > span').text('h');
			$track.addClass('playing');
			soundManager.play(id);
			current = $('.tracks').find('.playing');
		}		
	});	
	function millisToMinutesAndSeconds(millis) {
	  var minutes = Math.floor(millis / 60000);
	  var seconds = ((millis % 60000) / 1000).toFixed(0);
	  return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
	}
	function getParameterByName(name){
	  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
	  var regexS = "[\\?&]" + name + "=([^&#]*)";
	  var regex = new RegExp(regexS);
	  var results = regex.exec(window.location.search);
	  if (results == null)
	    return "";
	  else
	    return decodeURIComponent(results[1].replace(/\+/g, " "));
	}
	
	var mainSlider, instagramFeed;
	$(window).load(function(){
		$('.zone.sub').css('height','auto');
		$('.zone.sub #homeSlider').css({'max-height':'auto'});		
		$('.instagram .hold').css({'max-height':'auto'});		
		$('.instagram .hold .image').css({'opacity':1});		
		// Main Slider
		if($('#homeSlider .slide').length){
			mainSlider = $('#homeSlider').bxSlider({			
		    		useCSS: false,
		    		controls: false,
		    		pagerCustom: '#subSlider'
				});
		}		
		$('#subSlider .controls .left').on('click',function(e){
			e.preventDefault();
			mainSlider.goToPrevSlide();
		});
		$('#subSlider .controls .right').on('click',function(e){
			e.preventDefault();
			mainSlider.goToNextSlide();
		});
		if($('#subSlider .slide').length <= 1){
			$('#subSlider .controls').hide();
		}
		instagramFeed = $('.instagram .social-block').bxSlider({		
			slideWidth: 298,
    		minSlides: 2,
    		maxSlides: 3,
    		useCSS: false,
    		controls: false,
    		pager: false,
    		onSliderLoad: function(){    			
    		}
		});
		$('.instagram .controls .left').on('click',function(e){
		e.preventDefault();
		instagramFeed.goToPrevSlide();
		});
		$('.instagram .controls .right').on('click',function(e){
			e.preventDefault();
			instagramFeed.goToNextSlide();
		});
		moveCart(mainSlider,instagramFeed);			
		$(".scroll").mCustomScrollbar({
			setLeft : 0,
			scrollInertia: 2500,
			mouseWheel: true
		});	
	});	
	// Mobile	
	$(window).resize(function(){	
		moveCart(mainSlider,instagramFeed);
	});
	function moveCart(mainSlider,instagramFeed){
		var onMobile,
			placed;
		if($(window).width() <= 800){
			onMobile = true;
		} else {
			onMobile = false;
		}
		if($('.mobile #cart-container').length){
			placed = true;			
		} else {
			placed = false;
		}
		if(onMobile == true && placed == false){			
			$('.mobile li.carthold').append($('#cart-container'));
			if($('#homeSlider .slide').length){
				mainSlider.reloadSlider({
					useCSS: false,
	    			controls: false,
	    			adaptiveHeight: true  			
				});
			}
			if($('.instagram .social-block').length){
				instagramFeed.reloadSlider({
		    		useCSS: false,
		    		controls: false,
		    		pager: false
				});
			}
		} else if(onMobile == false && placed == true) {			
			$('.desk li.carthold').append($('#cart-container'));
			if($('#homeSlider .slide').length){
				mainSlider.reloadSlider({
					useCSS: false,
	    			controls: false,
	    			pagerCustom: '#subSlider'
				});
			}
			if($('.instagram .social-block').length){
				instagramFeed.reloadSlider({
					slideWidth: 298,
		    		minSlides: 2,
		    		maxSlides: 3,
		    		useCSS: false,
		    		controls: false,
		    		pager: false
				});
			}
		}
	}
	function moveInstance() {
		$('.instances').hide('slide', {direction: 'right'}, 300);
	}
});