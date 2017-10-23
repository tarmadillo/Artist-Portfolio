jQuery(document).ready( function($) {
    var $grid = $('.content');

    // init Isotope
    $grid.isotope({
        itemSelector: '.entry',
        masonry: {
            columnWidth: '.entry',
            gutter: 5,
            horizontalOrder: true
        }
        
    });
    
    // store filter for each group
    var filters = [];

    // change is-checked class on buttons
    $(".sort").click(function(){
      var selector = $(this).attr('data-filter');
        $('.content').isotope({ filter: selector });
        $(this).parent().find(".sort").removeClass('is-checked');
        $(this).addClass('is-checked');
    });

    
    // get Isotope instance
    var iso = $grid.data('isotope');
    
    //-------------------------------------//
    // init Infinte Scroll

    $grid.infiniteScroll({
        path: '.pagination-next a',
        append: '.entry',
        history: 'push',
        outlayer: iso,
        loadOnScroll: false,
        button: '.view-more-button',
    });
                        
    // load automatically when sorting
    var $sortButton = $('.sort');
    $sortButton.on( 'click', function() {
        // load next page
        $grid.infiniteScroll('loadNextPage');
        // enable loading on scroll
        $grid.infiniteScroll( 'option', {
        loadOnScroll: false,

        });
    });
    
});