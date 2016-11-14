<?php

/**
 * Filters and other changes related to improving and customizing Google AMP support
 * for CST
 *
 * Most code snippets taken from here: https://github.com/Automattic/amp-wp/blob/master/readme.md
 * and modified for our theme.
 */
class CST_AMP {

	function __construct() {
		$this->setup_filters();
		$this->setup_actions();
	}

	function setup_filters() {

		/**
		 * Example sanitizer for Send to News video implementation, in body article leaderboard ad
		 */
		add_filter( 'amp_content_sanitizers', array( $this, 'amp_add_sanitizers' ), 10, 2 );
		add_filter( 'amp_content_embed_handlers', array( $this, 'amp_add_embed_handlers' ), 10, 2 );

		/**
		 * Slightly wider display to match non-AMP site
		 */
		add_filter( 'amp_content_max_width', array( $this, 'amp_change_content_width' ) );

		add_filter( 'amp_post_template_analytics', array( $this, 'amp_add_google_analytics' ) );

		add_filter( 'amp_post_template_file', array( $this, 'amp_set_custom_template' ), 10, 3 );
		add_filter( 'amp_post_template_head', array( $this, 'amp_set_custom_fonts' ), 10, 3 );
		add_filter( 'amp_post_template_head', array( $this, 'amp_set_sidebar_script' ), 10, 3 );
		add_filter( 'amp_post_template_data', [ $this, 'amp_set_site_icon_url' ] );

	}

	function setup_actions() {

		/**
		 * Add support for CST custom post type
		 */
		add_action( 'amp_init', array( $this, 'amp_cst_cpt' ) );

		add_action( 'pre_amp_render_post', array( $this, 'amp_add_custom_actions' ) );

		/**
		 * Add in a footer for good measure but need to allow for infinite scroll at some point perhaps
		 */
		add_action( 'amp_post_template_footer', array( $this, 'amp_add_footer' ) );
	}

	/**
	 * @param $file
	 * @param $type
	 * @param $post
	 *
	 * @return string
	 *
	 * Handle our customizations to the article layout
	 */
	function amp_set_custom_template( $file, $type, $post ) {
		if ( 'meta-taxonomy' === $type ) {
			$file = get_stylesheet_directory() . '/amp/meta-custom-tax.php';
		}
		if ( 'meta-time' === $type ) {
			$file = get_stylesheet_directory() . '/amp/meta-custom-time.php';
		}
		if ( 'single' === $type ) {
			$file = get_stylesheet_directory() . '/amp/cst-amp-template.php';
		}
		return $file;
	}

	/**
	 * Add AMP support for our post type(s)
	 */
	function amp_cst_cpt() {
		add_post_type_support( 'cst_article', AMP_QUERY_VAR );
		add_post_type_support( 'cst_gallery', AMP_QUERY_VAR );
	}


	function amp_add_custom_actions() {
		add_filter( 'the_content', array( $this, 'amp_add_featured_image' ) );
		add_filter( 'the_content', array( $this, 'amp_poss_add_gallery' ) );
		add_filter( 'the_content', array( $this, 'amp_social_share' ), 1000 );

	}

	/**
	 * @param $content
	 * @param $b
	 * @param $c
	 *
	 * @return string
	 *
	 * Handle cst_gallery post type telling AMP to do the shortcode for galleries
	 * inside the cst_gallery post type fo sho!
	 */
	function amp_poss_add_gallery( $content ) {

		if ( 'cst_gallery' === get_post_type() ) {
			$post_id = get_the_ID();
			$content = do_shortcode( '[cst-content id="' . $post_id . '"]' ) . $content;
		}

		return $content;
	}

	/**
	 * @param $content
	 *
	 * @return string
	 *
	 * Determine featured image type - matches website as best possible
	 */
	function amp_add_featured_image( $content ) {
		$image_content = '';
		$obj           = new CST\Objects\Article( get_queried_object_id() );
		$media_type    = $obj->get_featured_media_type();
		if ( 'image' === $media_type ) {
			$featured_image_id = $obj->get_featured_image_id();
			if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) { ?>
				<?php $image_content .= $attachment->get_html( 'cst-article-featured' );
				if ( $caption = $attachment->get_caption() ) :
					$image_content .= '<div class="image-caption wp-caption-text">' . wpautop( esc_html( $caption ) ) . '</div>';
				endif;
			}
		} elseif ( 'gallery' === $media_type && $gallery = $obj->get_featured_gallery() ) { ?>
			<?php $image_content .= do_shortcode( '[cst-content id="' . $gallery->get_id() . '"]' );
		} elseif ( 'video' === $media_type ) { ?>
			<?php $image_content .= '<p>' . $obj->get_featured_video_embed() . '</p>'; ?>
		<?php }
		$content = '
<div class="post-lead-media">' .
		wp_kses_post( $image_content ) .
'</div>' .
		$content;

