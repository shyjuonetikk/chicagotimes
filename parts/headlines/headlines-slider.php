<div class="slider">
<?php
	$primary_section = get_queried_object();
		if( isset( $primary_section ) && $primary_section->taxonomy == 'cst_section') {
			if( $primary_section->parent != 0 ) {
				$primary_slug = $primary_section->slug;
				if( ! in_array( $primary_slug, CST_Frontend::$post_sections ) ) {
					$current_section = get_term( $primary_section->parent, 'cst_section' );
					if( ! in_array( $current_section->slug, CST_Frontend::$post_sections ) ) {
						$current_section = get_term( $current_section->parent, 'cst_section' );
						if( ! in_array( $current_section->slug, CST_Frontend::$post_sections ) ) {
							$current_section = get_term( $current_section->parent, 'cst_section' );
						} else {
							$primary_slug = $current_section->slug;
						}
					} else {
						$primary_slug = $current_section->slug;
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
			case 'politics':
				dynamic_sidebar( 'politics_headlines' );
				break;
			case 'entertainment':
				dynamic_sidebar( 'entertainment_headlines' );
				break;
			case 'lifestyles':
				dynamic_sidebar( 'lifestyles_headlines' );
				break;
			case 'columnists':
				dynamic_sidebar( 'columnists_headlines' );
				break;
			case 'opinion':
				dynamic_sidebar( 'opinion_headlines' );
				break;
			case 'sponsored':
				break;
			default:
				dynamic_sidebar( 'news_headlines' );
				break;
		}
?>
</div>