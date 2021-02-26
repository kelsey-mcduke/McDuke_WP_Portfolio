<?php
/**
 * Returns an array of the supported social networks and their properties.
 *
 * @return array
 */
function truenorth_get_social_networks() {
	return apply_filters( 'truenorth_social_networks', array(
		array(
			'name'  => 'facebook',
			'label' => esc_html__( 'Facebook', 'truenorth' ),
			'icon'  => 'fab fa-facebook',
		),
		array(
			'name'  => 'twitter',
			'label' => esc_html__( 'Twitter', 'truenorth' ),
			'icon'  => 'fab fa-twitter',
		),
		array(
			'name'  => 'instagram',
			'label' => esc_html__( 'Instagram', 'truenorth' ),
			'icon'  => 'fab fa-instagram',
		),
		array(
			'name'  => 'pinterest',
			'label' => esc_html__( 'Pinterest', 'truenorth' ),
			'icon'  => 'fab fa-pinterest',
		),
		array(
			'name'  => 'snapchat',
			'label' => esc_html__( 'Snapchat', 'truenorth' ),
			'icon'  => 'fab fa-snapchat',
		),
		array(
			'name'  => 'behance',
			'label' => esc_html__( 'Behance', 'truenorth' ),
			'icon'  => 'fab fa-behance',
		),
		array(
			'name'  => 'dribbble',
			'label' => esc_html__( 'Dribbble', 'truenorth' ),
			'icon'  => 'fab fa-dribbble',
		),
		array(
			'name'  => 'youtube',
			'label' => esc_html__( 'YouTube', 'truenorth' ),
			'icon'  => 'fab fa-youtube',
		),
		array(
			'name'  => 'etsy',
			'label' => esc_html__( 'Etsy', 'truenorth' ),
			'icon'  => 'fab fa-etsy',
		),
		array(
			'name'  => 'flickr',
			'label' => esc_html__( 'Flickr', 'truenorth' ),
			'icon'  => 'fab fa-flickr',
		),
		array(
			'name'  => 'github',
			'label' => esc_html__( 'GitHub', 'truenorth' ),
			'icon'  => 'fab fa-github',
		),
		array(
			'name'  => 'linkedin',
			'label' => esc_html__( 'LinkedIn', 'truenorth' ),
			'icon'  => 'fab fa-linkedin',
		),
		array(
			'name'  => 'medium',
			'label' => esc_html__( 'Medium', 'truenorth' ),
			'icon'  => 'fab fa-medium',
		),
		array(
			'name'  => 'mixcloud',
			'label' => esc_html__( 'Mixcloud', 'truenorth' ),
			'icon'  => 'fab fa-mixcloud',
		),
		array(
			'name'  => 'paypal',
			'label' => esc_html__( 'PayPal', 'truenorth' ),
			'icon'  => 'fab fa-paypal',
		),
		array(
			'name'  => 'skype',
			'label' => esc_html__( 'Skype', 'truenorth' ),
			'icon'  => 'fab fa-skype',
		),
		array(
			'name'  => 'slack',
			'label' => esc_html__( 'Slack', 'truenorth' ),
			'icon'  => 'fab fa-slack',
		),
		array(
			'name'  => 'soundcloud',
			'label' => esc_html__( 'Soundcloud', 'truenorth' ),
			'icon'  => 'fab fa-soundcloud',
		),
		array(
			'name'  => 'spotify',
			'label' => esc_html__( 'Spotify', 'truenorth' ),
			'icon'  => 'fab fa-spotify',
		),
		array(
			'name'  => 'vimeo',
			'label' => esc_html__( 'Vimeo', 'truenorth' ),
			'icon'  => 'fab fa-vimeo',
		),
		array(
			'name'  => 'wordpress',
			'label' => esc_html__( 'WordPress', 'truenorth' ),
			'icon'  => 'fab fa-wordpress',
		),
		array(
			'name'  => 'xbox',
			'label' => esc_html__( 'Xbox Live', 'truenorth' ),
			'icon'  => 'fab fa-xbox',
		),
		array(
			'name'  => 'playstation',
			'label' => esc_html__( 'PlayStation Network', 'truenorth' ),
			'icon'  => 'fab fa-playstation',
		),
		array(
			'name'  => 'bloglovin',
			'label' => esc_html__( 'Bloglovin', 'truenorth' ),
			'icon'  => 'fas fa-heart',
		),
		array(
			'name'  => 'tumblr',
			'label' => esc_html__( 'Tumblr', 'truenorth' ),
			'icon'  => 'fab fa-tumblr',
		),
		array(
			'name'  => '500px',
			'label' => esc_html__( '500px', 'truenorth' ),
			'icon'  => 'fab fa-500px',
		),
		array(
			'name'  => 'tripadvisor',
			'label' => esc_html__( 'Trip Advisor', 'truenorth' ),
			'icon'  => 'fab fa-tripadvisor',
		),
		array(
			'name'  => 'telegram',
			'label' => esc_html__( 'Telegram', 'truenorth' ),
			'icon'  => 'fab fa-telegram',
		),
	) );
}
