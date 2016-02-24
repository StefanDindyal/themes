(function($){
	var contains = function(needle) {
	    // Per spec, the way to identify NaN is that it is not equal to itself
	    var findNaN = needle !== needle;
	    var indexOf;

	    if(!findNaN && typeof Array.prototype.indexOf === 'function') {
	        indexOf = Array.prototype.indexOf;
	    } else {
	        indexOf = function(needle) {
	            var i = -1, index = -1;

	            for(i = 0; i < this.length; i++) {
	                var item = this[i];

	                if((findNaN && item !== item) || item === needle) {
	                    index = i;
	                    break;
	                }
	            }

	            return index;
	        };
	    }

	    return indexOf.call(this, needle) > -1;
	};

	var scrollPos;

	var statesIn = Array();
	$.each($('.under ul li'), function(){
		var state = $(this).attr('data-id');
		statesIn.push(state);
	});

	console.log(statesIn);

	populate('all', false);

	$('#usMap').usmap({
		showLabels: false,
		stateStyles: {
			'stroke-width': 0.5,
			'stroke': '#1c1c1c',
			'fill': '#464648',
			'stroke-linejoin': 'inherit'
		},
		stateSpecificStyles: mapColor,
		stateSpecificHoverStyles: mapColor,
		stateHoverStyles: {fill: '#666'},
		stateHoverAnimation: 300,
		click: function(event, data) {
			// Output the abbreviation of the state name to the console
			var name = data.name;
			name = name.toLowerCase();
			var index = contains.call(statesIn, name);
			if(index){
				console.log('ok');
				$('.drop').addClass('down');
				$('.drop .under li[data-id="'+name+'"]').trigger('click');
			} else {
				return false;
			}
		}
	});

	$('#nav a').on('click', function(e){
		if($(window).width() <= 768){
			$('#hamburger').removeClass('down');
			$('.mobile').slideUp(300);
			$('body').removeClass('clip');
			$(window).scrollTop(scrollPos);
		}
		var elem = $(this).attr('href');
		var destination;
		if(elem == '#home'){
			destination = 0;
		} else {
			destination = $(elem).offset().top;
			destination = destination - 65;
		}		
		var timer = 500;		
		$('html, body').animate({ scrollTop: destination }, timer);
		e.preventDefault();
	});

	$('#feature .hero .copy .inner .cta a').on('click', function(e){
		var href = $(this).attr('href');
		if(href == '#about' || href == '#properties' || href == '#principals' || href == '#contact'){
			var elem = $(this).attr('href');
			var destination;
			if(elem == '#home'){
				destination = 0;
			} else {
				destination = $(elem).offset().top;
				destination = destination - 65;
			}		
			var timer = 500;		
			$('html, body').animate({ scrollTop: destination }, timer);
			e.preventDefault();
		} else {
			return true;
		}		
	});

	$('.drop').on('click',function(e){
		var me = $(this);
		if(me.hasClass('down')){
			me.find('.under').slideUp(300, function(){
				$('.drop .under ul').perfectScrollbar('destroy');
			});
			me.removeClass('down');			
		} else {
			me.find('.under').slideDown(300, function(){
				$('.drop .under ul').perfectScrollbar();
			});
			me.addClass('down');			
		}		
		e.preventDefault();
	});
	$('.drop .under li').on('click', function(e){
		var span = $('.drop span');
		var drop = $('.drop');
		var name = $(this).text();
		var state = $(this).attr('data-id');
		span.text(name).attr('data-state', state);
		drop.addClass('selected');
		if($('.view').hasClass('grid')){
			populate(state, true);
		} else {
			populate(state, false);
		}
		e.preventDefault();
	});

	$('.prop').live('click', function(e){
		var me = $(this);
		var content = me.attr('data-content');
		var limg = me.attr('data-limg');
		var units = me.attr('data-units');
		var city = me.attr('data-city');
		var state = me.attr('data-state');
		var title = me.attr('data-title');
		var str = '<div class="lightbox" style="background-image: url('+limg+');"><div class="close"></div><div class="grad"></div><div class="contents"><div class="left"><h2>'+title+'</h2><p>'+city+', '+state+'</p></div><div class="right"><p>'+content+'<span>|</span>'+units+' Units</p></div></div></div>';
		$('body').append(str);
		$('.lightbox').fadeIn(300);
		scrollPos = $(window).scrollTop();
		$('body').addClass('clip');	
		e.preventDefault();
	});

	$('.lightbox .close').live('click', function(e){
		$('.lightbox').fadeOut(300, function(){
			$('body').removeClass('clip');
			$('.lightbox').remove();
			$(window).scrollTop(scrollPos);
		});
		e.preventDefault();
	});

	$('.view').on('click', function(e){
		if($(this).hasClass('usa')){
			$(this).removeClass('usa');
			$(this).addClass('grid');			
			populate($('.drop span').attr('data-state'),true);
			$('#usMap').fadeIn(300);
		} else {
			$(this).removeClass('grid');
			$(this).addClass('usa');
			populate($('.drop span').attr('data-state'));
			$('#usMap').fadeOut(300);		
		}
		e.preventDefault();
	});

	// Submit Form
	$('form').submit(function(e){
		var self = $(this),
			resp = self.find('.resp'),
			nonce = self.attr("data-nonce"),
			name = self.find('input[name="your_full_name"]').val(),
			email = self.find('input[name="your_email_address"]').val(),			
			msg = self.find('textarea[name="message"]').val();

		if(name == '' || email == '' || msg == ''){
			resp.html('<div class="code">Missing content. Please fill out the form.</div>').show();
			return false;
		} else {
			if(!isValidEmailAddress(email)){
				resp.html('<div class="code">Please enter a proper email.</div>').show();
				return false;
			} else {

				$.ajax({ 
					type: 'POST',
					url: myAjax.ajaxurl, 
					data: {
						action: 'mid_submit',
			        	nonce: nonce,			        	
			        	name: name,
			        	email: email,			        	
			        	msg: msg			     
					},
					success: function(response){
						if(response === '1'){
							self.find('.inner').hide();
							resp.html('<div class="code">Thank you for your inquery.</div>').show();
						}
						$('.btn.again').on('click', function(e){
							resp.empty().hide();
							self.find('input[type="text"], textarea, select').val('');
							self.find('.inner').show();
							e.preventDefault();
						});
					}	        
			    });
				
			}
		}		

	    e.preventDefault();
	});	

	if($(window).width() <= 768 ) {
		$('#hamburger').on('click', function(e){
			scrollPos = $(window).scrollTop();
			if($(this).hasClass('down')){
				$(this).removeClass('down');
				$('.mobile').slideUp(300);
				$('body').removeClass('clip');
				$(window).scrollTop(scrollPos);
			} else {
				$(this).addClass('down');
				$('.mobile').slideDown(300);
				$('body').addClass('clip');
			}
			e.preventDefault();
		});
		$('.title-strong').on('click', function(e){			
			if($(this).hasClass('open')){
				$('.title-strong').removeClass('open');
				$('#principals .contents .copy .list .inner').slideUp(300);
			} else {
				$('.title-strong').removeClass('open');
				$('#principals .contents .copy .list .inner').slideUp(300);
				$(this).addClass('open');
				$(this).next().slideDown(300);
			}
			e.preventDefault();
		});
	}

	function populate(state, map){
		var state = state;
		var list = $('#properties .list');
		var count = 0;
		list.hide();
		list.empty();
		list.append('<div id="pager"><ul class="target"></ul><div class="page_navigation"></div></div>');				
		$.each(properties, function(key, data){			
			var build = setUpProp(data);
			var dataState = data.state;		
			// console.log(data);
			if(state == null || state == 'all'){
				list.find('ul').append(build);
				count++;
			} else if(state == dataState) {
				list.find('ul').append(build);
				count++;
			}				
		});
		list.removeClass('single double triple mapView');
		if(map == true) {

			list.addClass('mapView');
			setTimeout(function(){
				$('.list #pager').perfectScrollbar();
				$('.list #pager').perfectScrollbar('update');	
			},250);
			
		} else {
			if($(window).width() > 768){
				if(count == 1){
					list.addClass('single');
				}
				if(count > 1 && count < 5){
					list.addClass('double');
				}
				if(count > 4){
					list.addClass('triple');
					$('#pager').pajinate({
						item_container_id: '.target',
						show_first_last: false,
						abort_on_small_lists: true,
						items_per_page : 12,
						num_page_links_to_display: 3		
					});			
				}
			} else {
				$('#pager').pajinate({
					item_container_id: '.target',
					show_first_last: false,
					abort_on_small_lists: true,
					items_per_page : 5,
					num_page_links_to_display: 3		
				});
			}

		}	

		list.fadeIn(300);
	}	

	function setUpProp(data){
		var data = data;
		var title = data.title;
		var city = data.city;
		var state = data.state;
		var units = data.units;
		var simg = data.simg;
		var limg = data.limg;
		var desc = data.desc;
		var str = '';
		str += '<li class="prop" data-content="'+desc+'" data-limg="'+limg+'" data-units="'+units+'" data-city="'+city+'" data-state="'+state+'" data-title="'+title+'">';
		str += '<img src="'+simg+'" alt="" border="0"/>';
		str += '<div class="grad"></div>';
		str += '<div class="content">';
		str += '<h2 class="title">'+title+'</h2>';
		str += '<div class="location">';
		str += '<span class="city">'+city+'</span>';
		str += '<span class="state">, '+state+'</span>';
		str += '</div>';
		str += '</div>';
		str += '</li>';
		return str;
	}

	function isValidEmailAddress(emailAddress){
	    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
	    return pattern.test(emailAddress);
	}
})(jQuery);