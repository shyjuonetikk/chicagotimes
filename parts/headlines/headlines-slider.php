<div class="slider">
<?php
	$primary_section = get_queried_object();
	$primary_slug = 'news';
		if( $primary_section->taxonomy == 'cst_section') {
			if( $primary_section->parent != 0 ) {
				if( ! in_array( $primary_slug, CST_Frontend::$post_sections ) ) {
					$parent_terms = get_term( $primary_section->parent, 'cst_section' );
					if( ! in_array( $parent_terms->slug, CST_Frontend::$post_sections ) ) {
						$child_terms = get_term( $parent_terms->parent, 'cst_section' );
						$primary_slug = $child_terms->slug;
					} else {
						$primary_slug = $parent_terms->slug;
					}
				}
			} else {
				$primary_slug = $primary_section->slug;
			}
		} elseif( is_single() ) {
			$obj = \CST\Objects\Post::get_by_post_id( $primary_section->ID );
			$primary_section = $obj->get_primary_section();
			$primary_slug = $primary_section->slug;
				if( ! in_array( $primary_slug, CST_Frontend::$post_sections ) ) {
					$parent_terms = get_term( $primary_section->parent, 'cst_section' );
					if( ! in_array( $parent_terms->slug, CST_Frontend::$post_sections ) ) {
						$child_terms = get_term( $parent_terms->parent, 'cst_section' );
						$primary_slug = $child_terms->slug;
					} else {
						$primary_slug = $parent_terms->slug;
					}
				}
		} else {
			$primary_slug = 'news';
		}
		switch ($primary_slug) {
			case 'sports':
				dynamic_sidebar( 'sports_headlines' );
				break;
			case 'news':
				dynamic_sidebar( 'news_headlines' );
				break;
			default:
				dynamic_sidebar( 'news_headlines' );
				break;
		}
?>
</div>