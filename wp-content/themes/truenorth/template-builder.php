<?php
/*
 * Template Name: Page builder
 */
?>

<?php get_header(); ?>

<main class="main-builder main-builder-contained">
	<?php while ( have_posts() ) : the_post(); ?>
		<div class="builder-content">
			<?php the_content(); ?>
		</div>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
