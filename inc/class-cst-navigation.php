<?php

/**
 * Class GC_walker_nav_menu
 *
 * Walker class to add Foundation's "dropdown" class in the markup for relevant navigation items
 */

class GC_walker_nav_menu extends Walker_Nav_Menu {

	// add classes to ul sub-menus
	public function start_lvl( &$output, $depth = 0, $args = array() ) {

		// depth dependent classes
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

		// build html
		$output .= "\n" . $indent . '<ul class="dropdown left-submenu"><li class="back"><a href="#">Back</a></li>' . "\n";

	}

}

