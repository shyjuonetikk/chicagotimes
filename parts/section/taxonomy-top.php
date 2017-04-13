<?php if ( ! is_tax( 'cst_topic' ) && ! is_tax( 'cst_person' ) && ! is_tax( 'cst_location' ) ) : ?>
<?php $section_front = get_queried_object()->slug; ?>
<?php if ( $section_front ) { ?>
	<?php
	if ( 'obituaries-obituaries' === $section_front ) {
		$section_front_spacing = 'obituaries';
	} else {
		$section_front_spacing = str_replace( '-', ' ', $section_front );
	}
	?>
	<?php if ( 'television' === $section_front_spacing ) { ?>
		<a href="http://www.wciu.com" target="_blank" class="section-front-sponsor">Brought to you by
			<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/wciu-logo.png" alt="WCIU LOGO">
		</a>
	<?php } ?>
<?php } ?>
<?php else : ?>

<?php endif;
