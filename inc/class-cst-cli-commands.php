<?php
/**
 * Implements example command.
 */
class Chicago_Command extends WP_CLI_Command {

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
	 * [--dry-run]
	 * : Don't make changes - perform a dry run
	 * ---
	 * default: 1
	 * ---
	 * ## EXAMPLES
	 *
	 *     wp chicago reassign author_name --content=cst-content.csv
	 *
	 */
	function reassign( $args, $assoc_args ) {
		list( $name ) = $args;

		/**
		 * $author_mapping
		 * Author list array built from existing Suntimesmedia.wordpress.com accounts
		 * and staging site accounts
		 *
		 * left column : staging site account name
		 * Right column : Suntimesmedia.wordpress.com account name
		 */
		$author_mapping = array(
			"akeefe"             => array( "akeefecst" => 101943013 ),
			"akukulka"           => array( "akukulkacst" => 101796416 ),
			"agrimm"             => array( "grimmsuntimes" => 100348879 ),
			"arezincst"          => array( "arezincst" => 70352817 ),
			"bbarker"            => array( "bbarkercst"=> 70352819 ),
			"cdeluca"            => array( "chrisdcst"=> 70352827 ),
			"cfuscocst"          => array( "cfuscocst"=> 70352826 ),
			"danielbrown"        => array( "dbrowncst"=> 101809872 ),
			"dbowman"            => array( "bowmanoutside"=> 101986605 ),
			"fgattuso"           => array( "fgattusocst"=> 101789189 ),
			"herb-gould"         => array( "hgouldcst"=> 70352843 ),
			"jagrest"            => array( "jagrestcst"=> 70352845 ),
			"jkirk"              => array( "jkirkcst"=> 101783400 ),
			"jmayescst"          => array( "jmayescst"=> 70352852 ),
			"joneillcst"         => array( "joneillcst"=> 70352853 ),
			"jowen"              => array( "jowencst"=> 70352854 ),
			"jsilver"            => array( "jsilvercst"=> 101802833 ),
			"lfitzpatrick"       => array( "lfitzpatrickcst"=> 70352857 ),
			"luke-wilusz"        => array( "lwiluszcst"=> 70352861 ),
			"marmentroutcst"     => array( "marmentroutcst"=> 70352863 ),
			"mmitchell"          => array( "marymcst"=> 70352864 ),
			"marym"              => array( "marymcst"=> 70352864 ),
			"maureen-o'donnell"  => array( "modonnell791"=> 72099276 ),
			"mcorradino"         => array( "mcorradino"=> 75642309 ),
			"mcotter"            => array( "mpottercst"=> 70352880 ),
			"mdoubek"            => array( "mdudekcst"=> 70352868 ),
			"mdumke"             => array( "mdumke"=> 101845049 ),
			"mgarcia"            => array( "mgarciasuntimescom"=> 101640087 ),
			"ihejirika"          => array( "mihejirikacst"=> 70352871 ),
			"psaltzmancst"       => array( "psaltzmancst"=> 70352892 ),
			"rheincst"           => array( "rheincst"=> 70352894 ),
			"RUMMANA-HUSSAIN"    => array( "rhussaincst"=> 70352895 ),
			"scharles"           => array( "scharlescst"=> 70352898 ),
			"sesposito"          => array( "sespositocst"=> 72506209 ),
			"sfornek"            => array( "sfornekcst"=> 70352901 ),
			"sgreenberg"         => array( "sgreenbergcst"=> 70352902 ),
			"salicea"            => array( "saliceacst"=> 101846592 ),
			"swarmbircst"        => array( "swarmbircst"=> 70352909 ),
			"tfrisbie"           => array( "tfrisbiecst"=> 70352913 ),
			"tina-sfondeles"     => array( "tsfondelescst"=> 70352918 ),
			"tmcnamee"           => array( "tmcnameecst"=> 70352915 ),
			"tnovak"             => array( "tnovakcst"=> 72101282 ),
			"van-schouwen"       => array( "dvanschouwencst"=> 70352835 ),
		);

		$content_file = $assoc_args['content'];
		$dry_mode = ! empty ( $assoc_args['dry-run'] );

		if ( $content_handle = @fopen( $content_file, 'r' ) ) {
			// Go - we have a csv file to read
			WP_CLI::success( $content_file . " found and will be used" );
			$counter = 0;
			while ( false !== ( $buffer = fgets( $content_handle, 4096 ) ) ) {
				// Read each line to get the variables listed out below
				list( $remote_post_id, $staging_post_id, $remote_author_slug,
					$remote_author_nickname, $remote_author_id, $remote_author_name, $legacy_url
					) = explode( ',', $buffer );
				if ( 'unavailable' !== $remote_post_id ) {
					$counter++;
					if ( 0 == ( $counter % 10 ) ) {
						if ( $dry_mode ) {
							WP_CLI::warning( "Yawn - $counter" );
						} else {
							WP_CLI::line( "Yawn - $counter" );
						}
						sleep(1);
					}
					// If we have a valid remote post ID (from our legacy system prior to import)
					$found_content_by_id = get_post( $staging_post_id );
					// First try and get content by the staging ID as the content ids imported from staging to VIP matched.
					if ( null == $found_content_by_id ) {
						// No content found by id - try by slug from post_meta legacyUrl (provided by csv file)
						if ( 1 == preg_match( '#\/\d{3,8}\/(.+)#', $legacy_url, $matches ) ) {
							// Use remainder of legacy url as slug (as originally intended) to search for content.
							$the_slug = $matches[0];
							$args     = array(
								'name'           => $the_slug,
								'post_type'      => 'cst_article',
								'post_status'    => 'publish',
								'posts_per_page' => 1
							);
							$my_posts = get_posts( $args );
							if ( ! empty( $my_posts ) ) {
								// YES! content that matches by slug - let's notify intention to change the author of that content
								$new_author_id = $author_mapping[ $remote_author_slug ][1];
								WP_CLI::line( "[slug]Changing $staging_post_id to be $remote_author_slug/$new_author_id for $legacy_url" );
								if ( ! $dry_mode ) {
									WP_CLI::success( " ! Dry run mode" );
//								if ( $staging_post_id == wp_update_post( array( 'ID' => $staging_post_id, 'author' => $new_author_id ) ) ) {
//									WP_CLI::success( "[$staging_post_id] now authored by " );
//								}
								} else {
									WP_CLI::success( "Dry run mode" );
								}
							}
							// This is the bit that does stuff
							// Do we have the author in our array?
							if ( in_array( $remote_author_slug, $author_mapping ) ) {
								$new_author = $author_mapping[ $remote_author_slug ];
								if ( is_array( $new_author ) ) {
									$new_author_id = $new_author[1];
									$new_author_slug = $new_author[0];
									WP_CLI::line( "[id]Changing $staging_post_id to be $remote_author_slug/$new_author_id for $legacy_url" );
									WP_CLI::line( "[slug]wp_update_post : ID=>$staging_post_id author=>$new_author_id [$new_author_slug] for $legacy_url" );
									if ( ! $dry_mode ) {
										WP_CLI::success( " ! Dry run mode" );
//								if ( $staging_post_id == wp_update_post( array( 'ID' => $staging_post_id, 'author' => $new_author_id ) ) ) {
//									WP_CLI::success( "[$staging_post_id] now authored by " );
//								}
									} else {
										WP_CLI::success( "Dry run mode" );
									}
								} else {
									WP_CLI::error( "No author id specified for $new_author" );
								}

							}
						}
					} else {
						// This is the bit that does stuff
						// Get new author ID from our author_mapping array
						$new_author_id = $author_mapping[ $remote_author_slug ][1];
						WP_CLI::line( "[id]Changing $staging_post_id to be $remote_author_slug/$new_author_id for $legacy_url" );
						WP_CLI::line( "[id]wp_update_post : ID=>$staging_post_id author=>$new_author_id for $legacy_url" );
					}
				}
			}
		}

	}
}

WP_CLI::add_command( 'chicago', 'Chicago_Command' );