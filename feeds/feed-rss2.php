<?php
/**
 * RSS2 Feed Template for displaying RSS2 Posts feed.
 *
 * @package WordPress
 */

header( 'Content-Type: ' . feed_content_type( 'rss-http' ) . '; charset=' . get_option( 'blog_charset' ), true );
$more = 1;

echo '<?xml version="1.0" encoding="' . get_option( 'blog_charset' ) . '"?' . '>';

/**
 * Fires between the <xml> and <rss> tags in a feed.
 *
 * @since 4.0.0
 *
 * @param string $context Type of feed. Possible values include 'rss2', 'rss2-comments',
 *                        'rdf', 'atom', and 'atom-comments'.
 */
do_action( 'rss_tag_pre', 'rss2' );
?>
<rss version="2.0"
	 xmlns:content="http://purl.org/rss/1.0/modules/content/"
	 xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	 xmlns:dc="http://purl.org/dc/elements/1.1/"
	 xmlns:atom="http://www.w3.org/2005/Atom"
	 xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	 xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	<?php
	/**
	 * Fires at the end of the RSS root to add namespaces.
	 *
	 * @since 2.0.0
	 */
	do_action( 'rss2_ns' );
	?>
>

	<channel>
		<title><?php wp_title_rss(); ?></title>
		<atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml"/>
		<link><?php bloginfo_rss( 'url' ) ?></link>
		<description><?php bloginfo_rss( 'description' ) ?></description>
		<lastBuildDate><?php echo mysql2date( 'D, d M Y H:i:s +0000', get_lastpostmodified( 'GMT' ), false ); ?></lastBuildDate>
		<language><?php bloginfo_rss( 'language' ); ?></language>
		<?php
		$duration = 'hourly';
		/**
		 * Filter how often to update the RSS feed.
		 *
		 * @since 2.1.0
		 *
		 * @param string $duration The update period.
		 *                         Default 'hourly'. Accepts 'hourly', 'daily', 'weekly', 'monthly', 'yearly'.
		 */
		?>
		<sy:updatePeriod><?php echo apply_filters( 'rss_update_period', $duration ); ?></sy:updatePeriod>
		<?php
		$frequency = '1';
		/**
		 * Filter the RSS update frequency.
		 *
		 * @since 2.1.0
		 *
		 * @param string $frequency An integer passed as a string representing the frequency
		 *                          of RSS updates within the update period. Default '1'.
		 */
		?>
		<sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', $frequency ); ?></sy:updateFrequency>
		<?php
		/**
		 * Fires at the end of the RSS2 Feed Header.
		 *
		 * @since 2.0.0
		 */
		do_action( 'rss2_head' );

		while ( have_posts() ) : the_post();
			$obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );
			if ( CST()->cst_feeds->publish_this_content_item( $obj ) ) {
				?>
				<item>
					<title><?php the_title_rss() ?></title>
					<link><?php the_permalink_rss() ?></link>
					<comments><?php comments_link_feed(); ?></comments>
					<pubDate><?php echo mysql2date( 'D, d M Y H:i:s +0000', get_post_time( 'Y-m-d H:i:s', true ), false ); ?></pubDate>
					<?php
					if ( $obj ) :
						$byline = $obj->get_byline();
						if ( ! $byline ) {
							foreach ( $obj->get_authors() as $i => $author ) { ?>
								<dc:creator><![CDATA[<?php echo esc_html( $author->get_display_name() ); ?>]]></dc:creator>
								<?php
							}
						} else {
							?>
							<dc:creator><![CDATA[<?php echo esc_html( $byline ); ?>]]></dc:creator>
							<?php
						}
						?>
						<?php
					endif;
					?>
					<?php the_category_rss( 'rss2' ) ?>

					<guid isPermaLink="false"><?php the_guid(); ?></guid>
					<?php
					if ( $obj ) :
						$featured_image_id = $obj->get_featured_image_id();
						if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) :
							?>
							<media:content url="<?php echo esc_url( $attachment->get_url() ); ?>">
								<media:thumbnail url="<?php echo esc_url( $attachment->get_url() ); ?>"/>
								<?php $credit = $attachment->get_credit(); ?>
								<media:credit><?php echo esc_html( $credit ); ?></media:credit>
								<media:title><?php the_title_rss(); ?></media:title>
								<?php $caption = $attachment->get_caption(); ?>
								<media:text><?php echo esc_html( $caption ); ?></media:text>
							</media:content>
							<enclosure
									url="<?php echo esc_url( $attachment->get_url() ); ?>"
									length="0"
									type="<?php echo esc_html( get_post_mime_type( $featured_image_id ) ); ?>"
							/>
							<?php
						endif;
					endif;
					?>
					<?php if ( get_option( 'rss_use_excerpt' ) ) : ?>
						<description><![CDATA[<?php the_excerpt_rss(); ?>]]></description>
					<?php else : ?>
						<description><![CDATA[<?php the_excerpt_rss(); ?>]]></description>
						<?php $content = get_the_content_feed( 'rss2' ); ?>
						<?php if ( strlen( $content ) > 0 ) : ?>
							<content:encoded><![CDATA[<?php echo $content; ?>]]></content:encoded>
						<?php else : ?>
							<content:encoded><![CDATA[<?php the_excerpt_rss(); ?>]]></content:encoded>
						<?php endif; ?>
					<?php endif; ?>
					<?php
					if ( $obj ) {
						$sections   = $obj->get_sections();
						$people     = $obj->get_people();
						$locations  = $obj->get_locations();
						$topics     = $obj->get_topics();
						$newsletter = $obj->get_newsletter_tag();
						?>
						<?php
						if ( $sections ) {
							foreach ( $sections as $section ) { ?>
								<category domain="cst_section" nicename="<?php echo esc_html( $section->slug ); ?>"><![CDATA[<?php echo esc_html( $section->slug ); ?>]]></category>
								<?php
							}
						}
						?>
						<?php
						if ( $people ) {
							foreach ( $people as $person ) { ?>
								<category domain="cst_person" nicename="<?php echo esc_html( $person->slug ); ?>"><![CDATA[<?php echo esc_html( $person->slug ); ?>]]></category>
								<?php
							}
						}
						?>
						<?php
						if ( $locations ) {
							foreach ( $locations as $location ) { ?>
								<category domain="cst_location" nicename="<?php echo esc_html( $location->slug ); ?>"><![CDATA[<?php echo esc_html( $location->slug ); ?>]]></category>
								<?php
							}
						}
						?>
						<?php
						if ( $topics ) {
							foreach ( $topics as $topic ) { ?>
								<category domain="cst_topic" nicename="<?php echo esc_html( $topic->slug ); ?>"><![CDATA[<?php echo esc_html( $topic->slug ); ?>]]></category>
								<?php
							}
						}
						?>

						<?php
						if ( $newsletter ) { ?>
							<category domain="cst_newsletter" nicename="<?php echo esc_html( $newsletter ); ?>"><![CDATA[<?php echo esc_html( $newsletter ); ?>]]></category>
							<?php
						}
						?>
						<?php
					}
					?>
					<wfw:commentRss><?php echo esc_url( get_post_comments_feed_link( null, 'rss2' ) ); ?></wfw:commentRss>
					<slash:comments><?php echo get_comments_number(); ?></slash:comments>
					<?php rss_enclosure(); ?>
					<?php
					/**
					 * Fires at the end of each RSS2 feed item.
					 *
					 * @since 2.0.0
					 */
					do_action( 'rss2_item' );
					?>
				</item>
				<?php } ?>
		<?php endwhile; ?>
	</channel>
</rss>
