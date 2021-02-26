<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="searchform" method="get" role="search">
	<div>
		<label for="s" class="screen-reader-text"><?php esc_html_e( 'Search for:', 'truenorth' ); ?></label>
		<input type="text" placeholder="<?php esc_attr_e( 'Search', 'truenorth' ); ?>" id="s" name="s" value="<?php echo get_search_query(); ?>">
		<button class="searchsubmit" type="submit"><i class="fas fa-search"></i><span class="screen-reader-text"><?php esc_html_e( 'Search', 'truenorth' ); ?></span></button>
	</div>
</form>
