<?php global $homepage_election_well_posts, $election_sections; ?>
<style type="text/css">
	@media only screen and (min-width: 40.063em) {
		.elections-2016 {
			margin-bottom: 10px;
			float:left;
			height: auto;
		}
		.election-2016 h3 {
			font-size:1.0875rem;
			font-weight: bold;
		}
		.election-2016 hr {
			margin: 0.75rem 0 0.75rem;
		}
	}
</style>
<hr/>
<h2 class="section-title"><span><?php esc_html_e( 'Elections 2016', 'chicagosuntimes' ); ?></span></h2>
<hr/>
<section id="election-more-stories-wells" class="large-6 columns election-2016">
	<div class="row">
		<?php
		$obj = \CST\Objects\Post::get_by_post_id( $homepage_election_well_posts[0]->ID );
		if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
			$primary_section = $obj->get_primary_parent_section();
			if ( $byline = $obj->get_byline() ) {
				$author = $byline;
			} else {
				$author = get_the_author_meta( 'display_name', $homepage_election_well_posts[0]->post_author );
			}
			?>
			<div
				class="large-4 medium-4 small-12 columns article-image <?php echo esc_html( strtolower( $primary_section->name ) ); ?>-triangle">
				<a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
					<?php
					if ( $featured_image_id = $obj->get_featured_image_id() ) {
						if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) {
							echo $attachment->get_html( 'homepage-columns' );
						}
					}
					?>
				</a>
			</div>
			<div class="large-8 medium-8 small-12 columns">
				<a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
					<h3><?php esc_html_e( $obj->the_title(), 'chicagosuntimes' ); ?></h3>
				</a>
				<?php esc_html_e( $obj->the_excerpt(), 'chicagosuntimes' ); ?>
				<span
					class="author">By <?php echo esc_html( $author ); ?></span>
			</div>
			<?php
		}
		?>
	</div>
	<hr/>
	<div class="row">
		<?php
		$obj             = \CST\Objects\Post::get_by_post_id( $homepage_election_well_posts[1]->ID );
		$primary_section = $obj->get_primary_parent_section();
		if ( $byline = $obj->get_byline() ) {
			$author = $byline;
		} else {
			$author = get_the_author_meta( 'display_name', $homepage_election_well_posts[1]->post_author );
		}
		?>
		<div class="large-4 medium-4 small-12 columns article-image <?php echo esc_html( strtolower( $primary_section->name ) ); ?>-triangle">
			<a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
				<?php
				if ( $featured_image_id = $obj->get_featured_image_id() ) {
					if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) {
						echo $attachment->get_html( 'homepage-columns' );
					}
				}
				?>
			</a>
		</div>
		<div class="large-8 medium-8 small-12 columns">
			<a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
				<h3><?php esc_html_e( $obj->the_title(), 'chicagosuntimes' ); ?></h3>
			</a>
			<?php esc_html_e( $obj->the_excerpt(), 'chicagosuntimes' ); ?>
			<span class="author">By <?php echo esc_html( $author ); ?></span>
		</div>
	</div>
	<hr/>
	<div class="row">
		<?php
		$obj             = \CST\Objects\Post::get_by_post_id( $homepage_election_well_posts[2]->ID );
		$primary_section = $obj->get_primary_parent_section();
		if ( $byline = $obj->get_byline() ) {
			$author = $byline;
		} else {
			$author = get_the_author_meta( 'display_name', $homepage_election_well_posts[2]->post_author );
		}
		?>
		<div class="large-4 medium-4 small-12 columns article-image <?php echo esc_html( strtolower( $primary_section->name ) ); ?>-triangle">
			<a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
				<?php
				if ( $featured_image_id = $obj->get_featured_image_id() ) {
					if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) {
						echo $attachment->get_html( 'homepage-columns' );
					}
				}
				?>
			</a>
		</div>
		<div class="large-8 medium-8 small-12 columns">
			<a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
				<h3><?php esc_html_e( $obj->the_title(), 'chicagosuntimes' ); ?></h3>
			</a>
			<?php esc_html_e( $obj->the_excerpt(), 'chicagosuntimes' ); ?>
			<span class="author">By <?php echo esc_html( $author ); ?></span>
		</div>
	</div>
	<hr/>
	<div class="row">
		<?php
		$obj             = \CST\Objects\Post::get_by_post_id( $homepage_election_well_posts[3]->ID );
		$primary_section = $obj->get_primary_parent_section();
		if ( $byline = $obj->get_byline() ) {
			$author = $byline;
		} else {
			$author = get_the_author_meta( 'display_name', $homepage_election_well_posts[3]->post_author );
		}
		?>
		<div class="large-4 medium-4 small-12 columns article-image <?php echo esc_html( strtolower( $primary_section->name ) ); ?>-triangle">
			<a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
				<?php
				if ( $featured_image_id = $obj->get_featured_image_id() ) {
					if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) {
						echo $attachment->get_html( 'homepage-columns' );
					}
				}
				?>
			</a>
		</div>
		<div class="large-8 medium-8 small-12 columns">
			<a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
				<h3><?php esc_html_e( $obj->the_title(), 'chicagosuntimes' ); ?></h3>
			</a>
			<?php esc_html_e( $obj->the_excerpt(), 'chicagosuntimes' ); ?>
			<span class="author">By <?php echo esc_html( $author ); ?></span>
		</div>
	</div>
	<hr>
	<div class="row">
		<?php
		$obj = \CST\Objects\Post::get_by_post_id( $homepage_election_well_posts[4]->ID );
		$primary_section = $obj->get_primary_parent_section();
		if ( $byline = $obj->get_byline() ) {
			$author = $byline;
		} else {
			$author = get_the_author_meta( 'display_name', $homepage_election_well_posts[4]->post_author );
		}
		?>
		<div class="large-4 medium-4 small-12 columns article-image <?php echo esc_html( strtolower( $primary_section->name ) ); ?>-triangle">
			<a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
				<?php
				if ( $featured_image_id = $obj->get_featured_image_id() ) {
					if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) {
						echo $attachment->get_html( 'homepage-columns' );
					}
				}
				?>
			</a>
		</div>
		<div class="large-8 medium-8 small-12 columns">
			<a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
				<h3><?php esc_html_e( $obj->the_title(), 'chicagosuntimes' ); ?></h3>
			</a>
			<?php esc_html_e( $obj->the_excerpt(), 'chicagosuntimes' ); ?>
			<span class="author">By <?php echo esc_html( $author ); ?></span>
		</div>
	</div>
</section>
<div class="large-6 columns">
	<?php
	if ( shortcode_exists( 'election-2016' ) ) {
		echo do_shortcode( '[election-2016 page="' . $election_sections['section_id_upper'] . '"]' );
	}
	if ( shortcode_exists( 'election-2016' ) ) {
		echo do_shortcode( '[election-2016 page="' . $election_sections['section_id_lower'] . '"]' );
	}
	?>
</div>
