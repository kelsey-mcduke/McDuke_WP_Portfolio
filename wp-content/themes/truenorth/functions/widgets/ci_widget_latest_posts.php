<?php 
if ( ! class_exists( 'CI_Latest_Posts' ) ) :
class CI_Latest_Posts extends WP_Widget {

	protected $defaults = array(
		'title'     => '',
		'post_type' => 'post',
		'random'    => 0,
		'count'     => 2,
		'columns'   => 2,
		'masonry'   => 0,
	);

	public function __construct() {
		$widget_ops  = array( 'description' => __( 'Homepage widget. Displays a number of the latest (or random) posts from a specific post type.', 'truenorth' ) );
		$control_ops = array();

		parent::__construct( 'ci-latest-posts', __( 'Theme (home) - Latest Posts', 'truenorth' ), $widget_ops, $control_ops );

		add_action( 'admin_enqueue_scripts', array( $this, '_enqueue_admin_scripts' ) );
	}


	public function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$title     = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$post_type = $instance['post_type'];
		$random    = (int) $instance['random'];
		$count     = (int) $instance['count'];
		$masonry   = (int) $instance['masonry'];

		$columns = $instance['columns'];

		if ( 0 === $count ) {
			return;
		}

		$item_classes = truenorth_get_columns_classes( $columns );

		$div_class = '';
		if ( 1 === $masonry ) {
			$div_class = 'list-isotope';
		}

		echo $args['before_widget'];

		$q_args = array(
			'post_type'      => $post_type,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'posts_per_page' => $count,
		);

		if ( 1 === $random ) {
			$q_args['orderby'] = 'rand';
			unset( $q_args['order'] );
		}

		$q = new WP_Query( $q_args );

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		?>
		<div class="row <?php echo esc_attr( $div_class ); ?>">
			<?php
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
			?>
		</div>
		<?php

		wp_reset_postdata();

		echo $args['after_widget'];

	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']     = sanitize_text_field( $new_instance['title'] );
		$instance['post_type'] = sanitize_key( $new_instance['post_type'] );
		$instance['random']    = truenorth_sanitize_checkbox( $new_instance['random'] );
		$instance['count']     = intval( $new_instance['count'] );
		$instance['columns']   = intval( $new_instance['columns'] );
		$instance['masonry']   = truenorth_sanitize_checkbox( $new_instance['masonry'] );

		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$title     = $instance['title'];
		$post_type = $instance['post_type'];
		$random    = (int) $instance['random'];
		$count     = $instance['count'];
		$columns   = $instance['columns'];
		$masonry   = (int) $instance['masonry'];

		?><p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'truenorth' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat"/></p><?php

		$types = get_post_types( array(
			'public' => true,
		), 'objects' );

		unset( $types['attachment'] );

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>"><?php esc_html_e( 'Select a post type to display the latest post from', 'truenorth' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_type' ) ); ?>">
				<?php foreach ( $types as $key => $type ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $post_type, $key ); ?>>
						<?php echo wp_kses( $type->labels->name, 'strip' ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'random' ) ); ?>"><input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'random' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'random' ) ); ?>" value="1" <?php checked( $random, 1 ); ?> /><?php esc_html_e( 'Show random posts.', 'truenorth' ); ?></label></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'truenorth' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" min="1" step="1" value="<?php echo esc_attr( $count ); ?>" class="widefat"/></p>

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
						), array( 'option' => array( 'value' => true ) ) );
					}
				?>
			</select>
		</p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'masonry' ) ); ?>"><input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'masonry' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'masonry' ) ); ?>" value="1" <?php checked( $masonry, 1 ); ?> /><?php esc_html_e( 'Masonry effect (not applicable to 1 column layout).', 'truenorth' ); ?></label></p>
		<?php

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

register_widget( 'CI_Latest_Posts' );

endif;
