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

<div id="homepage-wrapper">
	<main id="main" class="site-main" role="main">

		<?php // Aquí dentro construiremos todas las secciones del home. ?>

		<!-- =================================================================
		HERO SECTION
		================================================================== -->
		<section id="hero" class="homepage-section">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-12 text-center hero-text-container">
						<div class="hero-images">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/bird-left.png" alt="Pájaro Izquierdo" class="bird-left">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/bird-rigth.png" alt="Pájaro Derecho" class="bird-right">
						</div>
						<h1>El auténtico sabor mexicano te espera</h1>
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
				<div class="row">
					<div class="col-md-4">
						<div class="card-link">
							<div class="card-header">
								<h3>Domicilios</h3>
								<span class="arrow">→</span>
							</div>
							<img src="https://via.placeholder.com/400x300" alt="Domicilios">
						</div>
					</div>
					<div class="col-md-4">
						<div class="card-link">
							<div class="card-header">
								<h3>Menú</h3>
								<span class="arrow">→</span>
							</div>
							<img src="https://via.placeholder.com/400x300" alt="Menú">
						</div>
					</div>
					<div class="col-md-4">
						<div class="card-link">
							<div class="card-header">
								<h3>Distribución</h3>
								<span class="arrow">→</span>
							</div>
							<img src="https://via.placeholder.com/400x300" alt="Distribución">
						</div>
					</div>
				</div>
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
						<h2>Chicanos son los Mexicanos de aqui.</h2>
						<p>Se dicen Chicanos, para celebrar un gusto por la comida mexicana que no pasa de moda, la que se sirve en Casa. Una casa al estilo tradicional y modernista de Luis Barragán.</p>
					</div>
					<div class="col-md-6">
						<div class="image-frame">
							<img src="https://via.placeholder.com/500x400" alt="Family photo">
						</div>
					</div>
				</div>
			</div>
		</section>

		<section id="home-section-3" class="homepage-section content-section">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6 order-md-2">
						<h2>Fueron los primeros, pero están mejor que siempre.</h2>
						<p>Tras inaugurar la explosión de restaurantes de comida mexicana en Bogotá hace tres décadas, Chicanos se convierte en La Casa que todos conocen y en la que siempre coinciden en volver.</p>
					</div>
					<div class="col-md-6 order-md-1">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/flor-layer.png" alt="Flower" class="content-flower">
					</div>
				</div>
			</div>
		</section>

		<section id="home-section-4" class="homepage-section content-section">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6">
						<h2>La sensación es de familiaridad y la de una larga amistad a la que se regresa.</h2>
						<p>La Casa de esos amigos de tus padres, expertos cicineros y divertidos anfitriones, que siempre quieren compartir el último descubrimiento gastronómico de su reciente viaje a México: los tacos de esquina, la salsa del Valle, la nueva receta de tortillas.</p>
					</div>
					<div class="col-md-6">
						<div class="image-frame">
							<img src="https://via.placeholder.com/500x400" alt="Family photo">
						</div>
					</div>
				</div>
			</div>
		</section>
		<section id="home-section-5" class="homepage-section content-section">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/green-flowers.png" alt="Flores Verdes" class="img-fluid">
					</div>
					<div class="col-md-6 home-section-5-text">
						<p>Sus platos llevan los nombres de sus célebres y viejos conocidos de los últimos treinta años. Ellos trajeron la experiencia de la comida mexicana a Colombia, pero siguen innovando. Son los que más saben lo que nos gusta por tradición.</p>
						<h2>Los primeros,<br>mejor que siempre</h2>
					</div>
				</div>
			</div>
		</section>
		<section id="home-section-6" class="homepage-section text-center">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-8">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/tacos-cart.png" alt="Carrito de Tacos" class="tacos-cart-img">
						<h2>Nuestro carrito de tacos para eventos</h2>
						<p>Lleva la auténtica experiencia Chicanos a donde tú quieras. Contamos con un carrito de tacos diseñado para cualquier tipo de evento. Nuestro equipo se encarga de todo: desde la logística, preparación, y servicio.</p>
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
                        <div class="col-lg-5 form-text-col">
                            <h2>¿Quieres tenerlo en<br>tu próximo evento?</h2>
                            <p>Contáctanos para cotizar y asegurar tu fecha.</p>
                        </div>
                        <div class="col-lg-7 form-fields-col">
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
                                    <label>Name</label>
                                    <input type="text" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" disabled />
                                </div>
                                <div class="form-group">
                                    <label>What type of event?</label>
                                    <select disabled>
                                        <option>Select an option</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Type your message below</label>
                                    <textarea rows="3" disabled>Please include as much detail in your message as possible so we can reply ASAP</textarea>
                                </div>
                                <div class="form-group">
                                    <label>When is your event?</label>
                                    <input type="text" placeholder="DD/MM/YYYY" disabled />
                                </div>
                                <button type="submit" class="btn" disabled>Submit</button>
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
