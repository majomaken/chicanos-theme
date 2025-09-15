<?php
/**
 * Understrap enqueue scripts
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'understrap_scripts' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
	function understrap_scripts() {
		// Get the theme data.
		$the_theme         = wp_get_theme();
		$theme_version     = $the_theme->get( 'Version' );
		$bootstrap_version = get_theme_mod( 'understrap_bootstrap_version', 'bootstrap4' );
		$suffix            = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Grab asset urls.
		$theme_styles  = "/css/theme{$suffix}.css";
		$theme_scripts = "/js/theme{$suffix}.js";
		if ( 'bootstrap4' === $bootstrap_version ) {
			$theme_styles  = "/css/theme-bootstrap4{$suffix}.css";
			$theme_scripts = "/js/theme-bootstrap4{$suffix}.js";
		}

		$css_version = $theme_version . '.' . filemtime( get_template_directory() . $theme_styles );
		wp_enqueue_style( 'understrap-styles', get_template_directory_uri() . $theme_styles, array(), $css_version );
		wp_enqueue_style( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.4' );
				wp_enqueue_style( 'chicanos-custom-styles', get_template_directory_uri() . '/css/custom.css', array('understrap-styles'), $css_version );
		wp_enqueue_style( 'chicanos-image-fixes', get_template_directory_uri() . '/css/image-fixes.css', array('chicanos-custom-styles'), $css_version );

		if ( is_page_template( 'page-templates/template-homepage.php' ) ) {
			$homepage_css_version = $css_version . '.' . time();
			wp_enqueue_style( 'chicanos-homepage-styles', get_template_directory_uri() . '/css/homepage.css', array('chicanos-custom-styles'), $homepage_css_version );
		}

		if ( is_page_template( 'page-templates/template-distribution.php' ) ) {
			wp_enqueue_style( 'chicanos-distribution-styles', get_template_directory_uri() . '/css/distribution.css', array('chicanos-custom-styles'), $css_version );
		}

		if ( is_page_template( 'page-templates/template-delivery.php' ) ) {
			wp_enqueue_style( 'chicanos-delivery-styles', get_template_directory_uri() . '/css/delivery.css', array('chicanos-custom-styles'), $css_version );
		}

		if ( is_page_template( 'page-templates/template-domicilio-nogal.php' ) ) {
			wp_enqueue_style( 'chicanos-domicilio-nogal-styles', get_template_directory_uri() . '/css/domicilio-nogal.css', array('chicanos-custom-styles'), $css_version );
		}

		if ( is_page_template( 'page-templates/template-domicilio-castellana.php' ) ) {
			wp_enqueue_style( 'chicanos-domicilio-castellana-styles', get_template_directory_uri() . '/css/domicilio-castellana.css', array('chicanos-custom-styles'), $css_version );
		}

		if ( is_page_template( 'page-templates/template-under-construction.php' ) ) {
			wp_enqueue_style( 'chicanos-under-construction-styles', get_template_directory_uri() . '/css/under-construction.css', array('chicanos-custom-styles'), $css_version );
		}

		if ( is_page_template( 'page-templates/template-combos-para-llevar.php' ) ) {
			wp_enqueue_style( 'chicanos-combos-para-llevar-styles', get_template_directory_uri() . '/css/combos-para-llevar.css', array('chicanos-custom-styles'), $css_version );
		}

		if ( is_page_template( 'page-templates/template-combos-para-llevar-4-6.php' ) ) {
			wp_enqueue_style( 'chicanos-combos-para-llevar-4-6-styles', get_template_directory_uri() . '/css/combos-para-llevar-4-6.css', array('chicanos-custom-styles'), $css_version );
		}

		if ( is_page_template( 'page-templates/template-combos-para-llevar-7-10.php' ) ) {
			wp_enqueue_style( 'chicanos-combos-para-llevar-7-10-styles', get_template_directory_uri() . '/css/combos-para-llevar-7-10.css', array('chicanos-custom-styles'), $css_version );
		}

		if ( is_page_template( 'page-templates/template-burritos.php' ) ) {
			wp_enqueue_style( 'chicanos-burritos-styles', get_template_directory_uri() . '/css/burritos.css', array('chicanos-custom-styles'), $css_version );
		}

		if ( is_page_template( 'page-templates/template-ensaladas.php' ) ) {
			wp_enqueue_style( 'chicanos-combos-para-llevar-styles', get_template_directory_uri() . '/css/combos-para-llevar.css', array('chicanos-custom-styles'), $css_version );
		}

		if ( is_page_template( 'page-templates/template-adiciones.php' ) ) {
			wp_enqueue_style( 'chicanos-adiciones-styles', get_template_directory_uri() . '/css/adiciones.css', array('chicanos-custom-styles'), $css_version );
			// DEBUG: CSS de adiciones cargado
		}

		// Fix that the offcanvas close icon is hidden behind the admin bar.
		if ( 'bootstrap4' !== $bootstrap_version && is_admin_bar_showing() ) {
			understrap_offcanvas_admin_bar_inline_styles();
		}

		wp_enqueue_script( 'jquery' );

		$js_version = $theme_version . '.' . filemtime( get_template_directory() . $theme_scripts );
		wp_enqueue_script( 'understrap-scripts', get_template_directory_uri() . $theme_scripts, array(), $js_version, true );
		
		// Enqueue mobile menu script
		wp_enqueue_script( 'chicanos-mobile-menu', get_template_directory_uri() . '/js/mobile-menu.js', array('jquery'), $theme_version, true );
		
		// Enqueue domicilio nogal script for specific template
		if ( is_page_template( 'page-templates/template-domicilio-nogal.php' ) ) {
			wp_enqueue_script( 'chicanos-domicilio-nogal', get_template_directory_uri() . '/js/domicilio-nogal.min.js', array('jquery'), $theme_version, true );
		}
		
		// Enqueue domicilio castellana script for specific template
		if ( is_page_template( 'page-templates/template-domicilio-castellana.php' ) ) {
			wp_enqueue_script( 'chicanos-domicilio-castellana', get_template_directory_uri() . '/js/domicilio-castellana.min.js', array('jquery'), $theme_version, true );
		}
		
		// Enqueue combos para llevar script for specific template
		if ( is_page_template( 'page-templates/template-combos-para-llevar.php' ) ) {
			// Comentado temporalmente - el JavaScript está inline en el template
			// wp_enqueue_script( 'chicanos-combos-para-llevar', get_template_directory_uri() . '/js/combos-para-llevar.js', array('jquery'), $theme_version, true );
		}
		
		// Enqueue burritos script for specific template
		if ( is_page_template( 'page-templates/template-burritos.php' ) ) {
			wp_enqueue_script( 'chicanos-combos-para-llevar', get_template_directory_uri() . '/js/combos-para-llevar.js', array('jquery'), $theme_version, true );
		}
		
		// Enqueue ensaladas script for specific template
		if ( is_page_template( 'page-templates/template-ensaladas.php' ) ) {
			wp_enqueue_script( 'chicanos-combos-para-llevar', get_template_directory_uri() . '/js/combos-para-llevar.js', array('jquery'), $theme_version, true );
		}
		
		// Enqueue adiciones script for specific template
		if ( is_page_template( 'page-templates/template-adiciones.php' ) ) {
			// No cargar combos-para-llevar.js para adiciones, ya que tiene su propio JavaScript inline
			
			// Enqueue WooCommerce scripts for cart functionality
			if ( class_exists( 'WooCommerce' ) ) {
				wp_enqueue_script( 'wc-add-to-cart' );
				wp_enqueue_script( 'wc-cart-fragments' );
			}
		}
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
} // End of if function_exists( 'understrap_scripts' ).

add_action( 'wp_enqueue_scripts', 'understrap_scripts' );

if ( ! function_exists( 'understrap_offcanvas_admin_bar_inline_styles' ) ) {
	/**
	 * Add inline styles for the offcanvas component if the admin bar is visible.
	 *
	 * Fixes that the offcanvas close icon is hidden behind the admin bar.
	 *
	 * @since 1.2.0
	 */
	function understrap_offcanvas_admin_bar_inline_styles() {
		$navbar_type = get_theme_mod( 'understrap_navbar_type', 'collapse' );
		if ( 'offcanvas' !== $navbar_type ) {
			return;
		}

		$css = '
		body.admin-bar .offcanvas.show  {
			margin-top: 32px;
		}
		@media screen and ( max-width: 782px ) {
			body.admin-bar .offcanvas.show {
				margin-top: 46px;
			}
		}';
		wp_add_inline_style( 'understrap-styles', $css );
	}
}
