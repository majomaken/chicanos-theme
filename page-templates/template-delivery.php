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
			<!-- Carousel Container -->
			<div class="carousel-container">
				<div class="carousel-slides">
					<div class="carousel-slide active">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/1-carrusel-domicilio.webp" alt="Carrusel Domicilio 1">
					</div>
					<div class="carousel-slide">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/2-carrusel-domicilio.webp" alt="Carrusel Domicilio 2">
					</div>
					<div class="carousel-slide">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/3-carrusel-domicilio.webp" alt="Carrusel Domicilio 3">
					</div>
					<div class="carousel-slide">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/4-carrusel-domicilio.webp" alt="Carrusel Domicilio 4">
					</div>
					<div class="carousel-slide">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/5-carrusel-domicilio.webp" alt="Carrusel Domicilio 5">
					</div>
				</div>
				<!-- Carousel Indicators -->
				<div class="carousel-indicators">
					<span class="indicator active" data-slide="0"></span>
					<span class="indicator" data-slide="1"></span>
					<span class="indicator" data-slide="2"></span>
					<span class="indicator" data-slide="3"></span>
					<span class="indicator" data-slide="4"></span>
				</div>
			</div>
			
			<div class="container text-center">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/pixel-flower-red.webp" alt="Flor Roja Pixelada" class="pixel-flower">
				<h1 class="display-4">Domicilios</h1>
				<div class="hero-layer-pink-container">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/hero-layer.webp" alt="Capa Rosa" class="hero-layer-pink">
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
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/sede-nogal.webp" alt="Sede Nogal">
								<div class="card-body">
									<p><strong>Dirección:</strong><br>Carrera 11 #78-70</p>
									<p><strong>Zona de distribución:</strong><br>Desde la calle 45 hasta la calle 150<br>y desde la Carrera 0 hasta la Carrera 30</p>
									<p><strong>Barrios:</strong><br>• El retiro • Nogal • Chapinero • Chico<br>• Rosales • Parkway • Nicolas de Federman<br>• Gallerias • Cedritos • Santa Bárbara y Santa Ana</p>
									<p><strong>Horarios:</strong><br>11am a 6:00pm de lunes a jueves<br>11am a 7:00pm viernes y sábado<br>11am a 4:00 domingo</p>
									<p><strong>Contacto:</strong><br>WhatsApp: +57 322 2112325<br>Teléfono: (601) 312 9887 o (601) 300 2326<br>Correo: contacto@chicanos.com.co</p>
									<p><strong>Rango de entrega:</strong><br>2 horas (pedir con 2 horas de anticipación)</p>
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
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/sede-castellana.webp" alt="Sede Castellana">
								<div class="card-body">
									<p><strong>Dirección:</strong><br>Carrera 47 #94-56</p>
									<p><strong>Zona de distribución:</strong><br>Desde la Calle 94 hasta la Calle 170<br>y desde la Carrera 30 hasta la Avenida Boyacá</p>
									<p><strong>Barrios:</strong><br>• Suba • Cedritos • San José de Babaria<br>• La floresta • Colina Campestre • Lagos de Córdoba<br>• Salitre • Santa Bárbara y Santa Ana • El Batán</p>
									<p><strong>Horarios:</strong><br>11am a 6:00pm de lunes a jueves<br>10am a 6:00pm viernes y sábado<br>10am a 3:00 domingo</p>
									<p><strong>Contacto:</strong><br>WhatsApp: +57 310 6878901<br>Teléfono: (310) 687 8901 o (601) 300 0780<br>Correo: castellana@chicanos.com.co</p>
									<p><strong>Rango de entrega:</strong><br>2 horas (pedir con 2 horas de anticipación)</p>
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
