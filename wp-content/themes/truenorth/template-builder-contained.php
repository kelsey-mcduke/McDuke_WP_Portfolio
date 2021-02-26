<?php
/*
 * Template Name: Page Builder Contained
 */
?>

<?php get_header(); ?>

<main class="main-builder main-builder-contained">
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="builder-content">
						<?php the_content(); ?>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
</main>

<?php get_footer();
