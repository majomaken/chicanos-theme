<?php
/**
 * Template Name: Página en Construcción
 *
 * Esta es la plantilla que muestra la página de mantenimiento
 * mientras se trabaja en la remodelación del sitio web.
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<!-- Página en Construcción -->
<div class="under-construction-wrapper">
    <div class="construction-card">
        <!-- Logo de CHICANOS -->
        <div class="logo-container">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Logochicanos 1.webp" alt="Logo de Chicanos" class="logo">
        </div>
        
        <h1>Hola 👋🏼</h1>
        <p>
            En este momento estamos trabajando en la remodelación de nuestra página web. Mientras tanto, puedes comunicarte con nosotros a través de WhatsApp o por teléfono, y te responderemos lo más pronto posible:
        </p>
        
        <div class="sedes-container">
            <div class="sede">
                <h2>
                    <svg class="location-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M12 0c-4.198 0-8 3.403-8 7.602 0 4.198 3.469 9.21 8 16.398 4.531-7.188 8-12.2 8-16.398 0-4.199-3.801-7.602-8-7.602zm0 11c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3z"/></svg>
                    Sede Nogal
                </h2>
                <ul>
                    <li>
                        <svg class="contact-icon address-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M12 0c-4.198 0-8 3.403-8 7.602 0 4.198 3.469 9.21 8 16.398 4.531-7.188 8-12.2 8-16.398 0-4.199-3.801-7.602-8-7.602zm0 11c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3z"/></svg>
                        <small>Carrera 11 #78-70</small>
                    </li>
                    <li>
                        <svg class="contact-icon whatsapp-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.894 11.892-1.99 0-3.902-.539-5.57-1.502l-6.162 1.688zm7.821-1.164c.579.326 1.21.513 1.866.513 4.971 0 9.002-4.032 9.003-9.003.001-4.97-4.03-9.002-9.002-9.002-4.97 0-9.002 4.032-9.003 9.002-.001 2.02.648 3.911 1.819 5.461l-.271 1.004-1.006.27-3.163.867.887-3.064.271-1.004-.271-1.004c-1.171-1.551-1.818-3.44-1.818-5.461 0-4.971 4.032-9.003 9.003-9.003s9.002 4.032 9.002 9.002-4.032 9.003-9.002 9.003c-.655 0-1.294-.092-1.896-.265l-1.004-.271z"/></svg>
                        <a href="https://wa.me/573222112325" target="_blank">WhatsApp: ‪322 2112325‬</a>
                    </li>
                    <li>
                        <svg class="contact-icon phone-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M20 22.621l-3.521-6.795c-.008.004-1.974.97-2.064 1.011-2.24 1.086-6.799-3.469-7.885-5.708-.041-.09-.981-2.092 1.01-2.065l6.795-3.521-2.261-4.355-7.394 2.146-2.565 6.175c-1.616 5.867 4.541 12.024 10.408 10.408l6.175-2.565-4.353-2.259zm-4.928-10.702c.883.883 1.217 2.243.513 3.656l-1.921.996c-.347.18-1.246-.86-2.13-1.743s-1.563-1.783-1.743-2.131l.996-1.921c1.413-.704 2.773-.37 3.656.513l.629.63z"/></svg>
                        <a href="tel:+576013129887">Tel: (601)312 9887</a> o <a href="tel:+576013002326">(601)3002326</a>
                    </li>
                </ul>
            </div>
            
            <div class="sede">
                <h2>
                    <svg class="location-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M12 0c-4.198 0-8 3.403-8 7.602 0 4.198 3.469 9.21 8 16.398 4.531-7.188 8-12.2 8-16.398 0-4.199-3.801-7.602-8-7.602zm0 11c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3z"/></svg>
                    Sede Castellana
                </h2>
                <ul>
                    <li>
                        <svg class="contact-icon address-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M12 0c-4.198 0-8 3.403-8 7.602 0 4.198 3.469 9.21 8 16.398 4.531-7.188 8-12.2 8-16.398 0-4.199-3.801-7.602-8-7.602zm0 11c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3z"/></svg>
                        <small>Carrera 47 #94-56</small>
                    </li>
                    <li>
                        <svg class="contact-icon whatsapp-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.894 11.892-1.99 0-3.902-.539-5.57-1.502l-6.162 1.688zm7.821-1.164c.579.326 1.21.513 1.866.513 4.971 0 9.002-4.032 9.003-9.003.001-4.97-4.03-9.002-9.002-9.002-4.97 0-9.002 4.032-9.003 9.002-.001 2.02.648 3.911 1.819 5.461l-.271 1.004-1.006.27-3.163.867.887-3.064.271-1.004-.271-1.004c-1.171-1.551-1.818-3.44-1.818-5.461 0-4.971 4.032-9.003 9.003-9.003s9.002 4.032 9.002 9.002-4.032 9.003-9.002 9.003c-.655 0-1.294-.092-1.896-.265l-1.004-.271z"/></svg>
                        <a href="https://wa.me/573106878901" target="_blank">WhatsApp: ‪310 687 8901</a>
                    </li>
                    <li>
                        <svg class="contact-icon phone-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M20 22.621l-3.521-6.795c-.008.004-1.974.97-2.064 1.011-2.24 1.086-6.799-3.469-7.885-5.708-.041-.09-.981-2.092 1.01-2.065l6.795-3.521-2.261-4.355-7.394 2.146-2.565 6.175c-1.616 5.867 4.541 12.024 10.408 10.408l6.175-2.565-4.353-2.259zm-4.928-10.702c.883.883 1.217 2.243.513 3.656l-1.921.996c-.347.18-1.246-.86-2.13-1.743s-1.563-1.783-1.743-2.131l.996-1.921c1.413-.704 2.773-.37 3.656.513l.629.63z"/></svg>
                        <a href="tel:+573106878901">Tel: 310 687 8901</a> o <a href="tel:+576013000708">(601)3000708</a>
                    </li>
                </ul>
            </div>
        </div>
        
        <p class="gracias">
            ¡Gracias por tu comprensión!
        </p>
    </div>
</div>

<?php get_footer(); ?>
