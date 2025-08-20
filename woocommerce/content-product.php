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

// Verificar si el producto pertenece a la categoría "combos" o "Ensalada-Burrito"
$is_combo = has_term('combos', 'product_cat', $product->get_id());
$is_ensalada_burrito = has_term('Ensalada-Burrito', 'product_cat', $product->get_id());

// Determinar la URL del enlace
$link_url = get_permalink();

if ($is_combo) {
    // Buscar la página de combos de manera más robusta
    $combo_page = get_posts(array(
        'name' => 'combos-para-llevar',
        'post_type' => 'page',
        'post_status' => 'publish',
        'numberposts' => 1
    ));
    
    if (!empty($combo_page)) {
        $base_url = get_permalink($combo_page[0]->ID);
        
        // Pasar el ID del producto del combo directamente
        $link_url = add_query_arg('combo_id', $product->get_id(), $base_url);
        
        // Debug: agregar comentario para ver la URL final
        echo '<!-- DEBUG: Combo ID: ' . $product->get_id() . ' - URL: ' . $link_url . ' -->';
    }
} elseif ($is_ensalada_burrito) {
    // Determinar si es ensalada o burrito basándose en el título o slug
    $product_title = strtolower($product->get_name());
    $product_slug = $product->get_slug();
    
    if (strpos($product_title, 'ensalada') !== false || strpos($product_slug, 'ensalada') !== false) {
        // Es una ensalada - redirigir al template de ensaladas
        $ensaladas_page = get_posts(array(
            'name' => 'ensaladas',
            'post_type' => 'page',
            'post_status' => 'publish',
            'numberposts' => 1
        ));
        
        if (!empty($ensaladas_page)) {
            $base_url = get_permalink($ensaladas_page[0]->ID);
            $link_url = add_query_arg('product_id', $product->get_id(), $base_url);
            echo '<!-- DEBUG: Ensalada ID: ' . $product->get_id() . ' - URL: ' . $link_url . ' -->';
        }
    } else {
        // Es un burrito - redirigir al template de burritos
        $burritos_page = get_posts(array(
            'name' => 'burritos',
            'post_type' => 'page',
            'post_status' => 'publish',
            'numberposts' => 1
        ));
        
        if (!empty($burritos_page)) {
            $base_url = get_permalink($burritos_page[0]->ID);
            $link_url = add_query_arg('product_id', $product->get_id(), $base_url);
            echo '<!-- DEBUG: Burrito ID: ' . $product->get_id() . ' - URL: ' . $link_url . ' -->';
        }
    }
}
?>
<li <?php wc_product_class( '', $product ); ?>>
    <div class="combo-card-personalizado">
        
        <div class="combo-header" style="background-color: #FAD3DB;">
            <a href="<?php echo esc_url( $link_url ); ?>">
                <h2 class="woocommerce-loop-product__title"><?php the_title(); ?></h2>
                <div class="combo-price">
                    <?php echo $product->get_price_html(); ?>
                </div>
            </a>
        </div>

        <div class="combo-imagen">
            <a href="<?php echo esc_url( $link_url ); ?>">
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
