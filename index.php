<html>
<head>
	<title>Zabriskieprod-player</title>
	 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	 <link rel="stylesheet" type="text/css" href="/main.css">
</head>
<body>

	<xmp>
	<?php
	define('VIDEO_URL', 'http://d1td3oskkcu6vh.cloudfront.net');
	// define('JSON_URL', 'http://d1td3oskkcu6vh.cloudfront.net');
	// define('THUMBS_URL', 'http://d1td3oskkcu6vh.cloudfront.net');
	define('JSON_URL', '/videos');
	define('THUMBS_URL', '/videos');
	$video_id = "test";

	$json = $_SERVER['DOCUMENT_ROOT'] . constant('JSON_URL') . '/' . $video_id . '/conf.json';

	if ( ! is_file($_SERVER['DOCUMENT_ROOT'] . $json ) ):
		// convert xml to json
	endif;

	$chapters = json_decode(file_get_contents($json))->FLVCoreCuePoints->CuePoint;

//	print_r($chapters->FLVCoreCuePoints->CuePoint);

	?>
	</xmp>

	<script type="text/javascript">
		var video_id = '<?php print $video_id ?>';
		var video_url = '<?php print constant('VIDEO_URL') ?>';
		var json_url = '<?php print constant('JSON_URL') ?>';
		var thumbs_url = '<?php print constant('THUMBS_URL') ?>';
	</script>

	<video id="video" width="768" height="385" controls autoplay preload="metadata" >
		<source type="video/mp4" src="<?php print constant('VIDEO_URL') ?>/<?php print $video_id ?>/video.mp4" />
		<source type="video/ogg" src="<?php print constant('VIDEO_URL') ?>/<?php print $video_id ?>/video.ogg" />
		<source type="video/webm" src="<?php print constant('VIDEO_URL') ?>/<?php print $video_id ?>/video.webm" />
	</video>

	<ul class="timeline">
		<?php
		foreach($chapters as $i => $chapter):
			$idx = $i + 1;
			?>
			<li>
				<a data-cue="<?php print $chapter->Time ?>">
					<?php print $idx ?>
				</a>
			</li>
			<?php
		endforeach;
		?>
	</ul>

	<ul class="timeline chapters">
		<?php
		foreach($chapters as $i => $chapter):
			$idx = $i + 1;

			$thumb = constant('THUMBS_URL') . '/' . $video_id . '/thumbs/' . $idx . '.png';

			if ( ! is_file($_SERVER['DOCUMENT_ROOT'] . $thumb) ) :
				print $_SERVER['DOCUMENT_ROOT'] . $thumb;
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . constant('THUMBS_URL') . '/' . $video_id . '/thumbs/' . $idx . '.png', file_get_contents('http://placehold.it/54x36.png&text='.$idx) );
			endif;

			?>
			<li>
				<a href="#" data-cue="<?php print $chapter->Time ?>">
					<img src="<?php print $thumb ?>">
				</a>
			</li>
			<?php
		endforeach;
		?>
	</ul>

	<script type="text/javascript">

		jQuery(function(){

			var $video = document.getElementById('video');

			jQuery.getJSON( json_url + '/' + video_id + '/conf.json', function(data) {

				jQuery('.timeline li').on('click', function(){
					time = Math.round(parseInt(jQuery(this).data('cue'), 10) / 1000);
					$video.currentTime = time;
					console.log(time);
				});

			});

		});

	</script>

	<ul class="chapitres">
	</ul>

	<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>

</body>
</html>