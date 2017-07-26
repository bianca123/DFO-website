$( document ).ready(function() {

  $('#mobilemenubtn').on('click', function() {
    $('body').toggleClass('menuopen');
    $('.js-mobilemenu').toggleClass('open');
  });

});