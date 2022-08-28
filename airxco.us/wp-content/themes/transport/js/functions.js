jQuery.fn.isOnScreen = function() {
    var win = jQuery(window);

    var viewport = {
        top: win.scrollTop(),
        left: win.scrollLeft()
    };
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height();

    var bounds = this.offset();
    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();

    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
}

var anpsSmoothScroll = (function (w, d, $) {
    // Smooth scroll to any element on page
    var SmoothScroll = function (node) {
        var adjusterNode = null
        var extraOffset = 10
        var adminBar = d.getElementById('wpadminbar')

        var setAdjuster = function (node, offset) {
            adjusterNode = node
            if (offset) extraOffset = offset
        }

        var getAdjuster = function () {
            var adminBarHeight = adminBar ? adminBar.getBoundingClientRect().height : 0
            if (!adjusterNode) return adminBarHeight + extraOffset
            var adjusterHeight = adjusterNode.getBoundingClientRect().height
            return (['fixed', 'sticky'].indexOf(w.getComputedStyle(adjusterNode).position) > -1)
                ? adjusterHeight + adminBarHeight + extraOffset
                : adminBarHeight + extraOffset
        }

        var scrollToNode = function (node, speed) {
            var speed = speed || 600
            return new Promise(function (resolve) {
                if (!node) return resolve(null)
                w.requestAnimationFrame(function () {
                    var maxScroll = d.body.scrollHeight - w.innerHeight
                    var nodeScrollOffset = Math.round(node.getBoundingClientRect().top - getAdjuster())
                    var scroll = Math.min(w.scrollY + nodeScrollOffset, maxScroll)
                    $('html, body').animate({ scrollTop: scroll }, speed, resolve)
                })
            })
        }

        if (node) setAdjuster(node)

        return {
            setAdjuster: setAdjuster,
            to: scrollToNode
        }
    }

    return SmoothScroll()
})(window, document, jQuery)

