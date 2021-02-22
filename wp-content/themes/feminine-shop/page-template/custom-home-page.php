<?php
/**
 * Template Name: Custom Home Page
 */

get_header(); ?>

<main id="maincontent" role="main">
  <?php do_action( 'feminine_shop_before_slider' ); ?>

  <?php if( get_theme_mod('feminine_shop_slider_arrows') != ''){ ?>
    <section id="slider">
      <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
        <?php $feminine_shop_pages = array();
          for ( $count = 1; $count <= 3; $count++ ) {
            $mod = intval( get_theme_mod( 'feminine_shop_slider_page' . $count ));
            if ( 'page-none-selected' != $mod ) {
              $feminine_shop_pages[] = $mod;
            }
          }
          if( !empty($feminine_shop_pages) ) :
            $args = array(
              'post_type' => 'page',
              'post__in' => $feminine_shop_pages,
              'orderby' => 'post__in'
            );
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) :
              $i = 1;
        ?>
        <div class="carousel-inner" role="listbox">
          <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <div <?php if($i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
              <?php the_post_thumbnail(); ?>
              <div class="carousel-caption pt-0">
                <div class="inner_carousel">
                  <h1 class="mb-0 py-0"><?php the_title(); ?></h1>
                  <p class="my-3"><?php $excerpt = get_the_excerpt(); echo esc_html( feminine_shop_string_limit_words( $excerpt, esc_attr(get_theme_mod('feminine_shop_slider_excerpt_number','25')))); ?></p>
                  <div class="more-btn mt-3 mb-3 mt-lg-5 mb-lg-5 mt-md-5 mb-md-5">
                    <a class="px-3 py-2 px-lg-4 py-lg-3 px-md-4 py-md-3" href="<?php the_permalink(); ?>"><?php esc_html_e('EXPLORE NOW','feminine-shop');?><i class="fas fa-angle-double-right"></i><span class="screen-reader-text"><?php esc_html_e('EXPLORE NOW','feminine-shop'); ?></span></a>
                  </div>
                </div>
              </div>
            </div>
          <?php $i++; endwhile; 
          wp_reset_postdata();?>
        </div>
        <?php else : ?>
          <div class="no-postfound"></div>
        <?php endif;
        endif;?>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon px-2 py-1 px-lg-3 py-lg-2 px-md-3 py-md-2" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
          <span class="screen-reader-text"><?php esc_html_e('Previous','feminine-shop'); ?></span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon px-2 py-1 px-lg-3 py-lg-2 px-md-3 py-md-2" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
          <span class="screen-reader-text"><?php esc_html_e('Next','feminine-shop'); ?></span>
        </a>
      </div>
      <div class="clearfix"></div>
    </section>
  <?php }?>

  <?php do_action( 'feminine_shop_after_slider' ); ?>

  <section id="about-us" class="py-5 text-center text-md-left">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-4">
        <?php if( get_theme_mod( 'feminine_shop_about_section_title') != '') { ?>
          <strong><?php echo esc_html(get_theme_mod('feminine_shop_about_section_title',''));?></strong>
        <?php } ?>
        <?php $feminine_shop_product_page = array();
          $mod = absint( get_theme_mod( 'feminine_shop_about_page','feminine-shop'));
          if ( 'page-none-selected' != $mod ) {
            $feminine_shop_product_page[] = $mod;
          }
          if( !empty($feminine_shop_product_page) ) :
            $args = array(
              'post_type' => 'page',
              'post__in' => $feminine_shop_product_page,
              'orderby' => 'post__in'
            );
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) :
              $count = 0;
              while ( $query->have_posts() ) : $query->the_post(); ?>
                <h3><?php the_title(); ?></h3>
                <p><?php $excerpt = get_the_excerpt(); echo esc_html( feminine_shop_string_limit_words( $excerpt, esc_attr(get_theme_mod('feminine_shop_slider_excerpt_number','30')))); ?></p>
                <div class="more-btn mt-3 mb-3 mt-lg-5 mb-lg-5 mt-md-5 mb-md-5">
                  <a class="px-3 py-2 px-lg-4 py-lg-3 px-md-4 py-md-3" href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html('KNOW MORE','feminine-shop');?><i class="fas fa-angle-double-right"></i><span class="screen-reader-text"><?php echo esc_html('KNOW MORE','feminine-shop');?></span></a>
                </div>
              <?php endwhile; ?>
            <?php else : ?>
              <div class="no-postfound"></div>
            <?php endif;
          endif;
          wp_reset_postdata()
        ?>
      </div>
      <div class="col-lg-8 col-md-8">
        <?php $feminine_shop_product_page = array();
          $mod = absint( get_theme_mod( 'feminine_shop_products_page','feminine-shop'));
          if ( 'page-none-selected' != $mod ) {
            $feminine_shop_product_page[] = $mod;
          }
          if( !empty($feminine_shop_product_page) ) :
            $args = array(
              'post_type' => 'page',
              'post__in' => $feminine_shop_product_page,
              'orderby' => 'post__in'
            );
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) :
              $count = 0;
              while ( $query->have_posts() ) : $query->the_post(); ?>
                <?php the_content(); ?>
              <?php endwhile; ?>
            <?php else : ?>
              <div class="no-postfound"></div>
            <?php endif;
          endif;
          wp_reset_postdata()
        ?>
      </div>
    </div>
  </div>
  </section>

  <?php do_action( 'feminine_shop_after_service' ); ?>

  <div id="content-vw">
    <div class="container">
      <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; // end of the loop. ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>