<?php
/**
 * Template Name: Distribution Template
 *
 * This template is for the tortillas distribution page.
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

?>

<div id="distribution-wrapper">
	<main id="main" class="site-main" role="main">

		<section id="distribution-hero" class="distribution-section">
			<div class="container text-center">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/yellow-flower.webp" alt="Flor Amarilla" class="yellow-flower">
				<h1 class="display-4">Distribución de Tortillas</h1>
				<div class="hero-layer-green-container">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/hero-layer-green.webp" alt="Capa Verde" class="hero-layer-green">
				</div>
			</div>
		</section>

		<section id="distribution-intro" class="distribution-section content-section">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-6">
						<h2 class="section-title">En Chicanos no solo servimos<br>nuestras tortillas en el restaurante—<br>también las distribuimos a otros<br>negocios gastronómicos.</h2>
						<p class="section-subtitle">Elaboramos tortillas artesanales personalizadas, adaptadas a las necesidades de cada cliente.</p>
					</div>
					<div class="col-lg-6 text-center">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/flowers-cross-layer.webp" alt="Adorno Floral" class="img-fluid">
					</div>
				</div>
			</div>
		</section>

		<section id="production-types" class="distribution-section text-center">
			<div class="container">
				<h3 class="section-title-alt">Podemos producirlas:</h3>
				<div class="row">
					<div class="col-md-4 production-item">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/maiz-item.webp" alt="Maíz o Trigo">
						<p>En maíz o trigo</p>
					</div>
					<div class="col-md-4 production-item">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/tortillas-item.webp" alt="Tamaño de Tortillas">
						<p>Del tamaño<br>que necesites</p>
					</div>
					<div class="col-md-4 production-item">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/tortilla-item.webp" alt="Grosor de Tortilla">
						<p>Con el grosor<br>que prefieras</p>
					</div>
				</div>
			</div>
		</section>

		<section id="distribution-section-4" class="distribution-section professional-clients">
			<div class="container text-center">
				<p class="clients-text">Trabajamos con restaurantes, hoteles y cocinas profesionales que valoran un producto fresco, hecho a la medida y con todo el sabor de México.</p>
				<div class="restaurant-logos-grid">
					<div class="logo-row">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/1-crepes-waffles-seeklogo.webp" alt="Crepes & Waffles" class="restaurant-logo">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/2-Club el nogal logo.webp" alt="Club El Nogal" class="restaurant-logo">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/3-logo_DLK.webp" alt="DLK" class="restaurant-logo">
					</div>
					<div class="logo-row">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/4-gun_club_logo.webp" alt="Gun Club" class="restaurant-logo">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/7-Logo club los lagartos.webp" alt="Club Los Lagartos" class="restaurant-logo">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/6-la-taqueria logo.webp" alt="La Taquería" class="restaurant-logo">
					</div>
				</div>
			</div>
		</section>

		<section id="distribution-section-5" class="distribution-section cta-section text-center">
			<div class="container">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/flower-red.webp" alt="Flor Roja" class="cta-flower">
				<h2>¿Te interesa tener nuestras<br>tortillas en tu negocio?</h2>
				<p>Escríbenos para una muestra o una<br>cotización personalizada.</p>
				<a href="#" class="btn btn-contact">Contacto</a>
			</div>
		</section>

	</main><!-- #main -->
</div><!-- #distribution-wrapper -->

<?php get_footer(); ?>
