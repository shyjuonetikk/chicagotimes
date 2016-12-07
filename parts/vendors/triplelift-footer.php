<?php
if ( CST()->frontend->include_triple_lift( $obj = \CST\Objects\Post::get_by_post_id( get_queried_object_id() ) ) ) { ?>
<script>
	document.addEventListener("DOMContentLoaded", function(){
		window.CSTTripleLift && CSTTripleLift.inject()
	})
</script>
<?php }
