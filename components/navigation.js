(function(){
  "use strict";

  var initialized = $.Deferred();
  var numbers = app.lib.numbers;
  var utilsHelper = app.lib.util;

  var searchComponent;
  var languageSelector;
  var searchButton;
  var languageButton;

  var navigationDiv;
  var navigationBar;
  var liElements;
  var mainSubMenus;
  var leftFiller;
  var arrowWidth;

  function init(searchComponentId, languageSelectorId) {
    searchComponent = app.instances.SearchComponents[searchComponentId];
    languageSelector = app.instances.LanguageSelectorComponents[languageSelectorId];
    navigationDiv = $(".navigationDiv");
    navigationBar = navigationDiv.find(".navigation-bar");
    searchButton = navigationDiv.find(".search-button");
    languageButton = navigationDiv.find(".language-button");

    liElements = navigationBar.find('> li');
    mainSubMenus = navigationBar.find('> li > .sub-menu');
    setLiElements();
    leftFiller = navigationDiv.find('.background-arrow .left');
    arrowWidth = navigationDiv.find('.background-arrow .arrow').width();

    searchButtonEvent();
    languageButtonEvent();
    
    initialized.resolve();
  }

  var get = function(){
    return $.Deferred(function (def) {
      if(app.lib.browserDetection.isDesktop() === false){
        app.components.navigation = null;
        def.resolve(app.components.navigation);  
      }
      else{
        $.when(initialized).done(function () {
          def.resolve(app.components.navigation);  
        });  
      }
    });  
  };

  function getHeight(){
    return navigationDiv.height();
  }

  function setLiElements() {
    liElements.each(function(index, liElement) {
      liElement = $(liElement);
      onLiHover(liElement);
      setHasSubMenuClass(liElement);
    });
    
    // Sub Menus
    // utilsHelper.setSameHeight(mainSubMenus, false, utilsHelper.createUniqueId("sub-menus"));
    setSubmenuElementsWidth();

    // Resize
    $(window).resize(function() {
      if(navigationDiv.css("display") !== "none") // executes if the nav is visible
      {
        // sub menus
        // utilsHelper.setSameHeight(mainSubMenus, false, utilsHelper.createUniqueId("sub-menus"));
      }
    });
  }

  function setSubmenuElementsWidth(){
    mainSubMenus.each(function(index, el) {
      el = $(el);
      var children = el.children("li");
      var childrenNumber = children.size();
      if(childrenNumber > 0){
        children.css('width', (80/childrenNumber)+"%");
      }
    });
  }

  function setHasSubMenuClass(li){
    if(li.find(".sub-menu").size() > 0){
      li.addClass("has-submenu");
    }
  }

  function onLiHover(liElement) {
    var hasSubmenu = (liElement.find(".sub-menu").length > 0) ? true : false;
    liElement.hover(function() {
      liElements.addClass('remove-arrow-in-current');
      closeSearchComponent();
      closeLanguageComponent();
      if(hasSubmenu){
        navigationDiv.addClass('show-arrow');
        resizeLeftFiller($(this));
      }
    },function(){
      if(hasSubmenu){
        navigationDiv.removeClass('show-arrow');
      }
      liElements.removeClass('remove-arrow-in-current');
    });
  }

  function resizeLeftFiller(liElement){
    var liLeftOffset = liElement.offset().left;
    var liWidth = parseInt(liElement.css("width").replace("px",""));
    var newLeftFillerWidth = liLeftOffset + (liWidth/2) - (arrowWidth/2);
    leftFiller.width(newLeftFillerWidth);
  }

  function searchButtonEvent() {
    var searchButton = navigationDiv.find('.search-button');
    searchButton.click(function(event) {
      toggleSearchComponent();
    });
  }

  function languageButtonEvent() {
    languageButton.click(function(event) {
      toggleLanguageComponent();
    });
  }

  function addClass(_class){
    navigationDiv.addClass(_class);
  }

  function removeClass(_class){
    navigationDiv.removeClass(_class);
  }

  function closeSearchComponent() {
    searchComponent.close();
  }

  function closeLanguageComponent() {
    languageSelector.close();
  }

  function toggleSearchComponent() {
    if (languageSelector.hasClass("show")) {
      languageSelector.toggle();
    }
    searchComponent.toggle();
  }

  function toggleLanguageComponent() {
    if (searchComponent.hasClass("show")) {
      searchComponent.toggle();
    }
    languageSelector.toggle();
  }

  function getSearchComponent(){
    return searchComponent;
  }

  function getLanguageSelector(){
    return languageSelector;
  }

  app.components.navigation = {
    init: init,
    closeSearchComponent: closeSearchComponent,
    addClass: addClass,
    removeClass: removeClass,
    getSearchComponent:getSearchComponent,
    getLanguageSelector: getLanguageSelector,
    get: get,
    // getHeight: getHeight,
  };

})();
