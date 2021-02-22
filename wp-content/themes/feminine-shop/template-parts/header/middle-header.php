<?php
/**
 * The template part for top header
 *
 * @package Feminine Shop
 * @subpackage feminine-shop
 * @since feminine-shop 1.0
 */
?>

<div class="middle-bar text-center text-lg-left text-md-left py-2">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-4 col-9">
        <div class="logo">
          <?php if ( has_custom_logo() ) : ?>
            <div class="site-logo"><?php the_custom_logo(); ?></div>
          <?php endif; ?>
          <?php $blog_info = get_bloginfo( 'name' ); ?>
            <?php if ( ! empty( $blog_info ) ) : ?>
              <?php if ( is_front_page() && is_home() ) : ?>
                <?php if( get_theme_mod('feminine_shop_logo_title_hide_show',true) != ''){ ?>
                  <h1 class="site-title py-1"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php } ?>
              <?php else : ?>
                <?php if( get_theme_mod('feminine_shop_logo_title_hide_show',true) != ''){ ?>
                  <p class="site-title py-1 mb-0"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                <?php } ?>
              <?php endif; ?>
            <?php endif; ?>
            <?php
              $description = get_bloginfo( 'description', 'display' );
              if ( $description || is_customize_preview() ) :
            ?>
            <?php if( get_theme_mod('feminine_shop_tagline_hide_show',true) != ''){ ?>
              <p class="site-description mb-0">
                <?php echo esc_html($description); ?>
              </p>
            <?php } ?>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-lg-7 col-md-4 col-3">
        <?php get_template_part('template-parts/header/navigation'); ?>
      </div>
      <div class="col-lg-2 col-md-4">
        <?php dynamic_sidebar('social-links'); ?>
        <?php if(class_exists('woocommerce')){ ?>
          <span class="cart_no">
            <a href="<?php if(function_exists('wc_get_cart_url')){ echo esc_url(wc_get_cart_url()); } ?>" title="<?php esc_attr_e( 'shopping cart','feminine-shop' ); ?>"><i class="fas fa-shopping-basket px-2 py-2 rounded-circle"></i><span class="screen-reader-text"><?php esc_html_e( 'shopping cart','feminine-shop' );?></span></a>
            <span class="cart-value px-1 rounded-circle"> <?php echo wp_kses_data( WC()->cart->get_cart_contents_count() );?></span>
          </span>
        <?php } ?>
      </div>
    </div>
  </div>
</div>