<?php global $ci, $ci_defaults, $load_defaults, $content_width; ?>
<?php if ( true === $load_defaults ) : ?>
<?php

	$ci_defaults['twitter_consumer_key']        = '';
	$ci_defaults['twitter_consumer_secret']     = '';
	$ci_defaults['twitter_access_token']        = '';
	$ci_defaults['twitter_access_token_secret'] = '';
	$ci_defaults['twitter_caching_seconds']     = 60;

	// Add Twitter widget support to the theme.
	add_truenorth_support( 'twitter_widget' );


	add_filter( 'truenorth_sanitize_panel_options', 'truenorth_panel_sanitize_snippet_twitter_api', 10, 2 );
	function truenorth_panel_sanitize_snippet_twitter_api( $values, $defaults ) {
		$values['twitter_consumer_key']        = sanitize_text_field( $values['twitter_consumer_key'] );
		$values['twitter_consumer_secret']     = sanitize_text_field( $values['twitter_consumer_secret'] );
		$values['twitter_access_token']        = sanitize_text_field( $values['twitter_access_token'] );
		$values['twitter_access_token_secret'] = sanitize_text_field( $values['twitter_access_token_secret'] );

		$values['twitter_caching_seconds'] = absint( $values['twitter_caching_seconds'] );
		$values['twitter_caching_seconds'] = $values['twitter_caching_seconds'] < 60 ? 60 : $values['twitter_caching_seconds'];

		return $values;
	}
?>
<?php else : ?>

	<fieldset id="ci-panel-twitter" class="set">
		<legend><?php esc_html_e( 'Twitter', 'truenorth' ); ?></legend>

		<p class="guide">
			<?php
				/* translators: %s is a url. */
				echo wp_kses( sprintf( __( 'You need to follow a series of steps in order to allow Twitter capabilities to your website. First, <a href="%s">log into the Twitter Developers website</a>.', 'truenorth' ), 'https://dev.twitter.com/apps' ), truenorth_get_allowed_tags( 'guide' ) );
			?>
		</p>
		<p class="guide"><?php echo wp_kses( __( "<strong>Step 1:</strong> Make sure you are on the <strong>My Applications</strong> page. If you don't already have an application set up, create a new one by pressing the <em>Create New App</em> button. Fill in the required details (you don't need a Callback URL) and press the <em>Create your Twitter application</em> button.", 'truenorth' ), truenorth_get_allowed_tags( 'guide' ) ); ?></p>
		<p class="guide"><?php echo wp_kses( __( '<strong>Step 2:</strong> On the following page (the application\'s page), in <em>API Keys</em> tab, under the <em>Your access token</em> label, press the <strong>Create my access token</strong> button (if no access token information is displayed). It might take a couple of minutes for it to generate, so refresh the page once in a while, until you see the generated codes.', 'truenorth' ), truenorth_get_allowed_tags( 'guide' ) ); ?></p>

		<p class="guide"><?php echo wp_kses( __( '<strong>Step 3:</strong> Under the <em>Application Settings</em> label, you will find your <strong>API key</strong> and <strong>API secret</strong>. Paste them below.', 'truenorth' ), truenorth_get_allowed_tags( 'guide' ) ); ?></p>
		<?php ci_panel_input( 'twitter_consumer_key', __( 'API Key', 'truenorth' ) ); ?>
		<?php ci_panel_input( 'twitter_consumer_secret', __( 'API Secret', 'truenorth' ), array( 'input_type' => 'password' ) ); ?>

		<p class="guide"><?php echo wp_kses( __( '<strong>Step 4:</strong> Under the <em>Your access token</em> label, you will find your <strong>Access token</strong> and <strong>Access token secret</strong>. Paste them below.', 'truenorth' ), truenorth_get_allowed_tags( 'guide' ) ); ?></p>
		<?php ci_panel_input( 'twitter_access_token', __( 'Access Token', 'truenorth' ) ); ?>
		<?php ci_panel_input( 'twitter_access_token_secret', __( 'Access Token Secret', 'truenorth' ), array( 'input_type' => 'password' ) ); ?>

		<p class="guide">
			<?php
				/* translators: %s is a url. */
				echo wp_kses( sprintf( __( 'Twitter.com places <a href="%s">limits on the number of requests</a> that you are allowed to make. As multiple <strong>Theme - Tweets</strong> widgets count as discreet requests, and each pageview triggers those requests, we have placed a caching mechanism so that you don\'t reach those limits. For normal use (one widget per page), an update period of one minute should be fine. If you have more than one widget instances, you might need to increase that number.', 'truenorth' ), 'https://dev.twitter.com/docs/rate-limiting/1.1/limits' ), truenorth_get_allowed_tags( 'guide' ) );
			?>
		</p>
		<?php ci_panel_input( 'twitter_caching_seconds', __( 'Tweets update period in seconds (min: 60)', 'truenorth' ) ); ?>
	</fieldset>

<?php endif;
