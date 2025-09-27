<?php
/**
 * Template Name: Homepage Template
 *
 * This is the template that displays all of the sections for the homepage.
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

?>

<style>
/* Inline CSS to ensure image dimensions are applied - HIGHEST PRIORITY */
#homepage-wrapper #home-section-1 .card-link img,
#homepage-wrapper .card-link img,
.card-link img {
    width: 400px !important;
    height: 360px !important;
    max-width: 400px !important;
    max-height: 360px !important;
    min-width: 400px !important;
    min-height: 360px !important;
    object-fit: cover !important;
    flex-shrink: 0 !important;
    border-radius: 0 !important;
}

/* Ensure cards maintain proper structure */
#home-section-1 .card-link {
    text-align: center !important;
    overflow: hidden !important;
    border-radius: 0 !important;
}

#home-section-1 .card-link .card-header {
    border-radius: 0 !important;
}

#home-section-1 .col-md-6 {
    display: flex !important;
    justify-content: center !important;
}

/* Mobile styles - HIGHEST PRIORITY */
@media (max-width: 767px) {
    #home-section-1 .row .col-md-6 {
        flex: 0 0 100% !important;
        max-width: 400px !important;
        margin: 0 auto 1rem auto !important;
        padding: 0 15px !important;
    }
    
    /* Asegurar que TODAS las cards tengan el mismo ancho */
    #home-section-1 .row .col-md-6:nth-child(1),
    #home-section-1 .row .col-md-6:nth-child(2) {
        flex: 0 0 100% !important;
        max-width: 400px !important;
        margin: 0 auto 1rem auto !important;
        padding: 0 15px !important;
    }
    
    #home-section-1 .card-link img {
        width: 100% !important;
        max-width: 400px !important;
        min-width: auto !important;
        height: 300px !important;
    }
    
    #home-section-1 .card-link + .card-link {
        margin-left: 0 !important;
    }
}
</style>

