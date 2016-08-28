$(document).foundation();
function tinyScroll()
{
	window.scrollBy(0, 1);
}
function lazy()
{
	$('.tabs-title > h3 > a').on('click', function(){
		tinyScroll();
	});
	$(".item>a>img").each(function(){
		$(this).attr("data-original", $(this).attr("src"));
		$(this).attr("src", "");
	});
	$(".item>a>img").lazyload({skip_invisible : false,failure_limit : 15, effect: "fadeIn", bind: "event"});
}
// function gotop()
// {
//     var t = $(".gotop");
//     $(window).scroll(function() {
//         if ($(this).scrollTop() > 10) {
//             t.addClass("active");
//         } else {
//             t.removeClass("active");
//         }
//     });
//     t.click(function() {
//         $('body,html').animate({scrollTop: 0}, 300);
//         return false;
//     });
// }
$(function () {
	lazy();
	// gotop();
});