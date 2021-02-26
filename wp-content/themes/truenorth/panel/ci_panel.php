<?php
if ( ! defined( 'CI_PANEL_TABS_DIR' ) ) {
	define( 'CI_PANEL_TABS_DIR', 'functions/tabs' );
}

// Load our default options.
load_ci_defaults();

add_action( 'init', 'ci_register_theme_default_scripts', 10 );
function ci_register_theme_default_scripts() {
	wp_register_script( 'jquery-cycle-all', get_theme_file_uri( '/panel/scripts/jquery.cycle.all-3.0.2.js' ), array( 'jquery' ), truenorth_asset_version( '3.0.2' ), true );
	wp_register_script( 'jquery-flexslider', get_theme_file_uri( '/panel/scripts/jquery.flexslider-2.1-min.js' ), array( 'jquery' ), truenorth_asset_version( '2.1' ), true );
	wp_register_script( 'jquery-hoverIntent', get_theme_file_uri( '/panel/scripts/jquery.hoverIntent.r7.min.js' ), array( 'jquery' ), truenorth_asset_version( 'r7' ), true );
	wp_register_script( 'jquery-superfish', get_theme_file_uri( '/panel/scripts/superfish-1.7.4.min.js' ), array(
		'jquery',
		'jquery-hoverIntent',
	), truenorth_asset_version( '1.7.4' ), true );
	wp_register_script( 'jquery-fitVids', get_theme_file_uri( '/panel/scripts/jquery.fitvids.js' ), array( 'jquery' ), truenorth_asset_version( '1.1' ), true );
	wp_register_script( 'jquery-ui-datepicker-localize', get_theme_file_uri( '/panel/scripts/jquery.ui.datepicker.localize.js' ), array( 'jquery' ), truenorth_asset_version( '1.0' ), true );

	// Bower-updated components
	wp_register_script( 'retinajs', get_theme_file_uri( '/panel/components/retinajs/dist/retina.js' ), array(), truenorth_asset_version( '2.1.2' ), true );
	wp_register_style( 'font-awesome', get_theme_file_uri( '/panel/components/fontawesome/css/font-awesome.min.css' ), array(), truenorth_asset_version( '4.7.0' ) );

}

add_action( 'admin_init', 'ci_register_admin_scripts' );
function ci_register_admin_scripts() {
	//
	// Register all scripts and style here, unconditionally. Conditionals are used further down this file for enqueueing.
	//
	wp_register_script( 'ci-panel', get_theme_file_uri( '/panel/scripts/panelscripts.js' ), array( 'jquery' ), truenorth_asset_version() );
	wp_register_style( 'ci-panel-css', get_theme_file_uri( '/panel/panel.css' ), array(), truenorth_asset_version() );

	wp_register_script( 'ci-post-formats', get_theme_file_uri( '/panel/scripts/ci-post-formats.js' ), array( 'jquery' ), truenorth_asset_version() );
	wp_register_style( 'ci-post-formats', get_theme_file_uri( '/panel/styles/ci-post-formats.css' ), array(), truenorth_asset_version() );

	// Can be enqueued properly by ci_enqueue_media_manager_scripts() defined in panel/generic.php
	wp_register_script( 'ci-media-manager-3-5', get_theme_file_uri( '/panel/scripts/media-manager-3.5.js' ), array( 'media-editor' ), truenorth_asset_version() );

	wp_register_script( 'ci-panel-post-edit-screens', get_theme_file_uri( '/panel/scripts/post-edit-screens.js' ), array( 'jquery' ), truenorth_asset_version() );
	wp_register_style( 'ci-panel-post-edit-screens', get_theme_file_uri( '/panel/styles/post-edit-screens.css' ), array(), truenorth_asset_version() );

	wp_register_style( 'ci-panel-widgets', get_theme_file_uri( '/panel/styles/widgets.css' ), array(), truenorth_asset_version() );
}

add_action( 'wp_enqueue_scripts', 'ci_enqueue_panel_scripts' );
function ci_enqueue_panel_scripts() {
	if ( ! apply_filters( 'limit_logo_size_support', false ) && apply_filters( 'ci_retina_logo', true ) ) {
		wp_enqueue_script( 'retinajs' );
	}
}

