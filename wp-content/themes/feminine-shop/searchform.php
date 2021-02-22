<?php
/**
 * The template for displaying search forms in feminine-shop
 *
 * @package Feminine Shop
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_attr_x( 'Search for:', 'label', 'feminine-shop' ); ?></span>
		<input type="search" class="search-field px-3 py-2" placeholder="<?php echo esc_attr_x( 'SEARCH', 'placeholder','feminine-shop' ); ?>" value="<?php echo esc_attr( get_search_query()); ?>" name="s">
	</label>
	<input type="submit" class="search-submit p-3" value="<?php echo esc_attr_x( 'SEARCH', 'submit button','feminine-shop' ); ?>">
</form>