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
			$url = "http://syndication.ap.org/AP.Distro.Feed/GetFeed.aspx?idList=30948&idListType=products&maxitems=50&fullContent=true";
			$xml = getData($url);
			foreach ($xml as $node)
			{
			    $row = simplexml_load_string($node->asXML());
			    // $result = $row->xpath("//media/media-reference[@mime-type='image/jpeg']");
			    $heading = $row->xpath("//body/body.content/block");
			    // print_r($heading);
			    if(!empty($heading)){
			    	// $image = $result[0];
			    	$head = $heading[0];
			    	// print_r($head);
			    	echo $head['table'];

			    }
			    else{
			    	echo "no result found <br>";
			    }
			    // print_r($heading);
			}
			
		?>
		</div>
	</div>
</section>
<?php get_footer();?>