add_action( 'admin_enqueue_scripts', 'ci_enqueue_admin_scripts' );
function ci_enqueue_admin_scripts() {
	global $pagenow;

	//
	// Enqueue here scripts and styles that are to be loaded on all admin pages.
	//

	if ( in_array( $pagenow, array( 'post-new.php', 'post.php' ), true ) ) {
		//
		// Enqueue here scripts and styles that are to be loaded only on post edit screens.
		//
		if ( current_theme_supports( 'post-formats' ) ) {
			wp_enqueue_script( 'ci-post-formats' );
		}

		wp_enqueue_script( 'ci-panel-post-edit-screens' );
		wp_enqueue_style( 'ci-panel-post-edit-screens' );
	}

	if ( in_array( $pagenow, array( 'widgets.php', 'customize.php' ), true ) ) {
		wp_enqueue_media();
		ci_enqueue_media_manager_scripts();
		wp_enqueue_style( 'ci-panel-widgets' );
	}

	if ( 'themes.php' === $pagenow && isset( $_GET['page'] ) && 'ci_panel.php' === $_GET['page'] ) { // phpcs:ignore WordPress.Security.NonceVerification
		//
		// Enqueue here scripts and styles that are to be loaded only on CSSIgniter Settings panel.
		//
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );

		wp_enqueue_media();
		ci_enqueue_media_manager_scripts();

		wp_enqueue_script( 'ci-panel' );
		wp_enqueue_style( 'ci-panel-css' );
	}
}

add_action( 'admin_bar_menu', 'ci_create_bar_menu', 100 );
function ci_create_bar_menu( $wp_admin_bar ) {
	if ( ! is_admin() && current_user_can( 'edit_theme_options' ) ) {
		if ( ! CI_WHITELABEL ) {
			$menu_title = __( 'CSSIgniter Settings', 'truenorth' );
		} else {
			$menu_title = __( 'Theme Settings', 'truenorth' );
		}

		$menu_title = apply_filters( 'ci_panel_menu_title', $menu_title, CI_WHITELABEL );

		$args = array(
			'id'     => 'truenorth_settings',
			'title'  => $menu_title,
			'href'   => admin_url( 'themes.php?page=ci_panel.php' ),
			'parent' => 'appearance',
		);

		$wp_admin_bar->add_node( $args );
	}
}

