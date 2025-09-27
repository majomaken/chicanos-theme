<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="wrapper-footer">

	<div class="<?php echo esc_attr( $container ); ?> position-relative">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/pajaro.png" alt="Pájaro decorativo" class="footer-bird">
		<div class="row">

			<div class="col-md-6 footer-section">
                <h2>¿Preguntas?<br>¡Contáctanos!</h2>
                <ul class="footer-menu">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Entregas</a></li>
                    <li><a href="#">Distribución</a></li>
                </ul>
            </div>

            <div class="col-md-6 footer-section">
                <div class="footer-location" style="margin-top: 20px;">
                    <h4><i class="fas fa-map-marker-alt"></i> Sede Nogal</h4>
                    <p>
                        Carrera 11 #78-70<br>
                        WhatsApp: +57 322 2112325<br>
                        Teléfono: (601) 312 9667 o (601) 300 2326<br>
                        Correo: contacto@chicano.com.co
                    </p>
                </div>
                <div class="footer-location mt-4" style="margin-top: 40px;">
                    <h4><i class="fas fa-map-marker-alt"></i> Sede Castellana</h4>
                    <p>
                        Carrera 47 #94-56<br>
                        WhatsApp: +57 310 6878901<br>
                        Teléfono: (310) 687 8901 o (601) 300 0780<br>
                        Correo: castellana@chicanos.com.co
                    </p>
                </div>
            </div>

		</div><!-- .row -->

        <div class="row footer-bottom-row" style="align-items: center;">
            <div class="col-md-4">
                <p>Chicanos 2025</p>
            </div>
            <div class="col-md-4">
                <ul class="footer-legal-menu" style="margin-bottom: 0; display: flex; justify-content: center; align-items: center;">
                    <li><a href="#">Política de Privacidad</a></li>
                    <li><a href="#">Términos y Condiciones</a></li>
                </ul>
            </div>
            <div class="col-md-4 text-right">
                <p>site designed by ikatnas</p>
            </div>
        </div>

	</div><!-- .container(-fluid) -->

</div><!-- #wrapper-footer -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>
