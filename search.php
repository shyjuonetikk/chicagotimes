<?php get_header(); ?>

<section id="search-body" class="white-background">
	<div class="row">	
		<div class="columns large-12">
			<?php
				get_template_part( 'parts/dfp/dfp-atf-leaderboard' );
				get_template_part( 'parts/dfp/dfp-mobile-leaderboard' ); 
			?>
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