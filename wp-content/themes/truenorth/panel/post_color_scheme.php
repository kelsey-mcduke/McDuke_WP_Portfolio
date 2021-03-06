<?php
add_action( 'admin_init', 'ci_pcsc_add_meta' );
add_action( 'save_post', 'ci_pcsc_update_post_meta' );

if ( ! function_exists( 'ci_pcsc_add_meta' ) ) :
function ci_pcsc_add_meta() {
	$post_types = get_truenorth_support( 'post-color-scheme' );

	if ( ! empty( $post_types ) ) {
		foreach ( $post_types as $post_type ) {
			add_meta_box( 'ci_pcsc_box', __( 'Post Color Scheme', 'truenorth' ), 'ci_pcsc_meta_box', $post_type, 'side', 'default' );
		}
	}
}
endif;

if ( ! function_exists( 'ci_pcsc_update_post_meta' ) ) :
function ci_pcsc_update_post_meta( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( isset( $_POST['post_view'] ) && 'list' === $_POST['post_view'] ) {
		return;
	}

	$post_types = get_truenorth_support( 'post-color-scheme' );

	if ( is_array( $post_types ) && isset( $_POST['post_type'] ) && in_array( $_POST['post_type'], $post_types, true ) ) {
		update_post_meta( $post_id, 'ci_pcsc_stylesheet', ( isset( $_POST['ci_pcsc_stylesheet'] ) ? $_POST['ci_pcsc_stylesheet'] : '' ) );
	}
}
endif;

if ( ! function_exists( 'ci_pcsc_meta_box' ) ) :
function ci_pcsc_meta_box() {
	global $post;

	$color   = get_post_meta( $post->ID, 'ci_pcsc_stylesheet', true );
	$schemes = array();
	$path    = '';

	if ( is_child_theme() && file_exists( get_stylesheet_directory() . '/colors' ) ) {
		$path = get_stylesheet_directory() . '/colors';
	} elseif ( file_exists( get_template_directory() . '/colors' ) ) {
		$path = get_template_directory() . '/colors';
	}

	$path = apply_filters( 'ci_color_schemes_directory', $path );

	if ( ! empty( $path ) && is_readable( $path ) ) {
		$handle = opendir( $path );
		if ( $handle ) {
			while ( false !== ( $file = readdir( $handle ) ) ) {
				if ( '.' !== $file && '..' !== $file ) {
					$file_info = pathinfo( $path . '/' . $file );
					if ( ! empty( $file_info['extension'] ) && 'css' === $file_info['extension'] ) {
						$schemes[] = $file;
					}
				}
			}
			closedir( $handle );
		}
	}
	?>
	<p><?php esc_html_e( "Select one of the available color schemes to override the one selected from the theme's options panel.", 'truenorth' ); ?></p>
	<select name="ci_pcsc_stylesheet" id="ci_pcsc_stylesheet" class="postform">
		<option value="" <?php selected( '', $color ); ?>> </option>
		<?php foreach ( $schemes as $scheme ) : ?>
			<option value="<?php echo esc_attr( $scheme ); ?>" <?php selected( $scheme, $color ); ?>><?php echo esc_html( $scheme ); ?></option>
		<?php endforeach; ?>
	</select>
	<?php
}
endif;

add_action( 'wp_enqueue_scripts', 'ci_pcsc_enqueue_scheme' );
if ( ! function_exists( 'ci_pcsc_enqueue_scheme' ) ) :
function ci_pcsc_enqueue_scheme() {
	if ( ! is_singular() ) {
		return;
	}

	global $post;

	$color = get_post_meta( $post->ID, 'ci_pcsc_stylesheet', true );

	if ( ! empty( $color ) ) {
		// Path discovery within the loop, avoids unnecessary disk operations.
		$path = '';
		if ( is_child_theme() && file_exists( get_stylesheet_directory() . '/colors' ) ) {
			$path = get_stylesheet_directory_uri() . '/colors';
		} elseif ( file_exists( get_template_directory() . '/colors' ) ) {
			$path = get_template_directory_uri() . '/colors';
		}


		if ( wp_style_is( 'ci-color-scheme' ) === 'registered' ) {
			wp_deregister_style( 'ci-color-scheme' );
		}

		wp_register_style( 'ci-color-scheme', $path . '/' . $color, array(), truenorth_asset_version() );
		wp_enqueue_style( 'ci-color-scheme' );
	}

}
endif;
