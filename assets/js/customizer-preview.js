/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ($, api) {
    'use strict';

    var $body = $('body'),
        $style = $('#snowbird-color-scheme-css'),
        $custom_css = $('#snowbird-custom-css');

    if (!$style.length) {
        $style = $('head').append('<style type="text/css" id="snowbird-color-scheme-css" />')
            .find('#snowbird-color-scheme-css');
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

    // Color Scheme CSS.
    api.bind('preview-ready', function () {
        api.preview.bind('update-color-scheme-css', function (css) {
            $style.text(css);
        });
    });

    api('snowbird-settings[custom_css]', function (value) {
        value.bind(function (to) {
            $custom_css.text(to);
        });
    });

})(jQuery, wp.customize);
