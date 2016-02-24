// Author: rGenerator

//Script for Analytics
<!--//--><![CDATA[//><!--
var _rgdataLayer=[]; 
if(window.location.hash == '#thankyou') {_rgdataLayer.push({'formType':'Newsletter','formAction': 'Submitted'})}; 
if(window.location.hash == '#block') {_rgdataLayer.push({'formType':'Newsletter','formAction': 'Geo Blocked'})};
_rgdataLayer.push({'cust01':'19814.disney.fc.myplaydirectcrm.com'});
(function() {
    var e = document.createElement("script");
    e.type = "text/javascript"; e.async = true;
    e.src = "http" + (document.location.protocol === "https:" ? "s://ssl" : "://") + "tag.myplay.com/t/a/19814.disney.fc.myplaydirectcrm.com";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(e, s);
  })();
//--><!]]>

//Form relevant JS Variables
var signupValidationRequiredMessages=  { email: 'Please enter your email address', dob: 'Enter your Birth Date'};
var signupValidationInvalidMessages=  { first_name: 'Enter your First Name', last_name: 'Enter your Last Name', email: 'Please enter your email address', dob: 'Enter your Birth Date'};

//client side validation
var version=Math.floor(Math.random()*1001);
var fr=document.createElement('script');
fr.setAttribute("type","text/javascript");
fr.setAttribute("src", "//fcmedia.myplayd2c.com/common/js/sFC.js?vr="+version);
if (typeof fr!="undefined") {
	document.getElementsByTagName("head")[0].appendChild(fr);
}

jQuery(function($){	
	if(window.location.href.indexOf("#thankyou") > -1) {
		$('.real').hide();
		$('.thankyou .txt').show();
		$.fancybox({
			type : 'inline',
			href : '#nl_form',
			padding : 0,
			margin : 0,
			tpl : {
				closeBtn : '<a title="Close" class="fancybox-item fancybox-close spec" href="javascript:;"></a>'
			}
		});
	}		
	
	$("a.tab").fancybox({
		padding : 0,
		margin : 0,
		tpl : {
			closeBtn : ''
		}
	});

	var slider2 = $('.post[data-id="tab-2"] .entry-thumbnail .target').bxSlider({controls:false}),
	slider3 = $('.post[data-id="tab-3"] .entry-thumbnail .target').bxSlider({controls:false}),
	slider4 = $('.post[data-id="tab-4"] .entry-thumbnail .target').bxSlider({controls:false});
	
	$('#tabs li').on('click', function(e){
		e.preventDefault();
		var id = $(this).prop('id');		
		$('#tabs li').removeClass('active');
		$(this).addClass('active');
		$('#discography .post').hide();
		$('#discography .post[data-id="'+id+'"]').fadeIn(300);			
		if($('.post[data-id="tab-2"] .entry-thumbnail .target').length){slider2.reloadSlider();}
		if($('.post[data-id="tab-3"] .entry-thumbnail .target').length){slider3.reloadSlider();}
		if($('.post[data-id="tab-4"] .entry-thumbnail .target').length){slider4.reloadSlider();}		
	});
	$('#selector select').on('change', function(e){
		e.preventDefault();
		var id = $(this).val();
		$('#discography .post').hide();
		$('#discography .post[data-id="'+id+'"]').fadeIn(300);
		if($('.post[data-id="tab-2"] .entry-thumbnail .target').length){slider2.reloadSlider();}
		if($('.post[data-id="tab-3"] .entry-thumbnail .target').length){slider3.reloadSlider();}
		if($('.post[data-id="tab-4"] .entry-thumbnail .target').length){slider4.reloadSlider();}	
	});

	$(window).load(function(){				
		if($(window).width() <= 800){
			
		} else {			
			$(".scroll").mCustomScrollbar({
				setLeft : 0,
				scrollInertia: 1000
			});	
		}		
		$("a.lb").fancybox({
			width       : 853,
		    height      : 580,
		    aspectRatio : true,
		    scrolling   : 'no',
		    padding : 0,
		    margin : 0,
			helpers : {
				media : {}
			},
			iframe : {
				scrolling : 'no'
			}
		});
		slider2.reloadSlider();
	});
	
	$('.custom-close').live('click', function(e){
		e.preventDefault();
		$.fancybox.close();
	});
	$('#form form[name="pinsubmit"]').on('submit', function(e){
		e.preventDefault();		
		if($('input[name="d24pin"]').val() == 'First 4 numbers of your Disney VISA Card'){
			$.fancybox({
				minWidth : 300,
				padding : 0,
				margin : 0,
				type : 'html',
				tpl : {
					closeBtn : ''
				},
				content : '<div class="notify">Please enter your pin <a href="#" class="custom-close hidetext">Close me</a></div>',
				afterClose : function (){
					$('input[name="d24pin"]').focus();
				}
			});			
		} else {
			submitAjax();
		}
	});
	function submitAjax(){
		var email = $('input[name="d24pin"]').val();
		var send = encodeURIComponent(email);
		var string = 'd24pin='+send;
		$.ajax({
			type: 'POST',
			url: '/d24/validate',
			data: string
		}).done(function(data){
			var status = data.status,
				url = data.url;
			if(status == 'valid'){
				window.location.href = url;			
			} else {
				$.fancybox({
					minWidth : 300,
					padding : 0,
					margin : 0,
					type : 'html',					
					tpl : {
						closeBtn : ''
					},
					content : '<div class="notify">Please enter the correct pin code <a href="#" class="custom-close hidetext">Close me</a></div>',
					afterClose : function (){
						$('input[name="d24pin"]').val('').focus();
					}
				});								
			}
		});
	}	
});