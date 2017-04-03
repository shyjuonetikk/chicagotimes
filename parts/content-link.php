<?php if ( ! empty( $is_main_query ) ) { ?>
	<h1><a href="<?php $obj->the_permalink(); ?>" target="_blank"><?php $obj->the_title(); ?></a></h1>
<?php } else { ?>
	<h3><a href="<?php $obj->the_permalink(); ?>" target="_blank"><?php $obj->the_title(); ?></a></h3>
<?php } ?>

<?php if ( ! empty( $is_main_query ) ) { ?>
	<?php
	if ( $obj->get_excerpt() ) {
		echo CST()->get_template_part( 'post/post-excerpt', array( 'obj' => $obj ) );
	}
	?>
	<?php if ( $obj->get_featured_image_id() ) {
		echo CST()->get_template_part( 'post/wire-featured-image', array( 'obj' => $obj ) );
} ?>

<?php } ?>
