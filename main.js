jQuery(function(){

	var $video = document.getElementById('video');

	jQuery('video').on('play', function(){
		jQuery('video').prop('muted', true);
	});
	var duration, timeline_length, prev_cue, cumul_width;
	jQuery('video').on('loadeddata', function(){
		duration = $video.duration;
		timeline_length = jQuery('.timeline').width();
		prev_cue = 0;
		cumul_width = 0;
		jQuery('.timeline li').each(function(idx, item){
			$item = jQuery(item);
			if ( $item.next().length ) {
				cue = parseInt($item.next().find('a').data('cue'), 10);
				width = Math.floor(  (cue - prev_cue) / ( duration * 1000) * timeline_length );
				cumul_width = cumul_width + width;
				prev_cue = cue;
			}
			else {
				width = timeline_length - cumul_width;
				cumul_width = cumul_width + width;
				jQuery(this).css({border: 'none'});
			}
			jQuery(this).css({width: width - 1}).show();
		});
	});

	jQuery.getJSON( json_url + '/' + video_id + '/conf.json', function(data) {

		jQuery('.timeline li, .chapters li').on('click', function(){
			time = Math.round(parseInt(jQuery(this).find('a').data('cue'), 10) / 1000);
			$video.currentTime = time;
			console.log(time);
		});

	});

});