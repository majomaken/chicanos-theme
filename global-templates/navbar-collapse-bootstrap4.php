<?php
/**
 * Header Navbar (bootstrap4)
 *
 * @package Understrap
 * @since 1.1.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

<nav id="main-nav" class="navbar navbar-expand-md" aria-labelledby="main-nav-label">

	<h2 id="main-nav-label" class="screen-reader-text">
		<?php esc_html_e( 'Main Navigation', 'understrap' ); ?>
	</h2>

	<div class="d-flex justify-content-between align-items-center w-100 container">
		<div class="navbar-brand-container">
			<?php
			if ( ! has_custom_logo() ) {
				if ( is_front_page() && is_home() ) :
					?>
					<h1 class="navbar-brand mb-0">
						<a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url">
							<?php bloginfo( 'name' ); ?>
						</a>
					</h1>
					<?php
				else :
					?>
					<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url">
						<?php bloginfo( 'name' ); ?>
					</a>
					<?php
				endif;
			} else {
				the_custom_logo();
			}
			?>
		</div>

		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'primary',
				'container'       => false,
				'menu_class'      => 'navbar-nav mx-auto',
				'fallback_cb'     => '',
				'menu_id'         => 'main-menu',
				'depth'           => 2,
				'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
			)
		);
		?>

		<div class="navbar-icons">
			<a href="#" class="navbar-icon"><i class="fas fa-map-marker-alt"></i></a>
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<a href="<?php echo wc_get_cart_url(); ?>" class="navbar-icon"><i class="fas fa-shopping-bag"></i></a>
			<?php endif; ?>
		</div>
	</div>

</nav><!-- #main-nav -->
