var $ = jQuery;
$(document).ready(function() {
	$('#playerControl a').click(function(e) {
		e.preventDefault();
		var i = $(this).index(),
			t = $('#videoPlayer img').eq(i).prev('pre.hidden').text();
		$('#playerBox').html(t);
	});
});