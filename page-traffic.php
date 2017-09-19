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
<section id="traffic">
	<div class="row">
		<div class="traffic-wrapper">
			<div class="row">
				<div class="large-12 columns">
					<div class="large-8 columns traffic-border">
						<h2>Traffic Report</h2>
							<?php $traffic = CST()->frontend->cst_homepage_get_traffic_report(); ?>
							<?php if( $traffic ) : ?>
							<h3><?php echo count( $traffic ); ?> Current Incidents</h3><br/>
								<?php foreach( $traffic as $incident ) { ?>
								<div class="traffic-incident">
									<div class="row">
										<div class="large-12 columns">
											<span class="traffic-expected-wrap">
												<span>Expected: <?php echo date( 'm/d/Y', strtotime( $incident->startTime ) ) . ' &#8212; ' . date( 'm/d/Y', strtotime( $incident->endTime ) ); ?></span><br/>
											</span>
										</div>
										<div class="large-4 columns traffic-map">
											<a href="<?php echo esc_url( 'https://www.google.com/maps/@' . $incident->lat . ',' . $incident->lng ); ?>" class="trafficImgLink" target="_blank">
												<img class="trafficImg" src="<?php echo esc_url ( 'https://maps.googleapis.com/maps/api/staticmap?center=' . $incident->lat . ',' . $incident->lng . 'amp;zoom=14&amp;size=300x200&amp;markers=color:black|' . $incident->lat . ',' . $incident->lng ); ?>" alt="<?php echo esc_attr( $incident->parameterizedDescription->eventText ); ?>" title="<?php echo esc_attr( $incident->parameterizedDescription->eventText ); ?>">
											</a>
										</div>
										<div class="large-8 columns traffic-details">
											<span class="traffic-event">
												<img src="<?php echo esc_url( $incident->iconURL ); ?>" /> <?php echo esc_html( $incident->parameterizedDescription->eventText ); ?>
											</span>
											<span class="traffic-description">
												<?php echo esc_html( $incident->shortDesc ); ?>
											</span>
										</div>
									</div>
								</div>
								<?php } ?>
							<?php endif; ?>
					</div>
					<div class="large-4 columns traffic-cube">
						<?php get_template_part( 'parts/dfp/homepage/dfp-rr-cube-1' ); ?>
					</div>
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

