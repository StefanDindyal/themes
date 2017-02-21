;(function($){	

	$(window).scroll(function(){

		$('.transition').each(function(){		
			
			var current = $(this);			

			if(!current.hasClass('active') && verge.inY(current, -450)){				
			
				var split = current.find('.split');
			
				if(split.hasClass('left')){
					var degree = -45;
					var origin = "50% 0%";
				} else {
					var degree = 45;
					var origin = "50% 0%";
				}

				var elem = $(this).find('.number');
				var elemNext = $(this).find('.number.next');
				var number = elem.attr('data-number');
				var numberNext = elemNext.attr('data-number')			
				
				var rotate = TweenMax.to(split, 2, {rotation: degree, transformOrigin: origin});
				if(elem.length){
					if(number.indexOf('.') === -1){						
						counter(elem,number);
					} else {
						counter(elem,number,true);
					}						
				}
				if(elemNext.length){
					if(numberNext.indexOf('.') === -1){						
						counter(elemNext,numberNext);
					} else {
						counter(elemNext,numberNext,true);
					}
				}

				current.addClass('active');
			
			}			
		
		});		

	});

	$(window).resize(function(){
		$('.transition').each(function(){		
			
			var current = $(this).find('.copy-wrapper');

			if($(window).width() <= 1250){
				current.css('background-color', current.attr('data-color'));
			} else {
				current.css('background-color', 'transparent');
			}
		});
	});

	$('.circle-section .btn.btn-default').attr('target','_blank');

	$('.unmissable .copy-text.autoHeight .btn.btn-default').on('click', function(e){
		location.reload();
		e.preventDefault();
	});
	
	function counter(elem,number,dec){
		var counter = { var: 0 };
		var number = number * 1;
		if(number > 50){
			counter = { var: number * 0.95 };
		}
		TweenMax.to(counter, 6, {
			var: number, 
			onUpdate: function () {				
				if(dec){
					elem.html((Math.round(counter.var * 10)/10));
				} else {
					// elem.html((Math.round(counter.var * 10)/10));
					elem.html(Math.ceil(counter.var));						
				}								
			},
			onComplete: function(){
				
			},
			// delay: 1,
			ease: Quint.easeOut
		});
	}

})(jQuery);