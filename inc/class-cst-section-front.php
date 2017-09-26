<?php

namespace CST;

class CST_Section_Front {
	private static $instance;

	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new CST_Section_Front;
			self::$instance->setup_actions();
			self::$instance->setup_filters();
		}
		return self::$instance;
	}

	public function setup_actions(  ) {

	}

	public function setup_filters(  ) {

	}

	public function five_block( $team ) {
		?>
<div class="stories-container">
<div class="small-12 columns more-stories-container" id="sf-section-lead">
	<hr>
	<?php CST()->frontend->sports_heading( $team ); ?>
	<?php CST()->frontend->mini_stories_content_block( CST()->customizer->get_upper_section_stories() ); ?>
</div><!-- /#sf-section-lead -->
</div>
<?php
	}
}