<div id="homepage-wrapper">
	<main id="main" class="site-main" role="main">

		<?php // Aquí dentro construiremos todas las secciones del home. ?>

		<!-- =================================================================
		HERO SECTION
		================================================================== -->
		<section id="hero" class="homepage-section">
			<!-- Video Background -->
			<video autoplay muted loop playsinline class="hero-video">
				<source src="<?php echo get_stylesheet_directory_uri(); ?>/img/CHICANOS 2025.mp4" type="video/mp4">
			</video>
			
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-12 text-center hero-text-container">
						<div class="hero-images">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/bird-left.png" alt="Pájaro Izquierdo" class="bird-left">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/bird-rigth.png" alt="Pájaro Derecho" class="bird-right">
						</div>
						<h1>El auténtico sabor<br>mexicano te espera</h1>
					</div>
				</div>
				<div class="hero-image-container">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/hero-layer.png" alt="Hero Layer" class="hero-layer">
				</div>
		</section>

		<!-- =================================================================
		Aquí irán las 10 secciones. He creado placeholders para cada una.
		================================================================== -->
		<section id="home-section-1" class="homepage-section">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-6">
						<a href="<?php echo site_url('/domicilio/'); ?>" class="card-link">
							<div class="card-header">
								<h3>Domicilios</h3>
								<span class="arrow">→</span>
							</div>
							<!-- Image path: <?php echo get_stylesheet_directory_uri(); ?>/img/domicilios.png -->
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/domicilios.jpg" alt="Domicilios Chicanos">
						</a>
					</div>
					<div class="col-md-6">
						<a href="<?php echo site_url('/distribution/'); ?>" class="card-link">
							<div class="card-header">
								<h3>Distribución</h3>
								<span class="arrow">→</span>
							</div>
							<!-- Image path: <?php echo get_stylesheet_directory_uri(); ?>/img/distribucion.png -->
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/distribucion.jpg" alt="Distribución Chicanos">
						</a>
					</div>
				</div>
				<div class="home-section-1-background-pattern"></div>
			</div>
		</section>

		<!-- =================================================================
		SCROLLING BANNER SECTION
		================================================================== -->
		<section id="scrolling-banner" class="homepage-section">
			<div class="scrolling-banner-inner">
				<div class="scrolling-banner-content">
					<span>¡de siempre y para siempre!</span>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cross-layer.png" alt="Cross">
					<span>¡de siempre y para siempre!</span>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cross-layer.png" alt="Cross">
					<span>¡de siempre y para siempre!</span>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cross-layer.png" alt="Cross">
				</div>
				<div class="scrolling-banner-content">
					<span>¡de siempre y para siempre!</span>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cross-layer.png" alt="Cross">
					<span>¡de siempre y para siempre!</span>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cross-layer.png" alt="Cross">
					<span>¡de siempre y para siempre!</span>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cross-layer.png" alt="Cross">
				</div>
			</div>
		</section>

		<section id="home-section-2" class="homepage-section content-section">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6">
						<h2>Así empezó todo</h2>
						<p>En 1986, Lina y Toño viajaron a México en su luna de miel y volvieron con algo más que recuerdos: trajeron la pasión por su gastronomía. Así nació Chicanos, el primer restaurante mexicano en Bogotá.</p>
					</div>
					<div class="col-md-6">
						<div class="image-frame">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/family.png" alt="Lina y Toño">
						</div>
					</div>
				</div>
			</div>
		</section>

		<section id="home-section-3" class="homepage-section content-section">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-4">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/flor-layer.png" alt="Flor" class="content-flower">
					</div>
					<div class="col-md-4">
						<h2>El primer Chicanos</h2>
						<p>Con una fachada sencilla y un sueño enorme, abrieron las puertas del primer restaurante mexicano en la ciudad. Entre tacos, margaritas y buena música, comenzó una historia que cambió la forma de vivir la comida mexicana en Colombia.</p>
					</div>
					<div class="col-md-4">
						<div class="image-frame">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/first-chicanos.png" alt="El primer Chicanos">
						</div>
					</div>
				</div>
			</div>
		</section>

		<section id="home-section-tradition" class="homepage-section content-section">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6">
						<h2>Una tradición que sigue viva</h2>
						<p>Lo que nació como el sueño de dos recién casados, hoy es un lugar donde generaciones han celebrado, reído y disfrutado del auténtico sabor de México. Casi cuatro décadas después, la historia continúa.</p>
					</div>
					<div class="col-md-6">
						<div class="image-frame">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/first-menu.png" alt="Primer menú de Chicanos">
						</div>
					</div>
				</div>
			</div>
		</section>

		<section id="home-section-6" class="homepage-section text-center">
			<div class="pattern-background-left">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Group 20.png" alt="Pattern Background" class="pattern-bg">
			</div>
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-10">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/tacos-cart.png" alt="Carrito de Tacos" class="tacos-cart-img">
						<h2>Nuestro carrito de <br> tacos para eventos</h2>
						<p>Lleva la auténtica experiencia Chicanos a donde tú quieras.<br>
						Contamos con un carrito de tacos diseñado para cualquier tipo de<br>
						evento. Nuestro equipo se encarga de todo: desde la logística,<br>
						preparación, y servicio.</p>
					</div>
				</div>
			</div>
		</section>
		<section id="home-section-7" class="homepage-section text-center">
			<div class="container">
				<h3 class="ideal-for-title">Ideal para:</h3>
				<div class="row justify-content-center">
					<div class="col-md-3 event-item">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/marry-item.png" alt="Matrimonios">
						<p>Matrimonios</p>
					</div>
					<div class="col-md-3 event-item">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/private-party-item.png" alt="Fiestas Privadas">
						<p>Fiestas Privadas</p>
					</div>
					<div class="col-md-3 event-item">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/corporative-item.png" alt="Eventos Corporativos">
						<p>Eventos<br>Corporativos</p>
					</div>
					<div class="col-md-3 event-item">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/party-item.png" alt="Celebraciones Especiales">
						<p>Celebraciones<br>Especiales</p>
					</div>
				</div>
			</div>
		</section>

		<!-- =================================================================
		FORM SECTION
		================================================================== -->
		<section id="home-form-section" class="homepage-section">
            <div class="container">
                <div class="form-wrapper">
                    <div class="row no-gutters">
                        <div class="col-lg-6 form-text-col">
                            <h2>¿Quieres tenerlo en<br>tu próximo evento?</h2>
                            <p class="form-intro-text">Contáctanos para <br> cotizar y asegurar tu <br>fecha.</p>
                        </div>
                        <div class="col-lg-6 form-fields-col">
                            <?php
                            /*
                             * Para un formulario como este, te recomiendo usar el plugin "Contact Form 7".
                             * Es gratuito y te permite crear todos estos campos de forma sencilla.
                             * Una vez lo instales, solo tienes que crear el formulario en el panel de WordPress
                             * y pegar el shortcode que te genere para reemplazar el bloque .form-mockup.
                             * Ejemplo: echo do_shortcode('[contact-form-7 id="TU_ID" title="Formulario Eventos"]');
                             */
                            ?>

                            <div class="form-mockup">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Correo</label>
                                    <input type="email" disabled />
                                </div>
                                <div class="form-group">
                                    <label>¿Qué tipo de evento?</label>
                                    <select disabled>
                                        <option>Selecciona una opción</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Escribe tu mensaje abajo</label>
                                    <textarea rows="3" disabled placeholder="Por favor incluir la mayor cantidad de informacion para el evento y te responderemos lo mas pronto posible."></textarea>
                                </div>
                                <div class="form-group">
                                    <label>¿Cuándo es el evento?</label>
                                    <input type="text" placeholder="DD/MM/YYYY" disabled />
                                </div>
                                <button type="submit" class="btn" disabled>Enviar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-background-pattern"></div>
		</section>

	</main><!-- #main -->
</div><!-- #homepage-wrapper -->

<?php get_footer(); ?>
