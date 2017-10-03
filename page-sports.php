<?php
/*

Template Name: Sports page

*/
get_header();
?>
<section>
	<div class="row page-content">
		<div class="small-12 columns">
		<?php 
			$feed = "http://syndication.ap.org/AP.Distro.Feed/GetFeed.aspx?idList=30948&idListType=products&maxitems=50&fullContent=true";
			// $feed = "http://syndication.ap.org/AP.Distro.Feed/GetFeed.aspx?idList=31075&idListType=products&maxitems=25&fullContent=true";
		// $feed = "http://syndication.ap.org/AP.Distro.Feed/GetFeed.aspx?idList=100502&idListType=products&maxitems=25&fullContent=true";
			$feed_data = getData( $feed );
			$xml = simplexml_load_string( $feed_data );
			print_r($feed_data);
			// foreach ($xml as $value) {
			// 	echo $value->title."<br>";
			// }
		?>
		</div>
	</div>
</section>
<?php get_footer();?>