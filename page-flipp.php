<?php
/*
 * Template Name: Flipp Template
 */
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Chicago Sun-Times | Circular</title>
</head>
<body>
<section id="post-body">
	<div class="row">
		<div id="main" class="columns large-10 end">
			<div id='circ-container'></div>
			<script>
              var pageSizing = 'WINDOW';
              var minHeight = 550;
              var initialHeight = 1000;
              var extraPadding = 70;
              var queryParameters = '';
              new wishabi.distributionservices.iframe.decorate(
                'circ-container', /* This is the div created above */
                'suntimesmedia', /* Your name identifier */
                wishabi.distributionservices.iframe.Sizing[pageSizing],
                {
                  minHeight: minHeight,
                  initialHeight: initialHeight,
                  extraPadding: extraPadding,
                  queryParameters: queryParameters
                });
			</script>
		</div>
	</div>
</section>
</body>
