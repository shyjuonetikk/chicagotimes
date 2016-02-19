<div class="slider">
<?php
	$primary_section = get_queried_object();
	$primary_slug = 'news';
		if( $primary_section->taxonomy == 'cst_section') {
			if( $primary_section->parent != 0 ) {
				if( $primary_slug != 'sports' || $primary_slug != 'news' ) {
					$parent_terms = get_term( $primary_section->parent, 'cst_section' );
					if( $parent_terms->slug != 'sports' && $parent_terms->slug != 'news' ) {
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
				if( $primary_slug != 'sports' && $primary_slug != 'news' ) {
					$parent_terms = get_term( $primary_section->parent, 'cst_section' );
					if( $parent_terms->slug != 'sports' && $parent_terms->slug != 'news' ) {
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