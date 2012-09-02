$(document).ready(function()
{
	$('div.error[close], div.info[close], div.ok[close], div.warn[close]').append('<div class="close"></div>');
    $('div[class=close]').mousedown(function () {
        $(this).parent().fadeOut('normal');
    });
    $('.box .tab span').mousedown(function () {
        if ($(this).find('a').length == 0) {
            $('.box .tab span').removeAttr('class');
            $(this).attr('class', 'checked');
            $('.context').hide();
            $('.context').eq($('.box .tab span').index(this)).fadeIn('normal');
            $('.box .title').text($(this).text());
        }
    });

	$('.nav').mouseenter(function () {
		$('.navhide').stop().fadeIn('normal');
	});
	$('.nav').mouseleave(function () {
		$('.navhide').stop().fadeOut('normal');
	});
	$('.navhide').click(function () {
		$('.nav').hide();
		$('body').attr('style', 'background-image:none');
		$('.navshow').stop().fadeIn(2000);
	});
	$('.navshow').click(function () {
		$('.navshow').hide();
		$('body').removeAttr('style');
		$('.nav').stop().fadeIn('normal');
	});
	$('.menu > p a').hover(
		function () { $(this).stop().animate({ paddingRight: '36px' }, 'normal'); },
		function () { $(this).stop().animate({ paddingRight: '16px' }); }
	);
	$('.menu > p a').mousedown(function () {
		if (!$(this).parent().parent().find('div:visible').is($(this).parent().next('div'))) {
			$(this).parent().parent().find('div:visible').stop().hide('normal');
		}
		$(this).parent().next('div').stop().toggle('normal');
	});
	$('.menu div p[class=selected]').parent().stop().toggle('normal');
	$('table tr:odd').addClass('odd');
});