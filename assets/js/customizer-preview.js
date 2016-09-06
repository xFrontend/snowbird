/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
(function ($, api) {
    'use strict';

    var $body = $('body'),
        $style = $('#snowbird-color-scheme-css'),
        $header = $('#snowbird-header-overlay-css'),
        $custom_css = $('#snowbird-custom-css'),
        post = $('body.single-post'),
        page = $('body.page');

    if (!$style.length) {
        $style = $('head').append('<style type="text/css" id="snowbird-color-scheme-css" />')
            .find('#snowbird-color-scheme-css');
    }

    if (!$header.length) {
        $header = $('head').append('<style type="text/css" id="snowbird-header-overlay-css" />')
            .find('#snowbird-header-overlay-css');
    }

    if (!$custom_css.length) {
        $custom_css = $('head').append('<style type="text/css" id="snowbird-custom-css" />')
            .find('#snowbird-custom-css');
    }

    // Site Title.
    api('blogname', function (value) {
        value.bind(function (to) {
            $('.site-title a').text(to);
        });
    });

    // Site Description.
    api('blogdescription', function (value) {
        value.bind(function (to) {
            $('.site-description').text(to);
        });
    });

    // Sidebar Position.
    api('site_sidebar_type', function (value) {
        value.bind(function (to) {
            $body.toggleClass('sidebar-content', Boolean('right' !== to));
            $body.toggleClass('content-sidebar', Boolean('right' === to));
        });
    });

    // Full Content Width for Single Post.
    api('post_full_content_width', function (value) {
        value.bind(function (to) {
            if (post.length) {
                post.toggleClass('full-content-width', to);
                post.find('.xf__entry').toggleClass('xf__singular-full', to);
                post.find('.xf__entry').toggleClass('xf__singular', !to);

                $(window).resize();
            }
        });
    });

    // Author Bio Class.
    api('post_display_author_bio', function (value) {
        value.bind(function (to) {
            if (post.length) {
                post.find('.xf__entry').toggleClass('has-author-bio', !to);
            }
        });
    });

    // Full Content Width for Page.
    api('page_full_content_width', function (value) {
        value.bind(function (to) {
            if (page.length && !page.hasClass('page-template-narrow-content-width') && !page.hasClass('page-template-full-content-width')) {
                page.toggleClass('full-content-width', to);
                page.find('.xf__entry').toggleClass('xf__singular-full', to);
                page.find('.xf__entry').toggleClass('xf__singular', !to);

                $(window).resize();
            }
        });
    });

    // Color Scheme CSS.
    api.bind('preview-ready', function () {
        api.preview.bind('update-color-scheme-css', function (css) {
            $style.text(css);
        });
    });

    // Header image overlay
    api.bind('preview-ready', function () {
        api.preview.bind('update-header-overlay-css', function (css) {
            $header.text(css);
        });
    });

    // Custom CSS.
    api('snowbird-settings[custom_css]', function (value) {
        value.bind(function (to) {
            $custom_css.text(to);
        });
    });

    /**
     * Handle rendering of partials.
     *
     * @param {api.selectiveRefresh.Placement} placement
     */
    api.selectiveRefresh.bind('partial-content-rendered', function () {
        $(window).resize();
    });

})(jQuery, wp.customize);
