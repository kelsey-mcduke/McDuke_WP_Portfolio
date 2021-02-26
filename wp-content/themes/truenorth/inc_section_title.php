<?php
	$_title = ci_setting( 'title_blog' );

	if ( is_home() || is_singular( 'post' ) ) {
		$_title = ci_setting( 'title_blog' );
	} elseif ( is_singular() ) {
		$_title = single_post_title( '', false );
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$_title = single_term_title( '', false );
	} elseif ( is_month() ) {
		$_title = single_month_title( '', false );
	} elseif ( is_search() ) {
		$_title = ci_setting( 'title_search' );
	} elseif ( is_404() ) {
		$_title = ci_setting( 'title_404' );
	}

?>
<h2 class="section-title"><?php echo wp_kses_post( $_title ); ?></h2>
