<?php
global $dfp_slug;
global $dfp_parent;
global $dfp_child;
	if( is_tax() ) :
		$dfp_obj = get_queried_object();
		if( $dfp_obj->taxonomy == 'cst_section' ) :
			if( $dfp_obj->parent == 0 ) :
				$dfp_slug = $dfp_obj->slug;
				get_template_part( 'parts/dfp/dfp-header' );
			else :
				$dfp_parent = $dfp_obj->parent;
				$dfp_term   = get_term( $dfp_parent, 'cst_section' );
				$dfp_slug 	= $dfp_term->slug;
				if( $dfp_term->parent != 0 ) {
					$dfp_term   = get_term( $dfp_term->parent, 'cst_section' );
					$dfp_slug 	= $dfp_term->slug;
				}
				get_template_part( 'parts/dfp/dfp-header' );

			endif;
		else :
			get_template_part( 'parts/dfp/dfp-header' );
		endif; 
	else :
		$obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );

		if ( $obj ) {
			$parent_section = $obj->get_primary_parent_section();

			if ( $parent_section ) {
				$dfp_slug = $parent_section->slug;
			} 
		} else {
			$dfp_slug = 'news';
		}
		get_template_part( 'parts/dfp/dfp-header' ); 
	endif;
?>