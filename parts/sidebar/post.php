<li <?php post_class(); ?> data-post-date="<?php echo esc_attr( $obj->get_post_date( 'Y-m-d-H-i-s' ) ); ?>">

	<?php

		// Embeds use the author details
		if ( ! in_array( $obj->get_post_type(), array( 'cst_embed' ) ) ) {
			echo CST()->get_template_part( 'sidebar/post-meta-top', array( 'obj' => $obj ) );
		}
		echo CST()->get_template_part( 'content-' . str_replace( 'cst_', '', get_post_type() ), array( 'obj' => $obj ) );
		echo CST()->get_template_part( 'sidebar/post-meta-bottom', array( 'obj' => $obj ) );

	?>

</li>