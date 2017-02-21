(function() {
  var initialized = $.Deferred();
  var navigationDiv;
  var menuContainer;
  var collapseButton;
  var currentMenu;
  var firstSubMenu;
  var searchComponent;
  var languageSelectorComponent;
  var languageSelectorButton;
  var onResizeHandler;

  function init(searchComponentId, languageComponentId) {
    searchComponent = app.instances.SearchComponents[searchComponentId];
    languageSelectorComponent = app.instances.LanguageSelectorComponents[languageComponentId];
    navigationDiv = $("#navigationDivSmall");
    menuContainer = navigationDiv.find('.menu-container');
    collapseButton = navigationDiv.find('.collapse-button');
    firstSubMenu = menuContainer.find("ul:first");
    languageSelectorButton = menuContainer.find(".language-button");
    setCurrentMenu(firstSubMenu);
    setCollapseButtonEvents();
    addSubMenuButtons();
    app.lib.util.setFullHeightElements(false);
    closeOnResizeIfNotVisible();
    closeWhenLinksPressed();
    languageButtonClickEvent();
    languageBackButtonClickEvent();

    initialized.resolve();
  }

  var get = function(){
    var navigationComponent = this;
    return $.Deferred(function (def) {
      $.when(initialized).done(function () {
        def.resolve(navigationComponent);  
      });
    });  
  };

  function getHeight() {
    if (navigationDiv === undefined || navigationDiv.css('display') === "none") {
      return 0;
    } else {
      return navigationDiv.height();
    }
  }

  function show() {
    closeOnResizeIfNotVisible();
    collapseButton.addClass('opened');
    menuContainer.addClass('opened');
    searchComponent.open();
    app.lib.scrolling.hideScroll();
  }

  function hide() {
    collapseButton.removeClass('opened');
    menuContainer.removeClass('opened');
    searchComponent.close();
    resetMenu();
    app.lib.scrolling.enableScroll();
  }

  function toggle() {
    if (collapseButton.hasClass("opened")) {
      hide();
    } else {
      show();
    }
  }

  function setCollapseButtonEvents() {
    collapseButton.click(function(event) {
      toggle();
    });
  }

  function resetMenu() {
    removeCurrentAndPastElements();
    searchComponent.showLeft();
    setCurrentMenu(firstSubMenu);
    centerLanguageButton();
  }

  function removeCurrentAndPastElements() {
    if (currentMenu) {
      menuContainer.find(".past").removeClass('past');
      currentMenu.removeClass('current');
      currentMenu = undefined;
    }
  }

  function hideMenuOptions() {
    removeCurrentAndPastElements();
    rightLanguageButton();
  }

  function showMenuOptions() {
    if (!currentMenu) {
      setCurrentMenu(firstSubMenu);
      centerLanguageButton();
    }
  }

  function addSubMenuButtons() {
    // back button click event
    function backButtonClickEvent() {
      currentMenu.removeClass('current');
      var previous = $('#' + $(this).attr('data-previous-item-id')).parent(".past");
      if (previous.attr('id') === firstSubMenu.attr('id')) {
        searchComponent.showLeft();
        centerLanguageButton();
      }
      previous.removeClass('past');
      currentMenu.removeClass('current');
      previous.addClass('current');
      currentMenu = previous;
    }

    // next (>) button click event
    function nextButtonClickEvent() {
      var nextCurrent = $(this).siblings('.sub-menu');
      if (nextCurrent) {
        searchComponent.hideLeft();
        leftLanguageButton();
        setCurrentMenu(nextCurrent);
      }
    }

    var subMenus = menuContainer.find(".sub-menu");
    var liOptions = subMenus.parent("li");
    liOptions.each(function(index, liOption) {
      liOption = $(liOption);
      // adding unique ID
      var liID = 'menu-item-' + index;
      liOption.attr('id', liID);

      //inserting next button
      liOption.find("a:first").addClass('hasSubMenu'); // for styling the button
      var nextSubMenuButton = $('<button class="next-submenu"></button>');
      liOption.append(nextSubMenuButton);
      nextSubMenuButton.click(nextButtonClickEvent);

      // inserting back button
      var backButtonText = liOption.children('a:first').text();
      var backButton = $('<li class="back-button-container"><a data-previous-item-id="' + liID + '">' + backButtonText + '</a></li>');
      liOption.children('.sub-menu:first').prepend(backButton);
      backButton.children('a').click(backButtonClickEvent);
    });
  }

  function setCurrentMenu(jqUlElement, setPastElement) {
    setPastElement = (setPastElement) ? setPastElement : true;
    if (currentMenu) {
      currentMenu.removeClass('current');
      if(setPastElement){
        currentMenu.addClass('past');
      }
    }
    currentMenu = jqUlElement;
    currentMenu.addClass('current');
  }

  function closeOnResizeIfNotVisible() {
    if (!onResizeHandler) {
      onResizeHandler = function() {
        if (navigationDiv.css('display') === "none") {
          hide();
          onResizeHandler = null;
        }
      };

      $(window).resize(function(event) {
        if (onResizeHandler) {
          onResizeHandler();
        }
      });
    }
  }

  function closeWhenLinksPressed(){
    menuContainer.find("a").each(function(index, el) {
      el = $(el);
      if(el.parent().hasClass('back-button-container') === false){
        el.click(function(event) {
          hide();
        });
      }
    });
  }

  // Language Button behavior
  function leftLanguageButton(){
    languageSelectorButton.addClass('left');
    languageSelectorButton.removeClass('right');
  }

  function rightLanguageButton(){
    languageSelectorButton.addClass('right');
    languageSelectorButton.removeClass('left');
  }

  function centerLanguageButton(){
    languageSelectorButton.removeClass('right');
    languageSelectorButton.removeClass('left');
    languageSelectorComponent.removeClass('current');
  }

  function languageButtonClickEvent(){
    languageSelectorButton.click(function(event) {
      languageSelectorComponent.addClass('current');
      leftLanguageButton();
      searchComponent.hideLeft();
      currentMenu.removeClass('current');
      currentMenu.addClass('past');
      currentMenu = undefined;
    });
  }

  function languageBackButtonClickEvent(){
    // Language back button event
    languageSelectorComponent.element.find(".back-button-container a").click(function(event){
      languageSelectorComponent.removeClass('current');
      setCurrentMenu(firstSubMenu);
      centerLanguageButton();
      searchComponent.showLeft();
    });
  }

  function addClass(_class){
    navigationDiv.addClass(_class);
  }

  function removeClass(_class){
    navigationDiv.removeClass(_class);
  }

  app.components.navigationSmall = {
    init: init,
    getHeight: getHeight,
    hideMenuOptions: hideMenuOptions,
    showMenuOptions: showMenuOptions,
    addClass: addClass,
    removeClass:removeClass,
    show: show,
	get: get
  };
})();
