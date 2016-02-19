<div id="index-sidebar-anchor"></div>

<aside class="sidebar show-for-large-up" id="index-sidebar">

	<ul class="widgets">
		<?php
			$primary_section = get_queried_object();
			$primary_slug = $primary_section->slug;
			if( $primary_section->taxonomy == 'cst_section' ) {
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
				} 
			} else {
				$primary_slug = 'news';
			}

			switch ($primary_slug) {
				case 'news' :
					dynamic_sidebar( 'newswire' );
					break;
				case 'sports' :
					dynamic_sidebar( 'sportswire' );
					break;
				case 'politics' :
					dynamic_sidebar( 'politicswire' );
					break;
				case 'entertainment' :
					dynamic_sidebar( 'entertainmentwire' );
					break;
				case 'lifestyles' :
					dynamic_sidebar( 'lifestyleswire' );
					break;
				case 'opinion' :
					dynamic_sidebar( 'opinionwire' );
					break;
				case 'columnists' :
					dynamic_sidebar( 'columnistswire' );
					break;
				case 'obits':
					dynamic_sidebar( 'obitswire' );
					break;
				default:
					dynamic_sidebar( 'newswire' );
					break;
			}
		?>
	</ul>

</aside>