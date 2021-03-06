<hr/>
<h2 class="section-title"><span><?php esc_html_e( 'Elections 2016', 'chicagosuntimes' ); ?></span></h2>
<hr/>
<div class="small-12 columns">
	<?php
	if ( shortcode_exists( 'election-2016-nov' ) ) {
		echo do_shortcode( '[election-2016-nov page="general-election" height="490px"]' );
	}
	?>
</div>
<div class="small-12">
	<div class="medium-6 small-12 columns ap-data">
		<?php
		if ( shortcode_exists( 'election-2016-race' ) ) {
			echo do_shortcode( '[election-2016-race race_num="16413" race_title="US Senate General"]' );
		}
		?></div>
	<div class="medium-6 small-12 columns ap-data">
		<?php
		if ( shortcode_exists( 'election-2016-race' ) ) {
			echo do_shortcode( '[election-2016-race race_num="15268" race_title="Comptroller"]' );
		}
		?></div>
	<div class="medium-6 small-12 columns ap-data">
		<?php
		if ( shortcode_exists( 'election-2016-race' ) ) {
			echo do_shortcode( '[election-2016-race race_num="14204" race_title="Legislative"]' );
		}
		?></div>
	<div class="medium-6 small-12 columns ap-data">
		<?php
		if ( shortcode_exists( 'election-2016-race' ) ) {
			echo do_shortcode( '[election-2016-race race_num="15999" race_title="Congressional 10"]' );
		}
		?>
	</div>
</div>
<hr>
<div class="medium-6 small-12 columns">
	<?php
	if ( shortcode_exists( 'election-2016-nov' ) ) {
		echo do_shortcode( '[election-2016-nov page="balance-of-power" office="PRESIDENT"]' );
	}
	?>
</div>
<div class="medium-6 small-12 columns">
	<?php
	if ( shortcode_exists( 'election-2016-nov' ) ) {
		echo do_shortcode( '[election-2016-nov page="balance-of-power" office="SENATE"]' );
	}
	?>
</div>
<div class="medium-6 small-12 columns">
	<?php
	if ( shortcode_exists( 'election-2016-nov' ) ) {
		echo do_shortcode( '[election-2016-nov page="balance-of-power" office="HOUSE"]' );
	}
	?>
</div>
<div class="medium-6 small-12 columns">
	<?php
	if ( shortcode_exists( 'election-2016-nov' ) ) {
		echo do_shortcode( '[election-2016-nov page="balance-of-power" office="GOVERNOR"]' );
	}
	?>
</div>
<br>