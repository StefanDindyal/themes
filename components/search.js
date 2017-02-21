(function() {
  "use strict";

  // var SELECTOR_ELEMENT = ".search-component";
  var SELECTOR_RESULTS_COUNT = ".results-count";
  var CLASS_NO_RESULTS = "no-results";
  var CLASS_EXPAND = "expand";
  var CLASS_LOADING = "loading";
  var SUGGESTION_CONTAINER = ".tt-menu .tt-dataset";
  var MAX_PAGES = 6;

  app.components.search = function(selectorID, isInSmallNav) {
    var self = this;
    isInSmallNav = (isInSmallNav === "1") ? true : false;
    self.element = $("#" + selectorID);

    if (self.element.length > 0) {
      self.selectorId = selectorID;
      self.isInSmallNav = isInSmallNav;
      self.results = self.element.find(".search-results");
      self.resultsInner = $(self.element.find(".search-results > .inner"));
      self.searchField = self.element.find(".search-field");
      self.setFormSubmitEvent(self.element.find("form"));
      self.closeOnResize();
      self.emptySearchOnFocus();
      self.element.on("toggle", self.toggle);
      self.element.on("open", self.open);
      self.element.on("close", self.close);
      self.resultsPerPage = (isInSmallNav) ? 3 : 4;
      self.currentSearchString = "";
      if (!isInSmallNav) {
        self.initSuggestions();
      }
    }
  };


  /****** METHODS *******/

  var SearchPrototype = app.components.search.prototype;


  SearchPrototype.close = function() {
    var self = this;
    if (self.element.length > 0) {
      self.showSiteScrollBar();
      self.element.removeClass("show");
      app.components.pageBlocker.unblock();
      self.clear();
    }
  };

  SearchPrototype.open = function() {
    var self = this;
    if (self.element.length > 0) {
      self.hideSiteScrollBar();
      self.element.addClass("show");
      app.components.pageBlocker.block(function(){
        self.close();
      });
      self.element.removeClass(CLASS_EXPAND);
      if(app.lib.browserDetection.isDesktop()){
        self.searchField.focus();
      }      
    }
  };

  SearchPrototype.toggle = function() {
    var self = this;
    if (self.element.length > 0) {
      if (self.element.hasClass("show")) {
        self.close();
      } else {
        self.open();
      }
    }
  };

  SearchPrototype.emptySearchOnFocus = function() {
    var self = this;
    self.searchField.focus(function(){
        self.clear();
        self.element.removeClass(CLASS_EXPAND);
    });
  };

  SearchPrototype.isOpened = function(){
    var self = this;
    if (self.element.length > 0) {
      return self.element.hasClass('show');
    }
    return false;
  };

  SearchPrototype.hideLeft = function() {
    var self = this;
    self.element.addClass('left');
  };
  SearchPrototype.showLeft = function() {
    var self = this;
    self.element.removeClass('left');
  };

  SearchPrototype.setFormSubmitEvent = function(jqFormElement) {
    var self = this;
    jqFormElement.on("submit", function(e) {
      e.preventDefault();
      self.currentSearchString = self.searchField.val();
      if (self.currentSearchString.length > 2) {
        self.search(self.currentSearchString, 1);
        if (self.isInSmallNav) {
          app.components.navigationSmall.hideMenuOptions();
        }
      } else if (self.currentSearchString.length === 0 && self.isInSmallNav) {
        app.components.navigationSmall.showMenuOptions();
        self.clear();
        self.element.removeClass(CLASS_EXPAND);
      }
    });
  };

  SearchPrototype.search = function(searchString, page) {
    var self = this;
    var typeahead = $(SUGGESTION_CONTAINER);
    self.element.addClass(CLASS_LOADING);


    $.get(ajaxUtil.url, {
        "nonce": ajaxUtil.nonce,
        "action": "search",
        "searchString": searchString,
        "page": page,
        "resultsPerPage": self.resultsPerPage
      },
      function(response) {
        if(__gaTracker){
          __gaTracker('send', {
            'hitType': 'pageview',
            'page': '/?s='+searchString,
            'title': 'Search Page'
          });
        }

        self.element.addClass(CLASS_EXPAND);
        if(typeahead){
          typeahead.empty();
        }

        if (response.total > 0) {
          var html;
          self.element.removeClass(CLASS_NO_RESULTS);
          html = self.genResults(response.results) + self.genPager(response.page, response.totalPage);
          self.resultsInner.html(html).promise().done(function() {
            self.pagerEvents(self);
          });
          self.results.find(SELECTOR_RESULTS_COUNT).text(response.total + " Results");

        } else {
          self.element.addClass(CLASS_NO_RESULTS);
        }
        self.element.removeClass(CLASS_LOADING);
        self.searchField.blur();
      });
  };

  SearchPrototype.clear = function() {
    var self = this;
    var typeahead = self.element.find(".typeahead");
    self.resultsInner.html("");
    self.searchField.val("");
    self.results.find(SELECTOR_RESULTS_COUNT).text("");
    self.element.removeClass(CLASS_LOADING);
    self.element.removeClass(CLASS_NO_RESULTS);
    if (typeahead) {
      self.searchField.typeahead('val', "");
    }
  };

  SearchPrototype.pagerEvents = function(self) {
    self.resultsInner.find("nav a").on("click", function(e) {
      e.preventDefault();
      if (!$(this).parent().hasClass("disabled") && !self.element.hasClass(CLASS_LOADING)) {
        var page = +$(this).attr("href");
        self.search(self.currentSearchString, page);
      }
    });

  };

  SearchPrototype.genResults = function(results) {
    var self = this;
    var html = '<table>';

    for (var i = 0; i < results.length; i++) {
      var result = results[i];
      html += '<tr><td><span>' + result.type + '</span></td><td>';
      html += '<h1>' + result.title + '</h1>';
      html += '<p>' + result.excerpt + '</p>';
      html += '<a href="' + result.permalink + '">' + result.permalink + '</a>';
      html += '</td></tr>';
    }
    html += '</table>\n\n';
    return html;
  };

  SearchPrototype.addClass = function(_class) {
    var self = this;
    self.element.addClass(_class);
  };

  SearchPrototype.hasClass = function(_class) {
    var self = this;
    return self.element.hasClass(_class);
  };

  SearchPrototype.removeClass = function(_class) {
    var self = this;
    return self.element.removeClass(_class);
  };

  SearchPrototype.closeOnResize = function() {
    var self = this;
    if (!self.isInSmallNav) {
      $(window).resize(function(event) {
        if(self.isOpened()){
          self.close();
        }
      });
    }
  };

  /* This function generates a Bootstrap paginator template */
  SearchPrototype.genPager = function(page, totalPage) {
    var self = this;
    var pageGap = Math.floor(MAX_PAGES / 2);
    var start = (page > pageGap + 1) ? page - pageGap : 1;
    var end = ((page + pageGap) < totalPage) ? page + pageGap : totalPage;

    var html = '<nav><ul class="pagination">';
    html += (page === 1) ? '<li class="disabled">' : '<li>';
    html += '<a href="' + (page - 1) + '" aria-label="Previous"><span aria-hidden="true" class="pag-arrow prev"></span></a></li>';
    for (var i = start; i <= end; i++) {
      if (i === page) {
        html += '<li class="active"><a href="#">' + i + '<span class="sr-only">(current)</span></a></li>';
      } else if (end < totalPage && i === end) {
        html += '<li><a href="' + i + '">...</a></li>';
        html += '<li><a href="' + totalPage + '">' + totalPage + '</a></li>';
      } else {
        html += '<li><a href="' + i + '">' + i + '</a></li>';
      }
    }
    html += (page === totalPage) ? '<li class="disabled">' : '<li>';
    html += '<a href="' + (page + 1) + '" aria-label="Next"><span aria-hidden="true" class="pag-arrow next"></span></a></li>';
    html += '</ul></nav>\n\n';
    return html;
  };

  SearchPrototype.initSuggestions = function () {
    var self = this;
    var typeahead = self.searchField.typeahead({
      minLength: 3,
      highlight: true,
      async: true
    },
    {
      name: 'search-suggestions',
      source: self.getSuggestions,
      display: "title",
      limit: 3,
      templates: {
        header: "<span class=\"title\">suggestions: </span>",
        suggestion: Handlebars.compile("<span class=\"suggestion\">{{title}}</span>)")
      }
    });

    // When selecting a selection trigger the search.
    typeahead.bind("typeahead:select", function ($e, datum) {
      self.search(datum.title, 1);
    });
  };

  SearchPrototype.getSuggestions = function (query, syncResults, asyncResults) {
    $.get(ajaxUtil.url, {
        "nonce": ajaxUtil.nonce,
        "action": "search_suggestions",
        "searchString": query
      },
      function(response) {
        asyncResults(response);
      });
  };

  SearchPrototype.hideSiteScrollBar = function(){
    if(app.lib.browserDetection.isMobileDevice()){
      app.lib.scrolling.hideScroll();
    }else{
      app.lib.scrolling.disableScroll();
    }
  };

  SearchPrototype.showSiteScrollBar = function(){
    if(app.lib.browserDetection.isMobileDevice()){
      app.lib.scrolling.showScroll();
    }else{
      app.lib.scrolling.enableScroll();
    }
  };
})();