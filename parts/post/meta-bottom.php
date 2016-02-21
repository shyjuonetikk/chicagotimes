<?php

if ( ! $obj ) {
    return;
}

	$classes = 'post-meta-bottom post-meta';
	if ( is_singular() ) {
		$classes .= ' columns medium-9 medium-offset-1 end';
	}
	if ( !is_singular() ) {
		$classes .= ' show-for-medium-up';
	}
?>
<div class="<?php echo esc_attr( $classes ); ?>">
	<?php if ( ! is_singular() ) : ?>
	<?php echo CST()->get_template_part( 'post/social-share', array( 'obj' => $obj ) ); ?>
	<div class="left">
		<i class="post-type fa fa-<?php echo esc_attr( $obj->get_font_icon() ); ?>"></i>
	</div>
	<?php endif; ?>
	<?php
		$topic = $obj->get_topics();
		$person = $obj->get_people();
		$location = $obj->get_locations();
		if ( $topic || $person || $location ) : ?>
		<div class="post-meta-taxonomy-terms">
		<?php if ( $topic ) :
			$topic = array_shift( $topic );
			$topic_link = wpcom_vip_get_term_link( $topic->name, 'cst_topic' );
			?>
			<span class="fa post-taxonomy">#</span> <a href="<?php echo esc_url( $topic_link ); ?>"><?php echo esc_html( $topic->name ); ?></a>
		<?php endif; ?>
		<?php if ( $person ) :
			$person = array_shift( $person );
			$person_link = wpcom_vip_get_term_link( $person->name, 'cst_person' );
			?>
			<i class="fa fa-male post-taxonomy"></i> <a href="<?php echo esc_url( $person_link ); ?>"><?php echo esc_html( $person->name ); ?></a>
		<?php endif; ?>
		<?php if ( $location ) :
			$location = array_shift( $location );
			$location_link = wpcom_vip_get_term_link( $location->name, 'cst_location' );
			?>
			<i class="fa fa-location-arrow post-taxonomy"></i> <a href="<?php echo esc_url( $location_link ); ?>"><?php echo esc_html( $location->name ); ?></a>
		<?php endif; ?>
		</div>
	<?php endif; ?>
	<div style="clear:both;"></div>
</div>
<?php if ( is_singular() && ! is_preview() && ! in_array( $obj->get_post_type(), array( 'cst_liveblog', 'cst_embed' ) ) ) : ?>
	<div class="columns medium-9 medium-offset-1 end">
		<div id="addthis-<?php the_id(); ?>" class="addthis_toolbox addthis_default_style addthis_32x32_style" addthis:url="<?php echo esc_url( $obj->get_share_link() ); ?>" addthis:title="<?php echo esc_attr( $obj->get_twitter_share_text() ); ?>">
			<a class="addthis_button_facebook" addthis:url="<?php echo esc_url( $obj->get_share_link() ); ?>" addthis:title="<?php echo esc_attr( $obj->get_title() ); ?>"></a>
			<a class="addthis_button_twitter" addthis:url="<?php echo esc_url( $obj->get_share_link() ); ?>" addthis:title="<?php echo esc_attr( $obj->get_twitter_share_text() ); ?>"></a>
			<a class="addthis_button_email" addthis:url="<?php echo esc_url( $obj->get_share_link() ); ?>" addthis:title="<?php echo esc_attr( $obj->get_title() ); ?>"></a>
			<a class="addthis_button_compact"></a>
		</div>
		<hr class="end-of-post-line">
	</div>
<?php endif; ?>
<div class="post-meta post-meta-top mobile-bottom hide-for-medium-up">
<?php if ( !is_singular() ) : ?>
	<i class="post-type fa fa-<?php echo esc_attr( $obj->get_font_icon() ); ?>"></i>
	<span class="post-relative-date"><?php echo human_time_diff( $obj->get_post_date_gmt() ); ?></span>
<?php endif; ?>
</div>
