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

	var $tooltip = jQuery('.tooltip');
	var $arrow = jQuery('.arrow');
	
	$tooltip.css({top: ( jQuery('.timeline').offset().top - $tooltip.height() - 34 ) + 'px'});
	$arrow.css({top: ( jQuery('.timeline').offset().top - 10 ) + 'px'});

	jQuery.getJSON( json_url + '/' + video_id + '/conf.json', function(data) {

		jQuery('.timeline li, .chapters li').on('click', function(){
			time = Math.round(parseInt(jQuery(this).find('a').data('cue'), 10) / 1000);
			$video.currentTime = time;
			$tooltip.hide();
			$arrow.hide();
		});

		jQuery('.timeline li, .chapters li').hover(
			function(){
				$item = jQuery(this);
				chapter = $item.find('a').data('chapter');
				thumb = $item.find('img').attr('src').replace('.png', '-big.png');
				tt = jQuery('.timeline li:nth('+(chapter-1)+')');
				tt.addClass('hover');

				left = tt.offset().left + tt.width() / 2; // add half the width of item
				left = left - $tooltip.width() / 2;  // remove half the width of tooltip
//				left = left - tt.width();
				left = left - 18; // adjust border && margins
				left = Math.max(left, 0);
				left = Math.min(left, 960 - $tooltip.width() );

				$arrow.css({left: ( tt.offset().left - $arrow.width() / 2 + tt.width() / 2 ) + 'px'});

				$tooltip.css({ left: left + 'px' });
				$tooltip.find('img').attr('src', thumb);
				$tooltip.find('span').text(chapter);
				$tooltip.show();
				$arrow.show();
			},
			function(){
				jQuery('.timeline .hover').removeClass('hover');
				$arrow.hide();
				$tooltip.hide();
			}
		);

	});

});