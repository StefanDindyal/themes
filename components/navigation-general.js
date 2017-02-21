// This js file helps controlling both nav bars at the same time.
(function() {
    var initialized = $.Deferred();

    var navigationBig;
    var navigationSmall;

    // this class indicates which modules are going to change the nav bar to the clear
    // version automatically through the waypoints.
    var clearNavClass = "clearNav";

    // this class indicates which modules are going to change the nav bar to the clear
    // version but manually.
    var clearNavClassOnRequest = "clearNavOnRequest";

    var clearVersionActive = false; // indicates if the clearVersion is active

    function init() {
        
        // Waits for both navs to be initialized
        $.when(app.components.navigation.get(), app.components.navigationSmall.get()).done(function() {
            navigationBig = app.components.navigation;
            navigationSmall = app.components.navigationSmall;
            createWaypoints();
            initialized.resolve();
        });
   
    }

    var get = function() {
        var navigationGeneralComponent = this;
        return $.Deferred(function(def) {
            $.when(initialized).done(function() {
                def.resolve(navigationGeneralComponent);
            });
        });
    };

    function setClearNav() {
        if (!clearVersionActive) {
            clearVersionActive = true;

            // Big Nav
            if (navigationBig) {
                app.components.pageBlocker.self().addClass(clearNavClass);
                navigationBig.closeSearchComponent();
                navigationBig.getSearchComponent().addClass(clearNavClass);
                navigationBig.getLanguageSelector().addClass(clearNavClass);
                navigationBig.addClass(clearNavClass);
            }
            // Small Nav
            navigationSmall.addClass(clearNavClass);
        }
    }

    function setGreenNav() {
        if (clearVersionActive) {
            clearVersionActive = false;

            // Big Nav
            if (navigationBig) {
                app.components.pageBlocker.self().removeClass(clearNavClass);
                navigationBig.closeSearchComponent();
                navigationBig.removeClass(clearNavClass);
                navigationBig.getSearchComponent().removeClass(clearNavClass);
                navigationBig.getLanguageSelector().removeClass(clearNavClass);
            }

            // Small Nav
            navigationSmall.removeClass(clearNavClass);
        }
    }

    function hasClearNavClass(jqElement) {
        if (jqElement.hasClass(clearNavClass) || jqElement.find("." + clearNavClass).size() > 0) {
            return true;
        }
        return false;
    }

    function hasClearNavClassOnRequest(jqElement) {
        if (jqElement.hasClass(clearNavClassOnRequest) || jqElement.find("." + clearNavClassOnRequest).size() > 0) {
            return true;
        }
        return false;
    }

    // this function is used for set the nav bar version manually depending on the module class
    function setNavBarVersion(jqElement) {
        if (hasClearNavClass(jqElement) || hasClearNavClassOnRequest(jqElement)) {
            setClearNav();
        } else {
            setGreenNav();
        }
    }

    function showDefaultNav() {
        setGreenNav();
    }

    function getMenuHeight(){
        if(app.lib.breakpoint.isLarge()){
            return navigationBig.getHeight();
        }else{
            return navigationSmall.getHeight();
        }
    }

    // Creates the waypoints to change the navigation automatically. Each time the "clearNav" class is found,
    // adds a woypoints on the start and end of the div containing the class. When "clearMav" is found sets the nav bar
    // to the clear version and when the div passes, sets the nav bar to the green version
    function createWaypoints() {
        var clearNavDivs = $("." + clearNavClass);
        clearNavDivs.each(function(index, el) {
            var currentEl = $(el);

            // waypoints when top of div reaches the top of the window
            new Waypoint({
                element: currentEl,
                handler: function(direction) {
                    if (direction === "down") {
                        setClearNav();
                    } else {
                        if (hasClearNavClass(currentEl.prev())) {
                            setClearNav();
                        } else {
                            setGreenNav();
                        }
                    }
                },
            });

            // waypoints when bottom of div reaches the top of the window
            new Waypoint({
                element: currentEl,
                handler: function(direction) {
                    if (direction === "down") {
                        if (!hasClearNavClass(currentEl.next())) {
                            setGreenNav();
                        }
                    } else {
                        setClearNav();
                    }
                },
                offset: function() {
                    return -this.element.context.clientHeight;
                }
            });
        });
    }
    app.components.navigationGeneral = {
        init: init,
        get: get,
        setClearNav: setClearNav,
        setGreenNav: setGreenNav,
        hasClearNavClass: hasClearNavClass,
        hasClearNavClassOnRequest: hasClearNavClassOnRequest,
        setNavBarVersion: setNavBarVersion,
        showDefaultNav: showDefaultNav,
        createWaypoints: createWaypoints,
        getMenuHeight: getMenuHeight,
    };
})();
