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
	 * [--author-map=<author-map-filename>]
	 * : The csv list of authors to be parsed for author changes
	 * ---
	 * default: cst-author-map-content.csv
	 * ---
	 * [--dry-run]
	 * : Don't make changes - perform a dry run
	 * ---
	 * default: 1
	 * ---
	 * [--sleep-mod]
	 * : Time between sleeps
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

		if ( isset( $assoc_args['content'] ) ) {
			$content_file = $assoc_args['content'];
		}
		if ( isset( $assoc_args['sleep-mod'] ) ) {
			$this->sleep_mod = intval( $assoc_args['sleep-mod'] );
		}

		$dry_mode      = ! empty ( $assoc_args['dry-run'] );

		if ( ! empty ( $content_file ) ) {
			if ( $content_handle = @fopen( $content_file, 'r' ) ) {

				// Go - we have a csv file to read
				WP_CLI::success( $content_file . " found and will be used :-)" );
				// read and discard header row from csv file
				$read_first_line_buffer = fgets( $content_handle, 4096 );
				while ( false !== ( $buffer = fgets( $content_handle, 4096 ) ) ) {

					$this->process_author_change( $buffer, $dry_mode );

				}
			} else {
				WP_CLI::error( "$content_file unable to open for reading :-(" );
			}
			$change_count_total = $this->change_count_id;
			$change_count_total += $this->change_count_slug;
			WP_CLI::success( "Items changed - [id]$this->change_count_id [slug]$this->change_count_slug $change_count_total" . ( $dry_mode ? " during dry run" : '' ) );

		} else {
			WP_CLI::error( "No filename supplied :-(" );
		}

	}

	/**
	 * @param $incoming_csv_line
	 * @param $dry_mode
	 * 
	 * Line from imported csv file
	 */
	private function process_author_change( $incoming_csv_line, $dry_mode ) {
		$sleep_counter = 0;
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
			$sleep_counter = $this->process_sleep_counter( $sleep_counter, $dry_mode );

			$found_content_by_id = get_post( $staging_post_id );
			// If we have a valid remote post ID (from our legacy system prior to import)
			// First try and get content by the ID as the content ids imported from staging to VIP matched.

			if ( null == $found_content_by_id ) {

				// No content found by id
				// 2nd and last resort - try and find by slug from post_meta legacyUrl (provided by csv file)
				if ( 1 == preg_match( '#\/\d{3,9}\/(.+)#', $legacy_url, $matches ) ) {

					// Use remainder of legacy url as slug to search for content.
					$the_slug          = $matches[0];
					$slug_args['name'] = $the_slug;
					// Let's get the post by slug given it's likely not to have changed

					$my_posts          = get_posts( $slug_args );
					if ( ! empty( $my_posts ) ) {
						// Found content by slug, yay!
						WP_CLI::line( "Found by slug $legacy_url" );

						// Do we have the author in our array - ie do we know who to map it to?
						// Lets find out...and apply the change
						$this->update_content_author( $remote_author_slug, $staging_post_id, $legacy_url, $dry_mode );
					} else {
						WP_CLI::warning( "[slug]No post found by slug for $the_slug from legacy url: $legacy_url" );
					}
				} else {
					WP_CLI::warning( "[slug]No content found by slug for $legacy_url" );
				}
			} else {
				// Do we have the author in our array - ie do we know who to map it to?
				// Lets find out...and apply the change
				$this->update_content_author( $remote_author_slug, $staging_post_id, $legacy_url, $dry_mode );
			}
		}
	}
	
	/**
	 * @param $sleep_counter
	 * @param $dry_mode
	 *
	 * @return mixed | $sleep_counter
	 * Display a sleep notice every $sleep_mod iterations.
	 */
	private function process_sleep_counter( $sleep_counter, $dry_mode ) {
		$sleep_counter ++;
		if ( 0 == ( $sleep_counter % $this->sleep_mod ) ) {
			if ( $dry_mode ) {
				WP_CLI::line( "<Yawn> - $sleep_counter" );
			} else {
				WP_CLI::line( "Yawn - $sleep_counter" );
			}
			sleep( 1 );
		}

		return $sleep_counter;
	}

	/**
	 * @param $remote_author_slug
	 * @param $staging_post_id
	 * @param $legacy_url
	 * @param $dry_mode
	 *
	 * Update counters for id and slug
	 * If it's not a dry-run then run wp_update_post to apply the author change
	 * then we tell coauthors about it
	 * otherwise in full dry run mode note the action that would have been taken
	 */
	private function update_content_author( $remote_author_slug, $staging_post_id, $legacy_url, $dry_mode ) {

		if ( array_key_exists( $remote_author_slug, $this->author_mapping ) ) {
			global $coauthors_plus;

			// Do author lookup from our pre-formed array
			$new_author = $this->author_mapping[ $remote_author_slug ];
			if ( is_array( $new_author ) ) {

				// Get new author id and slug
				$new_author_id   = $new_author[1];
				$new_author_slug = $new_author[0];
				WP_CLI::line( "[id]wp_update_post : ID=>$staging_post_id author=>$new_author_id [$new_author_slug] for $legacy_url" );
				if ( ! $dry_mode ) {
					if ( 6988 == $staging_post_id ) { // change only id 6988 for test purposes

						$updated_post_id = wp_update_post( array( 'ID' => $staging_post_id, 'post_author' => $new_author_id ) );
						$co_authors      = $coauthors_plus->add_coauthors( $staging_post_id, array( $new_author_slug ) );
						if ( is_wp_error( $updated_post_id ) ) {
							$errors = $updated_post_id->get_error_messages();
							foreach ( $errors as $error ) {
								WP_CLI::warning( "[$updated_post_id] $error" );
							}
						} else {
							WP_CLI::success( "[id]$updated_post_id now authored by $new_author_slug [$new_author_id]" );
						}
						$this->change_count_id ++;
					}
				} else {
					$this->change_count_id ++;
					WP_CLI::success( "[id]Dry run mode - $this->change_count_id" );
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
	 * left column : staging site account name
	 * Right column : array( Suntimesmedia.wordpress.com account name, related WordPress.com account/user id )
	 */
	private $author_mapping = array(
		"akeefe"            => array( "akeefecst", 101943013 ),
		"akukulka"          => array( "akukulkacst", 101796416 ),
		"agrimm"            => array( "grimmsuntimes", 100348879 ),
		"arezincst"         => array( "arezincst", 70352817 ),
		"bbarker"           => array( "bbarkercst", 70352819 ),
		"cdeluca"           => array( "chrisdcst", 70352827 ),
		"cfuscocst"         => array( "cfuscocst", 70352826 ),
		"danielbrown"       => array( "dbrowncst", 101809872 ),
		"dbowman"           => array( "bowmanoutside", 101986605 ),
		"fgattuso"          => array( "fgattusocst", 101789189 ),
		"herb-gould"        => array( "hgouldcst", 70352843 ),
		"jagrest"           => array( "jagrestcst", 70352845 ),
		"jkirk"             => array( "jkirkcst", 101783400 ),
		"jmayescst"         => array( "jmayescst", 70352852 ),
		"joneillcst"        => array( "joneillcst", 70352853 ),
		"jowen"             => array( "jowencst", 70352854 ),
		"jsilver"           => array( "jsilvercst", 101802833 ),
		"lfitzpatrick"      => array( "lfitzpatrickcst", 70352857 ),
		"luke-wilusz"       => array( "lwiluszcst", 70352861 ),
		"marmentroutcst"    => array( "marmentroutcst", 70352863 ),
		"mmitchell"         => array( "marymcst", 70352864 ),
		"marym"             => array( "marymcst", 70352864 ),
		"maureen-o'donnell" => array( "modonnell791", 72099276 ),
		"mcorradino"        => array( "mcorradino", 75642309 ),
		"mcotter"           => array( "mpottercst", 70352880 ),
		"mdoubek"           => array( "mdudekcst", 70352868 ),
		"mdumke"            => array( "mdumke", 101845049 ),
		"mgarcia"           => array( "mgarciasuntimescom", 101640087 ),
		"ihejirika"         => array( "mihejirikacst", 70352871 ),
		"psaltzmancst"      => array( "psaltzmancst", 70352892 ),
		"rheincst"          => array( "rheincst", 70352894 ),
		"RUMMANA-HUSSAIN"   => array( "rhussaincst", 70352895 ),
		"scharles"          => array( "scharlescst", 70352898 ),
		"sesposito"         => array( "sespositocst", 72506209 ),
		"sfornek"           => array( "sfornekcst", 70352901 ),
		"sgreenberg"        => array( "sgreenbergcst", 70352902 ),
		"salicea"           => array( "saliceacst", 101846592 ),
		"swarmbircst"       => array( "swarmbircst", 70352909 ),
		"tfrisbie"          => array( "tfrisbiecst", 70352913 ),
		"tina-sfondeles"    => array( "tsfondelescst", 70352918 ),
		"tmcnamee"          => array( "tmcnameecst", 70352915 ),
		"tnovak"            => array( "tnovakcst", 72101282 ),
		"van-schouwen"      => array( "dvanschouwencst", 70352835 ),
	);

	private $change_count_slug = 0;
	private $change_count_id = 0;
	private $sleep_mod = 10;
}
