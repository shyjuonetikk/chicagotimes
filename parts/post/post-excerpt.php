<?php
if ( $section = $obj->get_primary_section() ) {
	if ( ! CST()->frontend->do_sponsor_header( $section->term_id ) ) { ?>
		<div class="post-excerpt show-for-medium-up">
			<?php $obj->the_excerpt(); ?>
		</div>
	<?php }
}