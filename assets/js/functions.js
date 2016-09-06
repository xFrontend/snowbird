/* global snowbirdReaderText */

(function ($) {
    'use strict';

    var $body,
        $content,
        resizeTimer,
        delta = 50,
        lastScrollTop = 0,
        pop_conf_image = {
            tError: '',
            cursor: '',
            titleSrc: function (item) {
                var title = item.el.attr('title');

                return (typeof title !== typeof undefined && title !== false) ? title : item.img.attr('alt');
            }
        },
        pop_conf_image_gallery = {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
        },
        pop_conf_image_callbacks = {
            beforeOpen: function () {
                this.st.mainClass = 'mfp-image-popup pop-in-out mfp-with-zoom';
            },
            imageLoadComplete: function () {
                var self = this;
                setTimeout(function () {
                    self.wrap.addClass('mfp-image-loaded');
                }, 16);
            },
            updateStatus: function (data) {
                if ('error' === data.status) {
                    $.magnificPopup.instance.close();
                }
            },
            change: function () {
                this.wrap.removeClass('mfp-image-loaded');
            },
            close: function () {
                this.wrap.removeClass('mfp-image-loaded');
            },
            afterClose: function () {
            }
        },
        pop_conf_zoom = {
            enabled: true,
            duration: 300,
            opener: function (element) {
                return element.is('img') ? element : element.find('img');
            }
        };

    function initMainNavigation(container) {
        // Add dropdown toggle that display child menu items.
        container.find('.menu-item-has-children > a').after('<button class="dropdown-toggle" aria-expanded="false">' + snowbirdReaderText.expand + '</button>');

        // Toggle buttons and submenu items with active children menu items.
        container.find('.current-menu-ancestor > button').addClass('toggle-on');
        container.find('.current-menu-ancestor > .sub-menu').addClass('toggled-on');

        container.find('.dropdown-toggle').click(function (e) {
            var _this = $(this);
            e.preventDefault();
            _this.toggleClass('toggle-on');
            _this.next('.children, .sub-menu').toggleClass('toggled-on');
            _this.attr('aria-expanded', _this.attr('aria-expanded') === 'false' ? 'true' : 'false');
            _this.html(_this.html() === snowbirdReaderText.expand ? snowbirdReaderText.collapse : snowbirdReaderText.expand);
        });
    }

    // Add a class to big image and caption larger than or equal to 920px, and clearfix Gallery if needed.
    function contentChecks() {
        if (!$body.hasClass('page') && !$body.hasClass('single')) {
            return;
        }

        var entryContent = $('.entry-content');
        entryContent.find('img.size-full, img.size-large').each(function () {
            var img = $(this),
                caption = img.closest('figure'),
                imgPos = img.offset(),
                imgPosTop = imgPos.top,
                entryFooter = img.closest('article').find('.xf__author-bio'),
                entryFooterPos = ( entryFooter.length ) ? entryFooter.offset() : 0,
                entryFooterPosBottom = ( entryFooter.length ) ? entryFooterPos.top + ( entryFooter.height() + 20 ) : 0,
                newImg = new Image();

            newImg.src = img.attr('src');

            $(newImg).on('load.snowbird', function () {
                var imgWidth = newImg.width;

                if (imgPosTop > entryFooterPosBottom) {
                    if (img.hasClass('size-full') && 920 <= imgWidth) {
                        img.addClass('full-width');
                        caption.addClass('full-width');
                        caption.removeAttr('style');
                    } else if (caption.hasClass('wp-caption') && 920 <= imgWidth && !$body.hasClass('full-content-width')) {
                        caption.addClass('caption-big');
                        caption.removeAttr('style');
                    } else if (920 <= imgWidth && !$body.hasClass('full-content-width')) {
                        img.addClass('size-big');
                    }
                } else {
                    img.removeClass('size-big');
                    img.removeClass('full-width');
                    caption.removeClass('caption-big');
                    caption.removeClass('full-width');
                }
            });
        });

        entryContent.find('figure, .gallery, .embed-wrappar').each(function () {
            var eliment = $(this),
                elimentPos = eliment.offset(),
                elimentPosTop = elimentPos.top,
                entryFooter = eliment.closest('article').find('.xf__author-bio'),
                entryFooterPos = ( entryFooter.length ) ? entryFooter.offset() : 0,
                entryFooterPosBottom = ( entryFooter.length ) ? entryFooterPos.top + ( entryFooter.height() + 20 ) : 0;

            if (elimentPosTop < entryFooterPosBottom && 490 <= eliment.innerWidth()) {
                if (eliment.hasClass('gallery')) {
                    eliment.css('clear', 'both').css('margin-right', 0);
                } else if (eliment.hasClass('embed-wrappar')) {
                    eliment.css('margin-right', '300px');
                } else if (eliment.hasClass('wp-caption')) {
                    eliment.css('margin-right', '300px');
                }
            } else {
                eliment.removeAttr('style');
            }
        });
    }

    $(document)
        .ready(function () {
            $body = $(document.body);
            $content = $('.entry-content');

            // Image Popup
            $('.snowbird-popup').find('.entry-content').find('a[href]').filter(function () {
                return /(jpg|jpeg|gif|png)$/.test($(this).attr('href'));
            }).magnificPopup({
                type: 'image',
                tLoading: '',
                closeBtnInside: false,
                removalDelay: 100,
                image: pop_conf_image,
                gallery: pop_conf_image_gallery,
                zoom: pop_conf_zoom,
                callbacks: pop_conf_image_callbacks
            });

            // Responsive Media
            $content.fitVids();

            // Sidebar Toggle Button
            var toggleClass = 'xf__toggle-on';

            $('.xf__toggle').on('click.snowbird', function () {
                $body.addClass(toggleClass);
            });

            $('.xf__close').on('click.snowbird', function () {
                $body.removeClass(toggleClass);
            });

            $('.content-area').on('click.snowbird', function () {
                $body.removeClass(toggleClass);
            });

            // Go Top button
            $('.xf__top').on('click.snowbird', function (e) {
                e.preventDefault();

                $('.xf__sidebar').getNiceScroll(0).doScrollTop(0);
            });

            // Sidebar
            $('.xf__sidebar').niceScroll('.sidebar-area', {
                cursorcolor: '#929292',
                cursoropacitymax: 0.7,
                cursorwidth: '6px',
                cursorborder: 'none',
                boxzoom: false,
                gesturezoom: false,
                grabcursorenabled: false
            });

            $(window)
                .on('resize.snowbird', function () {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(contentChecks, 300);
                })

                // Toggle Button sticky/hide
                .scroll(function () {

                    var scrollTop = $(this).scrollTop();

                    if (Math.abs(lastScrollTop - scrollTop) <= delta) {
                        return;
                    }

                    $('.xf__toggle').toggleClass('xf__toggle-show', scrollTop < lastScrollTop);

                    lastScrollTop = scrollTop;
                });

            contentChecks();

            initMainNavigation($('.main-navigation'));
        })

        // Re-initialize the main navigation when it is updated, persisting any existing submenu expanded states.
        .on('customize-preview-menu-refreshed.snowbird', function (e, params) {
            if ('primary' === params.wpNavMenuArgs.theme_location) {
                initMainNavigation(params.newContainer);

                // Re-sync expanded states from oldContainer.
                params.oldContainer.find('.dropdown-toggle.toggle-on').each(function () {
                    var containerId = $(this).parent().prop('id');
                    $(params.newContainer).find('#' + containerId + ' > .dropdown-toggle').triggerHandler('click');
                });
            }
        });

})(jQuery);
