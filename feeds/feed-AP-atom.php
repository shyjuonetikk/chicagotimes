<?php
/**
 * Atom Feed Template for displaying Atom Posts feed.
 *
 * Specifically for AP
 */

header( 'Content-Type: ' . feed_content_type( 'atom' ) . '; charset=' . get_option( 'blog_charset' ), true );

echo '<?xml version="1.0" encoding="' . esc_attr( get_option( 'blog_charset' ) ) . '"?' . '>';

/** This action is documented in wp-includes/feed-rss2.php */
do_action( 'rss_tag_pre', 'atom' );
?>

<feed xml:lang="en-us" xmlns:apnm="http://ap.org/schemas/03/2005/apnm" xmlns:apxh="http://www.w3.org/1999/xhtml" xmlns:ap="http://ap.org/schemas/03/2005/aptypes" xmlns="http://www.w3.org/2005/Atom"
      xml:apcm="http://ap.org/schemas/03/2005/apcm">
	<author>
		<name><?php esc_attr_e( get_bloginfo_rss( 'name' ) ); ?></name>
		<uri><?php echo esc_url( get_bloginfo_rss( "url" ) ); ?></uri>
	</author>
	<id>chicago_suntimes_com_AP_atom_1</id>
	<title><?php esc_attr_e( get_bloginfo_rss( 'name' ) ); ?></title>
	<link href="<?php self_link(); ?>" rel="self"/>
	<rights>Copyright <?php echo date( "Y" ); ?> Sun-Times Media, LLC</rights>
	<updated><?php echo esc_html( mysql2date( 'Y-m-d\TH:i:s\Z', get_lastpostmodified( 'GMT' ), false ) ); ?></updated>
	<?php

	$args = array(
		'post_type' => 'cst_article',
		'suppress_filters' => false,
	);
	query_posts( $args );
	while ( have_posts() ) : the_post();

		?>
		<entry xml:lang="en-us">
			<id>urn:publicid:chicago.suntimes.com:c_s_t_<?php esc_attr_e( get_the_ID() ); ?>_t</id>
			<title><?php the_title_rss() ?></title>
			<updated><?php echo esc_html( get_post_modified_time( 'Y-m-d\TH:i:s\Z', true ) ); ?></updated>
			<published><?php echo esc_html( get_post_time( 'Y-m-d\TH:i:s\Z', true ) ); ?></published>
			<rights>Copyright <?php echo date( "Y" ); ?> Sun-Times Media, LLC</rights>
			<link href="<?php the_permalink_rss() ?>" rel="alternate"/>
			<summary type="xhtml">
				<apxh:div><?php the_excerpt_rss(); ?></apxh:div>
			</summary>
			<content type="xhtml">
				<apxh:div>
					<?php $the_atom_content = get_the_content_feed( 'atom' );
					$the_atom_content       = str_replace( '<', '<apxh:', $the_atom_content );
					$the_atom_content       = str_replace( '</', '</apxh:', $the_atom_content );
					echo $the_atom_content; ?>
				</apxh:div>
			</content>
			<apcm:ContentMetadata>
				<apcm:ByLine><?php the_author() ?></apcm:ByLine>
				<apcm:HeadLine><?php the_title_rss() ?></apcm:HeadLine>
				<apcm:Source City="<?php bloginfo_rss( 'name' ); ?>" Url="<?php echo esc_url( get_bloginfo_rss( "url" ) ); ?>"><?php esc_attr_e( get_bloginfo_rss( 'name' ) ); ?></apcm:Source>
				<?php $content = get_post_field( 'post_content', $post->ID );
				$word_count    = str_word_count( strip_tags( $content ) ); ?>
				<apcm:Characteristics MediaType="Text"
				/ Words="<?php echo esc_attr( $word_count ); ?>">
			</apcm:ContentMetadata>
		</entry>
	<?php endwhile; ?>

</feed>
