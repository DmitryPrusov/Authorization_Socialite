
// burger menu
$(document).ready(function(){
            $(".burger").click(function(){
                // $(".burger").addClass("active_burger");
                $(".navbar-menu").slideToggle(600);
                $(this).toggleClass('nav-toggle-open');
            });
            $(".regulations").click(function(){
                $(".victory-vote").show(500);
                
            });
            // window.onscroll = function(){
            //   if ($('.burger').hasClass('nav-toggle-open')) {
            //       $('.navbar-menu').fadeToggle(1000);
            //       $('.burger').toggleClass('nav-toggle-open');
            //   }
            // };
            $(window).resize(function(){
              if($(window).width()>980&&$(".navbar-menu").css('display')==="none"){
                $(".navbar-menu").css("display","block");
              }
            })
        });

$(document).ready(function () {
  $('.authorisation').click( function(event){
      var first_p_facebook = $("a[href*='/oauth/facebook']").attr('href');
      if (first_p_facebook.indexOf('?') > -1)
      {
          first_p_facebook = first_p_facebook.substr (0, first_p_facebook.indexOf('?'));
      }

      var second_p_facebook = '?nomination_id=' +$(this).attr('data-nomination') + '&nominee_id=' + $(this).attr('data-nominee');
      $("a[href*='/oauth/facebook']").attr('href', first_p_facebook + second_p_facebook);


      var first_p_google = $("a[href*='/oauth/google']").attr('href');
      if (first_p_google.indexOf('?') > -1)
      {
          first_p_google = first_p_google.substr (0, first_p_google.indexOf('?'));
      }

      var second_p_google = '?nomination_id=' +$(this).attr('data-nomination') + '&nominee_id=' + $(this).attr('data-nominee');
      $("a[href*='/oauth/google']").attr('href', first_p_google + second_p_google);

    event.preventDefault(); 
    $('#overlay2').fadeIn(400, 
    function(){ 
    $('.authorisation_icons') 
    .css({'display': 'block', 'z-index': '3000'}) 
    .animate({opacity: 1, top: '45%'}, 200); 
    });
    $('.insec_inner_overlay').fadeOut(400);
  });
  /* Зaкрытие мoдaльнoгo oкнa, тут делaем тo же сaмoе нo в oбрaтнoм пoрядке */
  $('#close2, #overlay2').click( function(){ 
    $('.authorisation_icons')
    .animate({opacity: 0, top: '45%'}, 200,  
    function(){ 
      $(this).css({'display': 'none', 'z-index': '-100'}); 
      $('#overlay2').fadeOut(400); 
    }
    );
  });
})

 $(document).ready(function(){
     var $root = $('html, body');

     $('a[href^="#"]').click(function() {
         var href = $.attr(this, 'href');

         $root.animate({
             scrollTop: $(href).offset().top
         }, 1000, function () {
             window.location.hash = href;
         });

         return false;
     });

    //
    //  $('a[href^="#"]').click(function(){
    // var target = $(this).attr('href');
    // $('html, body').animate({scrollTop: $(target).offset().top}, 1000);
    // return false;
    // });

  });


