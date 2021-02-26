<?php
if ( ! class_exists( 'CI_Items' ) ) :
class CI_Items extends WP_Widget {

	protected $defaults = array(
		'title'      => '',
		'post_types' => array(),
		'postids'    => array(),
		'columns'    => 2,
		'masonry'    => 0,
	);

	public $ajax_action = 'ci_items_widget_post_type_ajax_get_posts';

	public function __construct() {
		$widget_ops  = array( 'description' => __( 'Homepage widget. Displays a hand-picked selection of posts from a selected post type.', 'truenorth' ) );
		$control_ops = array();

		parent::__construct( 'ci-items', $name = __( 'Theme (home) - Items', 'truenorth' ), $widget_ops, $control_ops );

		if ( is_admin() === true ) {
			add_action( 'wp_ajax_' . $this->ajax_action, 'CI_Items::_ajax_get_posts' );
		}

		add_action( 'admin_enqueue_scripts', array( $this, '_enqueue_admin_scripts' ) );
	}

	public function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$title   = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$types   = $instance['post_types'];
		$ids     = $instance['postids'];
		$masonry = (int) $instance['masonry'];
		$columns = $instance['columns'];

		$count = max( count( $types ), count( $ids ) );

		$item_classes = truenorth_get_columns_classes( $columns );

		if ( empty( $types ) || empty( $ids ) ) {
			return;
		}

		$div_class = '';
		if ( 1 === $masonry ) {
			$div_class = 'list-isotope';
		}

		echo $args['before_widget'];


		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		?>
		<div class="row <?php echo esc_attr( $div_class ); ?>">
			<?php
				for ( $i = 0; $i < $count; $i++ ) {
					$pid       = $ids[ $i ];
					$post_type = $types[ $i ];

					$q = new WP_Query( array(
						'post_type' => $post_type,
						'p'         => $pid,
					) );

					while ( $q->have_posts() ) {
						$q->the_post();
						?>
						<div class="<?php echo esc_attr( $item_classes ); ?>">
							<?php
								if ( 1 === $masonry && 1 !== $columns ) {
									get_template_part( 'listing-masonry', get_post_type() );
								} else {
									get_template_part( 'listing', get_post_type() );
								}
							?>
						</div>
						<?php
					}
					wp_reset_postdata();
				}
			?>
		</div>
		<?php

		echo $args['after_widget'];

	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = sanitize_text_field( $new_instance['title'] );

		// Sanitize repeating fields. Remove empty entries.
		$instance['post_types'] = array();
		$instance['postids']    = array();

		$types = $new_instance['post_types'];
		$ids   = $new_instance['postids'];
		$count = max( count( $types ), count( $ids ) );

		for ( $i = 0; $i < $count; $i ++ ) {
			if ( ! empty( $types[ $i ] ) && ! empty( $ids[ $i ] ) ) {
				$instance['post_types'][] = sanitize_key( $types[ $i ] );
				$instance['postids'][]    = absint( $ids[ $i ] );
			}
		}

		$instance['columns'] = intval( $new_instance['columns'] );
		$instance['masonry'] = truenorth_sanitize_checkbox( $new_instance['masonry'] );

		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$title      = $instance['title'];
		$post_types = $instance['post_types'];
		$postids    = $instance['postids'];
		$columns    = $instance['columns'];
		$masonry    = $instance['masonry'];

		?><p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'truenorth' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat"/></p><?php

		$post_types_available = get_post_types( array(
			'public' => true,
		), 'objects' );

		unset( $post_types_available['attachment'] );

		$posttypes_name = $this->get_field_name( 'post_types' ) . '[]';
		$ids_name       = $this->get_field_name( 'postids' ) . '[]';

