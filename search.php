<?php get_header(); ?>

<section id="search-body" class="white-background">
	<div class="row">	
		<div class="columns large-12">
			<?php
				get_template_part( 'parts/dfp/dfp-atf-leaderboard' );
				get_template_part( 'parts/dfp/dfp-mobile-leaderboard' ); 
			?>
			<hr/>
			<div>
		        <div class="small-12 search-widget">
		            <form class="search-wrap" autocomplete="off" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		            	<h3>Search Results for...</h3>
		                <input id="search-input" placeholder="<?php esc_attr_e( 'search...', 'chicagosuntimes' ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" />
		        <?php if( is_front_page() ) : ?>
		                <a href="#" id="search-button" class="search-in">
		                    <i class="fa fa-search"></i>
		                </a>
		        <?php else : ?>
		                <button type="submit" id="search-button" class="search-in">
		                    <i class="fa fa-search"></i>
		                </button>
		        <?php endif; ?>
		            </form>
		        </div>
		    </div>
			<script>
				(function() {
					var cx = '005331855116509174310:f-yelopuxim';
					var gcse = document.createElement('script');
					gcse.type = 'text/javascript';
					gcse.async = true;
					gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
					'//www.google.com/cse/cse.js?cx=' + cx;
					var s = document.getElementsByTagName('script')[0];
					s.parentNode.insertBefore(gcse, s);
				})();
			</script>
			<gcse:searchresults-only linktarget="_parent" queryParameterName="s"></gcse:searchresults-only>
			<?php get_template_part( 'parts/dfp/dfp-btf-leaderboard' ); ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>