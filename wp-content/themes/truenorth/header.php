<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page">
	<header class="header">

		<div class="nav-hold">
			<nav class="main-nav nav">
				<?php wp_nav_menu( array(
					'theme_location' => 'main_menu',
					'fallback_cb'    => 'truenorth_main_menu_fallback',
					'container'      => '',
					'menu_id'        => '',
					'menu_class'     => 'navigation',
				) ); ?>
			</nav>

			<div id="mobilemenu"></div>
			<a class="menu-trigger" href="#mobilemenu"><i class="fas fa-bars"></i></a>
		</div><!-- /.nav-hold -->

		<div class="hero">
			<div class="logo <?php echo esc_attr( ci_setting( 'logo' ) ? 'imglogo' : 'textual' ); ?>">
				<?php ci_e_logo( '<p class="site-logo">', '</p>' ); ?>
				<?php ci_e_slogan( '<p class="site-tagline">', '</p>' ); ?>
			</div><!-- /.logo -->
		</div><!-- /.hero -->

	</header>

	<?php if ( ! is_page_template( 'template-builder.php' ) && ! is_page_template( 'template-builder-contained.php' ) ) : ?>
		<main class="main">
			<div class="container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
	<?php endif; ?>
