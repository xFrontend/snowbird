/* global snowbirdColorScheme, Color */

/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 */
(function (wp) {
    'use strict';

    var api = wp.customize,
        cssTemplate = wp.template('snowbird-color-scheme'),
        colorSchemeKeys = [
            // Header
            'header_text_color',
            'header_background_color',
            'header_border_rgba',

            // Content
            'content_title_color',
            'content_text_color',
            'content_alt_text_color',
            'content_accent_color',
            'content_background_color',

            'content_border_rgba',
            'content_accent_rgba',

            // Footer
            'footer_title_color',
            'footer_text_color',
            'footer_alt_text_color',
            'footer_accent_color',
            'footer_background_color',

            'footer_border_rgba',
            'footer_accent_rgba',

            // Button
            'button_text_color',
            'button_background_color'
        ],
        colorSettings = [
            // Header
            'header_text_color',
            'header_background_color',

            // Content
            'content_title_color',
            'content_text_color',
            'content_alt_text_color',
            'content_accent_color',
            'content_background_color',

            // Footer
            'footer_title_color',
            'footer_text_color',
            'footer_alt_text_color',
            'footer_accent_color',
            'footer_background_color',

            // Button
            'button_text_color',
            'button_background_color'
        ],

        // Generate the CSS for the current Color Scheme.
        updateCSS = function () {
            var scheme = api('color_scheme')(), css,
                colors = _.object(colorSchemeKeys, snowbirdColorScheme[scheme].colors);

            // Merge in color scheme overrides.
            _.each(colorSettings, function (setting) {
                colors[setting] = api(setting)();
            });

            // Add additional color.
            colors.header_border_rgba = new Color(colors.content_text_color).toCSS('rgba', 0.1);

            colors.content_border_rgba = new Color(colors.content_text_color).toCSS('rgba', 0.1);
            colors.content_accent_rgba = new Color(colors.content_accent_color).toCSS('rgba', 0.85);

            colors.footer_border_rgba = new Color(colors.footer_text_color).toCSS('rgba', 0.1);
            colors.footer_accent_rgba = new Color(colors.footer_accent_color).toCSS('rgba', 0.85);

            css = cssTemplate(colors);

            api.previewer.send('update-color-scheme-css', css);
        },

        // Generate the css for header image overlay.
        overlay_css = function () {
            var rgba = new Color(api('header_overlay_color')()).toCSS('rgba', api('header_overlay_opacity')() / 100),
                css = '.xf__header .background .overlay { background-color: ' + rgba + '; }';

            api.previewer.send('update-header-overlay-css', css);
        };

    // Default colors for current scheme.
    api.controlConstructor.select = api.Control.extend({
        ready: function () {
            if ('color_scheme' === this.id) {
                this.setting.bind('change', function (value) {

                    _.each(colorSettings, function (setting) {
                        var settingID = setting,
                            settingColor = snowbirdColorScheme[value].colors[setting];

                        api(settingID).set(settingColor);
                        api.control(settingID).container.find('.color-picker-hex')
                            .data('data-default-color', settingColor)
                            .wpColorPicker('defaultColor', settingColor);
                    });

                });
            }
        }
    });

    // Update the CSS whenever a color setting is changed.
    _.each(colorSettings, function (setting) {
        api(setting, function (control) {
            control.bind(updateCSS);
        });
    });

    // Update the CSS for header image overlay.
    _.each(['header_overlay_color', 'header_overlay_opacity'], function (setting) {
        api(setting, function (control) {
            control.bind(overlay_css);
        });
    });

})(wp);
