<div id="index-sidebar-anchor"></div>

<aside class="sidebar" id="index-sidebar">

	<ul class="widgets">
		<?php
		$cst = CST_Frontend::get_instance();
		$primary_slug = $cst->slug_detection();

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
				case 'autos' :
					dynamic_sidebar( 'autoswire' );
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
