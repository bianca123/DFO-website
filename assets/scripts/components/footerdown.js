$( document ).ready(function() {
    var fo = $('footer').height();
    var he  = $('header').height();
    var dohi = $(window).height();
    
    var minhe = dohi - fo - he - 100;
    
    $('#content > .wrapper').css('min-height', minhe);
    
  $( window ).resize(function() {
    var fo = $('footer').height();
    var he  = $('header').height();
    var dohi = $(window).height();
    
    var minhe = dohi - fo - he - 100;
    
    $('#content > .wrapper').css('min-height', minhe);
      
  });
});