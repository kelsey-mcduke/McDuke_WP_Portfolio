<?php
/*
 * OAuth and wp_TwitterOAuth libraries taken from Rotating Tweets (Twitter widget & shortcode) plugin, v1.3.13, http://wordpress.org/extend/plugins/rotatingtweets/
 */
if ( ! class_exists( 'wp_TwitterOAuth' ) ) {
	get_template_part( 'panel/libraries/wp_twitteroauth' );
}

if ( ! class_exists( 'CI_Tweets' ) ) :
class CI_Tweets extends WP_Widget {

	protected $defaults = array(
		'title'       => '',
		'ci_username' => '',
		'ci_number'   => '',
	);

	public function __construct() {
		$widget_ops  = array( 'description' => __( 'Display your latest tweets', 'truenorth' ) );
		$control_ops = array();

		parent::__construct( 'ci_twitter_widget', $name = __( 'Theme - Tweets', 'truenorth' ), $widget_ops, $control_ops );

		// These are needed for compatibility with older versions where the title field was named title
		add_filter( 'widget_display_callback', array( $this, '_rename_old_title_field' ), 10, 2 );
		add_filter( 'widget_form_callback', array( $this, '_rename_old_title_field' ), 10, 2 );
	}

	// This is needed for compatibility with older versions where the title field was named title
	public function _rename_old_title_field( $instance, $_this ) {
		$old_field = 'ci_title';
		$class     = get_class( $this );

		if ( get_class( $_this ) === $class && ! isset( $instance['title'] ) && isset( $instance[ $old_field ] ) ) {
			$instance['title'] = $instance[ $old_field ];
			unset( $instance[ $old_field ] );
		}

		return $instance;
	}

	public function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$title = ci_get_string_translation( 'Twitter - Title', $title, 'Widgets' );

		$ci_username  = $instance['ci_username'];
		$ci_number    = $instance['ci_number'];
		$callback     = str_replace( 'ci_twitter_widget-', '', $args['widget_id'] );
		$widget_class = preg_replace( '/[^a-zA-Z0-9]/', '', $args['widget_id'] );

		if ( ! ci_setting( 'twitter_consumer_key' ) ||
			! ci_setting( 'twitter_consumer_secret' ) ||
			! ci_setting( 'twitter_access_token' ) ||
			! ci_setting( 'twitter_access_token_secret' )
		) {
			return;
		}

		$connection = new wp_TwitterOAuth(
			trim( ci_setting( 'twitter_consumer_key' ) ),
			trim( ci_setting( 'twitter_consumer_secret' ) ),
			trim( ci_setting( 'twitter_access_token' ) ),
			trim( ci_setting( 'twitter_access_token_secret' ) )
		);

		$trans_name = sanitize_key( 'ci_widget_tweets_' . $ci_username . '_' . $ci_number );

		$result = get_transient( $trans_name );

		if ( false === ( $result ) ) {
			$result = $connection->get( 'statuses/user_timeline', array(
				'screen_name' => $ci_username,
				'count'       => $ci_number,
				'include_rts' => 1,
			) );

			$trans_time = ci_setting( 'twitter_caching_seconds' );
			if ( intval( $trans_time ) < 5 ) {
				$trans_time = 5;
			}
			set_transient( $trans_name, $result, $trans_time );
		}

		if ( is_wp_error( $result ) ) {
			return;
		}

		$data = json_decode( $result['body'], true );

		if ( null === $data ) {
			return;
		}

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<div class="' . esc_attr( $widget_class ) . '  tul"><ul>';

		if ( ! empty( $data['errors'] ) && count( $data['errors'] ) > 0 ) {
			foreach ( $data['errors'] as $error ) {
				/* translators: %1$s is the error number, %2$s is the error message. */
				echo wp_kses_post( '<li>' . sprintf( __( 'Error %1$s: %2$s', 'truenorth' ), $error['code'], $error['message'] ) . '</li>' );
			}
		} else {
			foreach ( $data as $tweet ) {
				// URL regex taken from http://daringfireball.net/2010/07/improved_regex_for_matching_urls
				// Needed to wrap with # and escape the single quote character near the end, in order to work right.
				$url_regex = '#(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))#';

				$tweet_username = $tweet['user']['screen_name'];
				$tweet_text     = $tweet['text'];
				$tweet_text     = preg_replace_callback( $url_regex, array( $this, '_link_urls' ), $tweet_text );
				$tweet_text     = preg_replace_callback( '/\B@([_a-z0-9]+)/i', array( $this, '_link_usernames' ), $tweet_text );
				$tweet_time     = ci_human_time_diff( strtotime( $tweet['created_at'] ) );
				$tweet_id       = $tweet['id_str'];

				echo wp_kses_post( '<li><span>' . $tweet_text . '</span> <a class="twitter-time" href="https://twitter.com/' . esc_attr( $tweet_username ) . '/statuses/' . esc_attr( $tweet_id ) . '">' . $tweet_time . '</a></li>' );
			}
		}

		echo '</ul></div>';

		echo $args['after_widget'];
	}


	protected function _link_usernames( $matches ) {
		return '<a href="https://twitter.com/' . esc_attr( $matches[1] ) . '">' . $matches[0] . '</a>';
	}


	protected function _link_urls( $matches ) {
		return '<a href="' . esc_url( $matches[0] ) . '">' . $matches[0] . '</a>';
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']       = sanitize_text_field( $new_instance['title'] );
		$instance['ci_username'] = sanitize_text_field( $new_instance['ci_username'] );
		$instance['ci_number']   = absint( $new_instance['ci_number'] );

		ci_register_string_translation( 'Twitter - Title', $instance['title'], 'Widgets' );

		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$title       = $instance['title'];
		$ci_username = $instance['ci_username'];
		$ci_number   = $instance['ci_number'];

		if ( ! ci_setting( 'twitter_consumer_key' ) ||
			! ci_setting( 'twitter_consumer_secret' ) ||
			! ci_setting( 'twitter_access_token' ) ||
			! ci_setting( 'twitter_access_token_secret' )
		) {
			?>
			<p><?php esc_html_e( "It looks like you haven't provided Twitter access details, in order for this widget to work. Unfortunately, this is needed. Please visit the theme's settings page and provide the required access details.", 'truenorth' ); ?></p>
			<input type="hidden" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
			<input type="hidden" name="<?php echo esc_attr( $this->get_field_name( 'ci_username' ) ); ?>" value="<?php echo esc_attr( $ci_username ); ?>">
			<input type="hidden" name="<?php echo esc_attr( $this->get_field_name( 'ci_number' ) ); ?>" value="<?php echo esc_attr( $ci_number ); ?>">
			<?php
		} else {
			?>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'truenorth' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat" /></p>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'ci_username' ) ); ?>"><?php esc_html_e( 'Username:', 'truenorth' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'ci_username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ci_username' ) ); ?>" type="text" value="<?php echo esc_attr( $ci_username ); ?>" class="widefat" /></p>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'ci_number' ) ); ?>"><?php esc_html_e( 'Number of tweets:', 'truenorth' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'ci_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ci_number' ) ); ?>" type="text" value="<?php echo esc_attr( $ci_number ); ?>" class="widefat" /></p>
			<?php
		}

	}

}


// Check that the Twitter widget can be loaded.
// Support is added automatically upon the inclusion of the twitter_api panel snippet.
if ( get_truenorth_support( 'twitter_widget' ) ) {
	register_widget( 'CI_Tweets' );
}

endif;
