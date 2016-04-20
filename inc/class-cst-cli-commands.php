<?php

/**
 * Suntimesmedia WP-CLI commands.
 *
 */

WP_CLI::add_command( 'suntimesmedia', 'Suntimesmedia_Command' );

class Suntimesmedia_Command extends  WPCOM_VIP_CLI_Command {

	/**
	 * Reassigns the author of content according to supplied author map.
	 *
	 * ## OPTIONS
	 *
	 * <author_name>
	 * : The author name to reassign content for.
	 *
	 * [--content=<content-filename>]
	 * : The csv list of content to be parsed for author changes
	 * ---
	 * default: cst-content.csv
	 * ---
	 *
	 * [--author-map=<author-map-filename>]
	 * : The csv list of authors to be parsed for author changes
	 * ---
	 * default: cst-author-map-content.csv
	 * ---
	 *
	 * [--live-run]
	 * : Actually make changes
	 *
	 * [--sleep-mod]
	 * : Time, in iterations, between sleeps of 1 second
	 *
	 * ---
	 * default: 10
	 * ---
	 *
	 * ## EXAMPLES
	 *
	 *     wp suntimesmedia reassign author_name --content=cst-content.csv
	 *
	 */

	function reassign( $args, $assoc_args ) {

		/**
		 * @param $args
		 * @param $assoc_args
		 *
		 * Reassign author based on author referenced in legacyUrl article mapped to new author
		 *
		 */

		$content_file    = 'cst-content.csv';
		$author_map_file = 'cst-author-map-content.csv';
		if ( isset( $assoc_args['content'] ) ) {
			$content_file = $assoc_args['content'];
		}
		if ( isset( $assoc_args['author-map'] ) ) {
			$author_map_file = $assoc_args['author-map'];
		}
		if ( isset( $assoc_args['sleep-mod'] ) ) {
			$this->sleep_mod = intval( $assoc_args['sleep-mod'] );
		}

		$dry_run_mode = empty ( $assoc_args['live-run'] );

		if ( ! empty ( $content_file ) && ! empty ( $author_map_file ) ) {
			if ( $content_handle = @fopen( $content_file, 'r' ) ) {

				if ( $author_map_handle = @fopen( $author_map_file, 'r' ) ) {
					// Go - we have a csv file to read and we have an author map

					if ( $this->set_author_mapping( $author_map_handle ) ) {
						WP_CLI::success( WP_CLI::colorize( "%g$content_file%n and %g$author_map_file%n found and will be used :-)" ) );
						// read and discard header row from csv file
						$read_first_line_buffer = fgets( $content_handle, 4096 );
						while ( false !== ( $buffer = fgets( $content_handle, 4096 ) ) ) {

							$this->process_author_change( $buffer, $dry_run_mode );

						}
					}

					fclose( $author_map_handle );
				} else {
					WP_CLI::error( "No author mapping filename found/supplied :-(" );
				}
				fclose( $content_handle );
			} else {
				WP_CLI::error( "$content_file unable to open for reading :-(" );
			}
			$change_count_total = $this->change_count_id;
			$change_count_total += $this->change_count_slug;
			WP_CLI::success( "Items changed -> [by id]$this->change_count_id [by slug]$this->change_count_slug totaling $change_count_total" . ( $dry_run_mode ? " during dry run" : '' ) );

		} else {
			WP_CLI::error( "No content mapping filename supplied :-(" );
		}

	}

	/**
	 * @param $incoming_csv_line
	 * @param $dry_run_mode
	 * 
	 * Line from imported csv file
	 */
	private function process_author_change( $incoming_csv_line, $dry_run_mode ) {
		$slug_args     = array(
			'post_type'        => 'cst_article',
			'post_status'      => 'publish',
			'posts_per_page'   => 1,
			'suppress_filters' => false,
		);

		// Read each line to get the variables listed out below
		list( $remote_post_id, $staging_post_id, $remote_author_slug,
			$remote_author_nickname, $remote_author_id, $remote_author_name, $legacy_url
			) = explode( ',', $incoming_csv_line );
		if ( 'unavailable' !== $remote_post_id ) {

			// Unavailable (around 242) covers content that exists but we appear to have no record
			// of the original author
			$this->process_sleep_counter( $dry_run_mode );

			$found_content_by_id = get_post( $staging_post_id );
			// If we have a valid remote post ID (from our legacy system prior to import)
			// First try and get content by the ID as the content ids imported from staging to VIP matched.

			if ( null == $found_content_by_id ) {

				// No content found by id
				// 2nd and last resort - try and find by slug from post_meta legacyUrl (provided by csv file)
				if ( 1 == preg_match( '#\/\d{3,9}\/(.+)#', $legacy_url, $matches ) ) {

					// Use remainder of legacy url as slug to search for content.
					$the_slug          = $matches[1];
					$slug_args['name'] = $the_slug;
					// Let's get the post by slug given it's likely not to have changed

					$my_posts          = get_posts( $slug_args );
					if ( ! empty( $my_posts ) ) {
						// Found content by slug, yay!
						WP_CLI::line( "Found by slug $legacy_url" );

						// Do we have the author in our array - ie do we know who to map it to?
						// Lets find out...and apply the change
						$this->update_content_author( $remote_author_slug, $staging_post_id, $legacy_url, $dry_run_mode );
						$this->change_count_slug++;
					} else {
						//WP_CLI::warning( "[slug]Search by slug failed: $the_slug legacy url: $legacy_url" );
					}
				} else {
					WP_CLI::warning( "[slug]No slug match for $legacy_url" );
				}
			} else {
				// Yay ! - content found.
				// Do we have the author in our array - ie do we know who to map it to?
				// Lets find out...and apply the change
				$this->update_content_author( $remote_author_slug, $staging_post_id, $legacy_url, $dry_run_mode );
				$this->change_count_id++;
			}
		}
	}

