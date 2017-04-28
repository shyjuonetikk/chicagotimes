<?php $section_slug = 'news'; ?>
<div class="row more-stories-container">
	<div class="columns small-12 medium-8 large-9">
		<div class="row">
		<div class="columns small-12 medium-6 large-4">
			<div class="section-column-wells">
			<h3 class="more-sub-head">Latest Stories</h3>
				<div class="section-list">
					<h3 class="<?php echo esc_attr( $section_slug ); ?>-border">
						<a href="<?php echo esc_url( home_url( '/' ) . 'section/' . esc_attr( $section_slug ) . '/' ); ?>" data-on="click" data-event-category="navigation"
																				   data-event-action="navigate-hp-<?php echo esc_attr( $section_slug ); ?>-column-title">
							Chicago <?php esc_html_e( ucfirst( $section_slug ), 'chicagosuntimes' ); ?></a></h3>
					<?php $query = array(
						'post_type'           => array( 'cst_article' ),
						'ignore_sticky_posts' => true,
						'posts_per_page'      => 5,
						'post_status'         => 'publish',
						'cst_section'         => esc_attr( $section_slug ),
						'orderby'             => 'modified',
					);
					CST()->frontend->cst_latest_stories_content_block( $query ); ?>
				</div>
			</div>
		</div>
		<div class="columns small-12 medium-6 large-8"><h3 class="more-sub-head"><a href="<?php echo esc_url( home_url( '/' ) ); ?>features/"></a>Features</h3>
			<div class="small-12 large-8 columns">
				<div class="row featured-story">
					<a href="http://chicago.suntimes.com/feature/50-years-after-chicago-areas-most-devastating-tornadoes/" target="_blank" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-featured-story">
						<img src="https://suntimesmedia.files.wordpress.com/2017/04/tornado-041617-01_68208979.jpg?w=394" alt="article promo image">
						<h3>Survivors' stories 50 years after Chicago area's deadliest tornadoes hit Oak Lawn, other towns</h3>
					</a>
				</div>
			</div>
			<div class="columns small-12 large-4">
				<div class="row">
					<div class="section-column-wells">
						<div class="section-list">
							<h3 class="news-border">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>features/" data-on="click" data-event-category="navigation"
								   data-event-action="navigate-hp-features-column-title">
									More Features</a></h3>
					<?php $query = array(
						'post_type'           => array( 'cst_feature' ),
						'ignore_sticky_posts' => true,
						'posts_per_page'      => 5,
						'post_status'         => 'publish',
						'orderby'             => 'modified',
					);
					CST()->frontend->cst_latest_stories_content_block( $query ); ?>
					</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</div>
	<div class="columns small-11 medium-4 large-3 sidebar small-centered medium-uncentered">
		<img src="http://placehold.it/300x250&amp;text=[ad]">
		<div class="section-column-wells">
			<h3 class="more-sub-head">Opinion</h3>
			<?php $section_slug = 'opinion'; ?>
				<div class="section-list">
					<h3 class="<?php echo esc_attr( $section_slug ); ?>-border">
						<a href="<?php echo esc_url( home_url( '/' ) . 'section/' . esc_attr( $section_slug ) . '/' ); ?>" data-on="click" data-event-category="navigation"
						   data-event-action="navigate-hp-<?php echo esc_attr( $section_slug ); ?>-column-title">
							<?php esc_html_e( ucfirst( $section_slug ), 'chicagosuntimes' ); ?></a></h3>
					<?php $query = array(
						'post_type'           => array( 'cst_article' ),
						'ignore_sticky_posts' => true,
						'posts_per_page'      => 5,
						'post_status'         => 'publish',
						'cst_section'         => esc_attr( $section_slug ),
						'orderby'             => 'modified',
					);
					CST()->frontend->cst_latest_stories_content_block( $query ); ?>
				</div>
		</div>
	</div>
</div>
