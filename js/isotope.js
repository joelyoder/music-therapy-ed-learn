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
        // no transitions
        transitionDuration: 0,
        // disable scale transform transition when hiding
        hiddenStyle: {
            opacity: 0
        },
        visibleStyle: {
            opacity: 1
        },
        // sort by color then number
        sortBy: [ 'owned', 'title' ]
    });

    // store filter for each group
    var filters = [];

    // change is-checked class on buttons
    $('.filters').on( 'click', 'button', function( event ) {
    var $target = $( event.currentTarget );
    $target.toggleClass('is-checked');
    var isChecked = $target.hasClass('is-checked');
    var filter = $target.attr('data-filter');
    if ( isChecked ) {
        addFilter( filter );
    } else {
        removeFilter( filter );
    }
    // filter isotope
    // group filters together, inclusive
    $grid.isotope({ filter: filters.join(',') });
    });
    
    function addFilter( filter ) {
    if ( filters.indexOf( filter ) == -1 ) {
        filters.push( filter );
    }
    }

    function removeFilter( filter ) {
    var index = filters.indexOf( filter);
    if ( index != -1 ) {
        filters.splice( index, 1 );
    }
    }

    $('.select-filters').on( 'change', function( event ) {
    var $select = $( event.target );
    // get group key
    var filterGroup = $select.attr('value-group');
    // set filter for group
    filters[ filterGroup ] = event.target.value;
    // combine filters
    var filterValue = concatValues( filters );
    // set filter for Isotope
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