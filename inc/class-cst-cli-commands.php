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
			"akeefe"             => "akeefecst",
			"akukulka"           => "akukulkacst",
			"agrimm"             => "grimmsuntimes",
			"arezincst"          => "arezincst",
			"bbarker"            => "bbarkercst",
			"cdeluca"            => "chrisdcst",
			"cfuscocst"          => "cfuscocst",
			"danielbrown"        => "dbrowncst",
			"dbowman"            => "bowmanoutside",
			"fgattuso"           => "fgattusocst",
			"herb-gould"         => "hgouldcst",
			"jagrest"            => "jagrestcst",
			"jkirk"              => "jkirkcst",
			"jmayescst"          => "jmayescst",
			"joneillcst"         => "joneillcst",
			"jowen"              => "jowencst",
			"jsilver"            => "jsilvercst",
			"lfitzpatrick"       => "lfitzpatrickcst",
			"luke-wilusz"        => "lwiluszcst",
			"marmentroutcst"     => "marmentroutcst",
			"mmitchell"          => "marymcst",
			"marym"              => "marymcst",
			"maureen-o'donnell"  => "modonnell791",
			"mcorradino"         => "mcorradino",
			"mcotter"            => "mpottercst",
			"mdoubek"            => "mdudekcst",
			"mdumke"             => "mdumke",
			"mgarcia"            => "mgarciasuntimescom",
			"ihejirika"          => "mihejirikacst",
			"psaltzmancst"       => "psaltzmancst",
			"rheincst"           => "rheincst",
			"RUMMANA-HUSSAIN"    => "rhussaincst",
			"scharles"           => "scharlescst",
			"sesposito"          => "sespositocst",
			"sfornek"            => "sfornekcst",
			"sgreenberg"         => "sgreenbergcst",
			"salicea"            => "saliceacst",
			"swarmbircst"        => "swarmbircst",
			"tfrisbie"           => "tfrisbiecst",
			"tina-sfondeles"     => "tsfondelescst",
			"tmcnamee"           => "tmcnameecst",
			"tnovak"             => "tnovakcst",
			"van-schouwen"       => "dvanschouwencst",
		);

		$content_file = $assoc_args['content'];
		$dry_mode = ! empty ( $assoc_args['dry-run'] );

		if ( $content_handle = @fopen( $content_file, 'r' ) ) {
			WP_CLI::success( $content_file . " found and will be used\n" );
			while ( false !== ( $buffer = fgets( $content_handle, 4096 ) ) ) { // read each line
				list( $remote_post_id, $staging_post_id, $remote_author_slug,
					$remote_author_nickname, $remote_author_id, $remote_author_name, $legacy_url
					) = explode( ',', $buffer );
				if ( 'unavailable' !== $remote_post_id ) {
					// get post by ID as the content ids imported from staging to VIP matched.
					if ( ! $dry_mode && get_post( $staging_post_id ) ) {
						WP_CLI::warning( "Changing $staging_post_id to be $remote_author_name for $legacy_url\n" );
					} else {
						// However, if no id match try by slug
						WP_CLI::warning( "Could not find $staging_post_id - trying by post slug\n" );
						if ( 1 == preg_match( '\/\d{3,8}\/(.+)', $legacy_url, $matches ) ) {
							$the_slug = $matches[0];
							$args=array(
								'name'           => $the_slug,
								'post_type'      => 'cst_article',
								'post_status'    => 'publish',
								'posts_per_page' => 1
							);
							$my_posts = get_posts( $args );
							if ( ! $dry_mode && ! empty( $my_posts ) ) {

							} else {
								if( ! empty( $my_posts ) ) {
									WP_CLI::warning( '[dry]ID on the first post found ' . $my_posts[0]->ID . "\n" );
								}
							}
						} else {

						}
					}
				}
			}
		}

	}
}

WP_CLI::add_command( 'chicago', 'Chicago_Command' );