var $ = jQuery;

$(document).ready(function() {
	$('#playerControl a').click(function(e) {
		e.preventDefault();
		var i = $(this).index();
		
		
		$('#videoPlayer .thumbnails ul').fadeOut(function() {
			$(this).css('left',-620*i+'px');
			$(this).fadeIn();
		});
		
	});
	
	$('#videoPlayer img').live('click', function() {
		var t = $(this).prev('pre.hidden').text();
		$('#videoPlayer .thumbnails ul').fadeOut(function() {
			$('#playerBox').html(t);	
		});
	});

});

