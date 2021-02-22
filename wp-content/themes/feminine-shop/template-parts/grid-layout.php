<?php
/**
 * The template part for displaying grid post
 *
 * @package Feminine Shop
 * @subpackage feminine-shop
 * @since feminine-shop 1.0
 */
?>

<div class="col-lg-4 col-md-6">
	<article id="post-<?php the_ID(); ?>" <?php post_class('inner-service'); ?>>
	    <div class="post-main-box p-3 mb-3">
	      	<div class="box-image">
	          	<?php 
		            if(has_post_thumbnail()) { 
		              the_post_thumbnail(); 
		            }
	          	?>
	        </div>
	        <h2 class="section-title mt-0 pt-0"><a href="<?php the_permalink(); ?>"><?php the_title();?><span class="screen-reader-text"><?php the_title(); ?></span></a></h2>
	        <div class="new-text">
	        	<p>
			        <?php $excerpt = get_the_excerpt(); echo esc_html( feminine_shop_string_limit_words( $excerpt, esc_attr(get_theme_mod('feminine_shop_excerpt_number','30')))); ?> <?php echo esc_html( get_theme_mod('feminine_shop_excerpt_suffix','') ); ?>
	        	</p>
	        </div>
	        <?php if( get_theme_mod('feminine_shop_button_text','READ MORE') != ''){ ?>
	          <div class="more-btn mt-4 mb-4">
	            <a class="p-3" href="<?php the_permalink(); ?>"><?php echo esc_html(get_theme_mod('feminine_shop_button_text',__('READ MORE','feminine-shop')));?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('feminine_shop_button_text',__('READ MORE','feminine-shop')));?></span></a>
	          </div>
	        <?php } ?>
	    </div>
	    <div class="clearfix"></div>
  	</article>
</div>