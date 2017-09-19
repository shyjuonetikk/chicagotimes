<?php

class CST_Twitter_Feed_Widget extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'cst_twitter_widget',
			esc_html__( 'CST Twitter Tweets', 'chicagosuntimes' ),
			array(
				'description' => esc_html__( 'Displays Tweets from a given list url.', 'chicagosuntimes' ),
			)
		);

	}

	public function get_cache_key( $args ) {
		return 'cst-twitter-widget-tweets-' . md5( json_encode( $args ) );
	}

	public function widget( $args, $instance ) {

		if ( empty( $instance['cst_twitter_screen_name'] ) ) {
			return;
		}

		$tweets = $this->fetch_tweets( $instance );

		if ( empty( $tweets ) || ! empty( $tweets['errors'] ) ) {
			return;
		}

		echo wp_kses_post( $args['before_widget'] );

		?>

		<div class="tweet-tweet">

			<?php foreach( $tweets as $tweet ) :

				// Codebird returns 'httpstatus' in the response too
				if ( ! is_object( $tweet ) ) {
					continue;
				}

				$reply_link    = 'https://twitter.com/intent/tweet?in_reply_to=' . $tweet->id_str . '';
				$retweet_link  = 'https://twitter.com/intent/retweet?tweet_id=' . $tweet->id_str . '';
				$favorite_link = 'https://twitter.com/intent/favorite?tweet_id=' . $tweet->id_str . '';
		
				$tweet_time = strtotime( $tweet->created_at );

				?>
				<div class="tweet-body">
					<span class="twitter-title"><i class="fa fa-twitter"></i> <a href="<?php echo esc_url( 'https://twitter.com/' . $tweet->user->screen_name ); ?>" target="_blank">@<?php echo esc_html( $tweet->user->screen_name ); ?></a> <span class="twitter-time"><?php echo human_time_diff( $tweet_time ); ?></span></span><br/>
					<p class="twitter-tweet"><?php echo wp_kses_post( str_replace( "<a ", "<a target='_blank' ", make_clickable( $tweet->text ) ) ); ?></p>
					<ul class="tweet-options">
						<li><a data-tooltip class="has-tip" title="<?php esc_attr_e( 'Reply to tweet', 'chicagosuntimes' ); ?>" href="<?php echo esc_url( $reply_link ); ?>"><i class="fa fa-reply"></i> </a></li>
						<li><a data-tooltip class="has-tip" title="<?php esc_attr_e( 'Retweet', 'chicagosuntimes' ); ?>" href="<?php echo esc_url( $retweet_link ); ?>"><i class="fa fa-retweet"></i> </a></li>
						<li><a data-tooltip class="has-tip" title="<?php esc_attr_e( 'Favorite tweet', 'chicagosuntimes' ); ?>" href="<?php echo esc_url( $favorite_link ); ?>"><i class="fa fa-star-o"></i> </a></li>
					</ul>
				</div>

			<?php endforeach; ?>

		</div>

		<div id="triangle-topleft"></div>
		<div class="tweet-bird">
			<i class="fa fa-twitter big"></i>
		</div>

		<?php

		echo wp_kses_post( $args['after_widget'] );

		wp_enqueue_script( 'cst-twitter-widget', get_template_directory_uri() . '/assets/js/twitter-widget.js', array( 'jquery', 'slick' ) );
	}

	public function form( $instance ) {

		$screen_name = ! empty( $instance['cst_twitter_screen_name'] ) ? $instance['cst_twitter_screen_name'] : '';

		$tweets = $this->fetch_tweets( $instance );

		if ( ! empty( $tweets['errors'] ) ) : ?>
		<div class="widget-error"><p><?php echo esc_html( $tweets['errors'][0]->message ); ?></p></div>
		<?php endif; ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cst_twitter_screen_name' ) ); ?>"><?php esc_html_e( 'Twitter Screen Name:', 'chicagosuntimes' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cst_twitter_screen_name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cst_twitter_screen_name' ) ); ?>" type="text" value="<?php echo esc_attr( $screen_name ); ?>" />
		</p>
	<?php
	}

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['cst_twitter_screen_name'] = sanitize_text_field( $new_instance['cst_twitter_screen_name'] );

		return $instance;

	}

	protected function fetch_tweets( $instance ) {

		if ( empty( $instance['cst_twitter_screen_name'] ) ) {
			return array();
		}

		$cache_key = $this->get_cache_key( $instance );
		$tweets = wpcom_vip_cache_get( $cache_key );
		if ( false === $tweets ) {

			$cb = new \WP_Codebird;
			$cb->setConsumerKey( CST_TWITTER_CONSUMER_KEY, CST_TWITTER_CONSUMER_SECRET );

			$cb_params = array(
				'screen_name' => $instance['cst_twitter_screen_name'],
				'count'       => 5,
				'include_rts' => false,
			);

			$tweets = (array) $cb->statuses_userTimeline( $cb_params );
			wpcom_vip_cache_set( $cache_key, $tweets, '', MINUTE_IN_SECONDS * 5 );
		}

		return $tweets;
	}

}