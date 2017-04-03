<?php
	/*
	 * Template Name: Traffic Page
	 */
 ?>

<?php get_header(); ?>
<?php get_template_part( 'parts/homepage/navigation' ); ?>
<div id="dfp-top-placement" class="dfp">
	<?php get_template_part( 'parts/dfp/homepage/dfp-sbb' ); ?>
</div>
<section id="advertiser">
	<div class="row">
		<div class="traffic-wrapper">
			<div class="row">
				<div class="large-12 columns">
					<div id="about-us">
						<h1>About Us</h1>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="large-8 columns">
					<h3>Our mission:</h3>
					<p>Deliver Chicago’s truths, fiercely urban character and trending buzz.</p>
					<h3>We believe in:</h3>
					<ul>
						<li>The future of media</li>
						<li>Delivering relevant content in innovative ways to create tremendous value</li>
						<li>Going deeper than others to find the information</li>
						<li>Creating Solution Driven Strategies to Support Partnership Goals</li>
						<li>Leveraging emerging technologies that help us connect with diverse audiences-new and future media generations</li>
					</ul>
				</div>
				<div class="large-4 columns">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/media.png' ); ?>">
				</div>
			</div>
			<div class="row">
				<div class="large-12 columns">
					<h3 class="red">National Network:</h3>
					<img class="image-left" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/suntimes-network.png' ); ?>">
					<p>A mobile-first app network available in 70 U.S. cities featuring original content from Sun-Times reporters 
					and columnists as well as original and curated news and content in each local market. The app organizes top 
					stories and trends in each market for its readers and compliments them with commentary—a presentation seen in 
					popular websites like <em>Buzzfeed.com</em> and <em>Deadspin.com</em>.</p>
				</div>
			</div>
			<div class="row">
				<div class="large-12 columns">
					<h3 class="red">Print and Digital Products:</h3>
					<img class="image-left" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/chicagosuntimes.png' ); ?>">
					<p style="margin-top:16px;">is the oldest continuously published daily newspaper in Chicago. Winner of eight Pulitzer prizes, the expertise
					 of the Chicago Sun-Times includes hard-hitting investigative reporting, in-depth political coverage, insightful 
					 sports analysis, entertainment reviews and cultural commentary.</p>
				</div>
			</div>
			<div class="row">
				<div class="large-12 columns">
					<img class="image-left" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/reader.png' ); ?>">
					<p style="margin-top:10px;">is the city’s largest free weekly newspaper, nationally recognized as a leader in the alternative press.
					 Since 1971, the Reader has served as Chicago’s political conscience, cultural guide, and music authority. 
					 The Chicago Reader is the city’s most essential alternative media resource.</p>
				</div>
			</div>
			<div class="row">
				<div class="large-12 columns">
					<img class="image-left" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/splash.png' ); ?>">
					<p style="margin-top:6px;">is the premier weekly guide to Chicago living—fashion, philanthropy, dining, real 
					estate and more. Featuring 100% local content, Splash gives an inside look at what’s trending and consumer
					spending across high-end products.</p>
				</div>
			</div>
			<div class="row">
				<div class="large-12 columns">
					<h3 class="text-center black">If you would like to advertise in any of these products, please call 312-321-2345.</h3>
				</div>
			</div>
		</div>
	</div>
</section>
<section id="section-dfp-bottom-cubes">
	<div class="large-4 columns">
	  <?php get_template_part( 'parts/dfp/homepage/dfp-rr-cube-2' ); ?>
	</div>
	<div class="large-4 columns">
	  <?php get_template_part( 'parts/dfp/homepage/ndn-video' ); ?>
	</div>
	<div class="large-4 columns">
	  <?php get_template_part( 'parts/dfp/homepage/dfp-rr-cube-3' ); ?>
	</div>
</section>
  <?php get_template_part( 'parts/dfp/homepage/dfp-homepage-mobile-wire-cube-2' ); ?>
  <?php get_template_part( 'parts/dfp/homepage/dfp-btf-leaderboard' ); ?>
<?php get_template_part( 'parts/homepage/footer' ); ?>
<?php get_footer();