	/**
	 * @param $file_handle
	 * @return bool
	 *
	 * Read from author mapping file and set up author lookup array
	 */
	private function set_author_mapping( $file_handle ) {

		$temp_array = array();
		while ( false !== ( $author_buffer = fgets( $file_handle ) ) ) {
			list( $legacy_author, $wpcom_author, $wpcom_author_id ) = explode( ',' , $author_buffer );
			$wpcom_author_id = intval( $wpcom_author_id ) ;
			$temp_array[$legacy_author] = array( $wpcom_author, $wpcom_author_id );
		}
		if ( ! empty( $temp_array ) ) {
			$this->author_mapping = $temp_array;
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @param $sleep_counter
	 * @param $dry_run_mode
	 *
	 * @return mixed | $sleep_counter
	 * Display a sleep notice every $sleep_mod iterations.
	 */
	private function process_sleep_counter( $dry_run_mode ) {
		$this->sleep_counter++;
		if ( 0 == ( $this->sleep_counter % $this->sleep_mod ) ) {
			if ( $dry_run_mode ) {
				WP_CLI::line( "<Yawn - dry run> - $this->sleep_counter" );
			} else {
				WP_CLI::line( "Yawn - $this->sleep_counter" );
			}
			sleep( 1 );
		}

	}

	/**
	 * @param $remote_author_slug
	 * @param $staging_post_id
	 * @param $legacy_url
	 * @param $dry_run_mode
	 *
	 * Update counters for id and slug
	 * If it's not a dry-run then run wp_update_post to apply the author change
	 * then we tell coauthors about it
	 * otherwise in full dry run mode note the action that would have been taken
	 */
	private function update_content_author( $remote_author_slug, $staging_post_id, $legacy_url, $dry_run_mode ) {

		if ( array_key_exists( $remote_author_slug, $this->author_mapping ) ) {
			global $coauthors_plus;

			// Do author lookup from our pre-formed array
			$new_author = $this->author_mapping[ $remote_author_slug ];
			if ( is_array( $new_author ) ) {
				$new_author_slug = $new_author[0];
				$new_author_id   = $new_author[1];
				if ( $dry_run_mode ) {
					WP_CLI::success( WP_CLI::colorize( "[%w$this->change_count_id%n]Dry run: changing ID=>$staging_post_id author=>$new_author_id [$new_author_slug]: legacy url $legacy_url " ) );
				} else {
					// Get new author id and slug
					WP_CLI::line( WP_CLI::colorize( "[%y*live* by id%n]wp_update_post : ID=>$staging_post_id author=>$new_author_id [$new_author_slug]: legacy url$legacy_url" ) );
					if ( 6988 == $staging_post_id ) { // change only id 6988 for test purposes

						$updated_post_id = wp_update_post( array( 'ID' => $staging_post_id, 'post_author' => $new_author_id ) );
						$co_authors      = $coauthors_plus->add_coauthors( $staging_post_id, array( $new_author_slug ) );
						if ( is_wp_error( $updated_post_id ) ) {
							$errors = $updated_post_id->get_error_messages();
							foreach ( $errors as $error ) {
								WP_CLI::warning( "[$updated_post_id] $error" );
							}
						} else {
							WP_CLI::success( "[*live*id]$updated_post_id now authored by $new_author_slug [$new_author_id]" );
						}
					}
				}
			} else {
				WP_CLI::warning( "[id]No author id found/specified for $new_author" );
			}
		}

	}
	/**
	 * $author_mapping
	 * Author list array built from existing Suntimesmedia.wordpress.com accounts
	 * and staging site accounts
	 *
	 * Provide csv as a paramter with:
	 * legacy author slug, wpcom author slug, wpcom author id
	 *
	 */
	private $author_mapping;

	private $change_count_slug = 0;
	private $change_count_id = 0;
	private $sleep_mod = 10;
	private $sleep_counter = 0;
}
