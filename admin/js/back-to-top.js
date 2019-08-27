var $;
var offset = 100;
var scrollTopDuration = 700;

window.onscroll = function() {scrollFunction();};

function scrollFunction() {
	if (document.body.scrollTop > offset || document.documentElement.scrollTop > offset) {
		$('#backToTop').fadeIn();
	} else {
		$('#backToTop').fadeOut();
	}
}

$(document).ready(function($) {
	$('#backToTop').on('click', function(event) {
		event.preventDefault();
		$('body,html').animate({
			scrollTop: 0
		}, scrollTopDuration
		);
	});

});