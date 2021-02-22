<?php
/**
 * The template part for header
 *
 * @package Feminine Shop 
 * @subpackage feminine-shop
 * @since feminine-shop 1.0
 */
?>

<div id="header" class="p-2 p-lg-0 p-md-0">
  <?php if(has_nav_menu('primary')){ ?>
    <div class="toggle-nav mobile-menu text-md-right my-md-2">
      <button role="tab" onclick="feminine_shop_menu_open_nav()" class="responsivetoggle"><i class="fas fa-bars p-3"></i><span class="screen-reader-text"><?php esc_html_e('Open Button','feminine-shop'); ?></span></button>
    </div>
  <?php } ?>
  <div id="mySidenav" class="nav sidenav">
    <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'feminine-shop' ); ?>">
      <?php if(has_nav_menu('primary')){
        wp_nav_menu( array( 
          'theme_location' => 'primary',
          'container_class' => 'main-menu my-3 clearfix' ,
          'menu_class' => 'clearfix',
          'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
          'fallback_cb' => 'wp_page_menu',
        ) );
      } ?>
      <a href="javascript:void(0)" class="closebtn mobile-menu" onclick="feminine_shop_menu_close_nav()"><i class="fas fa-times"></i><span class="screen-reader-text"><?php esc_html_e('Close Button','feminine-shop'); ?></span></a>
    </nav>
  </div>
</div>