(function() {
  "use strict";

  app.components.languageSelector = function(selectorID, isInSmallNav) {
    var self = this;
    self.isInSmallNav = isInSmallNav;
    self.element = $("#"+selectorID);
    if (self.element.length > 0) {    
      self.closeOnResize();
      self.element.on("toggle", self.toggle);
      self.element.on("open", self.open);
      self.element.on("close", self.close);
    }
  };

  /****** METHODS *******/

  var LanguageSelectorPrototype = app.components.languageSelector.prototype;

  LanguageSelectorPrototype.close = function(){
    var self = this;
    if (self.element.length > 0) {
      app.lib.scrolling.enableScroll();
      self.element.removeClass("show");
      app.components.pageBlocker.unblock();
    }
  };

  LanguageSelectorPrototype.open = function(){
    var self = this;
    if (self.element.length > 0) {
      app.lib.scrolling.disableScroll();
      self.element.addClass("show");
      app.components.pageBlocker.block(function(){
        self.close();
      });
    }
  };

  LanguageSelectorPrototype.toggle = function(){
    var self = this;
    if (self.element.length > 0) {
      if (self.element.hasClass("show")) {
        self.close();
      } else {
        self.open();
      }
    }
  };

  LanguageSelectorPrototype.isOpened = function(){
    var self = this;
    if (self.element.length > 0) {
      return self.element.hasClass('show');
    }
    return false;
  };

  LanguageSelectorPrototype.hasClass = function(_class){
    var self = this;
    return self.element.hasClass(_class);
  };

  LanguageSelectorPrototype.addClass = function(_class){
    var self = this;
    return self.element.addClass(_class);
  };

  LanguageSelectorPrototype.removeClass = function(_class){
    var self = this;
    return self.element.removeClass(_class);
  };

  LanguageSelectorPrototype.slideToLeft = function(_class){
    var self = this;
    return self.element.addClass('left');
  };

  LanguageSelectorPrototype.hideToRight = function(_class){
    var self = this;
    return self.element.removeClass('left');
  };

  LanguageSelectorPrototype.closeOnResize = function() {
    var self = this;
    if (!self.isInSmallNav) {
      $(window).resize(function(event) {
        if(self.isOpened()){
          self.close();
        }
      });
    }
  };



})();
