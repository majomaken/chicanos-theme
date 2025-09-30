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
    position: relative !important;
    z-index: 10 !important;
    cursor: pointer !important;
    pointer-events: auto !important;
}

/* Ensure the background pattern doesn't interfere with clicks */
#home-section-1 .home-section-1-background-pattern {
    pointer-events: none !important;
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
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/bird-left.webp" alt="Pájaro Izquierdo" class="bird-left">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/bird-rigth.webp" alt="Pájaro Derecho" class="bird-right">
						</div>
						<h1>El auténtico sabor<br>mexicano te espera</h1>
					</div>
				</div>
				<div class="hero-image-container">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/hero-layer.webp" alt="Hero Layer" class="hero-layer">
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
							<!-- Image path: <?php echo get_stylesheet_directory_uri(); ?>/img/domicilios.webp -->
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/domicilios.webp" alt="Domicilios Chicanos">
						</a>
					</div>
					<div class="col-md-6">
						<a href="<?php echo home_url('/distribucion/'); ?>" class="card-link">
							<div class="card-header">
								<h3>Distribución</h3>
								<span class="arrow">→</span>
							</div>
							<!-- Image path: <?php echo get_stylesheet_directory_uri(); ?>/img/distribucion.webp -->
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/distribucion.webp" alt="Distribución Chicanos">
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
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cross-layer.webp" alt="Cross">
					<span>¡de siempre y para siempre!</span>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cross-layer.webp" alt="Cross">
					<span>¡de siempre y para siempre!</span>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cross-layer.webp" alt="Cross">
				</div>
				<div class="scrolling-banner-content">
					<span>¡de siempre y para siempre!</span>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cross-layer.webp" alt="Cross">
					<span>¡de siempre y para siempre!</span>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cross-layer.webp" alt="Cross">
					<span>¡de siempre y para siempre!</span>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cross-layer.webp" alt="Cross">
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
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/family.webp" alt="Lina y Toño">
						</div>
					</div>
				</div>
			</div>
		</section>

		<section id="home-section-3" class="homepage-section content-section">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-4">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/flor-layer.webp" alt="Flor" class="content-flower">
					</div>
					<div class="col-md-4">
						<h2>El primer Chicanos</h2>
						<p>Con una fachada sencilla y un sueño enorme, abrieron las puertas del primer restaurante mexicano en la ciudad. Entre tacos, margaritas y buena música, comenzó una historia que cambió la forma de vivir la comida mexicana en Colombia.</p>
					</div>
					<div class="col-md-4">
						<div class="image-frame">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/first-chicanos.webp" alt="El primer Chicanos">
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
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/first-menu.webp" alt="Primer menú de Chicanos">
						</div>
					</div>
				</div>
			</div>
		</section>

		<section id="home-section-6" class="homepage-section text-center">
			<div class="pattern-background-left">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Group 20.webp" alt="Pattern Background" class="pattern-bg">
			</div>
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-10">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/tacos-cart.webp" alt="Carrito de Tacos" class="tacos-cart-img">
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
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/marry-item.webp" alt="Matrimonios">
						<p>Matrimonios</p>
					</div>
					<div class="col-md-3 event-item">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/private-party-item.webp" alt="Fiestas Privadas">
						<p>Fiestas Privadas</p>
					</div>
					<div class="col-md-3 event-item">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/corporative-item.webp" alt="Eventos Corporativos">
						<p>Eventos<br>Corporativos</p>
					</div>
					<div class="col-md-3 event-item">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/party-item.webp" alt="Celebraciones Especiales">
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
                            <p class="form-intro-text">Contáctanos para<br>cotizar y asegurar tu<br>fecha.</p>
                            <div class="contact-emails">
                                <p>Felipe@chicanos.com.co</p>
                            </div>
                        </div>
                        <div class="col-lg-6 form-fields-col">
                            <?php
                            // Procesar el formulario cuando se envía
                            if ($_POST['submit_event_form']) {
                                // Validar que todos los campos estén presentes
                                $required_fields = ['nombre', 'correo', 'telefono', 'tipo_evento', 'mensaje', 'fecha_evento'];
                                $missing_fields = [];
                                
                                foreach ($required_fields as $field) {
                                    if (empty($_POST[$field])) {
                                        $missing_fields[] = $field;
                                    }
                                }
                                
                                if (!empty($missing_fields)) {
                                    echo '<div class="form-error" style="background: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border: 1px solid #f5c6cb; border-radius: 4px;">';
                                    echo '<strong>Error:</strong> Por favor completa todos los campos requeridos.';
                                    echo '</div>';
                                } else {
                                    // Todos los campos están presentes, procesar el formulario
                                    $nombre = sanitize_text_field($_POST['nombre']);
                                    $correo = sanitize_email($_POST['correo']);
                                    $telefono = sanitize_text_field($_POST['telefono']);
                                    $tipo_evento = sanitize_text_field($_POST['tipo_evento']);
                                    $mensaje = sanitize_textarea_field($_POST['mensaje']);
                                    $fecha_evento = sanitize_text_field($_POST['fecha_evento']);
                                    
                                    // Preparar el email
                                    $to = 'Felipe@chicanos.com.co';
                                    $subject = 'Nueva solicitud de evento - ' . $tipo_evento;
                                    
                                    $email_message = "Nueva solicitud de evento recibida:\n\n";
                                    $email_message .= "Nombre: " . $nombre . "\n";
                                    $email_message .= "Correo: " . $correo . "\n";
                                    $email_message .= "Teléfono: " . $telefono . "\n";
                                    $email_message .= "Tipo de evento: " . $tipo_evento . "\n";
                                    $email_message .= "Fecha del evento: " . $fecha_evento . "\n";
                                    $email_message .= "Mensaje: " . $mensaje . "\n";
                                    
                                    $headers = array(
                                        'Content-Type: text/plain; charset=UTF-8',
                                        'From: ' . $nombre . ' <' . $correo . '>',
                                        'Reply-To: ' . $correo
                                    );
                                    
                                    // Enviar el email
                                    $sent = wp_mail($to, $subject, $email_message, $headers);
                                    
                                    if ($sent) {
                                        echo '<div class="form-success" style="background: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border: 1px solid #c3e6cb; border-radius: 4px;">';
                                        echo '<strong>¡Mensaje enviado exitosamente!</strong> Te contactaremos pronto.';
                                        echo '</div>';
                                    } else {
                                        echo '<div class="form-error" style="background: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border: 1px solid #f5c6cb; border-radius: 4px;">';
                                        echo '<strong>Error al enviar el mensaje.</strong> Por favor intenta nuevamente.';
                                        echo '</div>';
                                    }
                                }
                            }
                            ?>

                            <form class="event-form" method="post" action="">
                                <input type="hidden" name="submit_event_form" value="1">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" id="nombre" name="nombre" required />
                                </div>
                                <div class="form-group">
                                    <label for="correo">Correo</label>
                                    <input type="email" id="correo" name="correo" required />
                                </div>
                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <input type="tel" id="telefono" name="telefono" required />
                                </div>
                                <div class="form-group">
                                    <label for="tipo_evento">¿Qué tipo de evento?</label>
                                    <select id="tipo_evento" name="tipo_evento" required>
                                        <option value="">Selecciona una opción</option>
                                        <option value="matrimonios">Matrimonios</option>
                                        <option value="fiesta_privada">Fiesta privada</option>
                                        <option value="eventos_corporativos">Eventos Corporativos</option>
                                        <option value="celebraciones_especiales">Celebraciones Especiales</option>
                                        <option value="otros">Otros</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="mensaje">Escribe tu mensaje abajo</label>
                                    <textarea id="mensaje" name="mensaje" rows="3" placeholder="Por favor incluir la mayor cantidad de informacion para el evento y te responderemos lo mas pronto posible." required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_evento">¿Cuándo es el evento?</label>
                                    <input type="date" id="fecha_evento" name="fecha_evento" required />
                                </div>
                                <button type="submit" class="btn">Enviar</button>
                            </form>
                            
                            <script>
                            // Validación y manejo del formulario
                            document.addEventListener('DOMContentLoaded', function() {
                                const form = document.querySelector('.event-form');
                                const successMessage = document.querySelector('.form-success');
                                const errorMessage = document.querySelector('.form-error');
                                
                                // Validación adicional antes del envío
                                if (form) {
                                    form.addEventListener('submit', function(e) {
                                        const requiredFields = form.querySelectorAll('[required]');
                                        let allFieldsValid = true;
                                        
                                        requiredFields.forEach(function(field) {
                                            if (!field.value.trim()) {
                                                allFieldsValid = false;
                                                field.style.borderColor = '#dc3545';
                                                
                                                // Remover el estilo de error después de 3 segundos
                                                setTimeout(function() {
                                                    field.style.borderColor = '#000';
                                                }, 3000);
                                            } else {
                                                field.style.borderColor = '#000';
                                            }
                                        });
                                        
                                        if (!allFieldsValid) {
                                            e.preventDefault();
                                            alert('Por favor completa todos los campos requeridos.');
                                            return false;
                                        }
                                    });
                                }
                                
                                // Limpiar formulario después del envío exitoso
                                if (successMessage && form) {
                                    // Limpiar el formulario
                                    form.reset();
                                    
                                    // Scroll hacia arriba para mostrar el mensaje de éxito
                                    successMessage.scrollIntoView({ behavior: 'smooth' });
                                }
                                
                                // Scroll hacia arriba para mostrar mensajes de error
                                if (errorMessage) {
                                    errorMessage.scrollIntoView({ behavior: 'smooth' });
                                }
                            });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-background-pattern"></div>
		</section>

	</main><!-- #main -->
</div><!-- #homepage-wrapper -->

<?php get_footer(); ?>
