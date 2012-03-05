var $ = jQuery;

$(document).ready(function() {
	$('#playerControl a').click(function(e) {
		e.preventDefault();
		var i = $(this).index();
		
		$('#videoPlayer .thumbnails ul').each(function() {
			var $activeLi = $(this).children('li').eq(i),
				left = $activeLi.position().left;
			$(this).fadeOut(function() {	
				$(this).css('left',-left+'px');
				$(this).fadeIn();
			});
		});	
	});
	
	$('#videoPlayer').each(function() {
		$(this).find('.thumbnails ul li').width($(this).width()).show();
	});
	
	$('#videoPlayer img').live('click', function() {
		var t = $(this).prev('pre.hidden').text();
		$('#videoPlayer .thumbnails ul').fadeOut(function() {
			$('#playerBox').html(t);	
		});
	});

});

