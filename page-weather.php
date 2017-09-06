<?php
/*
 * Template Name: Weather Page
 */
?>
<?php get_header(); ?>

	<section class="row">
		<div id="main" class="wire columns large-12">
			<div id="fixed-back-to-top" class="hide-back-to-top">
				<a id="back-to-top" href="#">
					<p><i class="fa fa-arrow-circle-up"></i><?php esc_html_e( 'Back To Top', 'chicagosuntimes' ); ?></p>
				</a>
			</div>
			<div class="large-8 columns">
				<div class="weather-video-container">
					<h2><?php esc_html_e( 'ABC7 Weather', 'chicagosuntimes' ); ?></h2>
					<video id= "player" width="100%" height="357" controls poster = "http://cdn.abclocal.go.com/images/wls/cms_exf_2007/automation/images/9423983_600x338.jpg">
						<source src="https://dig.abclocal.go.com/wls/video/SunTimes/wls_vid_wx_planner.mp4?vs=20141101 21:16:01" type='video/mp4' />
						<source src="https://dig.abclocal.go.com/wls/video/SunTimes/wls_vid_wx_planner.webm?vs=20141101 21:16:01" type='video/webm' />
						<source src="https://dig.abclocal.go.com/wls/video/SunTimes/wls_vid_wx_planner.ogv?vs=20141101 21:16:01" type='video/ogg' />
					</video>
				</div>
			</div>
			<div class="large-4 columns weather-sidebar">
				<script src="https://content.synapsys.us/embeds/placement.js?p=VSUE4YV38U&#038;type=dynamic_group_weather&#038;style=standard"></script>
			</div>
		</div>
	</section>

<?php get_footer();