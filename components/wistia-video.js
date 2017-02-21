(function() {
    "use strict";    

    function init(id, showPlayButton, playButtonContainerSelector) {
        showPlayButton = (showPlayButton === "0") ? false : true;

        var selector = "#wistia_" + id;
        setWistia(id, selector, showPlayButton, playButtonContainerSelector);
    }

    function setWistia(id, selector, showPlayButton, playButtonContainerSelector) {
        // WISTIA DOCS: http://wistia.com/doc/player-api

        (Wistia.embed(id, {
            autoPlay: false,
            playButton: false,
            playbar: true,
            volume: (showPlayButton === true) ? 100 : 0,
            endVideoBehavior: 'default',
            smallPlayButton: false,
            fullscreenButton: false,
            volumeControl: showPlayButton,
        })).ready(function() {
            var parent = $(selector).parent(".wistia-wrapper");

            var video = $(selector + " video");
            if (!showPlayButton) { // if play button is hidden
                setPlayWaypoint(video);
                setVideoPlayTrigger(video, showPlayButton);

            } else {
                var overlay = parent.find('.videoOverlay');
                var content = $(parent).parent().find("section");
                var playButton = overlay.find('.playButton');

                playButton.click(function(event) {
                    video.get(0).play();
                    overlay.addClass('hidden');
                    content.addClass('hidden');
                });

                if (playButtonContainerSelector !== "") {
                    movePlayButtonToDifferentContainer(playButton, playButtonContainerSelector);
                }
                playButton.removeClass('hidden');

            }
        }).bind('play', function() {});
    }

    function setPlayWaypoint(video) {

        if (video.offset().top < 200) {
            video.get(0).play();
        } else {
            var waypoint = new Waypoint({
                element: video,
                handler: function(direction) {
                    if (direction === "down") {
                        video.get(0).play();
                        if (waypoint) {
                            waypoint.destroy();
                        }
                    }
                },
                offset: "70%"
            });
        }
    }

    function movePlayButtonToDifferentContainer(jqButton, selector) {
        jqButton.detach();
        $(selector).append(jqButton);
    }

    // This trigger checks if the play button is displayed, if it is not displayed then it plays the video
    // for use, get the video and fire "verifyAutoPlay", example: $(".<selector> video").trigger("verifyAutoPlay");
    function setVideoPlayTrigger(video, showPlayButton) {
        video.on("verifyAutoPlay", function() {
            if (showPlayButton === false) {
                video.get(0).play();
            }
        });
    }

    app.components.wistia = {
        init: init
    };

})();
