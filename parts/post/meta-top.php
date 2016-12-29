<?php

if ( ! $obj ) {
	return;
}

	$classes = array( 'post-meta', 'post-meta-top' );

	if ( is_singular() ) {
		if ( $section = $obj->get_primary_section() ) {
			if ( CST()->frontend->do_sponsor_header( $section->term_id ) ) {
				$classes[] = 'columns medium-4';
			} else {
				$classes[] = 'columns small-12 end';
			}
		}
	}

	if ( is_sticky() && ! is_singular() ) {
		$classes[] = 'sticky-taxonomy';
	}
?>
<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
<?php if ( $section = $obj->get_primary_section() ) : ?>
<?php if ( is_sticky() && ! is_singular() ) : ?>
	<span class="developing">
		<span class="triangle-top-right"></span>
		<span class="developing-text">developing</span>
		<span class="right-ribbon"></span>
	</span>
<?php endif; ?>
<?php
// VIP: Stopping fatal errors "Call to undefined method CST\Objects\Gallery::get_preferred_section()"
if ( is_callable( array( $obj, 'get_preferred_section' ) ) ) :
?>
<?php $preferred_section = $obj->get_preferred_section( $section );
echo sprintf(
	'<span class="post-section-taxonomy">
	<a href="%1$s" data-on="click" data-event-category="article" data-event-action="navigate to %2$s section-front">%2$s</a>
</span>',
	esc_url( $preferred_section['term_link'] ),
	esc_html( $preferred_section['term_name'] )
);
?>
<?php endif; // End VIP Hotfix ?>
<?php endif; ?>
	<?php if ( ! is_sticky() ) : ?>
	<span class="post-relative-date top-date"><?php echo date( 'm/d/Y, h:ia', $obj->get_post_date() ); ?></span>
<?php endif; ?>
</div>
<?php
if ( $section = $obj->get_primary_section() ) {
	if ( CST()->frontend->do_sponsor_header( $section->term_id ) ) { ?>
		<div class="medium-7 end" style="float: right;">
			<?php CST()->frontend->sponsor_header( $section->term_id ); ?>
		</div>
<?php }
}
