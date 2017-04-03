<?php

if ( ! $obj ) {
	return;
}

$classes = 'post-meta-bottom post-meta';
if ( 'cst_feature' === $obj->get_post_type() ) {
	$classes .= ' cst_feature-meta-bottom';
}
if ( is_singular() ) {
	$classes .= ' columns small-12 end';
}
if ( ! is_singular() ) {
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
	$topic    = $obj->get_topics();
	if ( ! is_array( $topic ) ) {
		$topic = array();
	}
	$topic    = array_shift( $topic );

	$person   = $obj->get_people();
	if ( ! is_array( $person ) ) {
		$person = array();
	}
	$person   = array_shift( $person );

	$location = $obj->get_locations();
	if ( ! is_array( $location ) ) {
		$location = array();
	}
	$location = array_shift( $location );

	$preferred_terms = $obj->get_preferred_terms( 'cst_preferred_terms' );
	if ( $preferred_terms ) {
		$preferred_topic = $preferred_terms['choose_topic']['featured_option_topic'];
		if ( $preferred_topic ) {
			$topic = wpcom_vip_get_term_by( 'id', $preferred_topic, 'cst_topic' );
		}
		$preferred_location = $preferred_terms['choose_location']['featured_option_location'];
		if ( $preferred_location ) {
			$location = wpcom_vip_get_term_by( 'id', $preferred_location, 'cst_topic' );
		}
		$preferred_person = $preferred_terms['choose_person']['featured_option_person'];
		if ( $preferred_person ) {
			$person = wpcom_vip_get_term_by( 'id', $preferred_person, 'cst_topic' );
		}
	}
	if ( $topic || $person || $location ) : ?>
		<div class="post-meta-taxonomy-terms">
		<?php if ( $topic ) :
			$topic_link = wpcom_vip_get_term_link( $topic->slug, 'cst_topic' );
			if ( ! is_wp_error( $topic_link ) ) {
			?>
			<span class="fa post-taxonomy">#</span> <a href="<?php echo esc_url( $topic_link ); ?>"><?php echo esc_html( $topic->name ); ?></a>
			<?php } ?>
		<?php endif; ?>
		<?php if ( $person ) :
			$person_link = wpcom_vip_get_term_link( $person->name, 'cst_person' );
			if ( ! is_wp_error( $person_link ) ) {
			?>
			<i class="fa fa-male post-taxonomy"></i> <a href="<?php echo esc_url( $person_link ); ?>"><?php echo esc_html( $person->name ); ?></a>
			<?php } ?>
		<?php endif; ?>
		<?php if ( $location ) :
			$location_link = wpcom_vip_get_term_link( $location->name, 'cst_location' );
			if ( ! is_wp_error( $location_link ) ) {
				?>
				<i class="fa fa-location-arrow post-taxonomy"></i> <a href="<?php echo esc_url( $location_link ); ?>"><?php echo esc_html( $location->name ); ?></a>
			<?php }	?>
		<?php endif; ?>
		</div>
	<?php endif; ?>
	<div style="clear:both;"></div>
</div>
<?php if ( is_singular() && ! is_preview() && ! in_array( $obj->get_post_type(), array( 'cst_liveblog', 'cst_embed' ) ) ) : ?>
	<div class="columns small-12 end">
		<?php echo CST()->frontend->inject_public_good_markup( $obj ); ?>
		<div id="addthis-<?php the_id(); ?>" class="addthis_toolbox addthis_default_style addthis_32x32_style"  addthis:url="<?php echo esc_url( $obj->get_share_link() ); ?>" addthis:title="<?php echo esc_attr( $obj->get_twitter_share_text() ); ?>">
			<a class="addthis_button_facebook" addthis:url="<?php echo esc_url( $obj->get_share_link() ); ?>" data-on="click" data-event-category="add-this" data-event-action="-facebook" addthis:title="<?php echo esc_attr( $obj->get_title() ); ?>"></a>
			<a class="addthis_button_twitter" addthis:url="<?php echo esc_url( $obj->get_share_link() ); ?>" data-on="click" data-event-category="add-this" data-event-action="twitter" addthis:title="<?php echo esc_attr( $obj->get_twitter_share_text() ); ?>"></a>
			<a class="addthis_button_email" addthis:url="<?php echo esc_url( $obj->get_share_link() ); ?>" data-on="click" data-event-category="add-this" data-event-action="email" addthis:title="<?php echo esc_attr( $obj->get_title() ); ?>"></a>
			<a class="addthis_button_compact"></a>
		</div>
		<hr class="end-of-post-line">
	</div>
<?php endif; ?>

