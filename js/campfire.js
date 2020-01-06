jQuery(document).ready(function($){
    var body = $( 'body' );
    $('.filter-menu li').on('click', function() {
    $(this).addClass('active');
    $(this).siblings(".active").removeClass('active');
    });
    var filterizd = $(".filtr-container").filterizr({
    //options object
    });
});