add_action( 'admin_menu', 'ci_create_menu' );
function ci_create_menu() {
	add_action( 'admin_init', 'ci_register_settings' );

	// Handle reset before anything is outputed in the browser.
	// This is here because it needs the settings to be registered, but because it
	// redirects, it should be called before the ci_settings_page.
	global $pagenow;
	if ( is_admin() && isset( $_POST['reset'] ) && ( 'themes.php' === $pagenow ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		delete_option( THEME_OPTIONS );
		global $ci;
		$ci = array();
		ci_default_options( true );
		wp_safe_redirect( 'themes.php?page=ci_panel.php' );
	}

	if ( ! CI_WHITELABEL ) {
		$menu_title = __( 'CSSIgniter Settings', 'truenorth' );
	} else {
		$menu_title = __( 'Theme Settings', 'truenorth' );
	}

	$menu_title = apply_filters( 'ci_panel_menu_title', $menu_title, CI_WHITELABEL );

	add_theme_page( $menu_title, $menu_title, 'edit_theme_options', basename( __FILE__ ), 'ci_settings_page' );
}

function ci_register_settings() {
	register_setting( 'ci-settings-group', THEME_OPTIONS, 'ci_options_validate' );
}

function ci_options_validate( $set ) {
	global $ci_defaults;
	$set = (array) $set;

	foreach ( $ci_defaults as $key => $value ) {
		if ( ! isset( $set[ $key ] ) ) {
			$set[ $key ] = '';
		}
	}

	$set = apply_filters( 'truenorth_sanitize_panel_options', $set, $ci_defaults );

	return $set;
}


function ci_settings_page() {
	?>
	<div class="wrap">
		<h2>
			<?php
				if ( ! CI_WHITELABEL ) {
					/* translators: %1$s is the theme name. %2$s is the theme's version number prepended by a 'v', e.g. v1.2 */
					echo wp_kses_post( sprintf( _x( '%1$s Settings v%2$s', 'theme name settings version', 'truenorth' ),
						TRUENORTH_NICENAME,
						TRUENORTH_VERSION
					) );
				} else {
					/* translators: %s is the theme name. */
					echo wp_kses_post( sprintf( _x( '%s Settings', 'theme name settings', 'truenorth' ),
						TRUENORTH_NICENAME
					) );
				}
			?>
		</h2>

		<?php $latest_version = truenorth_update_check(); ?>
		<?php if ( ( false !== $latest_version ) && version_compare( $latest_version, TRUENORTH_VERSION, '>' ) ) : ?>
			<div class="notice notice-info theme-update">
				<p>
					<?php
						/* translators: %1$s is the newest version. %2$s is the currently installed version. */
						echo wp_kses_post( sprintf( __( 'A theme update is available. The latest version is <strong>%1$s</strong> and you are running <strong>%2$s</strong>', 'truenorth' ), $latest_version, TRUENORTH_VERSION ) );
					?>
				</p>
			</div>
		<?php endif; ?>

		<?php
			$panel_classes = truenorth_classes();
			unset( $panel_classes['theme_color_scheme'] );
		?>
		<div id="ci_panel" class="<?php echo esc_attr( implode( ' ', $panel_classes ) ); ?>">
			<form method="post" action="options.php" id="theform" enctype="multipart/form-data">
				<?php
					settings_fields( 'ci-settings-group' );
					$theme_options = get_option( THEME_OPTIONS );
				?>
				<div id="ci_header">
					<?php if ( ! CI_WHITELABEL ) : ?>
						<img src="<?php echo esc_url( apply_filters( 'ci_panel_logo_url', get_theme_file_uri( '/panel/img/logo.png' ), '/panel/img/logo.png' ) ); ?>"/>
					<?php endif; ?>
				</div>

				<?php if ( isset( $_POST['reset'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification ?>
					<div class="resetbox"><?php esc_html_e( 'Settings reset!', 'truenorth' ); ?></div>
				<?php endif; ?>

				<div class="success"></div>

				<div class="ci_save ci_save_top group">
					<p>
						<?php
							$docs_links = array();
							if ( CI_DOCS !== '' ) {
								$docs_links[] = sprintf( '<a href="%s">%s</a>',
									esc_url( CI_DOCS ),
									__( 'Documentation', 'truenorth' )
								);
							}
							if ( CI_FORUM !== '' ) {
								$support_url   = 'https://www.cssigniter.com/support-hub/';
								$support_title = __( 'Support Hub', 'truenorth' );
								$is_ci_forum   = preg_match( '#cssigniter\.com/support/viewforum#', CI_FORUM );

								if ( ! $is_ci_forum ) {
									$support_url   = CI_FORUM;
									$support_title = __( 'Support', 'truenorth' );
								}

								$docs_links[] = sprintf( '<a href="%s">%s</a>',
									esc_url( $support_url ),
									$support_title
								);
							}

							echo wp_kses_post( implode( ' | ', $docs_links ) );
						?>
					</p>
					<input type="submit" class="button-primary save" value="<?php esc_attr_e( 'Save Changes', 'truenorth' ); ?>"/>
				</div>

				<div id="ci_main" class="group">

					<?php
						// Each tab is responsible for adding itself to the list of the panel tabs.
						// The priority on add_filter() affects the order of the tabs.
						// Tab files are automatically loaded for initialization by the function load_ci_defaults().
						// Child themes have a chance to load their tabs (or unload the parent theme's tabs) only after
						// the parent theme has initialized its tabs.
						$paneltabs = apply_filters( 'ci_panel_tabs', array() );
					?>

					<div id="ci_sidebar_back"></div>
					<div id="ci_sidebar">
						<ul>
							<?php
								$tab_num = 1;
								foreach ( $paneltabs as $name => $title ) {
									$firstclass = 1 === $tab_num ? 'active' : '';
									echo sprintf( '<li id="%1$s"><a href="#tab%2$s" rel="tab%2$s" class="%3$s"><span>%4$s</span></a></li>',
										esc_attr( $name ),
										esc_attr( $tab_num ),
										esc_attr( $firstclass ),
										wp_kses_post( $title )
									);
									$tab_num ++;
								}
							?>
						</ul>
					</div><!-- /sidebar -->

					<div id="ci_options">
						<div id="ci_options_inner">
							<?php
								$tab_num = 1;
								foreach ( $paneltabs as $name => $title ) {
									$firstclass = 1 === $tab_num ? 'one' : '';
									?><div id="tab<?php echo esc_attr( $tab_num ); ?>" class="tab <?php echo esc_attr( $firstclass ); ?>"><?php get_template_part( CI_PANEL_TABS_DIR . '/' . $name ); ?></div><?php
									$tab_num ++;
								}
							?>
						</div>
					</div><!-- #ci_options -->

				</div><!-- #ci_main -->
				<div class="ci_save group">
					<input type="submit" class="button-primary save" value="<?php esc_attr_e( 'Save Changes', 'truenorth' ); ?>"/>
				</div>
			</form>
		</div><!-- #ci_panel -->

		<div id="ci-reset-box">
			<form method="post" action="">
				<input type="hidden" name="reset" value="reset" />
				<input type="submit" class="button" value="<?php esc_attr_e( 'Reset Settings', 'truenorth' ); ?>" onclick="return confirm('<?php esc_attr_e( 'Are you sure? All settings will be lost!', 'truenorth' ); ?>'); "/>
			</form>
		</div>
	</div><!-- wrap -->
	<?php
}


function load_ci_defaults() {
	global $load_defaults, $ci, $ci_defaults;
	$load_defaults = true;

	// All php files in CI_PANEL_TABS_DIR are loaded by default.
	// Those files (tabs) are responsible for adding themselves on the actual tabs that will be show,
	// by hooking on the 'ci_panel_tabs' filter.
	$paths   = array();
	$paths[] = get_template_directory();
	if ( is_child_theme() ) {
		$paths[] = get_stylesheet_directory();
	}

	foreach ( $paths as $path ) {
		$path .= '/' . CI_PANEL_TABS_DIR;

		if ( file_exists( $path ) ) {
			$handle = opendir( $path );
			if ( $handle ) {
				while ( false !== ( $file = readdir( $handle ) ) ) {
					if ( '.' !== $file && '..' !== $file ) {
						$file_info = pathinfo( $path . '/' . $file );
						if ( isset( $file_info['extension'] ) && 'php' === $file_info['extension'] ) {
							get_template_part( CI_PANEL_TABS_DIR . '/' . basename( $file, '.php' ) );
						}
					}
				}
				closedir( $handle );
			}
		}
	}

	$load_defaults = false;
	$ci_defaults   = apply_filters( 'ci_defaults', $ci_defaults );
}

function load_panel_snippet( $slug, $name = null ) {
	$slug = 'panel/snippets/' . $slug;

	do_action( "get_template_part_{$slug}", $slug, $name );

	$templates = array();
	if ( isset( $name ) ) {
		$templates[] = "{$slug}-{$name}.php";
	}

	$templates[] = "{$slug}.php";

	locate_template( $templates, true, false );
}

//
//
// CSSIgniter panel control generators
//
//
function ci_panel_textarea( $fieldname, $label ) {
	global $ci;
	?>
	<label for="<?php echo esc_attr( $fieldname ); ?>"><?php echo $label; ?></label>
	<textarea id="<?php echo esc_attr( $fieldname ); ?>" name="<?php echo esc_attr( THEME_OPTIONS . '[' . $fieldname . ']' ); ?>" rows="5"><?php echo esc_textarea( $ci[ $fieldname ] ); ?></textarea>
	<?php
}

function ci_panel_input( $fieldname, $label, $params = array() ) {
	global $ci;

	$defaults = array(
		'label_class' => '',
		'input_class' => '',
		'input_type'  => 'text',
	);

	$params = wp_parse_args( $params, $defaults );

	if ( ! empty( $label ) ) {
		?><label for="<?php echo esc_attr( $fieldname ); ?>" class="<?php echo esc_attr( $params['label_class'] ); ?>"><?php echo $label; ?></label><?php
	}
	?><input id="<?php echo esc_attr( $fieldname ); ?>" type="<?php echo esc_attr( $params['input_type'] ); ?>" size="60" name="<?php echo esc_attr( THEME_OPTIONS . '[' . $fieldname . ']' ); ?>" value="<?php echo esc_attr( $ci[ $fieldname ] ); ?>" class="<?php echo esc_attr( $params['input_class'] ); ?>" /><?php
}

// $fieldname is the actual name="" attribute common to all radios in the group.
// $optionname is the id of the radio, so that the label can be associated with it.
function ci_panel_radio( $fieldname, $optionname, $optionval, $label ) {
	global $ci;
	?>
	<label for="<?php echo esc_attr( $optionname ); ?>" class="radio">
		<input type="radio" class="radio" id="<?php echo esc_attr( $optionname ); ?>" name="<?php echo esc_attr( THEME_OPTIONS . '[' . $fieldname . ']' ); ?>" value="<?php echo esc_attr( $optionval ); ?>" <?php checked( $ci[ $fieldname ], $optionval ); ?> />
		<?php echo $label; ?>
	</label>
	<?php
}

function ci_panel_checkbox( $fieldname, $value, $label, $params = array() ) {
	global $ci;

	$params = wp_parse_args( $params, array(
		'input_class' => 'check',
	) );

	?>
	<label for="<?php echo esc_attr( $fieldname ); ?>">
		<input type="checkbox" id="<?php echo esc_attr( $fieldname ); ?>" class="<?php echo esc_attr( $params['input_class'] ); ?>" name="<?php echo esc_attr( THEME_OPTIONS . '[' . $fieldname . ']' ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php checked( $ci[ $fieldname ], $value ); ?> />
		<?php echo $label; ?>
	</label>
	<?php
}

function ci_panel_upload_image( $fieldname, $label, $params = array() ) {
	global $ci;

	$defaults = array(
		'input_class'   => 'uploaded',
		'input_type'    => 'text',
		'esc_func'      => 'esc_url',
		'preview_field' => $fieldname,
		'select_size'   => true,
	);

	$params = wp_parse_args( $params, $defaults );

	$value = $ci[ $fieldname ];
	$value = call_user_func( $params['esc_func'], $value );

	$preview_url = $ci[ $params['preview_field'] ];

	$frame = 'post';
	if ( ! $params['select_size'] ) {
		$frame = 'select';
	}

	?>
	<label for="<?php echo esc_attr( $fieldname ); ?>"><?php echo $label; ?></label>
	<input id="<?php echo esc_attr( $fieldname ); ?>" type="<?php echo esc_attr( $params['input_type'] ); ?>" size="60" name="<?php echo esc_attr( THEME_OPTIONS . '[' . $fieldname . ']' ); ?>" value="<?php echo esc_attr( $value ); ?>" class="<?php echo esc_attr( $params['input_class'] ); ?>"/>
	<input type="submit" class="ci-upload button" data-frame="<?php echo esc_attr( $frame ); ?>" value="<?php esc_attr_e( 'Upload image', 'truenorth' ); ?>"/>
	<div class="up-preview">
		<?php
			if ( ! empty( $preview_url ) ) {
				echo sprintf( '<img src="%s" /><a href="#" class="close media-modal-icon" title="%s"></a>',
					esc_url( $preview_url ),
					esc_attr__( 'Remove image', 'truenorth' )
				);
			}
		?>
	</div>
	<?php if ( ! empty( $preview_url ) ) : ?>
		<div class="up-preview-bg group">
			<?php
				/* translators: %s is a color name, e.g. white, black, etc. */
				$preview_text = __( 'Preview in %s background', 'truenorth' );
			?>
			<span class="swatch white" title="<?php echo esc_attr( sprintf( $preview_text, _x( 'White', 'color', 'truenorth' ) ) ); ?>"></span>
			<span class="swatch grey" title="<?php echo esc_attr( sprintf( $preview_text, _x( 'Grey', 'color', 'truenorth' ) ) ); ?>"></span>
			<span class="swatch black" title="<?php echo esc_attr( sprintf( $preview_text, _x( 'Black', 'color', 'truenorth' ) ) ); ?>"></span>
			<span class="swatch transparent" title="<?php echo esc_attr( sprintf( $preview_text, _x( 'Transparent', 'color', 'truenorth' ) ) ); ?>"></span>
		</div>
	<?php endif; ?>
<?php
}

function ci_panel_dropdown( $fieldname, $options, $label ) {
	global $ci;
	$options = (array) $options;
	?>
	<label for="<?php echo esc_attr( $fieldname ); ?>"><?php echo $label; ?></label>
	<select id="<?php echo esc_attr( $fieldname ); ?>" name="<?php echo esc_attr( THEME_OPTIONS . '[' . $fieldname . ']' ); ?>">
		<?php foreach ( $options as $opt_val => $opt_label ) : ?>
			<option value="<?php echo esc_attr( $opt_val ); ?>" <?php selected( $ci[ $fieldname ], $opt_val ); ?>><?php echo $opt_label; ?></option>
		<?php endforeach; ?>
	</select>
	<?php
}

function ci_panel_terms_checklist( $fieldname, $taxonomy, $label ) {
	global $ci;
	?>
	<label for="ul-<?php echo esc_attr( $fieldname ); ?>"><?php echo $label; ?></label>
	<ul id="ul-<?php echo esc_attr( $fieldname ); ?>" class="terms_checklist">
		<?php
			$cats = $ci[ $fieldname ];

			// Compatibility for old style category input boxes, where categories
			// where inputed by their IDs, separated by comma.
			if ( ! is_array( $cats ) && is_string( $cats ) && ! empty( $cats ) ) {
				$cats = explode( $cats, ',' );
			}

			wp_terms_checklist( 0, array(
				'selected_cats' => $cats,
				'checked_ontop' => false,
				'taxonomy'      => $taxonomy,
				'walker'        => new CI_Panel_Walker_Category_Checklist( THEME_OPTIONS . '[' . $fieldname . ']' ),
			) );
		?>
	</ul>
	<?php
}


//
// Walkers
//
/**
 * Walker to output an unordered list of category checkbox input elements.
 * This is almost identical to Walker_Category_Checklist, however it allows
 * the name to be configured for the checkboxes.
 *
 * @since 2.5.1
 *
 * @see Walker
 * @see wp_category_checklist()
 * @see wp_terms_checklist()
 */
class CI_Panel_Walker_Category_Checklist extends Walker {

	public $field_name = ''; // This will be used as base for the HTML name="" attributes.
	public $tree_type  = 'category';
	public $db_fields  = array( 'parent' => 'parent', 'id' => 'term_id' );

	public function __construct( $field_name = 'selected_categories' ) {
		$this->field_name = $field_name;
	}

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker:start_lvl()
	 *
	 * @since 2.5.1
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of category. Used for tab indentation.
	 * @param array  $args   An array of arguments. @see wp_terms_checklist()
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent  = str_repeat( "\t", $depth );
		$output .= "$indent<ul class='children'>\n";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker::end_lvl()
	 *
	 * @since 2.5.1
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of category. Used for tab indentation.
	 * @param array  $args   An array of arguments. @see wp_terms_checklist()
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent  = str_repeat( "\t", $depth );
		$output .= "$indent</ul>\n";
	}

	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @since 2.5.1
	 *
	 * @param string $output   Passed by reference. Used to append additional content.
	 * @param object $category The current term object.
	 * @param int    $depth    Depth of the term in reference to parents. Default 0.
	 * @param array  $args     An array of arguments. @see wp_terms_checklist()
	 * @param int    $id       ID of the current term.
	 */
	public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		if ( empty( $args['taxonomy'] ) ) {
			$taxonomy = 'category';
		} else {
			$taxonomy = $args['taxonomy'];
		}

		$name   = $this->field_name;
		$prefix = sanitize_html_class( $name );

		$args['popular_cats'] = empty( $args['popular_cats'] ) ? array() : $args['popular_cats'];

		$class = in_array( $category->term_id, $args['popular_cats'] ) ? ' class="popular-category"' : '';

		$args['selected_cats'] = empty( $args['selected_cats'] ) ? array() : $args['selected_cats'];

		/** This filter is documented in wp-includes/category-template.php */
		$output .= "\n<li id='{$prefix}-{$taxonomy}-{$category->term_id}'$class>" .
			'<label class="selectit"><input value="' . $category->term_id . '" type="checkbox" name="' . $name . '[]" id="in-' . $prefix . '-' . $taxonomy . '-' . $category->term_id . '"' .
			checked( in_array( $category->term_id, $args['selected_cats'] ), true, false ) .
			disabled( empty( $args['disabled'] ), false, false ) . ' /> ' .
			esc_html( apply_filters( 'the_category', $category->name ) ) . '</label>';
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @see Walker::end_el()
	 *
	 * @since 2.5.1
	 *
	 * @param string $output   Passed by reference. Used to append additional content.
	 * @param object $category The current term object.
	 * @param int    $depth    Depth of the term in reference to parents. Default 0.
	 * @param array  $args     An array of arguments. @see wp_terms_checklist()
	 */
	public function end_el( &$output, $category, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}
