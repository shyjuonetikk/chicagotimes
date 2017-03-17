<aside class="sidebar article-sidebar widgets columns" id="post-sidebar">
	<div class="sidebar-scroll-container row">
		<ul>
			<?php if ( is_single() ) : ?>
				<?php if ( dynamic_sidebar( 'articleright' ) ) { } ?>
			<?php endif; ?>
		</ul>
	</div>
</aside>
