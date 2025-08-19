<?php
/**
 * Plantilla del producto simple
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

    <?php
        // Esta acción usualmente muestra mensajes de la tienda (ej. "Producto añadido al carrito").
        do_action( 'woocommerce_before_single_product' );
    ?>

    <div class="producto-personalizado-wrapper">

        <div class="columna-imagen">
            <?php
                // Esta acción engancha la galería de imágenes del producto.
                do_action( 'woocommerce_before_single_product_summary' );
            ?>
        </div>

        <div class="columna-opciones">
            <?php
                // Esta acción engancha el título, precio, descripción y el botón de añadir al carrito.
                // El código que pusiste en functions.php para los campos de ACF se enganchará aquí automáticamente.
                do_action( 'woocommerce_single_product_summary' );
            ?>
        </div>

    </div>

    <?php
        // Esta acción engancha las pestañas de información adicional, valoraciones, etc.
        // Puedes borrarla si tu diseño no las necesita.
        do_action( 'woocommerce_after_single_product_summary' );
    ?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
