$(document).ready(function(){
   /**
   * Porfolio isotope and filter
   */

    var $grid = $('.portfolio-container').isotope({
        layoutMode: 'fitRows'
    });


    $('#portfolio-flters').on( 'click', 'li', function() {
        var filterValue = $(this).attr('data-filter');
        $grid.isotope({ filter: filterValue });
    });
});