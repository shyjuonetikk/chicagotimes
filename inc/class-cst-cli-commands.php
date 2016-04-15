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
	 * ## EXAMPLES
	 *
	 *     wp chicago reassign author_name --content=cst-content.csv
	 *
	 * @when before_wp_load
	 */
	function reassign( $args, $assoc_args ) {
		list( $name ) = $args;

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
		WP_CLI::success( $content_file . ' will be used' );
		if ( $content_handle = @fopen( $content_file, 'r' ) ) {
			echo "Start\n";
			while ( false !== ( $buffer = fgets( $content_handle, 4096 ) ) ) {
				list( $remote_post_id, $staging_post_id, $remote_author_slug,
					$remote_author_nickname, $remote_author_id, $remote_author_name, $legacy_url
					) = explode( ',', $buffer );
				if ( 'unavailable' !== $remote_post_id ) {
					if ( get_post( $staging_post_id ) ) {
						echo "Changing $staging_post_id to be $remote_author_name for $legacy_url\n";
					} else {
						echo "Could not find $staging_post_id\n";
					}
				}
			}
		}

	}
}

WP_CLI::add_command( 'chicago', 'Chicago_Command' );