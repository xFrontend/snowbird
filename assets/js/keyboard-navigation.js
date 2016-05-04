/**
 * Keyboard support for image navigation.
 */

(function ($) {
    'use strict';

    $(document).on('keydown.snowbird', function (e) {
        var url = false;

        // Left arrow key code.
        if (37 === e.which) {
            url = $('.nav-previous a').attr('href') || $('.xf__nav-post a[rel="prev"]').attr('href');

            // Right arrow key code.
        } else if (39 === e.which) {
            url = $('.nav-next a').attr('href') || $('.xf__nav-post a[rel="next"]').attr('href');
        }

        if (url && ( !$('textarea, input').is(':focus') )) {
            window.location = url;
        }
    });

})(jQuery);

