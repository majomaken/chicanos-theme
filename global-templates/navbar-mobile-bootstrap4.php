<?php
/**
 * Header Navbar Mobile (bootstrap4)
 *
 * @package Understrap
 * @since 1.1.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

<nav id="main-nav" class="navbar navbar-expand-md mobile-navbar" aria-labelledby="main-nav-label">

	<h2 id="main-nav-label" class="screen-reader-text">
		<?php esc_html_e( 'Main Navigation', 'understrap' ); ?>
	</h2>

	<div class="d-flex justify-content-between align-items-center w-100 container">
		<!-- Hamburger Menu Button -->
		<button class="navbar-toggler mobile-menu-toggle" type="button" aria-controls="mobileMenu" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<!-- Logo -->
		<div class="navbar-brand-container">
			<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url">
				<img src="<?php echo get_template_directory_uri(); ?>/img/Logochicanos%201.webp" alt="<?php bloginfo( 'name' ); ?>" class="navbar-logo">
			</a>
		</div>

		<!-- Icons -->
		<div class="navbar-icons">
			<a href="#" class="navbar-icon"><i class="fas fa-map-marker-alt"></i></a>
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<a href="<?php echo wc_get_cart_url(); ?>" class="navbar-icon"><i class="fas fa-shopping-bag"></i></a>
			<?php endif; ?>
		</div>
	</div>

	<!-- Mobile Menu Collapse -->
	<div class="mobile-menu-wrapper" id="mobileMenu">
		<div class="mobile-menu-container">
			<?php
			wp_nav_menu(
				array(
					'theme_location'  => 'primary',
					'container'       => false,
					'menu_class'      => 'navbar-nav mobile-nav',
					'fallback_cb'     => '',
					'menu_id'         => 'mobile-menu',
					'depth'           => 2,
					'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
				)
			);
			?>
		</div>
	</div>

</nav><!-- #main-nav -->
