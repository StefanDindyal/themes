var app = {};
app.modules = {}, app.components = {}, app.templates = {}, app.lib = {}, app.instances = {}, app.instances.SearchComponents = [], app.instances.LanguageSelectorComponents = [],
    function(a) {
        var b = {
                common: {
                    init: function() {},
                    finalize: function() {
                        app.lib.util.setFullHeightElements(!0), app.lib.util.flexMinHeight(), app.lib.util.setupTilesAutoHeight(), app.components.navigationGeneral.init(), app.lib.scrolling.scrollToAnchorLink()
                    }
                },
                home: {
                    init: function() {},
                    finalize: function() {}
                },
                about_us: {
                    init: function() {}
                }
            },
            c = {
                fire: function(a, c, d) {
                    var e, f = b;
                    c = void 0 === c ? "init" : c, e = "" !== a, e = e && f[a], e = e && "function" == typeof f[a][c], e && f[a][c](d)
                },
                loadEvents: function() {
                    c.fire("common"), a.each(document.body.className.replace(/-/g, "_").split(/\s+/), function(a, b) {
                        c.fire(b), c.fire(b, "finalize")
                    }), c.fire("common", "finalize")
                }
            };
        a(document).ready(c.loadEvents)
    }(jQuery),
    function() {
        "use strict";

        function a(a) {
            var b = "fullPageStyle",
                c = document.head || document.getElementsByTagName("head")[0],
                d = function() {
                    var a = $(window).height(),
                        d = ".full-height { height: " + a + "px; } .full-height-min { min-height: " + a + "px; }",
                        e = document.getElementById(b);
                    e && c.removeChild(e), e = document.createElement("style"), e.type = "text/css", e.id = b, e.styleSheet ? e.styleSheet.cssText = d : e.appendChild(document.createTextNode(d)), c.appendChild(e)
                };
            d();
            var e = $(window).width();
            a === !0 && $(window).resize(function(a) {
                u(function() {
                    if (app.lib.browserDetection.isDesktop()) d();
                    else {
                        var a = $(window).width();
                        e !== a && (d(), e = a)
                    }
                }, 100, "id")
            })
        }

        function b(a) {
            var b = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
            return b.test(a)
        }

        function c(a) {
            var b = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;
            return b.test(a)
        }

        function d(a) {
            a.autogrow({
                animate: !1
            })
        }

        function e(a, b, c) {
            a.css("height", "");
            var d = 0;
            a.each(function() {
                var a = $(this),
                    b = parseInt(a.css("height").replace("px", ""));
                b > d && (d = b)
            }), a.css("height", d), b && $(window).resize(function(b) {
                u(function() {
                    e(a, !1, c)
                }, 300, c)
            })
        }

        function f(a, b, c) {
            a.css("width", "");
            var d = 0;
            a.each(function() {
                var a = $(this),
                    b = parseInt(a.css("width").replace("px", ""));
                b > d && (d = b)
            }), a.css("width", d), b && $(window).resize(function(b) {
                u(function() {
                    f(a, !1, c)
                }, 300, c)
            })
        }

        function g(a, b, c) {
            if (a.size() > 0) {
                var d = 0;
                a.each(function(a, b) {
                    var c = $(b),
                        e = parseInt(c.css("width").replace("px", ""));
                    e > d && (d = e)
                }), a.height(d), b && $(window).resize(function(b) {
                    u(function() {
                        g(a, !1, c)
                    }, 300, c)
                })
            }
        }

        function h() {
            var a = $(".jqFlexMinHeight");
            a.each(function(a, b) {
                var c = $(b),
                    d = c.css("min-height").replace("px", "");
                d = "" === d ? 0 : parseInt(d);
                var e = parseInt(c.css("padding-top").replace("px", "")),
                    f = parseInt(c.css("padding-bottom").replace("px", "")),
                    g = parseInt(c.children(".jqFlexMinHeight-body").css("height").replace("px", "")),
                    h = g + e + f;
                d > 0 && d > h && c.css("height", d + "px")
            }), $(window).resize(function(a) {
                u(function() {
                    h()
                }, 100, "flexMinHeight" + n())
            })
        }

        function i(a, b) {
            var c = [],
                d = "http://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(a) + "&t=" + b,
                e = "https://twitter.com/share?url=" + a + "&via=ACCESSUNDERTONE&text=" + b,
                f = "http://www.linkedin.com/shareArticle?mini=true&url=" + a + "&title=" + b + "&summary=" + b + "&source=UNDERTONE",
                g = "mailto:?subject=Me&body=" + encodeURIComponent(a) + "&t=" + b;
            return c.push(d), c.push(e), c.push(f), c.push(g), c
        }

        function j() {
            var a = $(".multi-hero");
            a.each(function() {
                var a = $(this);
                $(window).resize(function() {
                    a.find(".grid .info-wrapper").css("height", $(a.find(".grid")[0]).outerWidth())
                })
            }), $(window).trigger("resize")
        }

        function k() {
            return window.location.search.substring(1), window.location.hash
        }

        function l(a) {
            for (var b = window.location.search.substring(1), c = b.split("&"), d = 0; d < c.length; d++) {
                var e = c[d].split("=");
                if (e[0] === a) return e[1]
            }
        }

        function m(a) {
            var b = location.href,
                c = "?";
            if (b.indexOf("?") > -1) {
                for (var d = b.split("?")[1].split("&"), e = 0; e < d.length; e++) {
                    var f = d[e];
                    f.split("=")[0] !== a && "=" !== f && (c += f + "&")
                }
                "&" === c[c.length - 1] && (c = c.substr(0, c.length - 1)), history.pushState("", "", c)
            }
        }

        function n(a) {
            var b = "id-" + (a ? a + "-" : ""),
                c = new Date;
            return b += c.getHours(), b += c.getMinutes(), b += c.getSeconds(), b += c.getMilliseconds()
        }

        function o(a, b) {
            $("<img/>").attr("src", a).load(function() {
                $(this).remove(), b()
            })
        }

        function p(a, b) {
            var c = $(a),
                d = $(b);
            c.hover(function() {
                q($(this))
            }, function() {}), new Waypoint({
                element: d,
                handler: function() {
                    var a = d.attr("data-refresh");
                    "true" === a && (d.attr("data-refresh", "false"), $.each(c, function(a, b) {
                        q($(b))
                    }))
                },
                offset: "90%"
            })
        }

        function q(a) {
            var b, c, d, e, f;
            c = a.find("img"), c.length > 0 && (b = c.prop("src"), b = b.split("?")[0], d = b.split(".").pop(), "gif" === d && (app.lib.browserDetection.detectIE() ? c.prop("src", b + "?v=" + (new Date).valueOf()) : (c.hide(), c.prop("src", b + "?v=" + (new Date).valueOf()), e = c[0], f = c.parent(), c.remove(), f.prepend(e), f.find("img").load(function() {
                f.children().show()
            }))))
        }

        function r() {
            return !t() && !s() && window.matchMedia("(min-device-width: 320px)").matches
        }

        function s() {
            return !t() && window.matchMedia("(min-device-width: 768px)").matches
        }

        function t() {
            return window.matchMedia("(min-device-width: 1024px)").matches
        }
        var u = function() {
            var a = {};
            return function(b, c, d) {
                d || (d = "Don't call this twice without a uniqueId"), a[d] && clearTimeout(a[d]), a[d] = setTimeout(b, c)
            }
        }();
        app.lib.util = {
            setFullHeightElements: a,
            waitForFinalEvent: u,
            validateEmail: b,
            validatePhone: c,
            autogrowTextArea: d,
            setSameHeight: e,
            setSameWidth: f,
            setPerfectSquareByWidth: g,
            setupTilesAutoHeight: j,
            flexMinHeight: h,
            socialLinks: i,
            getAnchorLink: k,
            getUrlParameter: l,
            removeURLParam: m,
            createUniqueId: n,
            onImageLoad: o,
            refreshGifs: p,
            isPhone: r,
            isTablet: s,
            isDesktop: t
        }
    }(),
    function() {
        function a(a, b) {
            a.addClass("animated " + b), d(a, function() {
                c(a, b)
            })
        }

        function b(a, b) {
            a.addClass("animated infinite " + b)
        }

        function c(a, b) {
            a.removeClass("animated infinite " + b)
        }

        function d(a, b) {
            a.one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function() {
                b()
            })
        }
        app.lib.animate_sass = {
            animateOnce: a,
            animateInfinite: b,
            stopAnimation: c
        }
    }(),
    function() {
        function a() {
            return breakpoint = "(max-width: " + (g - 1) + "px)", !!Modernizr.mq(breakpoint)
        }

        function b() {
            return !!Modernizr.mq("(min-width: " + g + "px)" && "(max-width: " + (h - 1) + "px)")
        }

        function c() {
            return !!Modernizr.mq("(min-width: " + h + "px)" && "(max-width: " + (i - 1) + "px)")
        }

        function d() {
            return !!Modernizr.mq("(min-width: " + i + "px)")
        }

        function e(a, b, c, d) {
            breakpoint = "(max-width: " + (a - 1) + "px)";
            var e = !!Modernizr.mq(breakpoint),
                g = function(a, b, c) {
                    $(window).width(), e && Modernizr.mq(a) ? (e = !1, b && b()) : e || Modernizr.mq(a) || (e = !0, c && c())
                };
            if (g(breakpoint, b, c), d) {
                var h = f.createUniqueId();
                $(window).resize(function(a) {
                    f.waitForFinalEvent(function() {
                        g(breakpoint, b, c)
                    }, 300, h)
                })
            }
        }
        var f = app.lib.util,
            g = 768,
            h = 992,
            i = 1200;
        app.lib.breakpoint = {
            breakpoint_small: g,
            breakpoint_medium: h,
            fireOnBreakpointChange: e,
            isXSmall: a,
            isSmall: b,
            isMedium: c,
            isLarge: d
        }
    }(),
    function() {
        function a() {
            var a = window.navigator.userAgent,
                b = a.indexOf("MSIE ");
            if (b > 0) return parseInt(a.substring(b + 5, a.indexOf(".", b)), 10);
            var c = a.indexOf("Trident/");
            if (c > 0) {
                var d = a.indexOf("rv:");
                return parseInt(a.substring(d + 3, a.indexOf(".", d)), 10)
            }
            var e = a.indexOf("Edge/");
            return e > 0 && parseInt(a.substring(e + 5, a.indexOf(".", e)), 10)
        }

        function b() {
            return !!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)
        }

        function c() {
            return !b()
        }
        app.lib.browserDetection = {
            detectIE: a,
            isMobileDevice: b,
            isDesktop: c
        }
    }(),
    function(a, b, c) {
        "function" == typeof define && define.amd ? define(["jquery"], function(d) {
            return c(d, a, b), d.mobile
        }) : c(a.jQuery, a, b)
    }(this, document, function(a, b, c, d) {
        ! function(a, b, c, d) {
            function e(a) {
                for (; a && "undefined" != typeof a.originalEvent;) a = a.originalEvent;
                return a
            }

            function f(b, c) {
                var f, g, h, i, j, k, l, m, n, o = b.type;
                if (b = a.Event(b), b.type = c, f = b.originalEvent, g = a.event.props, o.search(/^(mouse|click)/) > -1 && (g = E), f)
                    for (l = g.length, i; l;) i = g[--l], b[i] = f[i];
                if (o.search(/mouse(down|up)|click/) > -1 && !b.which && (b.which = 1), -1 !== o.search(/^touch/) && (h = e(f), o = h.touches, j = h.changedTouches, k = o && o.length ? o[0] : j && j.length ? j[0] : d))
                    for (m = 0, n = C.length; n > m; m++) i = C[m], b[i] = k[i];
                return b
            }

            function g(b) {
                for (var c, d, e = {}; b;) {
                    c = a.data(b, z);
                    for (d in c) c[d] && (e[d] = e.hasVirtualBinding = !0);
                    b = b.parentNode
                }
                return e
            }

            function h(b, c) {
                for (var d; b;) {
                    if (d = a.data(b, z), d && (!c || d[c])) return b;
                    b = b.parentNode
                }
                return null
            }

            function i() {
                M = !1
            }

            function j() {
                M = !0
            }

            function k() {
                Q = 0, K.length = 0, L = !1, j()
            }

            function l() {
                i()
            }

            function m() {
                n(), G = setTimeout(function() {
                    G = 0, k()
                }, a.vmouse.resetTimerDuration)
            }

            function n() {
                G && (clearTimeout(G), G = 0)
            }

            function o(b, c, d) {
                var e;
                return (d && d[b] || !d && h(c.target, b)) && (e = f(c, b), a(c.target).trigger(e)), e
            }

            function p(b) {
                var c, d = a.data(b.target, A);
                !L && (!Q || Q !== d) && (c = o("v" + b.type, b), c && (c.isDefaultPrevented() && b.preventDefault(), c.isPropagationStopped() && b.stopPropagation(), c.isImmediatePropagationStopped() && b.stopImmediatePropagation()))
            }

            function q(b) {
                var c, d, f, h = e(b).touches;
                h && 1 === h.length && (c = b.target, d = g(c), d.hasVirtualBinding && (Q = P++, a.data(c, A, Q), n(), l(), J = !1, f = e(b).touches[0], H = f.pageX, I = f.pageY, o("vmouseover", b, d), o("vmousedown", b, d)))
            }

            function r(a) {
                M || (J || o("vmousecancel", a, g(a.target)), J = !0, m())
            }

            function s(b) {
                if (!M) {
                    var c = e(b).touches[0],
                        d = J,
                        f = a.vmouse.moveDistanceThreshold,
                        h = g(b.target);
                    J = J || Math.abs(c.pageX - H) > f || Math.abs(c.pageY - I) > f, J && !d && o("vmousecancel", b, h), o("vmousemove", b, h), m()
                }
            }

            function t(a) {
                if (!M) {
                    j();
                    var b, c, d = g(a.target);
                    o("vmouseup", a, d), J || (b = o("vclick", a, d), b && b.isDefaultPrevented() && (c = e(a).changedTouches[0], K.push({
                        touchID: Q,
                        x: c.clientX,
                        y: c.clientY
                    }), L = !0)), o("vmouseout", a, d), J = !1, m()
                }
            }

            function u(b) {
                var c, d = a.data(b, z);
                if (d)
                    for (c in d)
                        if (d[c]) return !0;
                return !1
            }

            function v() {}

            function w(b) {
                var c = b.substr(1);
                return {
                    setup: function() {
                        u(this) || a.data(this, z, {});
                        var d = a.data(this, z);
                        d[b] = !0, F[b] = (F[b] || 0) + 1, 1 === F[b] && O.bind(c, p), a(this).bind(c, v), N && (F.touchstart = (F.touchstart || 0) + 1, 1 === F.touchstart && O.bind("touchstart", q).bind("touchend", t).bind("touchmove", s).bind("scroll", r))
                    },
                    teardown: function() {
                        --F[b], F[b] || O.unbind(c, p), N && (--F.touchstart, F.touchstart || O.unbind("touchstart", q).unbind("touchmove", s).unbind("touchend", t).unbind("scroll", r));
                        var d = a(this),
                            e = a.data(this, z);
                        e && (e[b] = !1), d.unbind(c, v), u(this) || d.removeData(z)
                    }
                }
            }
            var x, y, z = "virtualMouseBindings",
                A = "virtualTouchID",
                B = "vmouseover vmousedown vmousemove vmouseup vclick vmouseout vmousecancel".split(" "),
                C = "clientX clientY pageX pageY screenX screenY".split(" "),
                D = a.event.mouseHooks ? a.event.mouseHooks.props : [],
                E = a.event.props.concat(D),
                F = {},
                G = 0,
                H = 0,
                I = 0,
                J = !1,
                K = [],
                L = !1,
                M = !1,
                N = "addEventListener" in c,
                O = a(c),
                P = 1,
                Q = 0;
            for (a.vmouse = {
                    moveDistanceThreshold: 10,
                    clickDistanceThreshold: 10,
                    resetTimerDuration: 1500
                }, y = 0; y < B.length; y++) a.event.special[B[y]] = w(B[y]);
            N && c.addEventListener("click", function(b) {
                var c, d, e, f, g, h, i = K.length,
                    j = b.target;
                if (i)
                    for (c = b.clientX, d = b.clientY, x = a.vmouse.clickDistanceThreshold, e = j; e;) {
                        for (f = 0; i > f; f++)
                            if (g = K[f], h = 0, e === j && Math.abs(g.x - c) < x && Math.abs(g.y - d) < x || a.data(e, A) === g.touchID) return b.preventDefault(), void b.stopPropagation();
                        e = e.parentNode
                    }
            }, !0)
        }(a, b, c),
        function(a) {
            a.mobile = {}
        }(a),
        function(a, b) {
            var d = {
                touch: "ontouchend" in c
            };
            a.mobile.support = a.mobile.support || {}, a.extend(a.support, d), a.extend(a.mobile.support, d)
        }(a),
        function(a, b, d) {
            function e(b, c, e, f) {
                var g = e.type;
                e.type = c, f ? a.event.trigger(e, d, b) : a.event.dispatch.call(b, e), e.type = g
            }
            var f = a(c),
                g = a.mobile.support.touch,
                h = "touchmove scroll",
                i = g ? "touchstart" : "mousedown",
                j = g ? "touchend" : "mouseup",
                k = g ? "touchmove" : "mousemove";
            a.each("touchstart touchmove touchend tap taphold swipe swipeleft swiperight scrollstart scrollstop".split(" "), function(b, c) {
                a.fn[c] = function(a) {
                    return a ? this.bind(c, a) : this.trigger(c)
                }, a.attrFn && (a.attrFn[c] = !0)
            }), a.event.special.scrollstart = {
                enabled: !0,
                setup: function() {
                    function b(a, b) {
                        c = b, e(f, c ? "scrollstart" : "scrollstop", a)
                    }
                    var c, d, f = this,
                        g = a(f);
                    g.bind(h, function(e) {
                        a.event.special.scrollstart.enabled && (c || b(e, !0), clearTimeout(d), d = setTimeout(function() {
                            b(e, !1)
                        }, 50))
                    })
                },
                teardown: function() {
                    a(this).unbind(h)
                }
            }, a.event.special.tap = {
                tapholdThreshold: 750,
                emitTapOnTaphold: !0,
                setup: function() {
                    var b = this,
                        c = a(b),
                        d = !1;
                    c.bind("vmousedown", function(g) {
                        function h() {
                            clearTimeout(k)
                        }

                        function i() {
                            h(), c.unbind("vclick", j).unbind("vmouseup", h), f.unbind("vmousecancel", i)
                        }

                        function j(a) {
                            i(), d || l !== a.target ? d && a.preventDefault() : e(b, "tap", a)
                        }
                        if (d = !1, g.which && 1 !== g.which) return !1;
                        var k, l = g.target;
                        c.bind("vmouseup", h).bind("vclick", j), f.bind("vmousecancel", i), k = setTimeout(function() {
                            a.event.special.tap.emitTapOnTaphold || (d = !0), e(b, "taphold", a.Event("taphold", {
                                target: l
                            }))
                        }, a.event.special.tap.tapholdThreshold)
                    })
                },
                teardown: function() {
                    a(this).unbind("vmousedown").unbind("vclick").unbind("vmouseup"), f.unbind("vmousecancel")
                }
            }, a.event.special.swipe = {
                scrollSupressionThreshold: 30,
                durationThreshold: 1e3,
                horizontalDistanceThreshold: 30,
                verticalDistanceThreshold: 30,
                getLocation: function(a) {
                    var c = b.pageXOffset,
                        d = b.pageYOffset,
                        e = a.clientX,
                        f = a.clientY;
                    return 0 === a.pageY && Math.floor(f) > Math.floor(a.pageY) || 0 === a.pageX && Math.floor(e) > Math.floor(a.pageX) ? (e -= c, f -= d) : (f < a.pageY - d || e < a.pageX - c) && (e = a.pageX - c, f = a.pageY - d), {
                        x: e,
                        y: f
                    }
                },
                start: function(b) {
                    var c = b.originalEvent.touches ? b.originalEvent.touches[0] : b,
                        d = a.event.special.swipe.getLocation(c);
                    return {
                        time: (new Date).getTime(),
                        coords: [d.x, d.y],
                        origin: a(b.target)
                    }
                },
                stop: function(b) {
                    var c = b.originalEvent.touches ? b.originalEvent.touches[0] : b,
                        d = a.event.special.swipe.getLocation(c);
                    return {
                        time: (new Date).getTime(),
                        coords: [d.x, d.y]
                    }
                },
                handleSwipe: function(b, c, d, f) {
                    if (c.time - b.time < a.event.special.swipe.durationThreshold && Math.abs(b.coords[0] - c.coords[0]) > a.event.special.swipe.horizontalDistanceThreshold && Math.abs(b.coords[1] - c.coords[1]) < a.event.special.swipe.verticalDistanceThreshold) {
                        var g = b.coords[0] > c.coords[0] ? "swipeleft" : "swiperight";
                        return e(d, "swipe", a.Event("swipe", {
                            target: f,
                            swipestart: b,
                            swipestop: c
                        }), !0), e(d, g, a.Event(g, {
                            target: f,
                            swipestart: b,
                            swipestop: c
                        }), !0), !0
                    }
                    return !1
                },
                eventInProgress: !1,
                setup: function() {
                    var b, c = this,
                        d = a(c),
                        e = {};
                    b = a.data(this, "mobile-events"), b || (b = {
                        length: 0
                    }, a.data(this, "mobile-events", b)), b.length++, b.swipe = e, e.start = function(b) {
                        if (!a.event.special.swipe.eventInProgress) {
                            a.event.special.swipe.eventInProgress = !0;
                            var d, g = a.event.special.swipe.start(b),
                                h = b.target,
                                i = !1;
                            e.move = function(b) {
                                g && !b.isDefaultPrevented() && (d = a.event.special.swipe.stop(b), i || (i = a.event.special.swipe.handleSwipe(g, d, c, h), i && (a.event.special.swipe.eventInProgress = !1)), Math.abs(g.coords[0] - d.coords[0]) > a.event.special.swipe.scrollSupressionThreshold && b.preventDefault())
                            }, e.stop = function() {
                                i = !0, a.event.special.swipe.eventInProgress = !1, f.off(k, e.move), e.move = null
                            }, f.on(k, e.move).one(j, e.stop)
                        }
                    }, d.on(i, e.start)
                },
                teardown: function() {
                    var b, c;
                    b = a.data(this, "mobile-events"), b && (c = b.swipe, delete b.swipe, b.length--, 0 === b.length && a.removeData(this, "mobile-events")), c && (c.start && a(this).off(i, c.start), c.move && f.off(k, c.move), c.stop && f.off(j, c.stop))
                }
            }, a.each({
                scrollstop: "scrollstart",
                taphold: "tap",
                swipeleft: "swipe.left",
                swiperight: "swipe.right"
            }, function(b, c) {
                a.event.special[b] = {
                    setup: function() {
                        a(this).bind(c, a.noop)
                    },
                    teardown: function() {
                        a(this).unbind(c)
                    }
                }
            })
        }(a, this)
    }),
    function() {
        function a(a) {
            return a % 1 === 0
        }
        app.lib.numbers = {
            isInt: a
        }
    }(), String.prototype.format || (String.prototype.format = function() {
        var a = arguments;
        return this.replace(/{(\d+)}/g, function(b, c) {
            return "undefined" != typeof a[c] ? a[c] : b
        })
    }),
    function() {
        function a(a, b, c) {
            a.length > 0
        }

        function b(a) {
            a = a || window.event, a.preventDefault && a.preventDefault(), a.returnValue = !1
        }

        function c(a) {
            return m[a.keyCode] ? (b(a), !1) : void 0
        }

        function d() {
            window.addEventListener && window.addEventListener("DOMMouseScroll", b, !1), window.onwheel = b, window.onmousewheel = document.onmousewheel = b, window.ontouchmove = b, document.onkeydown = c
        }

        function e() {
            window.removeEventListener && window.removeEventListener("DOMMouseScroll", b, !1), window.onmousewheel = document.onmousewheel = null, window.onwheel = null, window.ontouchmove = null, document.onkeydown = null
        }

        function f() {
            $("html").addClass(l)
        }

        function g() {
            $("html").removeClass(l)
        }

        function h(a, b, c) {}

        function i(a, b, c, d) {
            b.length > 0 && h(b.offset().top - a, c, d)
        }

        function j(a, b) {
            $.when(app.components.navigationGeneral.get()).done(function() {
                var c = app.components.navigationGeneral.getMenuHeight();
                i(c, a, b)
            })
        }

        function k() {
            var a = function() {
                var a = app.lib.util.getAnchorLink();
                a && j($(a), 100)
            };
            a(), $(window).bind("hashchange", function(b) {
                a()
            })
        }
        var l = "lock-scroll",
            m = {
                37: 1,
                38: 1,
                39: 1,
                40: 1
            };
        app.lib.scrolling = {
            scrollToElement: a,
            disableScroll: d,
            enableScroll: e,
            hideScroll: f,
            showScroll: g,
            scrollElementToTop: j,
            scrollToAnchorLink: k
        }
    }(),
    function() {
        var a = app.lib.util;
        app.modules.Circle = function(b) {
            var c = this;
            c.selectorID = b, c.circleModule = $(b), a.setSameHeight(c.circleModule.find(".circle-section .small-title"), !0, a.createUniqueId("sTitle")), a.setSameHeight(c.circleModule.find(".circle-section .copy"), !0, a.createUniqueId("copy")), a.refreshGifs(b + " .circle-section", b + " .circles-container")
        }
    }(),
    function() {
        function a(a) {
            b(a)
        }

        function b(a) {
            c = $(".slider-" + a);
            var b = ($(window).width(), 4);
            d.isXSmall() ? b = 1 : d.isSmall() ? b = 2 : d.isMedium() && (b = 3), c.jCarouselLite({
                btnNext: ".slider-next-" + a,
                btnPrev: ".slider-prev-" + a,
                visible: b,
                easing: "easeInCubic",
                speed: 400,
                beforeStart: function() {
                    c.attr("data-moving", "true")
                },
                afterEnd: function() {
                    setTimeout(function() {
                        c.attr("data-moving", "false")
                    }, 2500)
                }
            })
        }
        var c, d = app.lib.breakpoint;
        app.modules.copy = {
            init: a
        }
    }(),
    function() {
        var a = app.lib.animate_sass,
            b = app.lib.scrolling,
            c = app.lib.breakpoint,
            d = !0;
        app.modules.FullPageSlider = function(a, b) {
            var d = this;
            d.carousel = $(a), d.scrollDownArrow = d.carousel.find(".scrollDown"), d.nextModule = d.carousel.parents(".module").next(".module"), d.previousModule = d.carousel.parents(".module").prev(".module"), d.isNavColorChangeRange = !1, d.carouselSlides = d.carousel.find(".item"), d.scrollingWaypoints = [], d.scrollingWaypointsSet = !1, d.addSwipe(a), "display" === b && app.lib.browserDetection.isDesktop() && c.fireOnBreakpointChange(c.breakpoint_small, function() {
                d.disableScrollingWaypoints()
            }, function() {
                d.scrollingWaypointsSet === !1 && (d.scrollingWaypointsSet = !0, d.scrollDownArrowEvents(d.scrollDownArrow), d.setCarouselScrollingWaypoint()), d.enableScrollingWaypoints()
            }, !0), d.setCarouselEvents()
        };
        var e = app.modules.FullPageSlider.prototype;
        e.addSwipe = function(a) {
            $(a).swiperight(function() {
                $(this).carousel("prev")
            }), $(a).swipeleft(function() {
                $(this).carousel("next")
            })
        }, e.setCarouselEvents = function() {
            var a = this,
                b = function() {
                    $.when(app.components.navigationGeneral.get()).done(function() {
                        a.setCarouselNavColorWayPoint(), a.carousel.on("slid.bs.carousel", function(b) {
                            a.setCurrentItemNavigationColor(), a.playCurrentItemVideo()
                        }), a.setCarouselPauseContinueWaypoints(), a.pauseOnContentHover()
                    })
                };
            c.isXSmall() ? (a.hideLoader(), b()) : a.slideCarousel(function() {
                b()
            })
        }, e.setCarouselScrollingWaypoint = function() {
            var a = this;
            return a.scrollingWaypoints.push(new Waypoint({
                element: a.carousel,
                handler: function(b) {
                    "down" === b && a.scrollToElement(a.nextModule)
                },
                offset: -1
            })), a.scrollingWaypoints.push(new Waypoint({
                element: a.carousel,
                handler: function(b) {
                    "up" === b && a.scrollToElement(a.previousModule)
                },
                offset: 1
            })), a.scrollingWaypoints.push(new Waypoint({
                element: a.carousel,
                handler: function(b) {
                    "down" === b && a.scrollToElement(a.carousel)
                },
                offset: 200
            })), a.scrollingWaypoints.push(new Waypoint({
                element: a.carousel,
                handler: function(b) {
                    "up" === b && a.scrollToElement(a.carousel)
                },
                offset: function() {
                    return -a.carousel.height()
                }
            })), !0
        }, e.disableScrollingWaypoints = function() {
            for (var a = this, c = 0; c < a.scrollingWaypoints.length; c++) a.scrollingWaypoints[c].disable();
            b.enableScroll()
        }, e.enableScrollingWaypoints = function() {
            for (var a = this, b = 0; b < a.scrollingWaypoints.length; b++) a.scrollingWaypoints[b].enable()
        }, e.setCurrentItemNavigationColor = function() {
            var a = this;
            if (a.isNavColorChangeRange === !0) {
                var b = $(a.carousel).find(".item.active .module");
                app.components.navigationGeneral.setNavBarVersion(b)
            }
        }, e.playCurrentItemVideo = function() {
            var a = this,
                b = $(a.carousel).find(".item.active .module video");
            b.length > 0 && b.trigger("verifyAutoPlay")
        }, e.scrollDownArrowEvents = function() {
            var b = this;
            a.animateOnce(b.scrollDownArrow, "bounce"), b.scrollDownArrow.hover(function() {
                a.animateOnce(b.scrollDownArrow, "bounce")
            }, function() {}), b.scrollDownArrow.click(function(a) {
                b.scrollToElement(b.nextModule)
            })
        }, e.setCarouselNavColorWayPoint = function() {
            var a = this;
            new Waypoint({
                element: a.carousel,
                handler: function(b) {
                    "down" === b ? (a.isNavColorChangeRange = !0, app.components.navigationGeneral.setNavBarVersion(a.carousel)) : (a.isNavColorChangeRange = !1, app.components.navigationGeneral.setNavBarVersion(a.previousModule))
                },
                offset: 0
            }), new Waypoint({
                element: a.carousel,
                handler: function(b) {
                    "down" === b ? (a.isNavColorChangeRange = !1, app.components.navigationGeneral.setNavBarVersion(a.nextModule)) : (a.isNavColorChangeRange = !0, a.setCurrentItemNavigationColor())
                },
                offset: -150
            })
        }, e.setCarouselPauseContinueWaypoints = function() {
            var a = this;
            new Waypoint({
                element: a.carousel,
                handler: function(b) {
                    "down" === b ? a.continueCarousel() : (a.carouselAction(0), a.pauseCarousel()), a.playCurrentItemVideo()
                },
                offset: "99%"
            }), new Waypoint({
                element: a.carousel,
                handler: function(b) {
                    "down" === b ? (a.carouselAction(0), a.pauseCarousel()) : a.continueCarousel(), a.playCurrentItemVideo()
                },
                offset: "-100%"
            })
        }, e.pauseOnContentHover = function() {
            var a = this;
            a.carousel.find("section").hover(function() {
                a.pauseCarousel()
            }, function() {
                a.continueCarousel()
            })
        }, e.carouselAction = function(a) {
            var b = this;
            b.carousel.carousel(a)
        }, e.pauseCarousel = function() {
            var a = this;
            a.carouselAction("pause")
        }, e.continueCarousel = function() {
            var a = this;
            a.carouselAction("cycle")
        }, e.nextSlide = function() {
            var a = this;
            a.carouselAction("next")
        }, e.slideCarousel = function(a) {
            var b = this,
                c = b.carouselSlides.size();
            b.slideRecoursiveCarousel(c, 1, a)
        }, e.slideRecoursiveCarousel = function(a, b, c) {
            var d = this,
                e = 600;
            return b === a ? (d.carouselAction(0), setTimeout(function() {
                d.waitForHerosToLoad(function() {
                    c(), d.hideLoader()
                })
            }, e), !0) : (d.carouselAction(b), b++, void setTimeout(function() {
                d.slideRecoursiveCarousel(a, b, c)
            }, e))
        }, e.waitForHerosToLoad = function(a) {
            var b = this,
                c = b.carouselSlides.find(".hero"),
                d = !0;
            c.each(function(e, f) {
                if (f = $(f), f.hasClass("loaded") === !1 && (d = !1), e === c.size() - 1) {
                    if (d === !0) return a(), !0;
                    setTimeout(function() {
                        b.waitForHerosToLoad(a)
                    }, 100)
                }
            })
        }, e.hideLoader = function() {
            var a = this;
            a.carousel.find(".loader-container").removeClass("show")
        }, e.scrollToElement = function(a, c) {
            a && d && (d = !1, b.disableScroll(), b.scrollToElement(a, 200, function() {
                c && c(), setTimeout(b.enableScroll, 600), d = !0
            }))
        }
    }(),
    function() {
        var a = app.lib.util;
        app.modules.GridContainer = function(b, c) {
            var d = this;
            d.selectorId = b, d.module = $(d.selectorId), "always" === c ? (d.squaredSections = d.module.find(".grid-container .grid"), a.setSameHeight(d.squaredSections.find(".main-title"), !0, a.createUniqueId("sTitle")), a.setSameHeight(d.squaredSections.find(".copy"), !0, a.createUniqueId("copy"))) : d.resizeGrids(!0)
        };
        var b = app.modules.GridContainer.prototype;
        b.resizeGrids = function(b) {
            var c = this,
                d = 0,
                e = !1,
                f = c.module.find(".content-wrapper"),
                g = c.module.find(".grid-information"),
                h = parseInt(c.module.find(".grid").first().css("height").replace("px", "")) - 80;
            f.each(function(a, b) {
                var c = $(b),
                    f = ($(b).closest(".grid"), parseInt(c.css("height").replace("px", "")));
                f > d && (d = f), f > h && (h = f, e = !0)
            }), e ? g.css("height", h) : g.css("height", d), b && $(window).resize(function(b) {
                a.waitForFinalEvent(function() {
                    c.resizeGrids(!1)
                }, 300, a.createUniqueId())
            })
        }
    }(),
    function() {
        function a(a, c) {
            app.lib.browserDetection.isDesktop() && "" !== a ? app.lib.util.onImageLoad(a, function() {
                b(c)
            }) : b(c)
        }

        function b(a) {
            $("#" + a).addClass("loaded")
        }
        app.modules.hero = {
            init: a
        }
    }(),
    function() {
        var a = app.lib.util;
        app.modules.ImageGrid = function(b) {
            var c = this;
            c.selectorId = b, c.module = $(c.selectorId), c.squaredSections = c.module.find(".grid-container .grid"), a.setSameHeight(c.squaredSections.find(".main-title"), !0, a.createUniqueId("sTitle")), a.setSameHeight(c.squaredSections.find(".copy"), !0, a.createUniqueId("copy"))
        }
    }(),
    function() {
        "use strict";

        function a(a, c, d, e, f, g) {
            p = $(".jobs"), q = $(".location"), r = $(".department"), s = $(".filters"), t = r.find(".dropdown-toggle"), u = q.find(".dropdown-toggle"), y = $(".jobs-table"), z = $(".table-nav"), A = z.find(".pages"), v = $(a), w = $(c), x = $(f), B = g, b(), l()
        }

        function b() {
            $.get(ajaxUtil.url, {
                nonce: ajaxUtil.nonce,
                action: "job_get"
            }, function(a) {
                a = a.substring(0, a.length - 1), o = JSON.parse(a);
                for (var b = [], d = 0; d < o.job.length; d++) {
                    var e = o.job[d].location;
                    e.indexOf("United States") !== -1 && b.push(o.job[d])
                }
                var f = $(".job-template").html(),
                    d = Handlebars.compile(f),
                    g = d(b);
                p.removeClass("loading"), p.find("tbody").html(g).promise().done(function() {
                    c(), m()
                })
            })
        }

        function c() {
            var a = [],
                b = [],
                c = q.find(".dropdown-menu"),
                e = r.find(".dropdown-menu");
            $(".data.location").each(function() {
                a.push($(this).text().trim())
            }), $(".data.department").each(function() {
                b.push($(this).text().trim())
            }), a.sort(), b.sort(), c.append('<li><a href="#">All</a></li>'), $.each(a.filter(function(a, b, c) {
                return b === c.indexOf(a)
            }), function(a, b) {
                c.append('<li><a href="#">' + b + "</a></li>")
            }), e.append('<li><a href="#">All</a></li>'), $.each(b.filter(function(a, b, c) {
                return b === c.indexOf(a)
            }), function(a, b) {
                e.append('<li><a href="#">' + b + "</a></li>")
            }), f(), d()
        }

        function d() {
            var a;
            window.location.hash.indexOf("#") > -1 ? a = window.location.hash.substr(1) : (a = app.lib.util.getUrlParameter("job"), app.lib.util.removeURLParam("job")), "" !== a && null !== a && void 0 !== a && e(a)
        }

        function e(a) {
            var b = p.find("[data-id='" + a + "']");
            "" !== b && null !== b && void 0 !== b && b.trigger("click")
        }

        function f() {
            s.find(".dropdown-menu a").bind("click", g), s.find(".reset").bind("click", h), p.find(".job").bind("click", j), w.find(".back").bind("click", k)
        }

        function g(a) {
            var b = $(this),
                c = b.closest(".dropdown").first(),
                d = c.find(".dropdown-toggle"),
                e = d.data("type"),
                f = b.text();
            d.text(f.toUpperCase() === E.toUpperCase() ? e : f), i(0), m(), a.preventDefault()
        }

        function h() {
            t.text(C), u.text(D), i(1), m()
        }

        function i(a) {
            var b = u.text(),
                c = t.text();
            p.find("tbody tr").each(function() {
                if (a) $(this).removeClass("hidden");
                else {
                    var d = !1,
                        e = !1;
                    (c.toUpperCase() === C.toUpperCase() || $(this).find("td").eq(1).text().toUpperCase() === c.toUpperCase()) && (e = !0), (b.toUpperCase() === D.toUpperCase() || $(this).find("td").eq(2).text().toUpperCase() === b.toUpperCase()) && (d = !0), d && e ? $(this).removeClass("hidden") : $(this).hasClass("hidden") || $(this).addClass("hidden")
                }
            })
        }

        function j(a) {
            var b = $(this);
            v.fadeOut(function() {
                var a = b.find(".title").html(),
                    c = b.find(".department").html(),
                    d = b.find(".location").html(),
                    e = b.find(".description").html(),
                    f = b.find(".apply").html(),
                    g = x.find("iframe"),
                    h = b.data("id"),
                    i = window.location.origin + window.location.pathname + "?job=" + h,
                    j = app.lib.util.socialLinks(i, a);
                F = !0, window.location.hash = h, w.find(".main-title .title").html(a), w.find(".main-title .department").html(c), w.find(".location").html(d), w.find(".description").html(e), w.find(".facebook-share").attr("href", j[0]), w.find(".twitter-share").attr("href", j[1]), w.find(".linkedin-share").attr("href", j[2]), w.find(".mail-share").attr("href", j[3]), g.attr("src", f), w.fadeIn(function() {
                    $("html,body").animate({
                        scrollTop: w.offset().top
                    }, "fast")
                })
            }), a.preventDefault()
        }

        function k(a) {
            w.fadeOut(function() {
                v.fadeIn(), $("html,body").animate({
                    scrollTop: $(".job-listing").offset().top - 100
                }, "fast")
            }), F = !0, window.location.hash = "", a.preventDefault()
        }

        function l() {
            window.onpopstate = function(a) {
                F || d(), F = !1
            }
        }

        function m() {
            var a = y.find("tr").not(".hidden"),
                b = a.length,
                c = b / B;
            if (b > B) {
                z.show(), A.empty();
                for (var d = 0; c > d; d++) {
                    var e = d + 1;
                    A.append('<span class="nav-page" data-rel="' + d + '">' + e + "</span>")
                }
                a.hide(), a.slice(0, B).show(), A.find(".nav-page:first").addClass("active"), A.find(".nav-page").unbind("click").bind("click", function() {
                    n($(this), a)
                }), z.find(".prev-page").unbind("click").bind("click", function() {
                    n($(".nav-page.active").prev(), a)
                }), z.find(".next-page").unbind("click").bind("click", function() {
                    n($(".nav-page.active").next(), a)
                })
            } else z.hide(), a.show()
        }

        function n(a, b) {
            if (a.length > 0) {
                A.find(".nav-page").removeClass("active"), a.addClass("active");
                var c = a.attr("data-rel"),
                    d = c * B,
                    e = d + B;
                b.hide().slice(d, e).css("display", "table-row")
            }
        }
        var o, p, q, r, s, t, u, v, w, x, y, z, A, B, C = "all departments",
            D = "all locations",
            E = "all",
            F = !1;
        app.modules.jobListing = {
            init: a
        }
    }(),
    function() {
        "use strict";
        var a = "",
            b = "",
            c = [],
            d = ".tile.info-wrapper",
            e = ".clock",
            f = "data-timezone",
            g = "AIzaSyCaZd4aEB0xJcWkKELPJiB3UiiVQoFSwZw",
            h = "https://maps.googleapis.com/maps/api/timezone/json",
            i = (/iPad|iPhone|iPod/.test(navigator.platform), !!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/)),
            j = Modernizr.testProp("backgroundBlendMode"),
            k = 600,
            l = app.lib.browserDetection.isMobileDevice(),
            m = "",
            n = function(a) {
                for (var b, c = $($(a).find(".minilines")), d = 0; 12 > d; d++) b = document.createElementNS("http://www.w3.org/2000/svg", "line"), b.setAttribute("x1", "60"), b.setAttribute("y1", "10"), b.setAttribute("x2", "60"), b.setAttribute("y2", "17"), b.setAttribute("transform", "rotate(" + 360 * d / 12 + " 60 60)"), c.append(b)
            },
            o = function(a, c) {
                if (a || (a = b), c || (c = $(a.find(e)).attr(f)), c) {
                    $(a.find(e)).attr(f, c);
                    var d = $(a.find(".second")),
                        g = $(a.find(".minute")),
                        h = $(a.find(".hour")),
                        i = new Date,
                        j = moment().tz(c).format("hh"),
                        k = moment().tz(c).format("mm"),
                        l = 6 * i.getSeconds(),
                        m = 6 * k + l / 60,
                        n = 30 * j + m / 12;
                    d.attr("transform", "rotate(" + l + " 60,60)"), g.attr("transform", "rotate(" + m + " 60,60)"), h.attr("transform", "rotate(" + n + " 60,60)")
                }
                setTimeout(function() {
                    o(a)
                }, 1e3)
            },
            p = function(a, b, c) {
                $.get(h + "?location=" + a + "," + b + "&timestamp=" + moment().unix() + "&key=" + g, function(a) {
                    null != a && $(c).attr(f, a.timeZoneId)
                })
            },
            q = function() {
                var a = b,
                    d = c,
                    g = k;
                n(d), $.each(d, function(a, b) {
                    b = $(b);
                    var c = $(b.find(".hero-info-latitude")).html(),
                        d = $(b.find(".hero-info-longitude")).html();
                    c && d && "" !== c && "" !== d && (p(c, d, b.find(e)), o(b))
                }), d.click(function(b) {
                    var c, h, i, j = ".hero-info-",
                        k = $(this),
                        l = $(k.find(j + "title")).html(),
                        n = $(k.find(j + "pre-title")).html(),
                        p = $(k.find(j + "sub-title")).html(),
                        q = $(k.find(j + "url")).html(),
                        s = $(k.find(j + "desc1")).html(),
                        t = $(k.find(j + "email")).html(),
                        u = $(k.find(j + "desc2")).html(),
                        v = ($(k.find(j + "latitude")).html(), $(k.find(j + "longitude")).html(), $(k.find(j + "align")).html()),
                        w = $(k.find(j + "font-color")).html(),
                        x = $(k.find(e)).attr(f);
                    $(d).removeClass("active"), k.addClass("active"), "1" === m ? (c = $(k.find(j + "img-regular")).html(), $(a.find(".main-background")).fadeOut(function() {
                        $(this).css("background-image", "url(" + c + ")")
                    }).fadeIn()) : (h = $(k.find(j + "img-portrait")).html(), i = $(k.find(j + "img-landscape")).html(), $(a.find(".main-background.portrait")).fadeOut(function() {
                        $(this).css("background-image", "url(" + h + ")")
                    }).fadeIn(), $(a.find(".main-background.landscape")).fadeOut(function() {
                        $(this).css("background-image", "url(" + i + ")")
                    }).fadeIn()), $(a.find(".main-title")).fadeOut(function() {
                        $(this).html(l)
                    }).fadeIn(), $(a.find(".main-pre-title")).fadeOut(function() {
                        $(this).html(n)
                    }).fadeIn(), $(a.find(".main-sub-title")).fadeOut(function() {
                        $(this).html(p)
                    }).fadeIn(), $(a.find(".hero-url")).fadeOut(function() {
                        $(this).attr("href", q)
                    }).fadeIn(), $(a.find(".hero-description-1")).fadeOut(function() {
                        $(this).html(s)
                    }).fadeIn(), $(a.find(".hero-email")).fadeOut(function() {
                        $(this).html(t)
                    }).fadeIn(), $(a.find(".hero-email")).attr("href", "mailto: " + t), $(a.find(".hero-description-2")).fadeOut(function() {
                        $(this).html(u)
                    }).fadeIn(), $(a.find("section")).fadeOut(function() {
                        $(this).removeClass().addClass(v).addClass(w)
                    }).fadeIn(), x && o(a, x), b.originalEvent && ($(window).width() <= 1200 ? setTimeout(function() {
                        r(k)
                    }, g) : r(a))
                })
            },
            r = function(a) {
                var b = a;
                $("html,body").animate({
                    scrollTop: b.offset().top - 45
                }, 1e3)
            },
            s = function(e, f) {
                a = e, b = $("#multihero-" + a + " .hero"), c = $("#multihero-" + a + " " + d), m = f, l || ($("#multihero-" + a + " .grids").addClass(j ? "blend-mode" : "no-blend-mode"), i && $("#multihero-" + a + " .grids").addClass("overlay")), q(), $(c[0]).trigger("click")
            };
        app.modules.multiHero = {
            init: s,
            setUpMiniLines: n,
            setupTilesClick: q,
            updateTimezone: p,
            setClock: o
        }
    }(),
    function() {
        var a = app.lib.util;
        app.modules.Triptych = function(b) {
            var c = this;
            c.selectorID = b, c.triptychModule = $(b), a.setSameHeight(c.triptychModule.find("section .small-title"), !0, a.createUniqueId(".small-title")), a.setSameHeight(c.triptychModule.find("section .copy"), !0, a.createUniqueId(".copy"))
        }
    }(),
    function() {
        "use strict";

        function a(a) {
            d = $(a), e = d.find(".play-button"), g = d.find(".wistia_embed"), f = d.find(".main-section"), b()
        }

        function b() {
            e.click(function() {
                var a = $(this).attr("data-code"),
                    b = "wistia_" + a;
                g.attr("id", b), g.empty(), c(a), f.hasClass("playing") || f.addClass("playing"),
                    $("html, body").animate({
                        scrollTop: f.offset().top
                    }, 800)
            })
        }

        function c(a) {
            Wistia.embed(a, {
                autoPlay: !0,
                playbar: !1,
                volume: 0,
                playButton: !1,
                smallPlayButton: !1,
                fullscreenButton: !1,
                volumeControl: !1,
                endVideoBehavior: "loop"
            })
        }
        var d, e, f, g;
        app.modules.videoGrid = {
            init: a
        }
    }(),
    function() {
        "use strict";

        function a() {
            $("#404-search").click(function() {
                app.lib.breakpoint.isXSmall() ? app.components.navigationSmall.show() : app.components.navigation.getSearchComponent().toggle()
            })
        }
        app.templates.page404 = {
            init: a
        }
    }(),
    function() {
        "use strict";

        function a() {
            c = $(".campaign-single-tpl"), c.length > 0 && (d = c.find(".launch-campaign")), b()
        }

        function b() {
            var a = d.data("devices"),
                b = !1;
            a = a ? a.split(",") : [], b = a.indexOf("phone") > -1 && e.isPhone() || a.indexOf("tablet") > -1 && e.isTablet() || a.indexOf("desktop") > -1 && e.isDesktop(), b && d.removeClass("hidden")
        }
        var c, d, e = app.lib.util;
        app.templates.campaignSingle = {
            init: a
        }
    }(),
    function() {
        "use strict";

        function a(a, h) {
            xa = a, q = $(Y), r = $(Z), s = $(_), w = $(ka), x = $(la), y = $(ma), C = $(qa), D = $(ra), E = $(ea), F = $(fa), G = $(da), H = $(ca), I = $(aa), J = $(ba), K = $(ga), L = $(sa), A = $(oa), B = $(pa), M = $(Y + " " + ta), t = $(ha), u = $(ia), v = $(ja), z = $(na), b(), c(r), d(h), e(), f(), g(), k();
            var i = app.lib.util.getUrlParameter("hubspot");
            i && l()
        }

        function b() {
            var a = M.length,
                b = setInterval(function() {
                    var c = 0;
                    M.each(function() {
                        if (this.complete && "undefined" != typeof this.naturalWidth && this.naturalWidth > 0 && c++, c === a) {
                            clearInterval(b);
                            var d = app.lib.util.createUniqueId();
                            app.lib.util.setSameHeight($(".interest .option-container"), !0, d), app.lib.util.setSameWidth($(".interest .option-container"), !0, d), app.lib.util.refreshGifs(".option-container", ".step-2")
                        }
                    })
                }, 500)
        }

        function c(a) {
            app.lib.util.autogrowTextArea(a)
        }

        function d(a) {
            switch (a) {
                case "en":
                    F.mask("(999) 999-9999");
                    break;
                case "de":
                    F.mask("(999) 999-9999");
                    break;
                case "en-uk":
                    F.mask("(999) 999-9999")
            }
        }

        function e() {
            w.change(function() {
                "email" === $(this).attr("name") ? o($(this)) : "" === $(this).val() && "phone" !== $(this).attr("name") ? $(this).hasClass("invalid") || $(this).addClass("invalid") : $(this).removeClass("invalid"), !ua && h() && (ua = !0, u.removeClass("disabled-section"), x.each(function() {
                    $(this).removeClass("disabled")
                }))
            })
        }

        function f() {
            x.click(function() {
                u.hasClass("disabled-section") ? w.trigger("change") : $(this).hasClass("disabled") || ($(this).hasClass("selected") ? wa > 1 && (wa--, $(this).removeClass("selected")) : ($(this).addClass("selected"), wa++, u.removeClass("invalid")), va || (v.removeClass("disabled-section"), z.off("click"), y.each(function() {
                    $(this).removeClass("disabled"), $(this).prop("disabled", !1)
                }), va = !0))
            })
        }

        function g() {
            z.click(function() {
                u.hasClass("disabled-section") ? w.trigger("change") : i() || u.hasClass("invalid") || u.addClass("invalid")
            }), y.change(function() {
                "" === $(this).val().trim() ? $(this).hasClass("invalid") || $(this).addClass("invalid") : $(this).removeClass("invalid")
            })
        }

        function h() {
            var a = !0;
            return ("" === I.val().trim() || "" === J.val().trim() || "" === G.val().trim() || "" === H.val().trim()) && (a = !1), ("" === E.val().trim() || E.hasClass("invalid")) && (a = !1), F.hasClass("invalid") && (a = !1), a
        }

        function i() {
            var a = !1;
            return x.each(function() {
                $(this).hasClass("selected") && (a = !0)
            }), a
        }

        function j() {
            var a = !0;
            return "" === K.val().trim() && (a = !1), "" === r.val().trim() && (a = !1), a
        }

        function k() {
            q.submit(function(a) {
                a.preventDefault();
                var b = h(),
                    c = j();
                b && c ? (n(), L.prop("disabled", !0)) : (w.trigger("change"), y.trigger("change"))
            })
        }

        function l() {
            A.fadeIn("fast"), B.modal("show"), setTimeout(function() {
                B.modal("hide")
            }, 3e3)
        }

        function m() {
            w.each(function() {
                $(this).add("disabled"), $(this).prop("disabled", !0)
            }), y.each(function() {
                $(this).add("disabled"), $(this).prop("disabled", !0)
            })
        }

        function n() {
            var a = [];
            $(".interest.selected").each(function() {
                a.push($(this).attr("data-theme"))
            }), O = $(xa + " " + ya), P = $(xa + " " + za), Q = $(xa + " " + Ba), R = $(xa + " " + Aa), S = $(xa + " " + Da), T = $(xa + " " + Ca), U = $(xa + " " + Fa), V = $(xa + " " + Ga), N = $(xa), W = $(xa + " " + Ha), O.val(I.val()), P.val(J.val()), Q.val(G.val()), R.val(H.val()), S.val(F.val()), T.val(E.val()), U.val(K.val()), V.val(r.val()), W.prop("checked", s.prop("checked")), $.each(a, function(a, b) {
                X = $(xa + " " + Ea + '[value="' + b + '"]'), X.prop("checked", !0)
            }), N.submit(), m()
        }

        function o(a) {
            var b = p(a.val());
            b ? a.removeClass("invalid") : a.addClass("invalid")
        }

        function p(a) {
            return app.lib.util.validateEmail(a)
        }
        var q, r, s, t, u, v, w, x, y, z, A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P, Q, R, S, T, U, V, W, X, Y = ".contact-form",
            Z = ".message",
            _ = ".newsletter",
            aa = '.step[name="firstname"]',
            ba = '.step[name="lastname"]',
            ca = '.step[name="company"]',
            da = '.step[name="title"]',
            ea = '.step[name="email"]',
            fa = '.step[name="phone"]',
            ga = '.step[name="heard"]',
            ha = ".step-1",
            ia = ".step-2",
            ja = ".step-3",
            ka = ".step-1 .step",
            la = ".step-2 .interest",
            ma = ".step-3 .step, .step-3 .message, .step-3 .newsletter, .step-3 .submit-contact",
            na = ".step-3 .response-container, .step-3 .message-container, .step-3 .checkbox-container",
            oa = ".step-4.form-section",
            pa = "#contact-success",
            qa = ".next-step-2",
            ra = ".next-step-3",
            sa = ".step-3 .submit-contact",
            ta = ".option",
            ua = !1,
            va = !1,
            wa = 0,
            xa = "",
            ya = '.hs-input[name="firstname"]',
            za = '.hs-input[name="lastname"]',
            Aa = '.hs-input[name="company"]',
            Ba = '.hs-input[name="jobtitle"]',
            Ca = '.hs-input[name="email"]',
            Da = '.hs-input[name="phone"]',
            Ea = ".hs-input",
            Fa = '.hs-input[name="i_heard_about_undertone_from"]',
            Ga = '.hs-input[name="your_message"]',
            Ha = '.hs-input[name="sign_up_for_our_newsletter"]';
        app.templates.contact = {
            init: a
        }
    }(),
    function() {
        "use strict";

        function a(a) {
            d = $(a + " .ad-media"), d.length > 0 && (e = d.find(".launch-demo"), f = d.find(".view-gallery")), b(), c()
        }

        function b() {
            if (e.length > 0) {
                var a = e.data("devices"),
                    b = !1;
                a = a ? a.split(",") : [], b = a.indexOf("phone") > -1 && g.isPhone() || a.indexOf("tablet") > -1 && g.isTablet() || a.indexOf("desktop") > -1 && g.isDesktop(), b && e.removeClass("hidden")
            }
        }

        function c() {
            if (f.length > 0) {
                var a = f.data("devices"),
                    b = !1;
                a = a ? a.split(",") : [], b = a.indexOf("phone") > -1 && g.isPhone() || a.indexOf("tablet") > -1 && g.isTablet() || a.indexOf("desktop") > -1 && g.isDesktop(), b && f.removeClass("hidden")
            }
        }
        var d, e, f, g = app.lib.util;
        app.templates.formatSingle = {
            init: a
        }
    }(),
    function() {
        "use strict";

        function a() {
            var a = app.lib.util;
            a.isPhone() && a.setPerfectSquareByWidth($(".thumbnail-image"), !0, a.createUniqueId()), d = $(".load-more"), e = $(".posts-container"), b()
        }

        function b() {
            d.click(function(a) {
                a.preventDefault(), e.toggleClass("loading"), f = parseInt($(this).attr("data-page"));
                var b = $(this).data("elements"),
                    d = $(this).data("type"),
                    g = $(this).data("year"),
                    h = $(this).data("cat"),
                    i = $(this).data("author");
                $.get(ajaxUtil.url, {
                    nonce: ajaxUtil.nonce,
                    action: "more_posts",
                    page: f,
                    elements: b,
                    type: d,
                    year: g,
                    author: i,
                    cat: h
                }, function(a) {
                    c(a)
                })
            })
        }

        function c(a) {
            a = a.substring(0, a.length - 1), f++, d.before(a), d.attr("data-page", f), e.toggleClass("loading")
        }
        var d, e, f;
        app.templates.postIndex = {
            init: a
        }
    }(),
    function() {
        "use strict";

        function a(a, d, m) {
            e(), "research_post" === a && (f = $(".research-form"), g = $("#firstNameINPUT"), h = $("#lastNameINPUT"), i = $("#emailINPUT"), j = $("#companyINPUT"), k = $("#stateregionINPUT"), s = m, l = d, b(), c())
        }

        function b() {
            $("#infographicVisualLink").click(function(a) {
                a.preventDefault(), $("#infographicVisualCode").select();
                var b = "";
                try {
                    document.execCommand("copy"), b = "The code was copied to your clipboard."
                } catch (a) {
                    b = "Oops, unable to copy"
                }
                alert(b)
            })
        }

        function c() {
            f.submit(function(a) {
                a.preventDefault(), d()
            })
        }

        function d() {
            r = $(s), m = $(s + ' input[name="firstname"]'), n = $(s + ' input[name="lastname"]'), o = $(s + ' input[name="email"]'), p = $(s + ' input[name="company"]'), q = $(s + ' input[name="state"]'), m.val(g.val()), n.val(h.val()), o.val(i.val()), p.val(j.val()), q.val(k.val()), r.submit(), $(l).modal("hide")
        }

        function e() {
            $(".comment-form input[name='author']").val(""), $(".comment-form input[name='email']").val(""), $(".comment-form input[name='url']").val(""), $(".comment-form input[name='comment']").val("")
        }
        var f, g, h, i, j, k, l, m, n, o, p, q, r, s;
        app.templates.postSingle = {
            init: a
        }
    }(),
    function() {
        "use strict";

        function a() {
            n = $(".gallery-tpl"), n.length > 0 && (o = n.find(".filter-nav"), c(), d(), o && e(!1), p = n.find(".load-trigger"))
        }

        function b() {
            q || (q = new Waypoint({
                element: p[0],
                offset: "bottom-in-view",
                handler: function(a) {
                    if($('.favorite').hasClass('faved')){

                    } else {
                        "down" === a && (p.addClass("loading"), k(s, 0))
                    }                    
                }
            }))
        }

        function c() {
            $(window).resize(function() {
                d()
            }), k(1, 1)
        }

        function d() {
            var a = n.find(r);
            a.each(function() {
                var a = $(this),
                    b = a.find(".gallery-post-content"),
                    c = a.find(".post-img");
                a.off("click"), c.load(function() {
                    b.height(a.height()), Waypoint.refreshAll()
                }), b.height(a.height()), i(a), Waypoint.refreshAll()
            })
        }

        function e(a) {
            var b = o.find(".reset");
            var fav = o.find(".favorite");
            if (o.find(".dropdown-menu a").bind("click", g), fav.bind('click', h), b.unbind("click"), b.bind("click", h), a && !u) {
                var c = app.lib.util.getUrlParameter("form"),
                    d = app.lib.util.getUrlParameter("vertical"),
                    e = app.lib.util.getUrlParameter("feature"),
                    f = app.lib.util.getUrlParameter("device"),
                    fav = app.lib.util.getUrlParameter("favorite");;
                j(1, c), j(2, d), j(3, e), j(4, f), j(5, fav), u = !0
            }
        }

        function f(a) {
            var b = o.find(".menu-entry-template").html(),
                c = o.find(".dropdown.formats .dropdown-menu"),
                d = o.find(".dropdown.verticals .dropdown-menu"),
                f = o.find(".dropdown.features .dropdown-menu"),
                g = o.find(".dropdown.devices .dropdown-menu"),
                h = Handlebars.compile(b),
                i = c.html(h(a.formats)).$promise,
                j = d.html(h(a.verticals)).$promise,
                k = f.html(h(a.features)).$promise,
                l = g.html(h(a.devices)).$promise;
            $.when(i, j, k, l).done(function() {
                e(!0)
            })
        }

        function g(a) {            
            if($(this).hasClass('favorite')){
                var b = $(this),
                c = b.closest(".dropdown").first(),
                d = c.find(".dropdown-toggle"),
                e = b.data("id"),
                f = b.text();
                $(this).addClass('faved');
                k(1, 0, b), a.preventDefault()
            } else {
                var b = $(this),
                c = b.closest(".dropdown").first(),
                d = c.find(".dropdown-toggle"),
                e = b.data("id"),
                f = b.text();
                $('.favorite').removeClass('faved');
                d.text(f), c.data("selected", e), k(1, 0), a.preventDefault()
            }            
        }

        function h() {
            if($(this).hasClass('favorite')){
                $(this).addClass('faved');
            } else {
                $('.favorite').removeClass('faved');
            }
            var me = $(this);
            var a = o.find(".dropdown");
            a.each(function() {
                var a = $(this),
                    b = a.find(".dropdown-toggle");
                a.data("selected", ""), b.text(b.data("default-text"))
            }), window.history.replaceState(null, null, window.location.pathname), k(1, 0, me)
        }

        function i(a) {
            // add click to campaign box
            a.click(function(b) {
                b.preventDefault();
                var c = a.find(".btn-cms.btn-green").attr("href");
                $(location).attr("href", c)
            })
        }

        function j(a, b) {
            var c, d, e;
            switch (a) {
                case 1:
                    c = $(".dropdown.formats [data-id='" + b + "']");
                    break;
                case 2:
                    c = $(".dropdown.verticals [data-id='" + b + "']");
                    break;
                case 3:
                    c = $(".dropdown.features [data-id='" + b + "']");
                    break;
                case 4:
                    c = $(".dropdown.devices [data-id='" + b + "']");
                    break;
                case 5:
                    c = $(".favorite");
            }
            c.length > 0 && (d = c.closest(".dropdown").first(), e = d.find(".dropdown-toggle"), e.text(c.text()), d.data("selected", c.data("id")))
        }

        function k(a, c, el) {
            t = !0, a = a ? a : 1;
            var d = "",
                e = "",
                g = "",
                h = "",
                fav = "";
                el = el;
            c && (
                fav = app.lib.util.getUrlParameter("favorite"), 
                d = app.lib.util.getUrlParameter("form"), 
                e = app.lib.util.getUrlParameter("vertical"), 
                g = app.lib.util.getUrlParameter("feature"), 
                h = app.lib.util.getUrlParameter("device"));
                if(el && el.hasClass('favorite')){
                    ("" === fav || null === fav || void 0 === fav) && (fav = true);
                }
                ("" === d || null === d || void 0 === d) && (d = o.find(".dropdown.formats").data("selected")), 
                ("" === e || null === e || void 0 === e) && (e = o.find(".dropdown.verticals").data("selected")), 
                ("" === g || null === g || void 0 === g) && (g = o.find(".dropdown.features").data("selected")), 
                ("" === h || null === h || void 0 === h) && (h = o.find(".dropdown.devices").data("selected")),
                ("" === h || null === h || void 0 === h) && (h = o.find(".dropdown.devices").data("selected"));
            var i = n.find(".gallery-contents"),
                j = i.find(".gallery-contents-inner"),
                k = n.find(".no-results");
            k.addClass("hidden"), 1 === a && i.addClass("loading"), o.addClass("loading"), $.get(ajaxUtil.url, {
                nonce: ajaxUtil.nonce,
                action: "gallery_get",
                format: d,
                vertical: e,
                feature: g,
                device: h,
                page: a,
                favorite: fav
            }, function(c) {                
                f(c.filters), i.removeClass("loading"), p.removeClass("loading"), o.removeClass("loading");
                var d = n.find(".entry-template").html(),
                    e = Handlebars.compile(d),
                    g = e(c.results);
                m(), 1 === a ? j.html(g).promise().done(function() {
                    l(c.results, a), s = c.results.length > 0 ? 2 : 1, b()
                }) : j.append(g).promise().done(function() {
                    l(c.results, a), c.results.length > 0 && s++
                })
            })
        }

        function l(a, b) {
            var c = n.find(".no-results");
            d(), t = !1, Waypoint.refreshAll(), p.removeClass("loading"), 0 === a.length && 1 === b && c.removeClass("hidden")
        }

        function m() {
            var a = "",
                b = o.find(".dropdown.formats").data("selected"),
                c = o.find(".dropdown.verticals").data("selected"),
                d = o.find(".dropdown.features").data("selected"),
                e = o.find(".dropdown.devices").data("selected"),
                fav = o.find(".favorite").data("selected");
            "" !== b && null !== b && void 0 !== b && (a += "form=" + b + "&"), "" !== c && null !== c && void 0 !== c && (a += "vertical=" + c + "&"), "" !== d && null !== d && void 0 !== d && (a += "feature=" + d + "&"), "" !== e && null !== e && void 0 !== e && (a += "device=" + e + "&"), "" !== a && (a = window.location.pathname + "?" + a, window.history.replaceState(null, null, a))
            console.log('a: '+a);
        }
        var n, o, p, q, r = ".gallery-post",
            s = 1,
            t = !1,
            u = !1;
        app.templates.gallery = {
            init: a
        }
    }(),
    function() {
        "use strict";
        var a = function(a, b, c) {
            this.$element = $(a), "devices" === b ? this.$element.length > 0 && (this.stoppedVideosCount = 0, this.$videos = this.$element.find("video"), this.setPlayVideosWaypoint(), this.setDeviceSectionHeight(), app.lib.scrolling.scrollToAnchorLink(), this.eventHandlers(), this.isFirefox = navigator.userAgent.toLowerCase().indexOf("firefox") > -1) : "wistia" === b && this.setWistia(c)
        };
        a.prototype.playVideos = function() {
            var a, b = this,
                c = b.$videos.length;
            a = setInterval(function() {
                var d = 0;
                b.$videos.each(function() {
                    (this.readyState > 3 || b.isFirefox) && d++, d === c && (clearInterval(a), b.$videos.each(function() {
                        this.play()
                    }))
                })
            }, 500)
        }, a.prototype.setPlayVideosWaypoint = function() {
            var a = this;
            new Waypoint({
                element: a.$element,
                handler: function(b) {
                    "down" === b && a.playVideos()
                },
                offset: "50%"
            })
        }, a.prototype.eventHandlers = function() {
            var a = this;
            a.$element.find("img").each(function() {
                $(this).load(function() {
                    a.setDeviceSectionHeight()
                })
            }), $(window).resize(function() {
                a.setDeviceSectionHeight()
            }), a.$videos.bind("ended", function() {
                a.stoppedVideosCount >= $videos.length - 1 && (a.$videos.each(function() {
                    this.pause(), this.currentTime = 0, this.play()
                }), a.stoppedVideosCount = -1), a.stoppedVideosCount++
            })
        }, a.prototype.setDeviceSectionHeight = function() {
            var a = this,
                b = 0,
                c = a.$element.find(".device");
            c.each(function() {
                var a = $(this),
                    c = a.height();
                b = c > b ? c : b
            }), a.$element.height(b)
        }, a.prototype.setWistia = function(a) {
            Wistia.embed(a, {
                autoPlay: !0,
                playbar: !1,
                volume: 0,
                endVideoBehavior: "loop"
            })
        }, app.components.adMedia = a
    }(),
    function() {
        "use strict";

        function a(a) {
            H = a, l = $(".footer-bar > .menu-item"), m = $(".links-and-submit"), n = $(".triangle-background"), o = $(".footer-newsletter"), p = $(".newsletter-complete"), r = $(".submit-email"), s = $("input[name='newsFirstName']"), t = $("input[name='newsLastName']"), u = $("input[name='newsJob']"), v = $("input[name='newsCompany']"), q = $("input[name='email2']"), w = $("#modal-buttons"), y = $("#newsletter-part2"), x = $(".sucess-message-form"), z = $(".newsletter-complete .step"), b(), c(), f(), d(), e();
            var g = (app.lib.util.createUniqueId(), app.lib.util.getUrlParameter("step"));
            k(g)
        }

        function b() {
            l.each(function() {
                $(this).addClass("col-xs-6 col-sm-3")
            })
        }

        function c() {
            var a = m.innerHeight();
            n.css("border-bottom-width", a), $(window).resize(function() {
                a = m.innerHeight(), n.css("border-bottom-width", a)
            })
        }

        function d() {
            o.click(function() {
                y.modal("show")
            })
        }

        function e() {
            p.on("submit", function(a) {
                a.preventDefault();
                var b = $(".footer-interest:checked");
                b.length > 0 && i() && j(b)
            })
        }

        function f() {
            z.change(function() {
                "email2" === $(this).attr("name") ? g($(this)) : "" === $(this).val() ? $(this).hasClass("invalid") || $(this).addClass("invalid") : $(this).removeClass("invalid")
            })
        }

        function g(a) {
            var b = h(a.val());
            b ? a.removeClass("invalid") : a.addClass("invalid")
        }

        function h(a) {
            return app.lib.util.validateEmail(a)
        }

        function i() {
            var a = !0;
            return ("" === s.val().trim() || "" === t.val().trim() || "" === u.val().trim() || "" === v.val().trim()) && (a = !1), ("" === q.val().trim() || q.hasClass("invalid")) && (a = !1), a
        }

        function j(a) {
            A = $(H), C = $(H + ' .hs-input[name="firstname"]'), D = $(H + ' .hs-input[name="lastname"]'), B = $(H + ' .hs-input[name="email"]'), F = $(H + ' .hs-input[name="jobtitle"]'), E = $(H + ' .hs-input[name="company"]'), C.val(s.val()), D.val(t.val()), F.val(u.val()), B.val(q.val()), E.val(v.val()), $.each(a, function(a, b) {
                G = $(H + ' .hs-input[value="' + $(b).attr("name") + '"]'), G.prop("checked", !0)
            }), A.submit()
        }

        function k(a) {
            "one" === a && (y.modal("show"), $("#newsletter-part2 :input").prop("disabled", !0), $(".btn-okay").prop("disabled", !1), w.hide(), x.show())
        }
        var l, m, n, o, p, q, r, s, t, u, v, w, x, y, z, A, B, C, D, E, F, G, H = "";
        app.components.footer = {
            init: a
        }
    }(),
    function() {
        var a = function(a) {
            this.METRIC_TYPE = {
                CTR: {
                    selector: ".metric.ctr"
                },
                INTERACTION: {
                    selector: ".metric.interaction"
                },
                COMPLETED_VIEW_RATE: {
                    selector: ".metric.completed-view-rate"
                }
            }, this.METRIC_KPI = {
                FORMAT: {
                    selector: ".metric-kpi.format"
                },
                STANDARD: {
                    selector: ".metric-kpi.standard"
                },
                selector: ".metric-kpi"
            }, this.SELECTOR_METRIC_VALUE = ".metric_value", this.SELECTOR_METRIC_BAR = ".metric-bar", this.BAR_MAX_SIZE = 190, this.METRIC_10_MAX_VALUE = 100, this.METRIC_MAX_VALUE = 10, this.ANIMATION_DURATION = 1500, this.selector = a, this.$element = $(a), this.hasStarted = !1, this.$element.length > 0 && (this.$element.data("controller", this), this.init())
        };
        a.prototype.init = function() {
            var a = this;
            a.$element.waypoint(function(b) {
                a.hasStarted || (a.hasStarted = !0, a.animateMetrics(a.METRIC_KPI.STANDARD), setTimeout(function() {
                    a.animateMetrics(a.METRIC_KPI.FORMAT)
                }, a.ANIMATION_DURATION))
            }, {
                offset: "bottom-in-view"
            })
        }, a.prototype.animateMetrics = function(a) {
            var b = this,
                c = b.$element.find(a.selector);
            c.each(function() {
                var a = $(this),
                    c = a.data("value"),
                    d = a.data("range");
                $({
                    value: 0
                }).animate({
                    value: c
                }, {
                    duration: b.ANIMATION_DURATION,
                    easing: "easeOutExpo",
                    progress: function(c, e) {
                        b.setMetricValue(a, this.value, d)
                    }
                })
            })
        }, a.prototype.setMetricValue = function(a, b, c) {
            var d = 10 === c ? this.METRIC_MAX_VALUE : this.METRIC_10_MAX_VALUE;
            b = b !== isNaN ? b : 0, b = d >= b ? b : d, b = b >= 0 ? b : 0;
            var e = a.find(this.SELECTOR_METRIC_VALUE),
                f = a.find(this.SELECTOR_METRIC_BAR),
                g = this.BAR_MAX_SIZE / 100 * (100 * b / d);
            e.text(b.toFixed(1)), f.width(g)
        }, app.components.formatMetrics = a
    }(),
    function() {
        "use strict";
        app.components.languageSelector = function(a, b) {
            var c = this;
            c.isInSmallNav = b, c.element = $("#" + a), c.element.length > 0 && (c.closeOnResize(), c.element.on("toggle", c.toggle), c.element.on("open", c.open), c.element.on("close", c.close))
        };
        var a = app.components.languageSelector.prototype;
        a.close = function() {
            var a = this;
            a.element.length > 0 && (app.lib.scrolling.enableScroll(), a.element.removeClass("show"), app.components.pageBlocker.unblock())
        }, a.open = function() {
            var a = this;
            a.element.length > 0 && (app.lib.scrolling.disableScroll(), a.element.addClass("show"), app.components.pageBlocker.block(function() {
                a.close()
            }))
        }, a.toggle = function() {
            var a = this;
            a.element.length > 0 && (a.element.hasClass("show") ? a.close() : a.open())
        }, a.isOpened = function() {
            var a = this;
            return a.element.length > 0 && a.element.hasClass("show")
        }, a.hasClass = function(a) {
            var b = this;
            return b.element.hasClass(a)
        }, a.addClass = function(a) {
            var b = this;
            return b.element.addClass(a)
        }, a.removeClass = function(a) {
            var b = this;
            return b.element.removeClass(a)
        }, a.slideToLeft = function(a) {
            var b = this;
            return b.element.addClass("left")
        }, a.hideToRight = function(a) {
            var b = this;
            return b.element.removeClass("left")
        }, a.closeOnResize = function() {
            var a = this;
            a.isInSmallNav || $(window).resize(function(b) {
                a.isOpened() && a.close()
            })
        }
    }(),
    function() {
        function a() {
            $.when(app.components.navigation.get(), app.components.navigationSmall.get()).done(function() {
                j = app.components.navigation, k = app.components.navigationSmall, i(), l.resolve()
            })
        }

        function b() {
            o || (o = !0, j && (app.components.pageBlocker.self().addClass(m), j.closeSearchComponent(), j.getSearchComponent().addClass(m), j.getLanguageSelector().addClass(m), j.addClass(m)), k.addClass(m))
        }

        function c() {
            o && (o = !1, j && (app.components.pageBlocker.self().removeClass(m), j.closeSearchComponent(), j.removeClass(m), j.getSearchComponent().removeClass(m), j.getLanguageSelector().removeClass(m)), k.removeClass(m))
        }

        function d(a) {
            return !!(a.hasClass(m) || a.find("." + m).size() > 0)
        }

        function e(a) {
            return !!(a.hasClass(n) || a.find("." + n).size() > 0)
        }

        function f(a) {
            d(a) || e(a) ? b() : c()
        }

        function g() {
            c()
        }

        function h() {
            return app.lib.breakpoint.isLarge() ? j.getHeight() : k.getHeight()
        }

        function i() {
            var a = $("." + m);
            a.each(function(a, e) {
                var f = $(e);
                new Waypoint({
                    element: f,
                    handler: function(a) {
                        "down" === a ? b() : d(f.prev()) ? b() : c()
                    }
                }), new Waypoint({
                    element: f,
                    handler: function(a) {
                        "down" === a ? d(f.next()) || c() : b()
                    },
                    offset: function() {
                        return -this.element.context.clientHeight
                    }
                })
            })
        }
        var j, k, l = $.Deferred(),
            m = "clearNav",
            n = "clearNavOnRequest",
            o = !1,
            p = function() {
                var a = this;
                return $.Deferred(function(b) {
                    $.when(l).done(function() {
                        b.resolve(a)
                    })
                })
            };
        app.components.navigationGeneral = {
            init: a,
            get: p,
            setClearNav: b,
            setGreenNav: c,
            hasClearNavClass: d,
            hasClearNavClassOnRequest: e,
            setNavBarVersion: f,
            showDefaultNav: g,
            createWaypoints: i,
            getMenuHeight: h
        }
    }(),
    function() {
        function a(a, b) {
            A = app.instances.SearchComponents[a], B = app.instances.LanguageSelectorComponents[b], v = $("#navigationDivSmall"), w = v.find(".menu-container"), x = v.find(".collapse-button"), z = w.find("ul:first"), C = w.find(".language-button"), l(z), f(), k(), app.lib.util.setFullHeightElements(!1), m(), n(), r(), s(), E.resolve()
        }

        function b() {
            return void 0 === v || "none" === v.css("display") ? 0 : v.height()
        }

        function c() {
            m(), x.addClass("opened"), w.addClass("opened"), A.open(), app.lib.scrolling.hideScroll()
        }

        function d() {
            x.removeClass("opened"), w.removeClass("opened"), A.close(), g(), app.lib.scrolling.enableScroll()
        }

        function e() {
            x.hasClass("opened") ? d() : c()
        }

        function f() {
            x.click(function(a) {
                e()
            })
        }

        function g() {
            h(), A.showLeft(), l(z), q()
        }

        function h() {
            y && (w.find(".past").removeClass("past"), y.removeClass("current"), y = void 0)
        }

        function i() {
            h(), p()
        }

        function j() {
            y || (l(z), q())
        }

        function k() {
            function a() {
                y.removeClass("current");
                var a = $("#" + $(this).attr("data-previous-item-id")).parent(".past");
                a.attr("id") === z.attr("id") && (A.showLeft(), q()), a.removeClass("past"), y.removeClass("current"), a.addClass("current"), y = a
            }

            function b() {
                var a = $(this).siblings(".sub-menu");
                a && (A.hideLeft(), o(), l(a))
            }
            var c = w.find(".sub-menu"),
                d = c.parent("li");
            d.each(function(c, d) {
                d = $(d);
                var e = "menu-item-" + c;
                d.attr("id", e), d.find("a:first").addClass("hasSubMenu");
                var f = $('<button class="next-submenu"></button>');
                d.append(f), f.click(b);
                var g = d.children("a:first").text(),
                    h = $('<li class="back-button-container"><a data-previous-item-id="' + e + '">' + g + "</a></li>");
                d.children(".sub-menu:first").prepend(h), h.children("a").click(a)
            })
        }

        function l(a, b) {
            b = !b || b, y && (y.removeClass("current"), b && y.addClass("past")), y = a, y.addClass("current")
        }

        function m() {
            D || (D = function() {
                "none" === v.css("display") && (d(), D = null)
            }, $(window).resize(function(a) {
                D && D()
            }))
        }

        function n() {
            w.find("a").each(function(a, b) {
                b = $(b), b.parent().hasClass("back-button-container") === !1 && b.click(function(a) {
                    d()
                })
            })
        }

        function o() {
            C.addClass("left"), C.removeClass("right")
        }

        function p() {
            C.addClass("right"), C.removeClass("left")
        }

        function q() {
            C.removeClass("right"), C.removeClass("left"), B.removeClass("current")
        }

        function r() {
            C.click(function(a) {
                B.addClass("current"), o(), A.hideLeft(), y.removeClass("current"), y.addClass("past"), y = void 0
            })
        }

        function s() {
            B.element.find(".back-button-container a").click(function(a) {
                B.removeClass("current"), l(z), q(), A.showLeft()
            })
        }

        function t(a) {
            v.addClass(a)
        }

        function u(a) {
            v.removeClass(a)
        }
        var v, w, x, y, z, A, B, C, D, E = $.Deferred(),
            F = function() {
                var a = this;
                return $.Deferred(function(b) {
                    $.when(E).done(function() {
                        b.resolve(a)
                    })
                })
            };
        app.components.navigationSmall = {
            init: a,
            getHeight: b,
            hideMenuOptions: i,
            showMenuOptions: j,
            addClass: t,
            removeClass: u,
            show: c,
            get: F
        }
    }(),
    function() {
        "use strict";

        function a(a, b) {
            r = app.instances.SearchComponents[a], s = app.instances.LanguageSelectorComponents[b], v = $(".navigationDiv"), w = v.find(".navigation-bar"), t = v.find(".search-button"), u = v.find(".language-button"), x = w.find("> li"), y = w.find("> li > .sub-menu"), c(), z = v.find(".background-arrow .left"), A = v.find(".background-arrow .arrow").width(), h(), i(), B.resolve()
        }

        function b() {
            return v.height()
        }

        function c() {
            x.each(function(a, b) {
                b = $(b), f(b), e(b)
            }), C.setSameHeight(y, !1, C.createUniqueId("sub-menus")), d(), $(window).resize(function() {
                "none" !== v.css("display") && C.setSameHeight(y, !1, C.createUniqueId("sub-menus"))
            })
        }

        function d() {
            y.each(function(a, b) {
                b = $(b);
                var c = b.children("li"),
                    d = c.size();
                d > 0 && c.css("width", 80 / d + "%")
            })
        }

        function e(a) {
            a.find(".sub-menu").size() > 0 && a.addClass("has-submenu")
        }

        function f(a) {
            var b = a.find(".sub-menu").length > 0;
            a.hover(function() {
                x.addClass("remove-arrow-in-current"), l(), m(), b && (v.addClass("show-arrow"), g($(this)))
            }, function() {
                b && v.removeClass("show-arrow"), x.removeClass("remove-arrow-in-current")
            })
        }

        function g(a) {
            var b = a.offset().left,
                c = parseInt(a.css("width").replace("px", "")),
                d = b + c / 2 - A / 2;
            z.width(d)
        }

        function h() {
            var a = v.find(".search-button");
            a.click(function(a) {
                n()
            })
        }

        function i() {
            u.click(function(a) {
                o()
            })
        }

        function j(a) {
            v.addClass(a)
        }

        function k(a) {
            v.removeClass(a)
        }

        function l() {
            r.close()
        }

        function m() {
            s.close()
        }

        function n() {
            s.hasClass("show") && s.toggle(), r.toggle()
        }

        function o() {
            r.hasClass("show") && r.toggle(), s.toggle()
        }

        function p() {
            return r
        }

        function q() {
            return s
        }
        var r, s, t, u, v, w, x, y, z, A, B = $.Deferred(),
            C = (app.lib.numbers, app.lib.util),
            D = function() {
                return $.Deferred(function(a) {
                    app.lib.browserDetection.isDesktop() === !1 ? (app.components.navigation = null, a.resolve(app.components.navigation)) : $.when(B).done(function() {
                        a.resolve(app.components.navigation)
                    })
                })
            };
        app.components.navigation = {
            init: a,
            closeSearchComponent: l,
            addClass: j,
            removeClass: k,
            getSearchComponent: p,
            getLanguageSelector: q,
            get: D,
            getHeight: b
        }
    }(),
    function() {
        "use strict";

        function a() {
            f = $(".page-blocker")
        }

        function b() {
            return f
        }

        function c(a) {
            f && (f.addClass("show"), a && e(a))
        }

        function d() {
            f && f.removeClass("show")
        }

        function e(a) {
            a && f && f.click(function(b) {
                a()
            })
        }
        var f;
        app.components.pageBlocker = {
            init: a,
            self: b,
            block: c,
            unblock: d
        }
    }(),
    function() {
        "use strict";

        function a(a) {
            k = $(O), l = $(N), m = $(Q), n = $(R), o = $(T), p = $(S), u = $(W), v = $(X), w = $(Y), r = $(P), x = $(Z), z = $(ba), A = $(aa), y = $(_), ca = a, b(k), c(), f(), h();
            var d = app.lib.util.getUrlParameter("hubspot");
            d && j()
        }

        function b(a) {
            app.lib.util.autogrowTextArea(a)
        }

        function c() {
            z.change(function() {
                "email" === $(this).attr("name") ? d($(this)) : "" === $(this).val() && "phone" !== $(this).attr("name") ? $(this).hasClass("invalid") || $(this).addClass("invalid") : $(this).removeClass("invalid")
            })
        }

        function d(a) {
            var b = e(a.val());
            b ? a.removeClass("invalid") : a.addClass("invalid")
        }

        function e(a) {
            return app.lib.util.validateEmail(a)
        }

        function f() {
            o.mask("(999) 999-9999")
        }

        function g() {
            var a = !0;
            return ("" === m.val().trim() || "" === n.val().trim() || "" === k.val().trim()) && (a = !1), ("" === p.val().trim() || p.hasClass("invalid")) && (a = !1), a
        }

        function h() {
            l.submit(function(a) {
                a.preventDefault(), g() && i()
            })
        }

        function i() {
            s = $(ca + " " + ka), q = $(U + ":checked"), t = $(V + ":checked"), G = $(ha + '[value="' + q.val() + '"]'), H = $(ia + '[value="' + t.val() + '"]'), B = $(ca), C = $(ca + " " + da), D = $(ca + " " + ea), E = $(ca + " " + ga), F = $(ca + " " + fa), M = $(ca + " " + ja), I = $(ca + " " + la), J = $(ca + " " + ma), K = $(ca + " " + na), L = $(ca + " " + oa), C.val(m.val()), D.val(n.val()), E.val(o.val()), F.val(p.val()), M.val(k.val()), s.val(r.val()), I.prop("checked", u.prop("checked")), J.prop("checked", v.prop("checked")), K.prop("checked", w.prop("checked")), L.prop("checked", x.prop("checked")), G.prop("checked", !0), H.prop("checked", !0), B.submit()
        }

        function j() {
            y.modal("show"), setTimeout(function() {
                y.modal("hide")
            }, 3e3)
        }
        var k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z, A, B, C, D, E, F, G, H, I, J, K, L, M, N = ".publisher-form",
            O = ".message",
            P = '.publisher-form input[name="website"]',
            Q = '.publisher-form input[name="firstName"]',
            R = '.publisher-form input[name="lastName"]',
            S = '.publisher-form input[name="email"]',
            T = '.publisher-form input[name="phoneNumber"]',
            U = '.publisher-form input[name="montlyTraffic"]',
            V = '.publisher-form input[name="inventoryType"]',
            W = '.publisher-form input[value="Mobile Web"]',
            X = '.publisher-form input[value="Mobile App"]',
            Y = '.publisher-form input[value="Tablet"]',
            Z = '.publisher-form input[value="Desktop"]',
            _ = "#publisher-form-success",
            aa = ".submit-publisher",
            ba = ".publisher-form .step",
            ca = "",
            da = '.hs-input[name="firstname"]',
            ea = '.hs-input[name="lastname"]',
            fa = '.hs-input[name="email"]',
            ga = '.hs-input[name="phone"]',
            ha = '.hs-input[name="monthly_unique_traffic"]',
            ia = '.hs-input[name="inventory_type"]',
            ja = '.hs-input[name="how_are_you_interested_in_working_with_us_"]',
            ka = '.hs-input[name="website"]',
            la = '.hs-input[value="Mobile Web"]',
            ma = '.hs-input[value="Mobile App"]',
            na = '.hs-input[value="Tablet"]',
            oa = '.hs-input[value="Desktop"]';
        app.components.publisherForm = {
            init: a
        }
    }(),
    function() {
        "use strict";
        var a = ".results-count",
            b = "no-results",
            c = "expand",
            d = "loading",
            e = ".tt-menu .tt-dataset",
            f = 6;
        app.components.search = function(a, b) {
            var c = this;
            b = "1" === b, c.element = $("#" + a), c.element.length > 0 && (c.selectorId = a, c.isInSmallNav = b, c.results = c.element.find(".search-results"), c.resultsInner = $(c.element.find(".search-results > .inner")), c.searchField = c.element.find(".search-field"), c.setFormSubmitEvent(c.element.find("form")), c.closeOnResize(), c.emptySearchOnFocus(), c.element.on("toggle", c.toggle), c.element.on("open", c.open), c.element.on("close", c.close), c.resultsPerPage = b ? 3 : 4, c.currentSearchString = "", b || c.initSuggestions())
        };
        var g = app.components.search.prototype;
        g.close = function() {
            var a = this;
            a.element.length > 0 && (a.showSiteScrollBar(), a.element.removeClass("show"), app.components.pageBlocker.unblock(), a.clear())
        }, g.open = function() {
            var a = this;
            a.element.length > 0 && (a.hideSiteScrollBar(), a.element.addClass("show"), app.components.pageBlocker.block(function() {
                a.close()
            }), a.element.removeClass(c), app.lib.browserDetection.isDesktop() && a.searchField.focus())
        }, g.toggle = function() {
            var a = this;
            a.element.length > 0 && (a.element.hasClass("show") ? a.close() : a.open())
        }, g.emptySearchOnFocus = function() {
            var a = this;
            a.searchField.focus(function() {
                a.clear(), a.element.removeClass(c)
            })
        }, g.isOpened = function() {
            var a = this;
            return a.element.length > 0 && a.element.hasClass("show")
        }, g.hideLeft = function() {
            var a = this;
            a.element.addClass("left")
        }, g.showLeft = function() {
            var a = this;
            a.element.removeClass("left")
        }, g.setFormSubmitEvent = function(a) {
            var b = this;
            a.on("submit", function(a) {
                a.preventDefault(), b.currentSearchString = b.searchField.val(), b.currentSearchString.length > 2 ? (b.search(b.currentSearchString, 1), b.isInSmallNav && app.components.navigationSmall.hideMenuOptions()) : 0 === b.currentSearchString.length && b.isInSmallNav && (app.components.navigationSmall.showMenuOptions(), b.clear(), b.element.removeClass(c))
            })
        }, g.search = function(f, g) {
            var h = this,
                i = $(e);
            h.element.addClass(d), $.get(ajaxUtil.url, {
                nonce: ajaxUtil.nonce,
                action: "search",
                searchString: f,
                page: g,
                resultsPerPage: h.resultsPerPage
            }, function(e) {
                if (__gaTracker && __gaTracker("send", {
                        hitType: "pageview",
                        page: "/?s=" + f,
                        title: "Search Page"
                    }), h.element.addClass(c), i && i.empty(), e.total > 0) {
                    var g;
                    h.element.removeClass(b), g = h.genResults(e.results) + h.genPager(e.page, e.totalPage), h.resultsInner.html(g).promise().done(function() {
                        h.pagerEvents(h)
                    }), h.results.find(a).text(e.total + " Results")
                } else h.element.addClass(b);
                h.element.removeClass(d), h.searchField.blur()
            })
        }, g.clear = function() {
            var c = this,
                e = c.element.find(".typeahead");
            c.resultsInner.html(""), c.searchField.val(""), c.results.find(a).text(""), c.element.removeClass(d), c.element.removeClass(b), e && c.searchField.typeahead("val", "")
        }, g.pagerEvents = function(a) {
            a.resultsInner.find("nav a").on("click", function(b) {
                if (b.preventDefault(), !$(this).parent().hasClass("disabled") && !a.element.hasClass(d)) {
                    var c = +$(this).attr("href");
                    a.search(a.currentSearchString, c)
                }
            })
        }, g.genResults = function(a) {
            for (var b = "<table>", c = 0; c < a.length; c++) {
                var d = a[c];
                b += "<tr><td><span>" + d.type + "</span></td><td>", b += "<h1>" + d.title + "</h1>", b += "<p>" + d.excerpt + "</p>", b += '<a href="' + d.permalink + '">' + d.permalink + "</a>", b += "</td></tr>"
            }
            return b += "</table>\n\n"
        }, g.addClass = function(a) {
            var b = this;
            b.element.addClass(a)
        }, g.hasClass = function(a) {
            var b = this;
            return b.element.hasClass(a)
        }, g.removeClass = function(a) {
            var b = this;
            return b.element.removeClass(a)
        }, g.closeOnResize = function() {
            var a = this;
            a.isInSmallNav || $(window).resize(function(b) {
                a.isOpened() && a.close()
            })
        }, g.genPager = function(a, b) {
            var c = Math.floor(f / 2),
                d = a > c + 1 ? a - c : 1,
                e = b > a + c ? a + c : b,
                g = '<nav><ul class="pagination">';
            g += 1 === a ? '<li class="disabled">' : "<li>", g += '<a href="' + (a - 1) + '" aria-label="Previous"><span aria-hidden="true" class="pag-arrow prev"></span></a></li>';
            for (var h = d; e >= h; h++) h === a ? g += '<li class="active"><a href="#">' + h + '<span class="sr-only">(current)</span></a></li>' : b > e && h === e ? (g += '<li><a href="' + h + '">...</a></li>', g += '<li><a href="' + b + '">' + b + "</a></li>") : g += '<li><a href="' + h + '">' + h + "</a></li>";
            return g += a === b ? '<li class="disabled">' : "<li>", g += '<a href="' + (a + 1) + '" aria-label="Next"><span aria-hidden="true" class="pag-arrow next"></span></a></li>', g += "</ul></nav>\n\n"
        }, g.initSuggestions = function() {
            var a = this,
                b = a.searchField.typeahead({
                    minLength: 3,
                    highlight: !0,
                    async: !0
                }, {
                    name: "search-suggestions",
                    source: a.getSuggestions,
                    display: "title",
                    limit: 3,
                    templates: {
                        header: '<span class="title">suggestions: </span>',
                        suggestion: Handlebars.compile('<span class="suggestion">{{title}}</span>)')
                    }
                });
            b.bind("typeahead:select", function(b, c) {
                a.search(c.title, 1)
            })
        }, g.getSuggestions = function(a, b, c) {
            $.get(ajaxUtil.url, {
                nonce: ajaxUtil.nonce,
                action: "search_suggestions",
                searchString: a
            }, function(a) {
                c(a)
            })
        }, g.hideSiteScrollBar = function() {
            app.lib.browserDetection.isMobileDevice() ? app.lib.scrolling.hideScroll() : app.lib.scrolling.disableScroll();
        }, g.showSiteScrollBar = function() {
            app.lib.browserDetection.isMobileDevice() ? app.lib.scrolling.showScroll() : app.lib.scrolling.enableScroll()
        }
    }(),
    function() {
        "use strict";

        function a(a, c, d) {
            c = "0" !== c;
            var e = "#wistia_" + a;
            b(a, e, c, d)
        }

        function b(a, b, f, g) {
            Wistia.embed(a, {
                autoPlay: !1,
                playButton: !1,
                playbar: !1,
                volume: f === !0 ? 100 : 0,
                endVideoBehavior: $(".unmissable").length ? "reset" : "loop",
                smallPlayButton: !1,
                fullscreenButton: !1,
                volumeControl: f
            }).ready(function() {
                var a = $(b).parent(".wistia-wrapper"),
                    h = $(b + " video");
                if (f) {
                    var i = a.find(".videoOverlay"),
                        j = $(a).parent().find("section"),
                        k = i.find(".playButton");
                    k.click(function(a) {
                        h.get(0).play(), i.addClass("hidden"), j.addClass("hidden")
                    }), "" !== g && d(k, g), k.removeClass("hidden")
                } else c(h), e(h, f)
            }).bind("play", function() {})
        }

        function c(a) {
            if (a.offset().top < 200) a.get(0).play();
            else var b = new Waypoint({
                element: a,
                handler: function(c) {
                    "down" === c && (a.get(0).play(), b && b.destroy())
                },
                offset: "70%"
            })
        }

        function d(a, b) {
            a.detach(), $(b).append(a)
        }

        function e(a, b) {
            a.on("verifyAutoPlay", function() {
                b === !1 && a.get(0).play()
            })
        }
        app.components.wistia = {
            init: a
        }
    }();