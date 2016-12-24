$(document).foundation();
gototop();
function gototop()
{
    // $(".gotop").hide();
    $(window).scroll(function() {
        if ($(this).scrollTop() > 10) {
            $('.gotop').addClass('gototop');
            // $('.gotop').fadeIn();
        } else {
            $('.gotop').removeClass('gototop');
            // $('.gotop').fadeOut();
        }
    });
    $('.gotop').click(function() {
        $('body,html').animate({scrollTop: 4}, 300);
        return false;
    });
}