(function() {
    'use strict';

    var pageBlocker;

    function init() {
        pageBlocker = $(".page-blocker");
    }
    
    function self() {
        return pageBlocker;
    }

    function block(onClick) {
        if (pageBlocker) {
            pageBlocker.addClass('show');
            if (onClick) {
                setClickEvent(onClick);
            }
        }
    }

    function unblock() {
        if(pageBlocker){
            pageBlocker.removeClass('show');
        }
    }

    function setClickEvent(onClick) {
        if (onClick && pageBlocker) {
            pageBlocker.click(function(event) {
                onClick();
            });
        }
    }

    app.components.pageBlocker = {
        init: init,
        self: self,
        block: block,
        unblock: unblock,
    };
})();
