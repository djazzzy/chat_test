(function($) {
  "use strict"; // Start of use strict

    $(document).ready(function(){
        var $element = $('.footer');
        let counter = 0;
        $(window).scroll(function() {
            var scroll = $(window).scrollTop() + $(window).height();
            //Если скролл до конца елемента
            //var offset = $element.offset().top + $element.height();
            //Если скролл до начала елемента
            var offset = $element.offset().top;

            if (scroll > offset){
                $('.js-messages-form').addClass("fix");
            }else{
                $('.js-messages-form').removeClass("fix");
            }
        });
        $('.btn').click(function(){
            $('#block').slideUp();
        });

    })



})(jQuery); // End of use strict