		return $content;
	}

	/**
	 * @param $sanitizer_classes
	 * @param $post
	 *
	 * @return mixed
	 *
	 * Sanitizer handler for AMP when processing SendToNews, ads
	 */
	function amp_add_sanitizers( $sanitizer_classes, $post ) {
		require_once( get_stylesheet_directory() . '/amp/amp-tools/classes/class-cst-ad-sanitizer.php' );

		$sanitizer_classes['CST_AMP_Ad_Injection_Sanitizer'] = array(); // the array can be used to pass args to your sanitizer and accessed within the class via `$this->args`
		return $sanitizer_classes;
	}

	function amp_add_embed_handlers( $embed_handler_classes, $post ) {
		require_once( get_stylesheet_directory() .  '/amp/amp-tools/classes/class-amp-cst-gallery-embed.php' );
		require_once( get_stylesheet_directory() .  '/amp/amp-tools/classes/class-amp-related-posts-embed.php' );
		$embed_handler_classes['CST_AMP_Gallery_Embed'] = array();
		$embed_handler_classes['CST_AMP_Related_Posts_Embed'] = array();
		return $embed_handler_classes;
	}
	/**
	 * @param $content_max_width
	 *
	 * @return int
	 *
	 * Match the widest viewport on our non-AMP site
	 */
	function amp_change_content_width( $content_max_width ) {
		return 600;
	}

	/**
	 * @param $amp_template
	 *
	 * Display a footer - infinite scroll anyone?
	 */
	function amp_add_footer( $amp_template ) {
		?>
		<footer>
			<hr>
			<div class="footer-container">
				<ul class="footer-nav">
					<li><a href="<?php echo esc_url( '/about-us' ); ?>">About us</a></li>
					<li><a href="<?php echo esc_url( '/contact-us' ); ?>">Contact us</a></li>
					<li><a href="<?php echo esc_url( '/terms-of-use' ); ?>">Terms of use</a></li>
					<li><a href="<?php echo esc_url( 'https://payments.suntimes.com' ); ?>" target="_blank">Order Back Issues</a>&nbsp;<i class="fa fa-external-link" aria-hidden="true"></i></li>
					<li><a href="<?php echo esc_url( '/privacy-policy/' ); ?>">Privacy Policy</a></li>
					<li><a href="<?php echo esc_url( '/about-our-ads/' ); ?>">About Our Ads</a></li>
				</ul>
			</div>
			<hr>
			<ul class="footer-nav">
					<li class="copyright"><?php echo esc_html( sprintf( 'Copyright &copy; 2005-%d Chicago Sun-Times' , date( 'Y' ) ) ); ?></li>
				</ul>
		</footer>
		<?php
	}

	/**
	 * Add Google Analytics to the footer
	 *
	 **/

	function amp_add_google_analytics( $analytics ) {

		if ( ! is_array( $analytics ) ) {
			$analytics = array();
		}

		// https://developers.google.com/analytics/devguides/collection/amp-analytics/
		$analytics['cst-googleanalytics'] = array(
			'type'        => 'googleanalytics',
			'attributes'  => array(
				'data-credentials' => 'include',
			),
			'config_data' => array(
				'vars'     => array(
					'account' => 'UA-52083976-1',
				),
				'triggers' => array(
					'trackPageview' => array(
						'on'      => 'visible',
						'request' => 'pageview',
					),
				),
			),
		);

		return $analytics;
	}

	/**
	 * Perhaps convert to use amp-font directive.
	 */
	function amp_set_custom_fonts() {
	?>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300">
	<?php

	}

	/**
	 * @param $content
	 *
	 * @return string
	 *
	 * Add share icons for both Twitter and Facebook below the article.
	 */
	function amp_social_share( $content ) {
		$post = get_post();
		$permalink = urlencode( get_permalink( $post->ID ) );
		if ( is_object( $post ) ) {
			$twitter  = add_query_arg( array(
				'url'    => $permalink,
				'status' => urlencode( $post->post_title ),
			), 'https://twitter.com/share' );
			$facebook = add_query_arg( array(
				'u' => $permalink,
			),  'https://www.facebook.com/sharer/sharer.php' );
			$share = sprintf( '
<hr><div class=post-meta-social><a class="post-social twitter" href="%s" title="Share on Twitter">
<svg viewBox="0 0 512 512" height="40" width="40"><path d="M419.6 168.6c-11.7 5.2-24.2 8.7-37.4 10.2 13.4-8.1 23.8-20.8 28.6-36 -12.6 7.5-26.5 12.9-41.3 15.8 -11.9-12.6-28.8-20.6-47.5-20.6 -42 0-72.9 39.2-63.4 79.9 -54.1-2.7-102.1-28.6-134.2-68 -17 29.2-8.8 67.5 20.1 86.9 -10.7-0.3-20.7-3.3-29.5-8.1 -0.7 30.2 20.9 58.4 52.2 64.6 -9.2 2.5-19.2 3.1-29.4 1.1 8.3 25.9 32.3 44.7 60.8 45.2 -27.4 21.4-61.8 31-96.4 27 28.8 18.5 63 29.2 99.8 29.2 120.8 0 189.1-102.1 185-193.6C399.9 193.1 410.9 181.7 419.6 168.6z"/></svg>
</a></ul>', esc_url_raw( $twitter ) );
			$content .= $share;
			$share = sprintf( '
<a class="post-social facebook" href="%s" title="Share on Facebook">
<svg viewBox="0 0 512 512" height="40" width="40"><path d="M211.9 197.4h-36.7v59.9h36.7V433.1h70.5V256.5h49.2l5.2-59.1h-54.4c0 0 0-22.1 0-33.7 0-13.9 2.8-19.5 16.3-19.5 10.9 0 38.2 0 38.2 0V82.9c0 0-40.2 0-48.8 0 -52.5 0-76.1 23.1-76.1 67.3C211.9 188.8 211.9 197.4 211.9 197.4z"/></svg>
</a></div><hr>', esc_url_raw( $facebook ) );
			$content .= $share;
		}

		return $content;
	}

	/**
	 * Include sidebar AMP script to support touch based sidebar navigation
	 */
	public function amp_set_sidebar_script() {
	?>
<script custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js" async></script>
	<?php
	}

	/**
	 * @param $data
	 *
	 * @return mixed
	 *
	 * Set site icon for AMP
	 */
	function amp_set_site_icon_url( $data ) {
		// Ideally a 32x32 image
		$data['site_icon_url'] = esc_url( get_stylesheet_directory_uri() . '/images/favicons/favicon-32x32.png' );
		return $data;
	}
}

$cst_amp = new CST_AMP();
