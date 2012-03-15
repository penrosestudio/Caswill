var $ = jQuery,
	initVideoPlayer = function() {
		$('#carouselPlayer').each(function() {
			$(this).find('.thumbnails ul li').width($(this).width()).show();
		});
	
		$('#playerControl a').click(function(e) { // clicks on the video details
			e.preventDefault();
			var $a = $(this),
				i = $a.index(),
				$ul = $('#carouselPlayer .thumbnails ul'),
				$playerBox = $('#playerBox'),
				showThumbnail = function() {
					$('#carouselPlayer .thumbnails ul').each(function() {
						var $activeLi = $(this).children('li').eq(i);
							//left = $activeLi.position().left;
						$a.addClass('active').siblings('a').removeClass('active');
						$(this).fadeOut(function() {	
							$(this).css('left',-i*$activeLi.width()+'px');
							$(this).fadeIn();
						});
					});
				};
			if($a.hasClass('active')) {
				return false;
			}
			$playerBox.fadeOut(showThumbnail);
				
		});
		
		$('#carouselPlayer img').live('click', function() { // clicks on the big thumbnails
			var t = $(this).prev('pre.hidden').text(),
				$playerBox = $('#playerBox'),
				$ul = $('#carouselPlayer .thumbnails ul'),
				showPlayer = function() {
					$('#playerBox').html(t).fadeIn();
				};
			$ul.fadeOut(showPlayer);
		});
	};

$(document).ready(function() {
	initVideoPlayer();
});

