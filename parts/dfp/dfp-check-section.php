<?php
	if( is_tax() ) :
		$dfp_obj = get_queried_object();
	//print_r($dfp_obj);
		if( $dfp_obj->taxonomy == 'cst_section' ) :
			if( $dfp_obj->parent == 0 ) :
				$dfp_slug = $dfp_obj->slug;
				switch( $dfp_slug ) {
					case 'sports':
						get_template_part( 'parts/dfp/sports/dfp-sports-header-index' );
						break;
					case 'news':
						get_template_part( 'parts/dfp/dfp-header' );
						break;
					default:
						get_template_part( 'parts/dfp/dfp-header' );
						break;
				}
			else :
				$dfp_child  = $dfp_obj->slug;
				$dfp_parent = $dfp_obj->parent;
				$dfp_term   = get_term( $dfp_parent, 'cst_section' );
				$dfp_slug   = $dfp_term->slug;

				if( ! in_array( $dfp_slug, CST_Frontend::$post_sections ) ) :
					// The original slug is a grandchild, so get the child parent slug
					$dfp_term   = get_term( $dfp_term->parent, 'cst_section' );
					$dfp_slug   = $dfp_term->slug;
				endif;
				
				switch( $dfp_slug ) {
					case 'sports':
						get_template_part( 'parts/dfp/sports/dfp-sports-header-child' );
						break;
					case 'news':
						get_template_part( 'parts/dfp/dfp-header' );
						break;
					default:
						get_template_part( 'parts/dfp/dfp-header' );
						break;
				}

			endif;
		else :
			get_template_part( 'parts/dfp/dfp-header' );
		endif; 
	else :
		get_template_part( 'parts/dfp/dfp-header' ); 
	endif;
?>