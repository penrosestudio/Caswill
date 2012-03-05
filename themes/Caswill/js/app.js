var $ = jQuery,
	initVideoPlayer = function() {
		$('#videoPlayer').each(function() {
			$(this).find('.thumbnails ul li').width($(this).width()).show();
		});
	
		$('#playerControl a').click(function(e) { // clicks on the video details
			e.preventDefault();
			var $a = $(this),
				i = $a.index(),
				$ul = $('#videoPlayer .thumbnails ul'),
				$playerBox = $('#playerBox'),
				showThumbnail = function() {
					$('#videoPlayer .thumbnails ul').each(function() {
						var $activeLi = $(this).children('li').eq(i);
							//left = $activeLi.position().left;
						console.log($activeLi,-i*$activeLi.width());
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
		
		$('#videoPlayer img').live('click', function() { // clicks on the big thumbnails
			var t = $(this).prev('pre.hidden').text(),
				$playerBox = $('#playerBox'),
				$ul = $('#videoPlayer .thumbnails ul'),
				showPlayer = function() {
					$('#playerBox').html(t).fadeIn();
				};
			$ul.fadeOut(showPlayer);
		});
	};

$(document).ready(function() {
	initVideoPlayer();
});

