(function () {
  "use strict";

  var AdMedia = function (selector, mediaType, id) {
    this.$element = $(selector);
    if(mediaType === 'devices'){
      if (this.$element.length > 0) {
        this.stoppedVideosCount = 0;
        this.$videos = this.$element.find("video");
        this.setPlayVideosWaypoint();
        this.setDeviceSectionHeight();
        app.lib.scrolling.scrollToAnchorLink();
        this.eventHandlers();
        this.isFirefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
      }
    } else if(mediaType === 'wistia'){
      this.setWistia(id);
    }
  };

  AdMedia.prototype.playVideos = function () {
    var self = this;
    var quantity = self.$videos.length;
    var interval;
    interval = setInterval(function () {
      var i = 0;
      self.$videos.each(function (){
        var videoElement = this;
        if (this.readyState > 3  || self.isFirefox) {
          i++;
        }
        if (i === quantity) {
          clearInterval(interval);
          self.$videos.each(function (){
            this.play();
          });
        }
      });
    }, 500);
  };

  AdMedia.prototype.setPlayVideosWaypoint = function(){
    var self = this;
    new Waypoint({
      element: self.$element,
      handler: function(direction) {
          if (direction === "down") {
              self.playVideos();
          }
      },
      offset: "50%"
    });
  };

  AdMedia.prototype.eventHandlers = function () {
    var self = this;
    /* When the devices images finish to load */
    self.$element.find("img").each(function () {
      $(this).load(function () {
        self.setDeviceSectionHeight();
      });
    });

    /* window resize */
    $(window).resize(function () {
      self.setDeviceSectionHeight();
    });

    /* Manual loop, in order sync videos when they end. */
    self.$videos.bind("ended", function () {
      if (self.stoppedVideosCount >= ($videos.length - 1)) {
        self.$videos.each(function() {
          this.pause();
          this.currentTime = 0;
          this.play();
        });
        self.stoppedVideosCount = -1;
      }
      self.stoppedVideosCount++;
    });
  };

   AdMedia.prototype.setDeviceSectionHeight = function () {
    var self = this;
    /* find the device element with the greater heigth */
    var height = 0;
    var $devices = self.$element.find(".device");

    $devices.each(function () {
      var $device = $(this);
      var devHeight = $device.height();
      height = (devHeight > height) ? devHeight : height;
    });
    self.$element.height(height);
  };

  AdMedia.prototype.setWistia = function(id) {
    Wistia.embed(id, {
      autoPlay: true,
      playbar: false,
      volume: 0,
      endVideoBehavior: 'loop'
    });
  };

  app.components.adMedia = AdMedia;

})();
