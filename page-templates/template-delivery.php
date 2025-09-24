<?php
/**
 * Template Name: Delivery Template
 *
 * This is the template for the delivery/locations page.
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

?>

<div id="delivery-wrapper">
	<main id="main" class="site-main" role="main">

		<section id="delivery-hero" class="delivery-section">
			<div class="container text-center">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/pixel-flower-red.png" alt="Flor Roja Pixelada" class="pixel-flower">
				<h1 class="display-4">Domicilio</h1>
				<div class="hero-layer-pink-container">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/hero-layer.png" alt="Capa Rosa" class="hero-layer-pink">
				</div>
			</div>
		</section>

		<section id="locations" class="delivery-section">
			<div class="container">
				<h2 class="text-center location-title">Elige una <br>ubicación</h2>
				<div class="row justify-content-center">
					<div class="col-lg-5">
						<a href="/domicilio-nogal" class="location-card-link">
							<div class="location-card nogal">
								<div class="card-header">
									<h3>Sede Nogal</h3>
									<span class="arrow">→</span>
								</div>
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/sede-nogal.jpg" alt="Sede Nogal">
								<div class="card-body">
									<p>Desde la carrera 1 con 24<br>hasta la carrera 90 con 20</p>
									<p>
										Carrera 11 #76-70<br>
										WhatsApp: +57 322 2112325<br>
										Teléfono: (601) 312 9887 o (601) 300 2326<br>
										Correo: contacto@chicano.com.co
									</p>
								</div>
							</div>
						</a>
					</div>
					<div class="col-lg-5">
						<a href="/domicilio-castellana" class="location-card-link">
							<div class="location-card castellana">
								<div class="card-header">
									<h3>Sede Castellana</h3>
									<span class="arrow">→</span>
								</div>
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/sede-castellana.jpg" alt="Sede Castellana">
								<div class="card-body">
									<p>Desde la carrera 1 con 24<br>hasta la carrera 90 con 20</p>
									<p>
										Carrera 47 #94-56<br>
										WhatsApp: +57 310 6878901<br>
										Teléfono: (310) 687 8901 o (601) 300 0780<br>
										Correo: castellana@chicanos.com.co
									</p>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
			<div class="delivery-background-pattern"></div>
		</section>

	</main><!-- #main -->
</div><!-- #delivery-wrapper -->

<?php get_footer(); ?>
