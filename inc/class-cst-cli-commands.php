<?php
/**
 * Implements example command.
 */
class CSTUser_Command extends WP_CLI_Command {

	/**
	 * Prints a greeting.
	 *
	 * ## OPTIONS
	 *
	 * <name>
	 * : The name of the person to greet.
	 *
	 * [--type=<type>]
	 * : Whether or not to greet the person with success or error.
	 * ---
	 * default: success
	 * options:
	 *   - success
	 *   - error
	 * ---
	 *
	 * ## EXAMPLES
	 *
	 *     wp example hello Newman
	 *
	 * @when before_wp_load
	 */
	function modify( $args, $assoc_args ) {
		list( $name ) = $args;

		// Print the message with type
		$type = $assoc_args['type'];
		WP_CLI::$type( "Hello, $name!" );
	}
}

WP_CLI::add_command( 'modify', 'Example_Command' );