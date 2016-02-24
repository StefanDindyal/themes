(function($){
$(document).ready(function(){

   var controls = [];			
   $('.social-block .instagram-info.video video').mediaelementplayer({
       alwaysShowControls: false,
       features: controls,
       pauseOtherPlayers: true,
       enableAutosize: false
   });
   $(".mejs-controls").remove();
		
});

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=270065846467161";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

window.twttr = (function (d,s,id) {
	  var t, js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return; js=d.createElement(s); js.id=id;
	  js.src="https://platform.twitter.com/widgets.js"; fjs.parentNode.insertBefore(js, fjs);
	  return window.twttr || (t = { _e: [], ready: function(f){ t._e.push(f) } });
	}(document, "script", "twitter-wjs"));

})(jQuery)
	
