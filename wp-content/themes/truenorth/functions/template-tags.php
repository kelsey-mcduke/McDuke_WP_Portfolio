<?php
/**
 * Custom template tags for this theme
 */

/**
 * Outputs the social icons HTML, depending on context.
 * @param false|string $context May be 'global' or 'user'. If false, it will try to decide by itself.
 */
function truenorth_the_social_icons( $context = false ) {
	$networks = truenorth_get_social_networks();

	$global_urls = array();
	$user_urls   = array();
	$used_urls   = array();

	$global_rss = get_theme_mod( 'social_content_rss_feed', get_bloginfo( 'rss2_url' ) );
	$user_rss   = get_author_feed_link( get_the_author_meta( 'ID' ) );
	$used_rss   = '';

	foreach ( $networks as $network ) {
		if ( get_theme_mod( 'social_content_' . $network['name'] ) ) {
			$global_urls[ $network['name'] ] = get_theme_mod( 'social_content_' . $network['name'] );
		}
	}

	foreach ( $networks as $network ) {
		if ( get_the_author_meta( 'user_' . $network['name'] ) ) {
			$user_urls[ $network['name'] ] = get_the_author_meta( 'user_' . $network['name'] );
		}
	}

	if ( 'user' === $context ) {
		$used_urls = $user_urls;
		$used_rss  = $user_rss;
	} elseif ( 'global' === $context ) {
		$used_urls = $global_urls;
		$used_rss  = $global_rss;
	} else {
		$used_urls = $global_urls;
		$used_rss  = $global_rss;

		if ( in_the_loop() ) {
			$used_urls = $user_urls;
			$used_rss  = $user_rss;
		}
	}

	$used_urls = apply_filters( 'truenorth_social_icons_used_urls', $used_urls, $context, $global_urls, $user_urls );
	$used_rss  = apply_filters( 'truenorth_social_icons_used_rss', $used_rss, $context, $global_rss, $user_rss );

	$has_rss = $used_rss ? true : false;

	// Set the target attribute for social icons.
	$add_target = false;
	if ( get_theme_mod( 'social_layout_target', false ) ) {
		$add_target = true;
	}

	if ( count( $used_urls ) > 0 || $has_rss ) {
		do_action( 'truenorth_before_the_social_icons' );
		?>
		<ul class="list-social-icons">
			<?php
				$template = '<li><a href="%1$s" class="social-icon"><i class="%2$s"></i></a></li>';

				foreach ( $networks as $network ) {
					if ( ! empty( $used_urls[ $network['name'] ] ) ) {
						$html = sprintf( $template,
							esc_url( $used_urls[ $network['name'] ] ),
							esc_attr( $network['icon'] )
						);

						if ( $add_target ) {
							$html = links_add_target( $html );
						}

						echo wp_kses( $html, truenorth_get_allowed_tags() );
					}
				}

				if ( $has_rss ) {
					$html = sprintf( $template,
						$used_rss,
						esc_attr( 'fas fa-rss' )
					);

					if ( $add_target ) {
						$html = links_add_target( $html );
					}

					echo wp_kses( $html, truenorth_get_allowed_tags() );
				}
			?>
		</ul>
		<?php
		do_action( 'truenorth_after_the_social_icons' );
	}
}