		?>
		<p><?php esc_html_e( 'Add as many items as you want by pressing the "Add Item" button. Remove any item by selecting "Remove me".', 'truenorth' ); ?></p>
		<fieldset class="ci-repeating-fields ci-items">
			<div class="inner">
				<?php
					if ( ! empty( $postids ) && ! empty( $post_types ) ) {
						$count = max( count( $postids ), count( $post_types ) );
						for ( $i = 0; $i < $count; $i ++ ) {
							?>
							<div class="post-field" data-ajaxaction="<?php echo esc_attr( $this->ajax_action ); ?>">
								<label class="post-field-type"><?php esc_html_e( 'Post type:', 'truenorth' ); ?>
									<select name="<?php echo esc_attr( $posttypes_name ); ?>" class="widefat posttype_dropdown">
										<?php
											foreach ( $post_types_available as $key => $pt ) {
												?><option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $post_types[ $i ] ); ?>><?php echo wp_kses( $pt->labels->name, 'strip' ); ?></option><?php
											}
										?>
									</select>
								</label>

								<label class="post-field-item"><?php esc_html_e( 'Item:', 'truenorth' ); ?>
									<?php
										wp_dropdown_posts( array(
											'post_type'            => $post_types[ $i ],
											'selected'             => $postids[ $i ],
											'class'                => 'widefat posts_dropdown',
											'show_option_none'     => '&nbsp;',
											'select_even_if_empty' => true,
										), $ids_name );
									?>
								</label>
								<p class="ci-repeating-remove-action"><a href="#" class="button ci-repeating-remove-field"><i class="dashicons dashicons-dismiss"></i><?php esc_html_e( 'Remove me', 'truenorth' ); ?></a></p>
							</div>
							<?php
						}
					}
				?>
				<?php
				//
				// Add an empty and hidden set for jQuery
				//
				?>
				<div class="post-field field-prototype" style="display: none;" data-ajaxaction="<?php echo esc_attr( $this->ajax_action ); ?>">
					<label class="post-field-type"><?php esc_html_e( 'Post type:', 'truenorth' ); ?>
						<select name="<?php echo esc_attr( $posttypes_name ); ?>" class="widefat posttype_dropdown">
							<?php
								foreach ( $post_types_available as $key => $pt ) {
									?><option value="<?php echo esc_attr( $key ); ?>"><?php echo wp_kses( $pt->labels->name, 'strip' ); ?></option><?php
								}
							?>
						</select>
					</label>
					<label class="post-field-item"><?php esc_html_e( 'Item:', 'truenorth' ); ?>
						<?php
							wp_dropdown_posts( array(
								'post_type'            => 'post',
								'class'                => 'widefat posts_dropdown',
								'show_option_none'     => '&nbsp;',
								'select_even_if_empty' => true,
							), $ids_name );
						?>
					</label>
					<p class="ci-repeating-remove-action"><a href="#" class="button ci-repeating-remove-field"><i class="dashicons dashicons-dismiss"></i><?php esc_html_e( 'Remove me', 'truenorth' ); ?></a></p>
				</div>
			</div>
			<a href="#" class="ci-repeating-add-field button"><i class="dashicons dashicons-plus-alt"></i><?php esc_html_e( 'Add Item', 'truenorth' ); ?></a>
		</fieldset>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>"><?php esc_html_e( 'Output Columns:', 'truenorth' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'columns' ) ); ?>">
				<?php
					for ( $i = 1; $i <= 4; $i ++ ) {
						echo wp_kses( sprintf( '<option value="%s" %s>%s</option>',
							esc_attr( $i ),
							selected( $columns, $i, false ),
							/* translators: %d is a number of columns. */
							sprintf( _n( '%d Column', '%d Columns', $i, 'truenorth' ), $i )
						), array( 'option' => array( 'value' => true, 'selected' => true ) ) );
					}
				?>
			</select>
		</p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'masonry' ) ); ?>"><input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'masonry' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'masonry' ) ); ?>" value="1" <?php checked( $masonry, 1 ); ?> /><?php esc_html_e( 'Masonry effect (not applicable to 1 column layout).', 'truenorth' ); ?></label></p>
		<?php
	}

	public static function _ajax_get_posts() {
		$post_type_name = sanitize_key( $_POST['post_type_name'] );
		$name_field     = esc_attr( $_POST['name_field'] );

		wp_dropdown_posts( array(
			'post_type'            => $post_type_name,
			'class'                => 'widefat posts_dropdown',
			'show_option_none'     => '&nbsp;',
			'select_even_if_empty' => true,
		), $name_field );

		die;
	}

	public static function _enqueue_admin_scripts() {
		global $pagenow;

		if ( in_array( $pagenow, array( 'widgets.php', 'customize.php' ), true ) ) {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_media();
			ci_enqueue_media_manager_scripts();
		}
	}

}

register_widget( 'CI_Items' );

endif;
