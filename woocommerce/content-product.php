<?php
/**
 * Plantilla para cada producto en el loop de la tienda.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Asegura que el producto esté disponible.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
?>
<li <?php wc_product_loop_start_tag(); ?>>
    <div class="combo-card-personalizado">
        
        <div class="combo-header" style="background-color: #fde9e4;">
            <a href="<?php echo esc_url( get_permalink() ); ?>">
                <h2 class="woocommerce-loop-product__title"><?php the_title(); ?></h2>
                <div class="combo-price">
                    <?php echo $product->get_price_html(); ?>
                </div>
            </a>
        </div>

        <div class="combo-imagen">
            <a href="<?php echo esc_url( get_permalink() ); ?>">
                <?php
                // Muestra la imagen destacada del producto.
                echo woocommerce_get_product_thumbnail();
                ?>
            </a>
        </div>
        
        <div class="combo-footer">
            <?php
            // Muestra el botón de "Agregar" o "Ver Opciones".
            woocommerce_template_loop_add_to_cart();
            ?>
        </div>

    </div>
</li>
