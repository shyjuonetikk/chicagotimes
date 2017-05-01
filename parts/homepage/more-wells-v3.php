<?php $section_slug = 'news'; ?>
<div class="row more-stories-container">
	<div class="columns small-12 medium-8 large-9">
		<div class="row">
		<div class="columns small-12 medium-6 large-4">
			<h3 class="more-sub-head">Latest Stories</h3>
			<div class="section-column-wells">
				<div class="section-list">
					<?php $query = array(
						'post_type'           => array( 'cst_article' ),
						'ignore_sticky_posts' => true,
						'posts_per_page'      => 10,
						'post_status'         => 'publish',
						'cst_section'         => esc_attr( $section_slug ),
						'orderby'             => 'modified',
					);
					CST()->frontend->cst_latest_stories_content_block( $query ); ?>
				</div>
			</div>
		</div>
		<div class="columns small-12 medium-6 large-8">
			<div class="small-12 large-8 columns">
			<div class="row">
				<h3 class="more-sub-head"><a href="<?php echo esc_url( home_url( '/' ) ); ?>features/"></a>Features</h3>
				<div class="featured-story">
					<a href="http://chicago.suntimes.com/feature/50-years-after-chicago-areas-most-devastating-tornadoes/" target="_blank" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-featured-story">
						<img src="https://suntimesmedia.files.wordpress.com/2017/04/tornado-041617-01_68208979.jpg?w=394" alt="article promo image">
						<h3>Survivors' stories 50 years after Chicago area's deadliest tornadoes hit Oak Lawn, other towns</h3>
					</a>
				</div>
			</div>
			</div>
			<div class="columns small-12 large-4">
				<div class="row">
				<h3 class="more-sub-head">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>features/" data-on="click" data-event-category="navigation"
					   data-event-action="navigate-hp-features-column-title">
						More Features</a></h3>
					<div class="section-column-wells">
						<div class="section-list">
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
			<div class="columns small-12">
				<div class="row">
					<div class="section-column-wells">
						<h3 class="more-sub-head">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>features/" data-on="click" data-event-category="navigation"
							   data-event-action="navigate-hp-features-column-title">
								Entertainment</a></h3>
						<div class="row mini-stories" data-equalizer>
							<div class="columns small-12 medium-12 large-6" data-equalizer-watch>
								<div class="row">
									<div class="columns small-12 medium-4 large-4">
								<span class="image">
									<img src="https://suntimesmedia.files.wordpress.com/2017/04/673416790_68461575.jpg?w=80">
								</span>
									</div>
									<div class="columns small-12 medium-8 large-8">
										<h3 class="title">Trump unveils tax plan: Three income brackets, top rate lowered</h3>
									</div>
									<div class="columns small-12"><p class="authors">By Clark Kent and Jimmy Olsen - 2 hours ago</p></div>
								</div>
							</div>
							<div class="columns small-12 medium-12 large-6" data-equalizer-watch>
								<div class="row">
									<div class="columns small-12 medium-4 large-4">
							<span class="image">
								<img src="https://suntimesmedia.files.wordpress.com/2017/01/sneedmccarthy012717.jpg?w=80">
							</span>
									</div>
									<div class="columns small-12 medium-8 large-8">
										<h3 class="title">Jesse Jackson Jr. dismisses divorce case in Chicago</h3>
									</div>
									<div class="columns small-12"><p class="authors">By Clark Kent and Jimmy Olsen - 3 hours ago</p></div>
								</div>
							</div>
							<div class="columns small-12 medium-12 large-6" data-equalizer-watch>
								<div class="row">
									<div class="columns small-12 medium-4 large-4">
						<span class="image">
							<img src="https://suntimesmedia.files.wordpress.com/2017/04/summers-042617-5.jpg?w=80">
						</span>
									</div>
									<div class="columns small-12 medium-8 large-8">
										<h3 class="title">Brown: Summers' floating of own candidacy could buoy Pritzker</h3>
									</div>
									<div class="columns small-12"><p class="authors">By Clark Kent and Jimmy Olsen - 4 hours ago</p></div>
								</div>
							</div>
							<div class="columns small-12 medium-12 large-6" data-equalizer-watch>
								<div class="row">
									<div class="columns small-12 medium-4 large-4">
						<span class="image">
							<img src="https://suntimesmedia.files.wordpress.com/2017/04/rondo13.jpg?w=80">
						</span>
									</div>
									<div class="columns small-12 medium-8 large-8">
										<h3 class="title">Rajon Rondo is still out for Game 5 — and shoots down report</h3>
									</div>
									<div class="columns small-12"><p class="authors">By Clark Kent and Jimmy Olsen - 1 day ago</p></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</div>
	<div class="columns small-11 medium-4 large-3 sidebar small-centered medium-uncentered">
		<img src="http://placehold.it/300x250&amp;text=[ad]">
		<hr>
		<div class="section-column-wells">
			<?php $section_slug = 'opinion'; ?>
			<h3 class="more-sub-head">
				<a href="<?php echo esc_url( home_url( '/' ) . 'section/' . esc_attr( $section_slug ) . '/' ); ?>" data-on="click" data-event-category="navigation"
				   data-event-action="navigate-hp-<?php echo esc_attr( $section_slug ); ?>-column-title">
					<?php esc_html_e( ucfirst( $section_slug ), 'chicagosuntimes' ); ?></a></h3>
				<div class="section-list">
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
