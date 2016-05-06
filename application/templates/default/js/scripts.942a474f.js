"use strict";
angular.module("muzloTemplateApp").factory("AudioService", function () {
    var a = {
        swf_path: "bower_components/audio5/swf/audio5js.swf",
        throw_errors: !0,
        format_time: !0
    }, b = new Audio5js(a);
    return b
}).factory("AudioServiceAd", function () {
    var a = {
        swf_path: "bower_components/audio5/swf/audio5js.swf",
        throw_errors: !0,
        format_time: !0
    }, b = new Audio5js(a);
    return b
}).controller("PlayerCtrl", ["$scope", "$http", "AudioService", "AudioServiceAd", function (a, b, c, d) {
    this.awesomeThings = ["HTML5 Boilerplate", "AngularJS", "Karma"], b.get(window.patternUrl).then(function (e) {
        function f(a, b) {
            var c = new FileReader;
            c.onload = b, c.readAsDataURL(a)
        }

        a.blobs = [], a.playerAd = d, a.player = c, a.timeoutAd = 0, a.pattern = e.data[0], a.patterns_dirs = a.pattern.patterns_dirs, a.patterns_dir = a.patterns_dirs[Object.keys(a.patterns_dirs)[0]], console.log("url advert " + window.advertUrl), console.log("length pattern dirs " + Object.keys(a.patterns_dirs).length), Object.keys(a.patterns_dirs).length > 0 && b.get(window.advertUrl).then(function (b) {
            a.ad = b.data[0].files, a.numberTrackAd = 0, a.adInterval = 60 * b.data[0].rhythm * 1e3, a.timeoutAd = a.adInterval, $.each(a.ad, function (b, c) {
                var d = new XMLHttpRequest;
                d.addEventListener("load", function () {
                    200 == d.status && (a.blobs[c.file_name] = d.response)
                }), d.open("GET", c.file_name), d.responseType = "blob", d.send(null)
            })
        }), $.each(a.patterns_dir.music_files, function (b, c) {
            var d = new XMLHttpRequest;
            d.addEventListener("load", function () {
                200 == d.status && (a.blobs[c.file_name] = d.response)
            }), d.open("GET", c.file_name), d.responseType = "blob", d.send(null)
        }), a.numberTrack = 0, a.checkPlaylistTime = function (a) {
            return !1
        }, a.findPlaylistTime = function () {
            return !1
        }, a.reset = function () {
            var b = new Date(1e3 * a.patterns_dir.time_start), c = new Date(1e3 * a.patterns_dir.time_end), d = !1;
            b = b.getHours() + ":" + b.getMinutes(), c = c.getHours() + ":" + c.getMinutes(), a.timeoutAd = a.adInterval, a.isReady() ? d = !0 : a.searchPlaylist() && (d = !0), d ? (a.numberTrack = 0, a.shuffle(), a.timeoutAd = a.adInterval, g(a.patterns_dir)) : a.resetAnimation()
        }, a.stop = function () {
            a.player.audio.pause()
        };
        var g = function (b) {
            a.blobs[b.music_files[a.numberTrack].file_name]instanceof Blob ? (console.log("blob"), f(a.blobs[b.music_files[a.numberTrack].file_name], function (b) {
                a.player.load(b.target.result), a.player.audio.play()
            })) : (console.log("no blob"), a.player.load(b.music_files[a.numberTrack].file_name), a.player.audio.play()), a.player.on("canplay", function () {
                a.resetAnimation()
            }), a.debug = function (b, c) {
                var d = new Date(1e3 * a.patterns_dir.time_start), e = new Date(1e3 * a.patterns_dir.time_end);
                d = d.getHours() + ":" + d.getMinutes(), e = e.getHours() + ":" + e.getMinutes()
            }
        };
        a.player.on("timeupdate", function (b, c) {
            a.isReady() || (a.player.audio.pause(), a.reset()), a.debug(b, c), a.timeoutAd -= 250, console.log(a.timeoutAd), a.timeoutAd <= 0 && (a.stop(), $(".ad").show(), $(".player-buttons").hide(), f(a.blobs[a.ad[a.numberTrackAd].file_name], function (b) {
                a.playerAd.load(b.target.result), a.playerAd.audio.play()
            }))
        }), a.playerAd.on("ended", function () {
            a.numberTrackAd++, a.numberTrackAd >= a.ad.length && (a.numberTrackAd = 0), a.timeoutAd = a.adInterval, setTimeout(function () {
                a.play(), $(".ad").hide(), $(".player-buttons").show()
            }, 1e3)
        }), a.player.on("ended", function () {
            setTimeout(function () {
                a.playNext()
            }, 1e3)
        }), a.playNext = function () {
            a.numberTrack++, a.numberTrack >= a.patterns_dir.music_files.length && (a.numberTrack = 0), g(a.patterns_dir)
        }, a.shuffle = function () {
            var b = function (a) {
                for (var b, c, d = a.length; d;)c = Math.floor(Math.random() * d--), b = a[d], a[d] = a[c], a[c] = b;
                return a
            };
            a.patterns_dir.music_files = b(a.patterns_dir.music_files)
        }, a.checkTimeInterval = function (a, b) {
            if (b > a) {
                if (moment(1e3 * a).format("HH:mm:ss") <= moment().format("HH:mm:ss") && moment(1e3 * b).format("HH:mm:ss") >= moment().format("HH:mm:ss"))return !0
            } else if (moment(1e3 * a).format("HH:mm:ss") <= moment().format("HH:mm:ss") || moment(1e3 * b).format("HH:mm:ss") >= moment().format("HH:mm:ss"))return !0;
            return !1
        }, a.isReady = function () {
            return a.checkTimeInterval(a.patterns_dir.time_start, a.patterns_dir.time_end) ? !0 : !1
        }, a.searchPlaylist = function () {
            var b = !1;
            return $.each(a.patterns_dirs, function (c, d) {
                return a.checkTimeInterval(d.time_start, d.time_end) ? (a.patterns_dir = d, b = !0, !0) : void 0
            }), b
        }, a.play = function () {
            a.player.position && !a.player.playing && a.isReady() ? a.player.audio.play() : a.player.position || a.reset(), setTimeout(function () {
                a.resetAnimation()
            }, 1e3)
        }, a.resetAnimation = function () {
            setTimeout(function () {
                $(".player-buttons .bg").removeClass("animated")
            }, 1e3)
        }, $(".player-buttons li.btn-play").click(function () {
            $(this).find("span.bg").addClass("bounce animated forever")
        })
    })
}]), function () {
    var a = function (b, c) {
        function d(b, c) {
            function d() {
                if (t.withControls) {
                    l.removeClass("active");
                    var a = o % 360 / n;
                    0 > a && (a = m + a), a > 0 && (a += 1), a || (a = 1), l.eq(a - 1).addClass("active")
                }
            }

            function e(a) {
                var b = o + a * n;
                k.css({
                    transform: "rotate" + u + "(" + b * v * -1 + "deg)",
                    transition: "transform " + t.speed / 1e3 + "s " + t.easing
                }), o = b, setTimeout(function () {
                    k.css("transition", "transform 0s"), d(), q = !1
                }, t.speed)
            }

            function f() {
                r > 1 ? (e(-1), $(".up").css("transform", "translateY(0%)"), r--, h()) : q = !1
            }

            function g(b) {
                console.log('scroll');
                if (!q || t.allowScrolluringAnim) {
                    q = !0;
                    console.log(b);
                    var c = b.originalEvent.wheelDelta || -b.originalEvent.detail;
                    
                    if (b.type == 'touchend') {
                        window.touchend = b.originalEvent.changedTouches[0].clientY;

                        if (window.touchend > window.touchstart+5) {
                            c = 1;
                        } else if (window.touchend < window.touchstart-5) {
                            c = -1;
                        }
                    }

                    c > 0 ? f() : 0 > c && a.navigateDown(), 4 == r ? ($(".cloud_women").removeAttr("style").addClass("animated"), setTimeout(function () {
                        $(".women").removeAttr("style").addClass("animated")
                    }, 1e3)) : setTimeout(function () {
                        $(".cloud_women").css({
                            visibility: "hidden",
                            "animation-name": "none"
                        }).removeClass("animated"), $(".women").css({
                            visibility: "hidden",
                            "animation-name": "none"
                        }).removeClass("animated")
                    }, 1e3)
                }
            }

            function h() {
                switch (r) {
                    case 1:
                        $(".r4").addClass("up"), $(".r2").addClass("down"), $(".r1").removeClass("up"), $(".r3").removeClass("down"), $(".r3").removeClass("up"), $(".r1").removeClass("down");
                        break;
                    case 2:
                        $(".r1").addClass("up"), $(".r3").addClass("down"), $(".r4").removeClass("up"), $(".r2").removeClass("down"), $(".r2").removeClass("up"), $(".r4").removeClass("down");
                        break;
                    case 3:
                        $(".r2").addClass("up"), $(".r4").addClass("down"), $(".r1").removeClass("up"), $(".r3").removeClass("down"), $(".r3").removeClass("up"), $(".r1").removeClass("down");
                        break;
                    case 5:
                        $(".r3").addClass("up"), $(".r1").addClass("down"), $(".r2").removeClass("up"), $(".r4").removeClass("down"), $(".r4").removeClass("up"), $(".r2").removeClass("down")
                }
                $(".up").css("transform", "translateY(-60%)"), $(".down").css("transform", "translateY(60%)")
            }

            function i(a) {
                j = a;
                var b = $(p + "wrapper", j), c = $(p + "inner", j), d = $(p + "item", j);
                m = d.length, n = 360 / m;
                var e = t.xRotation ? j.width() : j.height(), f = e * t.persMult, h = e / 2 / Math.tan(n / 2 * Math.PI / 180);
                b.css({
                    "-webkit-perspective": f + "px",
                    perspective: f + "px"
                }), c.css("transform", "translateZ(-" + h + "px)"), d.each(function (a) {
                    $(this).css("transform", "rotate" + u + "(" + a * n * v + "deg) translateZ(" + h + "px)")

                }), j.addClass("slider-ready"), k = $(p + "rotater", j), t.scrollRotation && j.on("mousewheel DOMMouseScroll touchend", g), j.on('touchstart', function(e){ window.touchstart =  e.originalEvent.touches[0].clientY; }) 

            }

            var j, k, l, m, n, o = 0, p = ".slider3d__", q = !1, r = 1, s = {
                xRotation: !1,
                speed: 1100,
                dragSpeedCoef: .7,
                handleSpeedCoef: 6,
                easing: "ease",
                persMult: 1.6,
                handlePersMult: 3,
                scrollRotation: !0,
                keysRotation: !1,
                globalDragRotation: !1,
                withControls: !1,
                handleAndGlobalDrag: !1,
                allowDragDuringAnim: !1,
                allowScrollDuringAnim: !1,
                allowKeysDuringAnim: !1,
                allowControlsDuringAnim: !1
            }, t = $.extend(s, c), u = t.xRotation ? "Y" : "X", v = t.xRotation ? 1 : -1;
            a.navigateDown = function () {
                6 != r ? (e(1), $(".down").css("transform", "translateY(0%)"), r++, h()) : q = !1
            }, i(b)
        }

        function e() {
            $(b).each(function () {
                d($(this), c)
            })
        }

        function f(a, b, c) {
            var d;
            return function () {
                var e = this, f = arguments, g = function () {
                    d = null, c || a.apply(e, f)
                }, h = c && !d;
                clearTimeout(d), d = setTimeout(g, b), h && a.apply(e, f)
            }
        }

        var g = f(function () {
            e()
        }, 100);
        $(window).on("resize", g), e()
    };
    window.rotatingSlider = a
}(), $(document).ready(function () {
    rotatingSlider(".slider3d", {xRotation: !1, globalDragRotation: !1}), $(window).resize()
}), angular.module("muzloTemplateApp").controller("LoginCtrl", ["$scope", "$http", "AudioService", "AudioServiceAd", function (a, b, c, d) {
    this.awesomeThings = ["HTML5 Boilerplate", "AngularJS", "Karma"], jQuery(".slider3d__item").each(function (a, b) {
        $(window).width() <= 960 ? void 0 != jQuery(b).attr("data-mob-video") && jQuery(b).data("mob-video").length > 0 && jQuery(b).vide({mp4: jQuery(b).data("mob-video")}, {
            volume: 1,
            playbackRate: 1,
            muted: !0,
            autoplay: !0,
            loop: !0,
            position: "50% 50%",
            posterType: "detect",
            resizing: !0
        }) : void 0 != jQuery(b).attr("data-video") && jQuery(b).data("video").length > 0 && jQuery(b).vide({mp4: jQuery(b).data("video")}, {
            volume: 1,
            playbackRate: 1,
            muted: !0,
            autoplay: !0,
            loop: !0,
            position: "50% 50%",
            posterType: "detect",
            resizing: !0
        })
    }), $(".arrow").each(function (a, b) {
        $(b).click(function (a) {
            a.preventDefault(), rotatingSlider.navigateDown()
        })
    }), $(".hint-right").each(function (a, b) {
        $(b).click(function (a) {
            console.log($(b).data("current-level")), a.preventDefault(), $("html, body").animate({scrollTop: $("." + $(b).data("current-level")).offset().top}, 1e3)
        })
    });
    var e = new WOW({boxClass: "wow", animateClass: "animated", offset: 0, mobile: !0, live: !0});
    e.init(), $(window).scroll(function () {
        console.log("window scrollTop = " + $(this).scrollTop()), $(this).scrollTop() > $(".level74").offset().top + $("html").height() || $(this).scrollTop() < $(".level74").offset().top - $("html").height() / 2 ? (console.log("hide wow"), $(".cloud_women").css({
            visibility: "hidden",
            "animation-name": "none"
        }).removeClass("animated"), $(".women").css({
            visibility: "hidden",
            "animation-name": "none"
        }).removeClass("animated")) : (console.log("show wow"), $(".cloud_women").removeAttr("style").addClass("animated"), setTimeout(function () {
            $(".women").removeAttr("style").addClass("animated")
        }, 1e3))
    })
}]), angular.module("muzloTemplateApp").run(["$templateCache", function (a) {
    a.put("views/login.html", '<div class="slider3d first"> <div class="slider3d__wrapper"> <div class="slider3d__inner"> <div class="slider3d__rotater"> <div class="slider3d__item level69" data-video="/video/web_one.mp4" data-mob-video="/video/web_one_mob.mp4"> <div class="content-wrapp"> <div class="rot r1"> <div class="wrap-center-block"> <div class="center-block"> <h2 class="slider3d__heading">YOUR ARTIFICIAL CLOUD</h2> </div> </div> </div> </div> <div class="hint-right" data-current-level="level80"> CUSTOMERS </div> <!-- Arrow Down --> <a href="#" class="arrow arrow-blink"></a> <!-- end Arrow Down --> </div> <div class="slider3d__item slider3d__item--dark"> <div class="content-wrapp"> <div class="rot r2 down"> <div class="wrap-center-block"> <div class="center-block"> <h2 class="slider3d__heading">WHAT IS THE SOUND OF YOUR SUCCESS?</h2> </div> </div> </div> </div> <!-- Arrow Down --> <a href="#" class="arrow arrow-blink arrow--dark"></a> <!-- end Arrow Down --> </div> <div class="slider3d__item" data-video="/video/web_two.mp4" data-mob-video="/video/web_two_mob.mp4"> <div class="content-wrapp"> <div class="rot r3"> <h2 class="slider3d__heading">HOW TO RULE THIS CROWD?</h2> </div> </div> <!-- Arrow Down --> <a href="#" class="arrow arrow-blink"></a> <!-- end Arrow Down --> </div> <div class="slider3d__item level74"> <div class="wrap-center-block"> <div class="center-block"> <div class="cloud_women wow slideInUp"></div> <div class="women wow slideInUp" data-wow-delay="1s"></div> </div> </div><a href="#" class="arrow arrow-blink" ></a> </div> <div class="slider3d__item" class="level76" data-video="/video/BG.mp4"> <div class="content-wrapp"> <div class="rot r4"> <h2 class="slider3d__heading">WHAT IF MUSIC CAN HELP?</h2> </div> </div> <!-- Arrow Down --> <a href="#" class="arrow arrow-blink"></a> <!-- end Arrow Down --> </div> <div class="slider3d__item"> <div class="wrap-line level-block level79"> <div class="shadow"></div> <div class="line"> <!-- Center Block --> <div class="wrap-center-block"> <div class="center-block"> <div class="text-block wow fadeIn"> <p style="text-align: center"><span style="color:rgb(255, 255, 255); font-size:24px">Fully customized online sound design for your shopping centre, hotel, spa, restaurant or any other public spaces.</span><br> <span style="color:rgb(255, 255, 255); font-size:24px">Beautiful soundwaves from hour to hour with your voice announcements on demand.</span> </p> </div> </div> </div> <!-- end Center Block --> </div> </div> <div class="wrap-form level80"> <div class="wrap-center-block"> <div class="center-block"> <div class="form"> <form method="POST" action="/user_login/"> <div class="for-input wow bounceInUp"> <input type="password" name="ext_login" placeholder="Please enter your code"> </div> <button type="submit" class="btn wow bounceInUp" data-wow-delay="0.5s">GO!</button> </form> </div> </div> </div> </div> </div> </div> </div> </div> </div> <!--&lt;!&ndash; Block1 &ndash;&gt;--> <!--<div class="wrap-header level-block level69" data-video="/video/web_one.mp4">--> <!--<div class="shadow"></div>--> <!--<div class="header">--> <!--&lt;!&ndash; Top &ndash;&gt;--> <!--<div class="top">--> <!--<div class="hint-left">--> <!--<div class="table">--> <!--<div class="table-cell">--> <!--<div class="text">--> <!--</div>--> <!--</div>--> <!--</div>--> <!--</div>--> <!--<div class="hint-right" data-current-level="level80">--> <!--CUSTOMERS--> <!--</div>--> <!--</div>--> <!--&lt;!&ndash; end Top &ndash;&gt;--> <!--&lt;!&ndash; Center Block &ndash;&gt;--> <!--<div class="wrap-center-block">--> <!--<div class="center-block">--> <!--<h1>YOUR ARTIFICIAL CLOUD</h1>--> <!--<h2></h2>--> <!--</div>--> <!--</div>--> <!--&lt;!&ndash; end Center Block &ndash;&gt;--> <!--&lt;!&ndash; Arrow Down &ndash;&gt;--> <!--<a href="#" class="arrow arrow-blink" data-current-level="level69"></a>--> <!--&lt;!&ndash; end Arrow Down &ndash;&gt;--> <!--</div>--> <!--</div>--> <!--&lt;!&ndash; end Block1 &ndash;&gt;--> <!--&lt;!&ndash; Block2 &ndash;&gt;--> <!--<div class="wrap-header level-block level71" >--> <!--<div class="shadow"></div>--> <!--<div class="header">--> <!--&lt;!&ndash; Top &ndash;&gt;--> <!--<div class="top">--> <!--<div class="hint-left">--> <!--<div class="table">--> <!--<div class="table-cell">--> <!--<div class="text">--> <!--</div>--> <!--</div>--> <!--</div>--> <!--</div>--> <!--<div class="hint-right hint-right-none">--> <!--</div>--> <!--</div>--> <!--&lt;!&ndash; end Top &ndash;&gt;--> <!--&lt;!&ndash; Center Block &ndash;&gt;--> <!--<div class="wrap-center-block">--> <!--<div class="center-block">--> <!--<h1>WHAT IS THE SOUND OF YOUR SUCCESS?</h1>--> <!--<h2></h2>--> <!--</div>--> <!--</div>--> <!--&lt;!&ndash; end Center Block &ndash;&gt;--> <!--</div>--> <!--</div>--> <!--&lt;!&ndash; end Block2 &ndash;&gt;--> <!--&lt;!&ndash; Block3 &ndash;&gt;--> <!--<div class="wrap-header level-block level72" data-video="/video/web_two.mp4">--> <!--<div class="shadow"></div>/--> <!--<div class="header">--> <!--&lt;!&ndash; Top &ndash;&gt;--> <!--<div class="top">--> <!--<div class="hint-left">--> <!--<div class="table">--> <!--<div class="table-cell">--> <!--<div class="text">--> <!--</div>--> <!--</div>--> <!--</div>--> <!--</div>--> <!--<div class="hint-right hint-right-none">--> <!--</div>--> <!--</div>--> <!--&lt;!&ndash; end Top &ndash;&gt;--> <!--&lt;!&ndash; Center Block &ndash;&gt;--> <!--<div class="wrap-center-block">--> <!--<div class="center-block">--> <!--<h1>HOW TO RULE THIS CROWD?</h1>--> <!--<h2></h2>--> <!--</div>--> <!--</div>--> <!--&lt;!&ndash; end Center Block &ndash;&gt;--> <!--</div>--> <!--</div>--> <!--&lt;!&ndash; end Block3 &ndash;&gt;--> <!--&lt;!&ndash; Block4 &ndash;&gt;--> <!--<div class="wrap-header level-block level74" >--> <!--<div class="shadow"></div>--> <!--<div class="header">--> <!--&lt;!&ndash; Top &ndash;&gt;--> <!--<div class="top">--> <!--<div class="hint-left">--> <!--<div class="table">--> <!--<div class="table-cell">--> <!--<div class="text">--> <!--</div>--> <!--</div>--> <!--</div>--> <!--</div>--> <!--<div class="hint-right hint-right-none">--> <!--</div>--> <!--</div>--> <!--&lt;!&ndash; end Top &ndash;&gt;--> <!--&lt;!&ndash; Center Block &ndash;&gt;--> <!--<div class="wrap-center-block">--> <!--<div class="center-block">--> <!--<h1></h1>--> <!--<h2></h2>--> <!--</div>--> <!--<div class="cloud_women wow slideInUp"></div>--> <!--<div class="women wow slideInUp" data-wow-delay="1s"></div>--> <!--</div>--> <!--&lt;!&ndash; end Center Block &ndash;&gt;--> <!--</div>--> <!--</div>--> <!--&lt;!&ndash; end Block4 &ndash;&gt;--> <!--&lt;!&ndash; Block5 &ndash;&gt;--> <!--<div class="wrap-header level-block level76" data-video="/video/BG.mp4">--> <!--<div class="shadow"></div>--> <!--<div class="header">--> <!--&lt;!&ndash; Top &ndash;&gt;--> <!--<div class="top">--> <!--<div class="hint-left">--> <!--<div class="table">--> <!--<div class="table-cell">--> <!--<div class="text">--> <!--</div>--> <!--</div>--> <!--</div>--> <!--</div>--> <!--<div class="hint-right hint-right-none">--> <!--</div>--> <!--</div>--> <!--&lt;!&ndash; end Top &ndash;&gt;--> <!--&lt;!&ndash; Center Block &ndash;&gt;--> <!--<div class="wrap-center-block">--> <!--<div class="center-block">--> <!--<h1>WHAT IF MUSIC CAN HELP?</h1>--> <!--<h2></h2>--> <!--</div>--> <!--</div>--> <!--&lt;!&ndash; end Center Block &ndash;&gt;--> <!--</div>--> <!--</div>--> <!--&lt;!&ndash; end Block5 &ndash;&gt;--> <!--&lt;!&ndash; Block6 &ndash;&gt;--> <!--<div class="wrap-line level-block level79">--> <!--<div class="shadow"></div>--> <!--<div class="line">--> <!--&lt;!&ndash; Center Block &ndash;&gt;--> <!--<div class="wrap-center-block">--> <!--<div class="center-block">--> <!--<div class="text-block wow fadeIn">--> <!--<p style="text-align: center;"><span style="color:rgb(255, 255, 255); font-size:24px">Fully customized online sound design for your shopping centre, hotel, spa, restaurant or any other public spaces.</span><br />--> <!--<span style="color:rgb(255, 255, 255); font-size:24px">Beautiful soundwaves from hour to hour with your voice announcements on demand.</span></p>--> <!--</div>--> <!--</div>--> <!--</div>--> <!--&lt;!&ndash; end Center Block &ndash;&gt;--> <!--</div>--> <!--</div>--> <!--&lt;!&ndash; end Block6 &ndash;&gt;--> <!--&lt;!&ndash; Block7 &ndash;&gt;--> <!--<div class="wrap-form level80">--> <!--<div class="wrap-center-block">--> <!--<div class="center-block">--> <!--<div class="form">--> <!--<form action="">--> <!--<div class="for-input wow bounceInUp">--> <!--<input type="password" placeholder="Please enter your code" />--> <!--</div>--> <!--<button type="submit" class="btn wow bounceInUp" data-wow-delay="0.5s">GO!</button>--> <!--</form>--> <!--</div>--> <!--</div>--> <!--</div>--> <!--</div>--> <!--&lt;!&ndash; end Block7 &ndash;&gt;-->'),a.put("views/main.html",'<!-- Video web_one --> <div class="wrap-block"> <div class="block block-1"> </div> </div> <!-- end Video web_one --> <!-- Text what is the sound of your success --> <div class="wrap-block"> <div class="block block-2"> what is the sound of your success? </div> </div> <!-- end Text what is the sound of your success --> <!-- Video web_two --> <div class="wrap-block"> <div class="block block-3"> </div> </div> <!-- end Video web_two --> <!-- Image baba --> <div class="wrap-block"> <div class="block block-4"> </div> </div> <!-- end Image baba --> <!-- Text What if music can help? --> <div class="wrap-block"> <div class="block block-5"> What if music can help? </div> </div> <!-- end Text What if music can help? --> <!-- Video BG--> <div class="wrap-block"> <div class="block block-6"> </div> </div> <!-- end Video BG --> <!-- Text big --> <div class="wrap-block"> <div class="block block-7"> Fully customized online sound design for your shopping centre, hotel, spa, restaurant or any other public spaces. Beautiful soundwaves from hour to hour with your voice announcements on demand. </div> </div> <!-- end Text big --> <!-- Log --> <div class="wrap-block"> <div class="wrap-form"><div class="form"><form method="POST" action="/user_login/" class="ng-pristine ng-valid"><div class="for-input"><input type="password" name="ext_login" placeholder="Enter your secret word"></div><button type="submit" class="btn">GO!</button> </form></div></div></div> <!-- end Log -->'),a.put("views/player.html",'<div class="debug"> </div> <div class="wrap-player"> <div class="player"> <div class="ad"> <div class="table"> <div class="table-cell"> <p>Реклама</p> </div> </div> </div> <div class="player-buttons"> <ul> <li class="btn-play" ng-click="play()"> <div class="wrap"> <span class="bg"></span> <span>PLAY</span> </div> </li> <li class="btn-stop" ng-click="stop()"> <div class="wrap"> <span class="bg"></span> <span>STOP</span> </div> </li> <li class="btn-reset" ng-click="reset()"> <div class="wrap"> <span class="bg"></span> <span>RESET</span> </div> </li> </ul> </div> </div> </div>')
}]);
