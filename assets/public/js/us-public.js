/**
 * All Public Javascript Code here
 *
 * Javascript code will be written here
 *
 * @package UltraSlideShow
 */

/**
 * Swiper Slider
 */
jQuery(function($) {

    $('[data-uslider').each(function() {
        var m = $(this);
        var config = {};
        var general = m.data('general');
        var autoplay = m.data('autoplay');
        var navigation = m.data('navigation');
        var pagination = m.data('pagination');
        var breakpoints = m.data('breakpoints');

        if (general) {
            config = general;
        }

        if (autoplay) {
            config.autoplay = autoplay;
        }

        if (navigation) {
            config.navigation = navigation;
        }


        if (pagination) {
            config.pagination = pagination;
        }

        if (breakpoints) {
            config.breakpoints = breakpoints;
        }

        var swiper = new Swiper(
            m, config
        );

    });

});