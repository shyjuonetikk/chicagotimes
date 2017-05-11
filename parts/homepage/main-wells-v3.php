<?php $ua_info = new Jetpack_User_Agent_Info(); ?>
<div class="row stories-container">
	<div class="columns small-12 medium-8 large-9 stories">
		<div class="row" data-equalizer-mq="large-up">
			<div class="columns small-12 large-4">
				<div class="lead-story">
					<h3 class="hero-title">Missing 1-year-old girl found dead in her Joliet home</h3>
					<div class="columns small-12 medium-6 large-12">
						<div class="row">
							<div class="show-for-portrait show-for-touch">
								<span class="image">
									<img src="https://suntimesmedia.files.wordpress.com/2017/04/semajcrosbyyellowhouse.jpg?w=394">
								</span>
							</div>
							<div class="show-for-portrait show-for-xlarge-up">
								<div class="small-12">
									<h3>Related News.</h3>
									<ul class="related-title">
										<li>Weekend Killings</li>
										<li>CPS budgets</li>
										<li>Rauner pulls funding</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="columns small-12 medium-5 medium-offset-1 large-12 large-offset-0">
						<div class="row">
							<p class="excerpt">
								A missing baby girl who vanished Tuesday evening was found dead late Wednesday in a home in “deplorable condition” near southwest suburban Joliet. “We do need the community’s help on this,” Will County sheriff’s office Deputy Chief Richard Ackerman said at a press conference Wednesday afternoon.
							</p>
							<p class="authors">By Clark Kent and Jimmy Olsen - 2 hours ago</p>
							<ul class="related-title">
								<li><a href="#"><h3>Analysis: When did Trump declare the wall will be built?</h3></a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="lead-story">
					<h3 class="title">Sandi Jackson to Jesse Jr.: List all sex partners—names and dates</h3>
					<span class="image show-for-landscape hidden-for-medium-up show-for-xlarge-up">
						<img src="https://suntimesmedia.files.wordpress.com/2017/04/jackson_resignation_30508923-e1493239957893.jpg?w=394">
					</span>
					<p class="excerpt">Sandi Jackson to Jesse Jr.: List all sex partners—names and dates
					</p>
					<p class="authors">By Tina Sfondeles - 1 hour ago</p>
				</div>
				<div class="lead-story">
					<h3 class="title">9-year sentence for Rockford-area doctor Charles Dehaan</h3>
					<span class="image show-for-landscape hidden-for-medium-up show-for-xlarge-up">
						<img src="https://suntimesmedia.files.wordpress.com/2016/09/doccharlesdehaan092216.jpg?w=394">
					</span>
					<p class="excerpt">
					<span class="image show-for-large-up show-for-touch">
						<img src="https://suntimesmedia.files.wordpress.com/2016/09/doccharlesdehaan092216.jpg?w=80">
					</span>
						Charles DeHaan got nine years in prison for fraudulently billing Medicare at house calls where prosecutors allege he sexually assaulted patients.</p>
					<p class="authors">By Andy Grimm - 1 hour ago</p>
				</div>
				<div class="show-for-large-up">
					<?php CST()->frontend->inject_newsletter_signup( 'news' ); ?>
				</div>
			</div>
			<div class="columns small-12 large-8">
				<div class="show-for-medium-only"><h3>In other news</h3></div>
				<div class="row lead-mini-story">
					<div class="columns small-12">
						<div class="row">
							<div class="columns small-12 medium-6 large-6">
								<span class="image"><img src="https://suntimesmedia.files.wordpress.com/2017/04/sir_the_baptist-09_68228313.jpg?w=394" alt=""></span>
								<div class="hide-for-landscape">
									<h3 class="alt-title">Sir the Baptist: ‘I want to be the first hip-hop chaplain’</h3>
								</div>
							</div>
							<div class="columns small-12 medium-6 large-6 show-for-landscape">
								<h3 class="alt-title">Sir the Baptist: ‘I want to be the first hip-hop chaplain’</h3>
							</div>
							<div class="columns small-12 medium-6 large-6">
								<p class="excerpt">Sir the Baptist is aiming to reconnect “the hip-hop world to spirituality” and “spirituality to common sense.” And listen to ‘Face to Faith’ podcast.</p>
								<p class="authors">By Robert Herguth - 1/2 hour ago</p>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<?php
				$query = array(
					'post_type'           => array( 'cst_article' ),
					'ignore_sticky_posts' => true,
					'posts_per_page'      => 4,
					'post_status'         => 'publish',
					'cst_section'         => 'news',
					'orderby'             => 'modified',
				);
				CST()->frontend->cst_mini_stories_content_block( $query ); ?>
				<div class="other-stories show-for-large-up">
				<hr>
					<h2>Trending in the Chicago Sun-Times</h2>
					<div id="root"></div>
					<script type="text/javascript" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/js/main.641bf377.js"></script>
				</div>
			</div>
			<div class="small-12 columns more-stories-container">
				<hr>
				<h3 class="more-sub-head"><a href="<?php echo esc_url( '/' ); ?>">Chicago Sports</a></h3>
				<?php
				$query = array(
					'post_type'           => array( 'cst_article' ),
					'ignore_sticky_posts' => true,
					'posts_per_page'      => 5,
					'post_status'         => 'publish',
					'cst_section'         => 'sports',
					'orderby'             => 'modified',
				);
				CST()->frontend->cst_mini_stories_content_block( $query ); ?>
			</div>
		</div>
		<?php if ( get_query_var( 'showads', false ) ) { ?>
			<div class="cst-ad-container"><img src="http://placehold.it/970x90/a0a0d0/130100&amp;text=[nativo]"></div>
		<?php } ?>
		<hr>
		<div class="row more-stories-container">
			<div class="columns small-12">
				<div class="row">
					<div class="columns small-12 medium-6 large-4">
						<h3 class="more-sub-head">More Top Stories</h3>
						<div class="row">
							<div class="stories-list">
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
						<div class="small-12 columns">
							<div class="row">
								<h3 class="more-sub-head"><a href="<?php echo esc_url( home_url( '/' ) ); ?>features/"></a>Featured story</h3>
								<div class="featured-story">
									<a href="http://chicago.suntimes.com/feature/50-years-after-chicago-areas-most-devastating-tornadoes/" target="_blank" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-featured-story">
										<img src="https://suntimesmedia.files.wordpress.com/2017/04/tornado-041617-01_68208979.jpg?w=700" alt="article promo image" class="featured-story-hero">
										<h3>Survivors' stories 50 years after Chicago area's deadliest tornadoes hit Oak Lawn, other towns</h3>
									</a>
								</div>
							</div>
							<div class="row">
								<h3 class="more-sub-head">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>features/" data-on="click" data-event-category="navigation"
									   data-event-action="navigate-hp-features-column-title">
										More Features</a></h3>
								<div class="columns small-12">
									<div class="row">
											<?php $query = array(
												'post_type'           => array( 'cst_feature' ),
												'ignore_sticky_posts' => true,
												'posts_per_page'      => 4,
												'post_status'         => 'publish',
												'orderby'             => 'modified',
											);
											CST()->frontend->cst_mini_stories_content_block( $query ); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="columns small-12">
						<?php if ( get_query_var( 'showads', false ) ) { ?>
							<div class="cst-ad-container dfp dfp-centered"><img src="http://placehold.it/970x90/6060e5/130100&amp;text=[ad-will-be-responsive]"></div>
						<?php } ?>
					</div>
					<div class="show-for-large-up hide-for-portrait">
						<div class="small-12 columns more-stories-container">
							<hr>
							<h3 class="more-sub-head"><a href="<?php echo esc_url( '/' ); ?>">Entertainment</a></h3>
							<?php
							$query = array(
								'post_type'           => array( 'cst_article' ),
								'ignore_sticky_posts' => true,
								'posts_per_page'      => 5,
								'post_status'         => 'publish',
								'cst_section'         => 'entertainment',
								'orderby'             => 'modified',
							);
							CST()->frontend->cst_mini_stories_content_block( $query ); ?>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	<div class="columns small-12 medium-4 large-3 sidebar homepage-sidebar widgets">
		<?php if ( get_query_var( 'showads', false ) ) { ?>
		<div class="cst-ad-container"><img src="http://placehold.it/300x600&amp;text=[ad-will-be-responsive]"></div>
		<?php } ?>
		<div class="more-stories-container hide-for-large-up">
			<hr>
			<div class="other-stories">
				<h2>Also in the Chicago Sun-Times</h2>
				<ul class="list">
					<li><span class="section-name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="section-link">Chicago News</a></span> <a href="<?php echo esc_url( 'http://chicago.suntimes.com/columnists/wanted-conservative-sports-network-to-compete-with-espn/' ); ?>" class=" magic-link-size">Mentally ill woman gets 22 years for killing husband with poison</a></li>
					<li><span class="section-name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="section-link">Chicago News</a></span> <a href="<?php echo esc_url( 'http://chicago.suntimes.com/columnists/wanted-conservative-sports-network-to-compete-with-espn/' ); ?>" class=" magic-link-size">9 charged with Crystal Lake fight that led to stabbing</a></li>
					<li><span class="section-name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="section-link">Chicago Sports</a></span> <a href="<?php echo esc_url( 'http://chicago.suntimes.com/columnists/wanted-conservative-sports-network-to-compete-with-espn/' ); ?>" class=" magic-link-size">Anthony Swarzak gettung career back on track with White Sox</a></li>
					<li><span class="section-name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="section-link">Entertainment</a></span> <a href="<?php echo esc_url( 'http://chicago.suntimes.com/columnists/wanted-conservative-sports-network-to-compete-with-espn/' ); ?>" class=" magic-link-size">Dear Abby: My friend bullies other kids at school</a></li>
					<li><span class="section-name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="section-link">Chicago Politics</a></span> <a href="<?php echo esc_url( 'http://chicago.suntimes.com/columnists/wanted-conservative-sports-network-to-compete-with-espn/' ); ?>" class=" magic-link-size">Sneed exclusive: City could deal blow to Trump wall contractors</a></li>
				</ul>
			</div>
		</div>
		<div class="row more-stories-container">
			<div class="columns small-12">
			<hr>
				<?php $section_slug = 'opinion'; ?>
				<h3 class="more-sub-head">
					<a href="<?php echo esc_url( home_url( '/' ) . 'section/' . esc_attr( $section_slug ) . '/' ); ?>" data-on="click" data-event-category="navigation"
					   data-event-action="navigate-hp-<?php echo esc_attr( $section_slug ); ?>-column-title">
						<?php esc_html_e( ucfirst( $section_slug ), 'chicagosuntimes' ); ?></a></h3>
				<div class="row">
					<div class="stories-list">
						<?php $query = array(
							'post_type'           => array( 'cst_article' ),
							'ignore_sticky_posts' => true,
							'posts_per_page'      => 7,
							'post_status'         => 'publish',
							'cst_section'         => esc_attr( $section_slug ),
							'orderby'             => 'modified',
						);
						CST()->frontend->cst_latest_stories_content_block( $query ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php if ( get_query_var( 'showads', false ) ) { ?>
		<div class="cst-ad-container">
			<hr>
			<img src="http://placehold.it/300x250/e0e0e0/130100&amp;text=[300x250-ad-will-be-responsive]">
		</div>
		<?php } ?>
		<div class="row more-stories-container hide-for-landscape">
			<div class="small-12 columns">
				<hr>
				<h3 class="more-sub-head"><a href="<?php echo esc_url( '/' ); ?>">Entertainment</a></h3>
				<?php
				$query = array(
					'post_type'           => array( 'cst_article' ),
					'ignore_sticky_posts' => true,
					'posts_per_page'      => 4,
					'post_status'         => 'publish',
					'cst_section'         => 'entertainment',
					'orderby'             => 'modified',
				);
				CST()->frontend->cst_mini_stories_content_block( $query ); ?>
			</div>
		</div>
		<div>
			<hr>
			<?php the_widget( 'CST_Chartbeat_Currently_Viewing_Widget' ); ?>
		</div>
		<div class="show-for-medium-up">
			<hr>
			<?php if ( get_query_var( 'showads', false ) ) { ?>
			<img src="http://placehold.it/300x250/a0d0a0/130100&amp;text=[300x250-ad-will-be-responsive]">
			<?php } ?>
		</div>
		<div class="hide-for-medium-down">
			<hr>
			<div class="row">
				<?php the_widget( 'CST_STNG_Wire_Widget' ); ?>
			</div>
		</div>
	</div>
</div>