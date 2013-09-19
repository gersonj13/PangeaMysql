$(function () {
	$('#ca-container').contentcarousel();
    $(window).scroll(function(){
        // add navbar opacity on scroll
        if ($(this).scrollTop() > 100) {
            $(".navbar.navbar-fixed-top").addClass("scroll");
        } else {
            $(".navbar.navbar-fixed-top").removeClass("scroll");
        }

        // global scroll to top button
        if ($(this).scrollTop() > 300) {
            $('.scrolltop').fadeIn();
        } else {
            $('.scrolltop').fadeOut();
        }        
    });
	 // scroll back to top btn
    $('.scrolltop').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 700);
        return false;
    });
	 $('.carousel').carousel({
                    interval: 7000,
					
                });
		$('.carousel').carousel('cycle');
      });
            $(document).ready(function() {
                magicline();
            });

            function magicline() {

                var $el, leftPos, newWidth,
                        $mainNav = $("#nav");
                $("#magic-line").remove();
                $mainNav.append('<li id="magic-line"></li>');
                var $magicLine = $('#magic-line');

				if($('#nav').find('.active').position()!=null){
                $magicLine
                        .width($('#nav').find('.active').width())
                        .css('left', $('#nav').find('.active').position().left)
                        .data('origLeft', $magicLine.position().left)
                        .data('origWidth', $magicLine.width());
				}
                $('#nav li a').hover(function() {

                    $el = $(this);

                    leftPos = $el.position().left;
                    if ($el.closest('li.dropdown').size() != 0)
                        leftPos += $el.closest('li.dropdown').position().left;
                    newWidth = $el.parent().width();
                    $magicLine.stop().animate({
                        left: leftPos,
                        width: newWidth
                    });
                }, function() {
                    $magicLine.stop().animate({
                        left: $magicLine.data('origLeft'),
                        width: $magicLine.data('origWidth')
                    });
                });
            }
            $('li a').on('click', function() {
                $('li').each(function() {
                    $(this).removeClass('active');

                });
                $(this).parent().addClass('active');
                magicline();
	
});



