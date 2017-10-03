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
				<div class="weather-radar-container">
					<h2><?php echo esc_html_e( 'Weather Radar', 'chicagosuntimes' ); ?></h2>
					<div class="image-container">
						<img src="<?php echo getWeatherImage('chicago'); ?>">
					</div>
					<div class="row">
						<div class="columns">
							<hr>
						</div>
						<div id="circularhub_module_10897"></div>
						<script src="//api.circularhub.com/10897/2e2e1d92cebdcba9/circularhub_module.js"></script>
						<?php
							$obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );
							$classes = array( 'single-view', 'columns', 'small-12', 'column-adjust', 'end', 'cst-sharing-relative' );
							$attrs = CST()->frontend->article_dimensions( $obj );
						?>
					</div>
					<article <?php post_class( $classes ); ?> <?php echo wp_kses_post( $attrs ); ?>>
								<?php 
									echo wp_kses( CST()->get_template_part( 'post/post-recommendations-chartbeat', array( 'obj' => $obj ) ), CST()->recommendation_kses ); 
								?>

					</article>
					<?php get_template_part( 'parts/taboola/taboola-weather' ); ?>
				</div>
			</div>
			<div class="large-4 columns weather-sidebar">
				<script src="https://content.synapsys.us/embeds/placement.js?p=VSUE4YV38U&#038;type=dynamic_group_weather&#038;style=standard"></script>
				<div class="sidebar-weather">
					<?php echo wp_kses( CST()->dfp_handler->unit( 1, 'div-gpt-sky-scraper', 'dfp' ), CST()->dfp_kses ); ?>
				</div>
			</div>

		</div>
	</section>

<?php get_footer();