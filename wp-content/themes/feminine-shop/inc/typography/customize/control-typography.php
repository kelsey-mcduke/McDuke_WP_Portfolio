<?php
/**
 * Typography control class.
 *
 * @since  1.0.0
 * @access public
 */

class Feminine_Shop_Control_Typography extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'feminine-shop-typography';

	/**
	 * Array 
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $l10n = array();

	/**
	 * Set up our control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @param  string  $id
	 * @param  array   $args
	 * @return void
	 */
	public function __construct( $manager, $id, $args = array() ) {

		// Let the parent class do its thing.
		parent::__construct( $manager, $id, $args );

		// Make sure we have labels.
		$this->l10n = wp_parse_args(
			$this->l10n,
			array(
				'color'       => esc_html__( 'Font Color', 'feminine-shop' ),
				'family'      => esc_html__( 'Font Family', 'feminine-shop' ),
				'size'        => esc_html__( 'Font Size',   'feminine-shop' ),
				'weight'      => esc_html__( 'Font Weight', 'feminine-shop' ),
				'style'       => esc_html__( 'Font Style',  'feminine-shop' ),
				'line_height' => esc_html__( 'Line Height', 'feminine-shop' ),
				'letter_spacing' => esc_html__( 'Letter Spacing', 'feminine-shop' ),
			)
		);
	}

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_script( 'feminine-shop-ctypo-customize-controls' );
		wp_enqueue_style(  'feminine-shop-ctypo-customize-controls' );
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		// Loop through each of the settings and set up the data for it.
		foreach ( $this->settings as $setting_key => $setting_id ) {

			$this->json[ $setting_key ] = array(
				'link'  => $this->get_link( $setting_key ),
				'value' => $this->value( $setting_key ),
				'label' => isset( $this->l10n[ $setting_key ] ) ? $this->l10n[ $setting_key ] : ''
			);

			if ( 'family' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_families();

			elseif ( 'weight' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_weight_choices();

			elseif ( 'style' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_style_choices();
		}
	}

	/**
	 * Underscore JS template to handle the control's output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function content_template() { ?>

		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<ul>

		<# if ( data.family && data.family.choices ) { #>

			<li class="typography-font-family">

				<# if ( data.family.label ) { #>
					<span class="customize-control-title">{{ data.family.label }}</span>
				<# } #>

				<select {{{ data.family.link }}}>

					<# _.each( data.family.choices, function( label, choice ) { #>
						<option value="{{ choice }}" <# if ( choice === data.family.value ) { #> selected="selected" <# } #>>{{ label }}</option>
					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.weight && data.weight.choices ) { #>

			<li class="typography-font-weight">

				<# if ( data.weight.label ) { #>
					<span class="customize-control-title">{{ data.weight.label }}</span>
				<# } #>

				<select {{{ data.weight.link }}}>

					<# _.each( data.weight.choices, function( label, choice ) { #>

						<option value="{{ choice }}" <# if ( choice === data.weight.value ) { #> selected="selected" <# } #>>{{ label }}</option>

					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.style && data.style.choices ) { #>

			<li class="typography-font-style">

				<# if ( data.style.label ) { #>
					<span class="customize-control-title">{{ data.style.label }}</span>
				<# } #>

				<select {{{ data.style.link }}}>

					<# _.each( data.style.choices, function( label, choice ) { #>

						<option value="{{ choice }}" <# if ( choice === data.style.value ) { #> selected="selected" <# } #>>{{ label }}</option>

					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.size ) { #>

			<li class="typography-font-size">

				<# if ( data.size.label ) { #>
					<span class="customize-control-title">{{ data.size.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.size.link }}} value="{{ data.size.value }}" />

			</li>
		<# } #>

		<# if ( data.line_height ) { #>

			<li class="typography-line-height">

				<# if ( data.line_height.label ) { #>
					<span class="customize-control-title">{{ data.line_height.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.line_height.link }}} value="{{ data.line_height.value }}" />

			</li>
		<# } #>

		<# if ( data.letter_spacing ) { #>

			<li class="typography-letter-spacing">

				<# if ( data.letter_spacing.label ) { #>
					<span class="customize-control-title">{{ data.letter_spacing.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.letter_spacing.link }}} value="{{ data.letter_spacing.value }}" />

			</li>
		<# } #>

		</ul>
	<?php }

	/**
	 * Returns the available fonts.  Fonts should have available weights, styles, and subsets.
	 *
	 * @todo Integrate with Google fonts.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_fonts() { return array(); }

	/**
	 * Returns the available font families.
	 *
	 * @todo Pull families from `get_fonts()`.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	function get_font_families() {

		return array(
			'' => __( 'No Fonts', 'feminine-shop' ),
        'Abril Fatface' => __( 'Abril Fatface', 'feminine-shop' ),
        'Acme' => __( 'Acme', 'feminine-shop' ),
        'Anton' => __( 'Anton', 'feminine-shop' ),
        'Architects Daughter' => __( 'Architects Daughter', 'feminine-shop' ),
        'Arimo' => __( 'Arimo', 'feminine-shop' ),
        'Arsenal' => __( 'Arsenal', 'feminine-shop' ),
        'Arvo' => __( 'Arvo', 'feminine-shop' ),
        'Alegreya' => __( 'Alegreya', 'feminine-shop' ),
        'Alfa Slab One' => __( 'Alfa Slab One', 'feminine-shop' ),
        'Averia Serif Libre' => __( 'Averia Serif Libre', 'feminine-shop' ),
        'Bangers' => __( 'Bangers', 'feminine-shop' ),
        'Boogaloo' => __( 'Boogaloo', 'feminine-shop' ),
        'Bad Script' => __( 'Bad Script', 'feminine-shop' ),
        'Bitter' => __( 'Bitter', 'feminine-shop' ),
        'Bree Serif' => __( 'Bree Serif', 'feminine-shop' ),
        'BenchNine' => __( 'BenchNine', 'feminine-shop' ),
        'Cabin' => __( 'Cabin', 'feminine-shop' ),
        'Cardo' => __( 'Cardo', 'feminine-shop' ),
        'Courgette' => __( 'Courgette', 'feminine-shop' ),
        'Cherry Swash' => __( 'Cherry Swash', 'feminine-shop' ),
        'Cormorant Garamond' => __( 'Cormorant Garamond', 'feminine-shop' ),
        'Crimson Text' => __( 'Crimson Text', 'feminine-shop' ),
        'Cuprum' => __( 'Cuprum', 'feminine-shop' ),
        'Cookie' => __( 'Cookie', 'feminine-shop' ),
        'Chewy' => __( 'Chewy', 'feminine-shop' ),
        'Days One' => __( 'Days One', 'feminine-shop' ),
        'Dosis' => __( 'Dosis', 'feminine-shop' ),
        'Droid Sans' => __( 'Droid Sans', 'feminine-shop' ),
        'Economica' => __( 'Economica', 'feminine-shop' ),
        'Fredoka One' => __( 'Fredoka One', 'feminine-shop' ),
        'Fjalla One' => __( 'Fjalla One', 'feminine-shop' ),
        'Francois One' => __( 'Francois One', 'feminine-shop' ),
        'Frank Ruhl Libre' => __( 'Frank Ruhl Libre', 'feminine-shop' ),
        'Gloria Hallelujah' => __( 'Gloria Hallelujah', 'feminine-shop' ),
        'Great Vibes' => __( 'Great Vibes', 'feminine-shop' ),
        'Handlee' => __( 'Handlee', 'feminine-shop' ),
        'Hammersmith One' => __( 'Hammersmith One', 'feminine-shop' ),
        'Inconsolata' => __( 'Inconsolata', 'feminine-shop' ),
        'Indie Flower' => __( 'Indie Flower', 'feminine-shop' ),
        'IM Fell English SC' => __( 'IM Fell English SC', 'feminine-shop' ),
        'Julius Sans One' => __( 'Julius Sans One', 'feminine-shop' ),
        'Josefin Slab' => __( 'Josefin Slab', 'feminine-shop' ),
        'Josefin Sans' => __( 'Josefin Sans', 'feminine-shop' ),
        'Kanit' => __( 'Kanit', 'feminine-shop' ),
        'Lobster' => __( 'Lobster', 'feminine-shop' ),
        'Lato' => __( 'Lato', 'feminine-shop' ),
        'Lora' => __( 'Lora', 'feminine-shop' ),
        'Libre Baskerville' => __( 'Libre Baskerville', 'feminine-shop' ),
        'Lobster Two' => __( 'Lobster Two', 'feminine-shop' ),
        'Merriweather' => __( 'Merriweather', 'feminine-shop' ),
        'Monda' => __( 'Monda', 'feminine-shop' ),
        'Montserrat' => __( 'Montserrat', 'feminine-shop' ),
        'Muli' => __( 'Muli', 'feminine-shop' ),
        'Marck Script' => __( 'Marck Script', 'feminine-shop' ),
        'Noto Serif' => __( 'Noto Serif', 'feminine-shop' ),
        'Open Sans' => __( 'Open Sans', 'feminine-shop' ),
        'Overpass' => __( 'Overpass', 'feminine-shop' ),
        'Overpass Mono' => __( 'Overpass Mono', 'feminine-shop' ),
        'Oxygen' => __( 'Oxygen', 'feminine-shop' ),
        'Orbitron' => __( 'Orbitron', 'feminine-shop' ),
        'Patua One' => __( 'Patua One', 'feminine-shop' ),
        'Pacifico' => __( 'Pacifico', 'feminine-shop' ),
        'Padauk' => __( 'Padauk', 'feminine-shop' ),
        'Playball' => __( 'Playball', 'feminine-shop' ),
        'Playfair Display' => __( 'Playfair Display', 'feminine-shop' ),
        'PT Sans' => __( 'PT Sans', 'feminine-shop' ),
        'Philosopher' => __( 'Philosopher', 'feminine-shop' ),
        'Permanent Marker' => __( 'Permanent Marker', 'feminine-shop' ),
        'Poiret One' => __( 'Poiret One', 'feminine-shop' ),
        'Quicksand' => __( 'Quicksand', 'feminine-shop' ),
        'Quattrocento Sans' => __( 'Quattrocento Sans', 'feminine-shop' ),
        'Raleway' => __( 'Raleway', 'feminine-shop' ),
        'Rubik' => __( 'Rubik', 'feminine-shop' ),
        'Rokkitt' => __( 'Rokkitt', 'feminine-shop' ),
        'Russo One' => __( 'Russo One', 'feminine-shop' ),
        'Righteous' => __( 'Righteous', 'feminine-shop' ),
        'Slabo' => __( 'Slabo', 'feminine-shop' ),
        'Source Sans Pro' => __( 'Source Sans Pro', 'feminine-shop' ),
        'Shadows Into Light Two' => __( 'Shadows Into Light Two', 'feminine-shop'),
        'Shadows Into Light' => __( 'Shadows Into Light', 'feminine-shop' ),
        'Sacramento' => __( 'Sacramento', 'feminine-shop' ),
        'Shrikhand' => __( 'Shrikhand', 'feminine-shop' ),
        'Tangerine' => __( 'Tangerine', 'feminine-shop' ),
        'Ubuntu' => __( 'Ubuntu', 'feminine-shop' ),
        'VT323' => __( 'VT323', 'feminine-shop' ),
        'Varela Round' => __( 'Varela Round', 'feminine-shop' ),
        'Vampiro One' => __( 'Vampiro One', 'feminine-shop' ),
        'Vollkorn' => __( 'Vollkorn', 'feminine-shop' ),
        'Volkhov' => __( 'Volkhov', 'feminine-shop' ),
        'Yanone Kaffeesatz' => __( 'Yanone Kaffeesatz', 'feminine-shop' )
		);
	}

	/**
	 * Returns the available font weights.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_font_weight_choices() {

		return array(
			'' => esc_html__( 'No Fonts weight', 'feminine-shop' ),
			'100' => esc_html__( 'Thin',       'feminine-shop' ),
			'300' => esc_html__( 'Light',      'feminine-shop' ),
			'400' => esc_html__( 'Normal',     'feminine-shop' ),
			'500' => esc_html__( 'Medium',     'feminine-shop' ),
			'700' => esc_html__( 'Bold',       'feminine-shop' ),
			'900' => esc_html__( 'Ultra Bold', 'feminine-shop' ),
		);
	}

	/**
	 * Returns the available font styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_font_style_choices() {

		return array(
			'' => esc_html__( 'No Fonts Style', 'feminine-shop' ),
			'normal'  => esc_html__( 'Normal', 'feminine-shop' ),
			'italic'  => esc_html__( 'Italic', 'feminine-shop' ),
			'oblique' => esc_html__( 'Oblique', 'feminine-shop' )
		);
	}
}
