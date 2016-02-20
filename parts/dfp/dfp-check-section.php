<?php
global $dfp_slug;
global $dfp_parent;
global $dfp_child;
	if( is_tax() ) :
		$dfp_obj = get_queried_object();
	//print_r($dfp_obj);
		if( $dfp_obj->taxonomy == 'cst_section' ) :
			if( $dfp_obj->parent == 0 ) :
				$dfp_slug = $dfp_obj->slug;
				get_template_part( 'parts/dfp/dfp-header' );
			else :
				$dfp_child  = $dfp_obj->slug;
				$dfp_parent = $dfp_obj->parent;
				$dfp_term   = get_term( $dfp_parent, 'cst_section' );
				$dfp_parent = $dfp_term->slug;
				echo $dfp_slug;
				get_template_part( 'parts/dfp/dfp-header-sub-section' );

			endif;
		else :
			get_template_part( 'parts/dfp/dfp-header' );
		endif; 
	else :
		get_template_part( 'parts/dfp/dfp-header' ); 
	endif;
?>