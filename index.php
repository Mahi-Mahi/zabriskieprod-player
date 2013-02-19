<html>
<head>
	<title>Zabriskieprod-player</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Signika+Negative' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="/main.css">
</head>
<body>

	<?php
	define('VIDEO_URL', 'http://d1td3oskkcu6vh.cloudfront.net');
	// define('JSON_URL', 'http://d1td3oskkcu6vh.cloudfront.net');
	// define('THUMBS_URL', 'http://d1td3oskkcu6vh.cloudfront.net');
	define('JSON_URL', '/videos');
	define('THUMBS_URL', '/videos');
	$video_id = "test";
	$video_title = "Introduction à la Chimiothérapie";
	$video_author = "Jean-Yves-Alexander Blay-Eggemont";

	$json = $_SERVER['DOCUMENT_ROOT'] . constant('JSON_URL') . '/' . $video_id . '/conf.json';

	if ( ! is_file($_SERVER['DOCUMENT_ROOT'] . $json ) ):
		// convert xml to json
	endif;

	$chapters = json_decode(file_get_contents($json))->FLVCoreCuePoints->CuePoint;

	?>

	<script type="text/javascript">
		var video_id = '<?php print $video_id ?>';
		var video_url = '<?php print constant('VIDEO_URL') ?>';
		var json_url = '<?php print constant('JSON_URL') ?>';
		var thumbs_url = '<?php print constant('THUMBS_URL') ?>';
	</script>

		<header>
			<div class="inner">
				<h1>
					<?php print $video_title ?>
				</h1>
				<div class="author">
					<div>Par <?php print $video_author ?></div>
				</div>
			</div>
		</header>
		<div class="content">
			<div class="inner">

				<video id="video" width="960" height="480" controls autoplay preload="metadata" >
					<source type="video/mp4" src="<?php print constant('VIDEO_URL') ?>/<?php print $video_id ?>/video.mp4" />
					<source type="video/ogg" src="<?php print constant('VIDEO_URL') ?>/<?php print $video_id ?>/video.ogg" />
					<source type="video/webm" src="<?php print constant('VIDEO_URL') ?>/<?php print $video_id ?>/video.webm" />
				</video>

				<div class="control">

					<div class="outer">
						<ul class="timeline">
							<?php
							$items = array();
							foreach($chapters as $i => $chapter):
								$items[$i] = $chapter;
								if ( isset($items[$i - 1]) )
									$items[$i - 1]->Duration = $chapter->Time;
							endforeach;

							foreach($items as $i => $chapter):
								$idx = $i + 1;
								?>
								<li>
									<a data-cue="<?php print $chapter->Time ?>" data-chapter="<?php print $idx ?>">
										&nbsp;
									</a>
								</li>
								<?php
							endforeach;
							?>
						</ul>
					</div>

					<div class="outer">
						<ul class="chapters">
							<?php
							foreach($chapters as $i => $chapter):
								$idx = $i + 1;

								$thumb = constant('THUMBS_URL') . '/' . $video_id . '/thumbs/' . $idx . '.png';
								$big_thumb = constant('THUMBS_URL') . '/' . $video_id . '/thumbs/' . $idx . '-big.png';

								if ( ! is_file($_SERVER['DOCUMENT_ROOT'] . $thumb) ) :
									@mkdir(dirname($_SERVER['DOCUMENT_ROOT'] . $thumb), 0755, true);
									print $_SERVER['DOCUMENT_ROOT'] . $thumb;
									file_put_contents($_SERVER['DOCUMENT_ROOT'] . $thumb, file_get_contents('http://placehold.it/54x36.png&text='.$idx) );
								endif;

								if ( ! is_file($_SERVER['DOCUMENT_ROOT'] . $big_thumb) ) :
									@mkdir(dirname($_SERVER['DOCUMENT_ROOT'] . $big_thumb), 0755, true);
									print $_SERVER['DOCUMENT_ROOT'] . $big_thumb;
									file_put_contents($_SERVER['DOCUMENT_ROOT'] . $big_thumb, file_get_contents('http://placehold.it/54x36.png&text='.$idx) );
								endif;


								?>
								<li>
									<a data-cue="<?php print $chapter->Time ?>">
										<img src="<?php print $thumb ?>">
									</a>
								</li>
								<?php
							endforeach;
							?>
						</ul>
					</div>

				</div>

			</div>

		</div>

		<footer>
			<div class="inner">
				<div class="copyright">
					powered by Zabriskie <strong>&bull;</strong> Prod | 2013
				</div>
			</div>
		</footer>

	<script type="text/javascript" src="/main.js" />

	<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>

</body>
</html>