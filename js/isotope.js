jQuery(function($) {
    var $grid = $('.grid').isotope({
        itemSelector: '.grid-item',
        masonry: {
            columnWidth: 40,
            isFitWidth: true
        },
        getSortData: {
            owned: '[data-owned] parseInt',
            number: '.title'
        },
        // sort by color then number
        sortBy: [ 'owned', 'title' ]
    });

    $('.button-group').on( 'click', 'button', function() {
        var filterValue = $(this).attr('data-filter');
        $grid.isotope({ filter: filterValue });
    });

    // store filter for each group
    var filters = {};

    $('.button-group').on( 'click', '.filter-button', function() {
    var $this = $(this);
    // get group key
    var $buttonGroup = $this.parents('.button-group');
    var filterGroup = $buttonGroup.attr('data-filter-group');
    // set filter for group
    filters[ filterGroup ] = $this.attr('data-filter');
    // combine filters
    var filterValue = concatValues( filters );
    $grid.isotope({ filter: filterValue });
    });

    // flatten object by concatting values
    function concatValues( obj ) {
    var value = '';
    for ( var prop in obj ) {
        value += obj[ prop ];
    }
    return value;
    }

    // quick search regex
    var qsRegex;

    // use value of search field to filter
    var $quicksearch = $('.quicksearch').keyup( debounce( function() {
    qsRegex = new RegExp( $quicksearch.val(), 'gi' );
    $grid.isotope({ filter: function() {
        return qsRegex ? $(this).text().match( qsRegex ) : true;
      } });
    }, 200 ) );

    // debounce so filtering doesn't happen every millisecond
    function debounce( fn, threshold ) {
    var timeout;
    threshold = threshold || 100;
    return function debounced() {
        clearTimeout( timeout );
        var args = arguments;
        var _this = this;
        function delayed() {
        fn.apply( _this, args );
        }
        timeout = setTimeout( delayed, threshold );
    };
    }

});