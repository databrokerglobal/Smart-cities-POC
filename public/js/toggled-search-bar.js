$( document ).ready(function() {
    $('[data-toggle=search-form]').click(function() {
        $('.search-form-wrapper').toggleClass('open');
        $('.search-form-wrapper .search').focus();
        $('html').toggleClass('search-form-open');
        $('.right-bar').css({float:'left'})
      });
      $('[data-toggle=search-form-close]').click(function() {
        $('.search-form-wrapper').removeClass('open');
        $('html').removeClass('search-form-open');
        $('.right-bar').css({float:'right'})
      });
    $('.search-form-wrapper .search').keypress(function( event ) {
      if($(this).val() == "Search") $(this).val("");
    });
  
    $('.search-close').click(function(event) {
      $('.search-form-wrapper').removeClass('open');
      $('html').removeClass('search-form-open');
      $('.right-bar').css({float:'right'})
    });
  });