;(function (w, $) {
    'use strict'

    // Global variables
    var isJqueryReady = false
    var $containerMasonry = null
    var topOffset = 0
    var $siteHeader = null
    var changeTopOffset = null
    var isStickyHeader = false
    var scrollTopEl = null
    var scrollTopVisible = false


    // Global functions
    function throttle (fn, wait, raf) {
        wait = wait || 0
        raf = typeof raf === 'boolean' ? raf : true
        var waiting = false
        return function () {
            if (waiting) return
            var _this = this
            var _args = arguments
            waiting = true
            window.setTimeout(function () {
                waiting = false
                if (raf) {
                    window.requestAnimationFrame(function () { fn.apply(_this, _args) })
                } else {
                    fn.apply(_this, _args)
                }
            }, wait)
        }
    }

    function checkCoordinates(str) {
        if (!str) return false
        var coords = str.split(',')
        if (coords.length !== 2) return false
        return coords.reduce(function (acc, cur) {
            return acc ? !Number.isNaN(Number.parseFloat(cur)) : false
        }, true)
    }

    function equalHeight() {
        function setHeight(column) {
            var setHeight = $(column).outerHeight();
            $('> .wpb_column > .vc_column-inner', column).css('min-height', setHeight);
        }

        var child_height = 0;
        var column_height = 0;

        if ($('.site-wrapper').hasClass('legacy')) {
            $('.wpb_row.double-column').each(function() {
                $('.row .row > .wpb_column', this).each(function() {
                    if ($(this).outerHeight() > column_height) {
                        column_height = $(this).outerHeight();
                    }
                });
                $('.row', this).css("min-height", column_height);
            });
        } else {
            $('.wpb_row.double-column').each(function() {
                $('> .wpb_column > .vc_column-inner', this).css("min-height", column_height);
                setHeight(this);
            });
        }
    }

    function checkForOnScreen() {
        $('.counter-number').each(function(index) {
            var $el = $(this)
            if (!$el.hasClass('animated') && $el.isOnScreen()) {
                $el.addClass('animated')
                $el.countTo({ speed: 5000 })
            }
        })
    }

    function submenuHeight() {
        if (window.innerWidth <= 991) return
        $('.menu-item-depth-0 > .sub-menu').each(function() {
            $(this).css({ 'display': 'none', 'height': 'auto' });
            $(this).attr('data-height', $(this).height());
            $(this).attr('style', '');
        });
    }

    function makeTopOffsetChanger () {
        var $wpBar = $('#wpadminbar')
        var $topBar = $('.top-bar')
        var hasTopBar = $topBar.length
        var isHeaderTransparent = $('.site-header-style-transparent').length
        var isBoxedMenu = $('.site-header-style-boxed').length
        var isFullScreenMenuType = $('.site-header-style-full-width').length || isBoxedMenu
        var $preHeaderWrap = $('.preheader-wrap')
        var isSearchOpen = $('.site-search-opened').length
        var $siteSearch = $('.site-search')
        var $navBarWrapper = $('.nav-bar-wrapper')

        return function () {
            topOffset = $siteHeader.offset().top
            var wpBarHeight = $wpBar.length ? $wpBar.height() : 0

            if (isHeaderTransparent && hasTopBar) {
                var topBarHeight = $topBar.innerHeight()
                topOffset = window.innerWidth < 600
                    ? wpBarHeight + topBarHeight
                    : topBarHeight + Number.parseInt($('.nav-wrap').css('top').replace('px', ''))
            }
            if (window.innerWidth > 600) {
                topOffset -= wpBarHeight
            }

            if (isFullScreenMenuType) {
                if (window.innerWidth > 991) {
                    topOffset += $preHeaderWrap.height()
                } else {
                    topOffset = 0
                    if (window.innerWidth < 600) {
                        topOffset += wpBarHeight
                    }
                    if (isSearchOpen) {
                        topOffset += $siteSearch.height()
                    }
                }
                if (isBoxedMenu) {
                    topOffset -= $navBarWrapper.height() / 2
                }
            }
        }
    }

    function stickyHeader() {
        if (window.scrollY > topOffset) {
            $siteHeader.addClass('site-header-sticky-active')
        } else {
            $siteHeader.removeClass('site-header-sticky-active')
        }
    }

    function topBarSize() {
        $('.top-bar .container').css('height', $('.top-bar-left').innerHeight() + $('.top-bar-right').innerHeight() + 15);
    }

    function handleScrollTopLinkVisibility () {
        if (window.scrollY > 300 && !scrollTopVisible) {
            scrollTopVisible = true
            scrollTopEl.fadeIn()
        } else if (window.scrollY < 300 && scrollTopVisible) {
            scrollTopVisible = false
            scrollTopEl.fadeOut()
        }
    }

    function resizeMiniCart() {
        if (window.innerWidth < 768) {
            $('.preheader-wrap .hidden-lg.cartwrap .mini-cart').width(window.innerWidth - 60);
        } else {
            $('.preheader-wrap .hidden-lg.cartwrap .mini-cart').attr('style', '');
        }
    }

    /**
     * Run stuff once on window load
     */
    w.addEventListener('load', function () {
        if (w.location.hash) {
            var target = document.querySelector(w.location.hash)
            if (!target) return
            var waitForJquery = setInterval(function () {
                if (!isJqueryReady) return
                clearInterval(waitForJquery)
                w.anpsSmoothScroll.to(target)
            }, 100)
        }

        if (!isJqueryReady) return

        equalHeight()

    }, false)

    /**
     * Run stuff 5 times per second while the window is being resized
     */
    w.addEventListener('resize', throttle(function () {
        if (!isJqueryReady) return

        equalHeight()
        submenuHeight()
        changeTopOffset()

        if ($containerMasonry && $containerMasonry.length) {
            $containerMasonry.isotope('layout')
        }

        if (window.innerWidth > 991) {
            $('.top-bar .container').attr('style', '')
            $('.top-bar').removeClass('top-bar-show top-bar-hide')
        } else if ($('.top-bar-show').length) {
            topBarSize()
        }
    }, 200), false)

    /**
     * Run stuff on every frame while the window is being scrolled
     */
    w.addEventListener('scroll', function () {
        if (!isJqueryReady) return
        w.requestAnimationFrame(function () {
            if (isStickyHeader) {
                changeTopOffset()
                stickyHeader()
            }
        })
    }, { passive: true })

    /**
     * Run stuff 10 times per second while the window is being scrolled
     */
    w.addEventListener('scroll', throttle(function () {
        if (!isJqueryReady) return
        checkForOnScreen()
        if (scrollTopEl) handleScrollTopLinkVisibility()
    }, 100), { passive: true })

    /**
     * Run stuff once when jQuery is ready
     */
    $(function () {
        // Set values to global variables so that they can be used in other events later
        isJqueryReady = true
        $containerMasonry = $('.blog-masonry')
        topOffset = 0
        $siteHeader = $('.site-header')
        changeTopOffset = makeTopOffsetChanger()
        isStickyHeader = $siteHeader.hasClass('site-header-sticky')
        scrollTopEl = $('#scrolltop')

        if (isStickyHeader) stickyHeader()

        checkForOnScreen()
        submenuHeight()

        // Tabs navigation
        $('.nav-tabs a').on('click', function(e) {
            e.preventDefault()
            $(this).tab('show')
        });

        if ($containerMasonry && $containerMasonry.length) {
            $containerMasonry.isotope({
                itemSelector: '.blog-masonry .post',
                animationOptions: { duration: 450, queue: false }
            });
            $containerMasonry.isotope('layout')
        }

        // Isotope filtering
        function handleIsotopeFilterButton ($el, $container) {
            $el.addClass('selected')
            var item = $el.attr('data-filter') !== '*' ? '.' : ''
            item += $el.attr('data-filter')
            $container.isotope({ filter: item })
        }
        $('.isotope').each(function() {
            var $container = $(this)
            var isRandom = $container.hasClass('random')
            var width = $container.width()
            var isotopeConfig = { itemSelector: '.isotope li' }

            if (isRandom) {
                isotopeConfig.layoutMode = 'masonry'
                if (width > 1140) {
                    isotopeConfig.masonry = { columnWidth: 292 }
                } else if (width > 940) {
                    isotopeConfig.masonry = { columnWidth: 242 }
                } else {
                    isotopeConfig.layoutMode = 'fitRows'
                }
            } else {
                isotopeConfig.layoutMode = 'fitRows'
                isotopeConfig.animationOptions = { duration: 750, queue: false }
            }

            $container.isotope(isotopeConfig)

            if (isRandom) {
                $('.filter button').on('click', function() {
                    $('.filter button').removeClass('selected')
                    handleIsotopeFilterButton($(this), $container)
                })
            } else {
                var $filter = $container.parents('.wpb_column').find('.filter')
                $filter.find('button').on('click', function () {
                    $(this).parents('.filter').find('button').removeClass('selected')
                    handleIsotopeFilterButton($(this), $container)
                })
            }

            $(window).on('resize', throttle(function () {
                var $filter = $('.filter button.selected')
                if (!$filter.length) return

                var item = $filter.attr('data-filter') !== '*' ? '.' : ''
                item += $filter.attr('data-filter')
                $container.isotope({ filter: item })
                $container.isotope('layout')
                if (isRandom) {
                    width = $container.width()
                    if (width > 1140) {
                        isotopeConfig.masonry = { columnWidth: 292 }
                    } else if (width > 940) {
                        isotopeConfig.masonry = { columnWidth: 242 }
                    } else {
                        isotopeConfig.layoutMode = 'fitRows'
                    }
                    $container.isotope(isotopeConfig)
                }
            }, 500))

            $(window).on('load', function() {
                $container.isotope('layout')
            })
        })

        if ($(window).height > 700) {
            $('.fullscreen').css('height', window.innerHeight); //menu position on home page
        }

        $('.site-search-close').on('click', function() {
            $('.site-wrapper').removeClass('site-search-opened');
        });

        $('.site-search-toggle').on('click', function() {
            if( !$('.site-search-opened').length ) {
                $(window).scrollTop(0);
                $('.site-search-input').focus()
            }
            $('.site-wrapper').toggleClass('site-search-opened');
        });

        $('.navbar-toggle').on('click', function() {
            $('.site-navigation').toggleClass('site-navigation-opened')
        })

        if( !$('.menu-item-depth-0').length ) {
            $('#menu-main-menu > li').addClass('menu-item-depth-0');
        }

        if( $('.site-search-toggle') && !$('.site-search-toggle').hasClass('hidden-sm') ) {
            $('.cartwrap').addClass('cart-search-space');
        }

        $('.menu-item-depth-0 > a').on('mouseenter', function() {
            if( window.innerWidth > 991 ) {
                var $subMenu = $(this).siblings('.sub-menu');
                $subMenu.css('height', $subMenu.attr('data-height'));
            }
        });

        $('.menu-item-depth-0 > .sub-menu ').on('mouseenter', function() {
            if( window.innerWidth > 991 ) {
                $(this).css('height', $(this).attr('data-height'));
                $(this).css('overflow', 'visible');
            }
        });

        $('.menu-item-depth-0 > a').on('mouseleave', function() {
            var $subMenu = $(this).siblings('.sub-menu');
            $subMenu.attr('style', '');
        });

        $('.menu-item-depth-0 > .sub-menu').on('mouseleave', function() {
            $(this).attr('style', '');
        });

        $('.top-bar-close').on('click', function() {
            if (!$('.top-bar .container').attr('style')) {
                topBarSize()
                $('.top-bar').addClass('top-bar-show').removeClass('top-bar-hide')
            } else {
                $('.top-bar .container').attr('style', '')
                $('.top-bar').removeClass('top-bar-show').addClass('top-bar-hide')
            }
            $(this).trigger('blur')
        })

        $('.widget_product_search form').addClass('searchform');
        $('.searchform input[type="submit"]').remove();
        $('.searchform div').append('<button type="submit" class="fa fa-search" id="searchsubmit" value=""></button>');
        $('.searchform input[type="text"]').attr('placeholder', anps.search_placeholder);

        $('.blog-masonry').parent().removeClass('col-md-12');
        $('.post.style-3').parent().parent().removeClass('col-md-12').parent().removeClass('col-md-12');

        if ($.fn.prettyPhoto) {
            $("a[rel^='prettyPhoto']").prettyPhoto();
        }

        $('.show-register').on('click', function() {
            $('#customer_login h3, #customer_login .show-register').addClass('hidden');
            $('#customer_login .register').removeClass('hidden');
        });

        $('body').on('added_to_cart',function(e) {
            $('.added_to_cart').addClass('btn btn-md style-3');
        })

        $('.wpb_single_image .wpb_wrapper a[href$=".jpg"], .wpb_single_image .wpb_wrapper a[href$=".png"], .wpb_single_image .wpb_wrapper a[href$=".gif"]').attr('rel', 'lightbox');

        function doParallaxBg ($el, speed) {
            $(window).on('scroll', function() {
                window.requestAnimationFrame(function () {
                    var yPos = -($(window).scrollTop() / speed)
                    var coords = '50% ' + yPos + 'px'
                    $el.css({ backgroundPosition: coords })
                })
            })
        }

        $('.parallax-window[data-type="background"]').each(function() {
            var $bgobj = $(this)
            var speed = Number.parseInt($bgobj.data('speed'), 10)
            if (Number.isNaN(speed) || !speed) return
            doParallaxBg($bgobj, speed)
        })

        $('.paraslider .tp-bgimg.defaultimg').each(function() {
            var $bgobj = $(this)
            doParallaxBg($bgobj, 5)
        })

        // Set smooth scrolling adjusting element (header)
        window.anpsSmoothScroll.setAdjuster(document.querySelector('.site-header .nav-wrap'))

        var nav = $('.site-navigation')
        // Enable smooth scrolling on all elements with a 'js--scroll' class
        $(document).on('click', '.js--scroll', function (e) {
            e.preventDefault()
            var trigger = this
            var selector = trigger.getAttribute('href') || trigger.dataset.to
            var aUrl = null
            try { aUrl = new URL(selector, window.location.origin) } catch (e) {}
            if (aUrl) selector = aUrl.hash
            var target = document.querySelector(selector)
            if (!target) return
            anpsSmoothScroll.to(target).then(function () {
                // Readjust in case the adjuster's size changed
                anpsSmoothScroll.to(target, 100)
                // If the mobile nav is open, close it
                if (nav.hasClass('site-navigation-opened')) {
                    $('.navbar-toggle').trigger('click')
                }
                // If the trigger was a menu-item, move the current class
                if (trigger.parentNode.classList.contains('menu-item')) {
                    nav.find('.current-menu-item').removeClass('current-menu-item')
                    trigger.parentNode.classList.add('current-menu-item')
                }
            })
        })

        var setCurrentMenuItemFromHash = function (initRun) {
            var menuItems = nav.find('.menu-item')
            if (!menuItems.length) return
            var current = null
            menuItems.each(function () {
                var a = $('a', this).get(0)
                var aUrl = null
                try { aUrl = new URL(a.getAttribute('href'), window.location) } catch (e) {}
                if (!aUrl || aUrl.pathname !== window.location.pathname) return
                if (initRun && aUrl.hash) a.classList.add('js--scroll')
                if (aUrl.hash === window.location.hash) current = this
            })
            if (current) {
                current.classList.add('current-menu-item')
                return
            }
            var currentCandidates = nav.find('.current-menu-item')
            if (currentCandidates.length) {
                currentCandidates.removeClass('current-menu-item')
                currentCandidates.get(0).classList.add('current-menu-item')
            } else {
                menuItems.get(0).classList.add('current-menu-item')
            }
        }
        // Enable smooth scrolling for all menu items with a hash link
        setCurrentMenuItemFromHash(true)

        $('#menu-main-menu').doubleTapToGo()

        var $owls = $('.owl-carousel')
        if ($owls.length) {
            $owls.each(function() {
                var owl = $(this);
                var number_items = $(this).attr("data-col");
                var loop = true;
                if (number_items >= owl.children().length) {
                    loop = false;
                    owl.parents('.wpb_column').find('.owlprev, .owlnext').hide();
                }
                owl.owlCarousel({
                    loop: loop,
                    margin: 30,
                    responsiveClass: true,
                    nav: owl.data('nav') !== undefined,
                    navText: [
                        '<i class="fa fa-chevron-left"></i>',
                        '<i class="fa fa-chevron-right"></i>',
                    ],
                    responsive: {
                        0: { items: 1, slideBy: 1 },
                        600: { items: 2, slideBy: 2 },
                        992: { items: number_items, slideBy: number_items }
                    }
                })
                owl.siblings().find('.owlnext').on('click', function() {
                    owl.trigger('next.owl.carousel');
                });
                owl.siblings().find('.owlprev').on('click', function() {
                    owl.trigger('prev.owl.carousel');
                });
            });
        }

        $('.wpcf7-form-control-wrap > select').each(function() {
            $(this).parent('.wpcf7-form-control-wrap').addClass('anps-select-wrap')
        })

        $('.map').each(function() {
            var gmap = {
                zoom   : $(this).attr('data-zoom') ? Number.parseInt($(this).attr('data-zoom'), 10) : 15,
                address: $(this).attr('data-address'),
                markers: $(this).attr('data-markers'),
                icon   : $(this).attr('data-icon'),
                typeID : $(this).attr('data-type'),
                ID     : $(this).attr('id'),
                styles : $(this).attr('data-styles') ? JSON.parse($(this).attr('data-styles')): ''
            }
            var gmapScroll = $(this).attr('data-scroll') ? $(this).attr('data-scroll') : 'false';
            var markersArray = [];
            var bound = new google.maps.LatLngBounds();
            if (gmapScroll === 'false' ) {
                gmap.draggable = false
                gmap.scrollwheel = false
            }
            if (gmap.markers) {
                gmap.markers = gmap.markers.split('|')
                gmap.markers.forEach(function(marker) {
                    if (!marker) return
                    marker = $.parseJSON(marker)
                    if (checkCoordinates(marker.address)) {
                        marker.position = marker.address.split(',')
                        delete marker.address
                    }
                    markersArray.push(marker)
                })
                $('#' + gmap.ID).gmap3({
                    zoom       : gmap.zoom,
                    draggable  : gmap.draggable,
                    scrollwheel: gmap.scrollwheel,
                    mapTypeId  : google.maps.MapTypeId[gmap.typeID],
                    styles     : gmap.styles
                }).on({ 'tilesloaded': function() {
                        if ('anpsMapsLoaded' in window) window.anpsMapsLoaded()
                }}).marker(markersArray).then(function(results) {
                    var center = null
                    window.anpsMarkers = results;
                    if (typeof results[0].position.lat !== 'function' || typeof results[0].position.lng !== 'function') return false
                    results.forEach(function(m, i) {
                        if (markersArray[i].center) {
                            center = new google.maps.LatLng(m.position.lat(), m.position.lng())
                        } else {
                            bound.extend(new google.maps.LatLng(m.position.lat(), m.position.lng()))
                        }
                    })
                    if (!center) center = bound.getCenter()
                    this.get(0).setCenter(center)
                }).infowindow({ content: '' }).then(function (infowindow) {
                    var map = this.get(0);
                    this.get(1).forEach(function(marker) {
                        if (!marker.data) return
                        marker.addListener('click', function() {
                            infowindow.setContent(decodeURIComponent(marker.data))
                            ifowindow.open(map, marker)
                        })
                    })
                })
            } else {
                console.error('No markers found. Add markers to the Google maps item using Visual Composer.');
            }
        })

        resizeMiniCart()

        $('.anps_line-chart').each(function() {
            var data = JSON.parse($(this).attr('data-vc-values'));
            var chart = $(this).find('.anps_line-chart-canvas').get(0).getContext('2d');
            chart.canvas.width = $(this).parents(".wpb_column").width();
            chart.canvas.height = $(this).attr('data-anps-height') || 221;
            new Chart(chart).Line(data, { responsive: true });
        });

        $('.anps_round-chart').each(function() {
            var data = JSON.parse($(this).attr('data-vc-values'));
            var chart = $(this).find('.anps_round-chart-canvas').get(0).getContext('2d');
            chart.canvas.width = $(this).parents(".wpb_column").width();
            chart.canvas.height = $(this).attr('data-anps-height') * 1.76 || 221;
            new Chart(chart).Pie(data, { responsive: true });
        });

        $('.vc_tta-style-anps-ts-2 .vc_tta-tabs-container.col-sm-3').each(function() {
            $(this).siblings('.col-sm-9').find('.vc_tta-panel-body > *').css('min-height', $(this).height() + 'px');
        });

        $('.product-header').on('click', 'a', function(e) {
            if( $(this).css('opacity') != 1 ) {
                e.preventDefault();
                return false;
            }
        });

        $('.tnp-email').attr('placeholder', $('.tnp-field label').text());
        $('.tnp-field-button').on('click', function (e) {
            if(e.target.nodeName == 'DIV') {
                $(this).find('.tnp-button').click();
            }
        });
    })
    /*-----------------------------------------------------------------------------------*/
    /*  Overwriting the vc row behaviour function for the vertical menu
    /*-----------------------------------------------------------------------------------*/
    if (typeof window['vc_rowBehaviour'] !== 'function') {
        window.vc_rowBehaviour = function () {
            var $ = window.jQuery;
            function fullWidthRow() {
                var $elements = $('[data-vc-full-width="true"]');
                $.each($elements, function (key, item) {
                    /* Anpthemes */
                    var verticalOffset = 0;
                    if ($('.site-header-vertical-menu').length && window.innerWidth > 992) {
                        verticalOffset = $('.site-header-vertical-menu').innerWidth();
                    }

                    var boxedOffset = 0;
                    if ($('body.boxed').length && window.innerWidth > 992) {
                        boxedOffset = ($('body').innerWidth() - $('.site-wrapper').innerWidth()) / 2;
                    }

                    var $el = $(this);
                    $el.addClass("vc_hidden");
                    var $el_full = $el.next(".vc_row-full-width");
                    $el_full.length || ($el_full = $el.parent().next(".vc_row-full-width"));
                    var el_margin_left = parseInt($el.css("margin-left"), 10),
                        el_margin_right = parseInt($el.css("margin-right"), 10),
                        offset = 0 - $el_full.offset().left - el_margin_left,
                        width = $(window).width() - verticalOffset - boxedOffset * 2,
                        positionProperty = $('html[dir="rtl"]').length ? 'right' : 'left';

                    if (positionProperty === 'right') {
                        verticalOffset = 0;
                    }

                    var options = {
                        'position': 'relative',
                        'box-sizing': 'border-box',
                        'width': width
                    };
                    options[positionProperty] = offset + verticalOffset + boxedOffset;

                    $el.css(options);

                    if (!$el.data("vcStretchContent")) {
                        var padding = -1 * offset - verticalOffset - boxedOffset;
                        0 > padding && (padding = 0);
                        var paddingRight = width - padding - $el_full.width() + el_margin_left + el_margin_right;
                        0 > paddingRight && (paddingRight = 0),
                            $el.css({
                                "padding-left": padding + "px",
                                "padding-right": paddingRight + "px"
                            })
                    }
                    $el.attr("data-vc-full-width-init", "true"),
                        $el.removeClass("vc_hidden")
                }),
                    $(document).trigger("vc-full-width-row", $elements)
            }

            function parallaxRow() {
                var vcSkrollrOptions, callSkrollInit = !1;
                return window.vcParallaxSkroll && window.vcParallaxSkroll.destroy(),
                    $(".vc_parallax-inner").remove(),
                    $("[data-5p-top-bottom]").removeAttr("data-5p-top-bottom data-30p-top-bottom"),
                    $("[data-vc-parallax]").each(function () {
                        var skrollrSpeed, skrollrSize, skrollrStart, skrollrEnd, $parallaxElement, parallaxImage, youtubeId;
                        callSkrollInit = !0,
                            "on" === $(this).data("vcParallaxOFade") && $(this).children().attr("data-5p-top-bottom", "opacity:0;").attr("data-30p-top-bottom", "opacity:1;"),
                            skrollrSize = 100 * $(this).data("vcParallax"),
                            $parallaxElement = $("<div />").addClass("vc_parallax-inner").appendTo($(this)),
                            $parallaxElement.height(skrollrSize + "%"),
                            parallaxImage = $(this).data("vcParallaxImage"),
                            youtubeId = vcExtractYoutubeId(parallaxImage),
                            youtubeId ? insertYoutubeVideoAsBackground($parallaxElement, youtubeId) : "undefined" != typeof parallaxImage && $parallaxElement.css("background-image", "url(" + parallaxImage + ")"),
                            skrollrSpeed = skrollrSize - 100,
                            skrollrStart = -skrollrSpeed,
                            skrollrEnd = 0,
                            $parallaxElement.attr("data-bottom-top", "top: " + skrollrStart + "%;").attr("data-top-bottom", "top: " + skrollrEnd + "%;")
                    }),
                    callSkrollInit && window.skrollr ? (vcSkrollrOptions = {
                        forceHeight: !1,
                        smoothScrolling: !1,
                        mobileCheck: function () {
                            return !1
                        }
                    },
                        window.vcParallaxSkroll = skrollr.init(vcSkrollrOptions),
                        window.vcParallaxSkroll) : !1
            }

            function fullHeightRow() {
                var $element = $(".vc_row-o-full-height:first");
                if ($element.length) {
                    var $window, windowHeight, offsetTop, fullHeight;
                    $window = $(window),
                        windowHeight = $window.height(),
                        offsetTop = $element.offset().top,
                        windowHeight > offsetTop && (fullHeight = 100 - offsetTop / (windowHeight / 100),
                            $element.css("min-height", fullHeight + "vh"))
                }
                $(document).trigger("vc-full-height-row", $element)
            }

            $(window).off("resize.vcRowBehaviour").on("resize.vcRowBehaviour", fullWidthRow).on("resize.vcRowBehaviour", fullHeightRow),
                fullWidthRow(),
                fullHeightRow(),
                vc_initVideoBackgrounds(),
                parallaxRow()
        }
    }
})(window, jQuery)
