<?php
$settings = get_option( 'mid_options' );
$footerprivacy = $settings['mid_privacy'];
$footerrite = $settings['mid_copyrite'];
?>	
	<div id="footer">
		<div class="inner">
			<?php if($footerprivacy){ ?>
				<a href="<?php echo $footerprivacy; ?>" target="_blank">Privacy Policy</a>
			<?php } ?>
			<span class="divider">|</span>
			<?php if($footerrite){ ?>
				<span class="copyrite"><?php echo $footerrite; ?></span>
			<?php } ?>
		</div>
	</div>
</div><!-- .site -->
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB9xMn1tr9lj0Eq3pH8wZfG3bOjAyBb6s0&callback=initMap">
</script>
<script type="text/javascript">
	var marker;
	function initMap() {
		var grayscale = new google.maps.StyledMapType([{"stylers":[{"saturation":-100},{"gamma":1},{"lightness":1},{"visibility":"on"}]}]);

		var myLatLng = {lat: 40.7240178, lng: -73.9965479};

		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 15,
			center: myLatLng,
			disableDefaultUI: true,
			draggable: false,
			zoomControl: false,
			scrollwheel: false, 
			disableDoubleClickZoom: true
		});

		google.maps.event.addDomListener(window, 'resize', function() {
		    map.setCenter(myLatLng);
		});

		var pinColor = "a4a4a4";
		var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor);

		var contentString = '<div id="content">'+
	      '<div id="siteNotice">'+
	      '</div>'+
	      '<h1 id="firstHeading" class="firstHeading">Midway Investors Inc</h1>'+
	      '<div class="address">'+
	      '<div class="address-line full-width">200 Park Ave</div>'+
	      '<div class="address-line full-width">New York, NY 10003</div>'+
	      '</div>'+
	      '<div id="bodyContent">'+
	      '<a href="https://www.google.com/maps/place/Midway+Investors+Inc/@40.7369032,-73.9893798,15z/data=!4m2!3m1!1s0x0:0x942581ef6bb14934" target="_blank">'+
	      'View on Google Maps</a> '+      
	      '</div>'+
	      '</div>';

		var infowindow = new google.maps.InfoWindow({
			content: contentString
		});

		marker = new google.maps.Marker({
			position: myLatLng,
			map: map,
			animation: google.maps.Animation.DROP,
			icon: pinImage,
			title: 'Midway Investors Inc'
		});
		marker.addListener('click', function() {
	    	infowindow.open(map, marker);
		});

		map.mapTypes.set('grayscale', grayscale);
			map.setMapTypeId('grayscale');
	}
</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/us-map-1.0.1/lib/raphael.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/us-map-1.0.1/jquery.usmap.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.pajinate.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/perfect-scrollbar.jquery.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/nano.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.scrollbar.js"></script>
<?php wp_footer(); ?>
</body>
</html>
