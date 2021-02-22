<?php
/**
 * The template for displaying the Front Page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Feminine Shop
 * @subpackage Feminine Shop Child
 */

get_header(); ?>

<main id="maincontent" class="middle-align pt-5" role="main"> 
    <div class="landing-hero">
    <?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
				<a class="work-button" href="<?php echo site_url('/blog/') ?>">Check Out My Work</a>
			<?php endwhile; // end of the loop. ?>
    </div>
</main>

<?php do_action( 'feminine_shop_page_bottom' ); ?>

<?php get_footer(); ?>