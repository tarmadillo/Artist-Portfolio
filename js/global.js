/**
 * This script adds the jquery effects to the theme.
 *
 * @package My Genesis\JS
 * @author Tony Armadillo
 * @license GPL-2.0+
 */

wow = new WOW( {
  boxClass:     'wow',      // default
  animateClass: 'animated', // default
  offset:       300,          // default
  mobile:       true,       // default
  live:         true        // default
 }); wow.init();

jQuery(function( $ ){
    
    lightbox($);

});

function lightbox ( $ ){
    $(document).ready(function ($) {
        $('.front-page .grid').magnificPopup({
            delegate: 'a',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            closeBtnInside: true,
            midClick: true,
            removalDelay: 500,
            mainClass: 'mfp-zoom-out',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0,1] // Will preload 0 - before current, and 1 after the current image
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
            }
        });
               
        $('.gallery').magnificPopup({
            delegate: 'a',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            closeBtnInside: true,
            midClick: true,
            removalDelay: 500,
            mainClass: 'mfp-zoom-out',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0,1] // Will preload 0 - before current, and 1 after the current image
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
            }
        });
    });
}

