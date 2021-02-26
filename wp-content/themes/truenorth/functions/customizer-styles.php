<?php
	if ( ! function_exists( 'truenorth_get_customizer_css' ) ) :
		/**
		 * Generates CSS based on per-theme customizer settings.
		 *
		 * @return string
		 */
		function truenorth_get_customizer_css() {
			ob_start();
			//
			// Global Colors
			//
			$body_bg = get_theme_mod( 'background_color' );

			if ( ! empty( $body_bg ) ) {
				?>
				<?php
			}

			$site_accent_color = get_theme_mod( 'site_accent_color' );

			if ( ! empty( $site_accent_color ) ) {
				?>
				a:hover,
				a:focus,
				.navigation > li ul a:hover,
				.entry .entry-meta dd a  {
					color: <?php echo sanitize_hex_color( $site_accent_color ); ?>;
				}

				blockquote,
				.btn,
				.comment-reply-link,
				input[type="button"],
				input[type="submit"],
				input[type="reset"],
				button,
				.entry .read-more a,
				.portfolio-filters li a:hover,
				.portfolio-filters li a.selected,
				#paging a:hover,
				#paging .current {
					background-color: <?php echo sanitize_hex_color( $site_accent_color ); ?>;
				}
				<?php
			}

			$site_text_color = get_theme_mod( 'site_text_color' );

			if ( ! empty( $site_text_color ) ) {
				?>
				body,
				.twitter-time,
				.widget_meta li a,
				.widget_pages li a,
				.widget_categories li a,
				.widget_archive li a,
				.widget_nav_menu li a,
				.widget_product_categories li a,
				.comment-author a,
				.comment-author a:hover,
				.comment-metadata a,
				.comment-metadata a:hover {
					color: <?php echo sanitize_hex_color( $site_text_color ); ?>;
				}

				.form-allowed-tags,
				.comment-notes {
					color: rgba( <?php echo sanitize_hex_color( $site_text_color ); ?>, 0.8 );
				}
				<?php
			}

			$site_header_color = get_theme_mod( 'site_header_color' );

			if ( ! empty( $site_header_color ) ) {
				?>
				h1, h2, h3, h4, h5, h6 {
					color: <?php echo sanitize_hex_color( $site_header_color ); ?>;
				}
				<?php
			}

			$site_form_bg = get_theme_mod( 'site_form_bg' );

			if ( ! empty( $site_form_bg ) ) {
				?>
				input[type=text],
				textarea {
					background-color: <?php echo sanitize_hex_color( $site_form_bg ); ?>;
				}
				<?php
			}

			$site_form_color = get_theme_mod( 'site_form_color' );

			if ( ! empty( $site_form_color ) ) {
				?>
				input[type=text],
				textarea,
				input::placeholder  {
					color: <?php echo sanitize_hex_color( $site_form_color ); ?>;
				}
				<?php
			}

			$site_form_border = get_theme_mod( 'site_form_border' );

			if ( ! empty( $site_form_border ) ) {
				?>
				input[type=text],
				textarea {
					border-color: <?php echo sanitize_hex_color( $site_form_border ); ?>;
				}
				<?php
			}

			$site_button_bg = get_theme_mod( 'site_button_bg' );

			if ( ! empty( $site_button_bg ) ) {
				?>
				.btn,
				.button,
				input[type="submit"],
				input[type="reset"],
				button[type="submit"],
				a.comment-reply-link,
				.entry .read-more a {
					background-color: <?php echo sanitize_hex_color( $site_button_bg ); ?>;
				}
				<?php
			}

			$site_button_text = get_theme_mod( 'site_button_text' );

			if ( ! empty( $site_button_text ) ) {
				?>
				.btn,
				.button,
				input[type="submit"],
				input[type="reset"],
				button[type="submit"],
				a.comment-reply-link,
				#comment-list a.comment-reply-link,
				.entry .read-more a {
					color: <?php echo sanitize_hex_color( $site_button_text ); ?>;
				}
				<?php
			}

			$site_button_bg_hover = get_theme_mod( 'site_button_bg_hover' );

			if ( ! empty( $site_button_bg_hover ) ) {
				?>
				.btn:hover,
				.button:hover,
				input[type="submit"]:hover,
				input[type="reset"]:hover,
				button[type="submit"]:hover,
				a.comment-reply-link:hover,
				.entry .read-more a:hover {
					background-color: <?php echo sanitize_hex_color( $site_button_bg_hover ); ?>;
				}
				<?php
			}

			$site_button_text_hover = get_theme_mod( 'site_button_text_hover' );

			if ( ! empty( $site_button_text_hover ) ) {
				?>
				.btn:hover,
				.button:hover,
				input[type="submit"]:hover,
				input[type="reset"]:hover,
				button[type="submit"]:hover,
				a.comment-reply-link:hover,
				#comment-list a.comment-reply-link:hover,
				.entry .read-more a:hover {
					color: <?php echo sanitize_hex_color( $site_button_text_hover ); ?>;
				}
				<?php
			}

			//
			// Header Colors
			//

			$header_bg = get_theme_mod( 'header_bg' );

			if ( ! empty( $header_bg ) ) {
				?>
				.nav-hold {
					background-color: <?php echo sanitize_hex_color( $header_bg ); ?>;
				}
				<?php
			}

			$header_menu_color = get_theme_mod( 'header_menu_color' );

			if ( ! empty( $header_menu_color ) ) {
				?>
				.navigation a,
				.navigation > li ul a {
					color: <?php echo sanitize_hex_color( $header_menu_color ); ?>;
				}
				<?php
			}

			$header_menu_color_hover = get_theme_mod( 'header_menu_color_hover' );

			if ( ! empty( $header_menu_color_hover ) ) {
				?>
				.navigation a:hover,
				.navigation a:focus,
				.navigation li .current-menu-item > a,
				.navigation li .current-menu-parent > a,
				.navigation li .current-menu-ancestor > a,
				.navigation > li ul a:hover {
					color: <?php echo sanitize_hex_color( $header_menu_color_hover ); ?>;
				}
				<?php
			}

			$header_menu_background = get_theme_mod( 'header_menu_background' );

			if ( ! empty( $header_menu_background ) ) {
				?>
				.navigation > li ul {
					background-color: <?php echo sanitize_hex_color( $header_menu_background ); ?>;
				}

				.navigation > li ul a {
					background-color: <?php echo sanitize_hex_color( truenorth_color_luminance( $header_menu_background, -0.6 ) ); ?>;
				}
				<?php
			}

			$css = ob_get_clean();
			return apply_filters( 'truenorth_customizer_css', $css );
		}
	endif;
