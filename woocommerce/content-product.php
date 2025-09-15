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

// Verificar si el producto pertenece a la categoría "combos", "ensaladas", "Ensalada-Burrito" o "adiciones"
$is_combo = has_term('combos', 'product_cat', $product->get_id());
$is_ensalada = has_term('ensaladas', 'product_cat', $product->get_id());
$is_ensalada_burrito = has_term('Ensalada-Burrito', 'product_cat', $product->get_id());
$is_adiciones = has_term('adiciones', 'product_cat', $product->get_id());

// Determinar la URL del enlace
$link_url = get_permalink();

if ($is_combo) {
    // Determinar el tamaño del combo basándose en el título o slug
    $product_title = strtolower($product->get_name());
    $product_slug = $product->get_slug();
    
    // Determinar qué página de combo usar
    $combo_page_slug = 'combos-para-llevar-1-3'; // Default
    
    if (strpos($product_title, '4-6') !== false || strpos($product_slug, '4-6') !== false || 
        strpos($product_title, '4 a 6') !== false || strpos($product_title, '4 a 6') !== false) {
        $combo_page_slug = 'combos-para-llevar-4-6';
    } elseif (strpos($product_title, '7-10') !== false || strpos($product_slug, '7-10') !== false || 
              strpos($product_title, '7 a 10') !== false || strpos($product_title, '7 a 10') !== false) {
        $combo_page_slug = 'combos-para-llevar-7-10';
    }
    
    // Buscar la página de combos específica
    $combo_page = get_posts(array(
        'name' => $combo_page_slug,
        'post_type' => 'page',
        'post_status' => 'publish',
        'numberposts' => 1
    ));
    
    if (!empty($combo_page)) {
        $link_url = get_permalink($combo_page[0]->ID);
        
        // Debug: agregar comentario para ver la URL final
        echo '<!-- DEBUG: Combo ID: ' . $product->get_id() . ' - Page: ' . $combo_page_slug . ' - URL: ' . $link_url . ' -->';
    }
} elseif ($is_ensalada) {
    // Es un producto de la categoría "ensaladas" - redirigir al template de ensaladas
    $ensaladas_page = get_posts(array(
        'name' => 'ensaladas',
        'post_type' => 'page',
        'post_status' => 'publish',
        'numberposts' => 1
    ));
    
    if (!empty($ensaladas_page)) {
        $link_url = get_permalink($ensaladas_page[0]->ID);
        echo '<!-- DEBUG: Ensalada ID: ' . $product->get_id() . ' - URL: ' . $link_url . ' -->';
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
            $link_url = get_permalink($ensaladas_page[0]->ID);
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
            $link_url = get_permalink($burritos_page[0]->ID);
            echo '<!-- DEBUG: Burrito ID: ' . $product->get_id() . ' - URL: ' . $link_url . ' -->';
        }
    }
} elseif ($is_adiciones) {
    // Es un producto de la categoría "adiciones" - redirigir al template de adiciones
    echo '<!-- DEBUG: Producto de adiciones detectado - ID: ' . $product->get_id() . ' - Nombre: ' . $product->get_name() . ' -->';
    
    $adiciones_page = get_posts(array(
        'name' => 'adiciones-extra',
        'post_type' => 'page',
        'post_status' => 'publish',
        'numberposts' => 1
    ));
    
    echo '<!-- DEBUG: Páginas encontradas con slug adiciones-extra: ' . count($adiciones_page) . ' -->';
    
    if (!empty($adiciones_page)) {
        $link_url = get_permalink($adiciones_page[0]->ID);
        echo '<!-- DEBUG: Adiciones ID: ' . $product->get_id() . ' - URL encontrada: ' . $link_url . ' -->';
    } else {
        echo '<!-- DEBUG: No se encontró página con slug adiciones-extra, buscando por template -->';
        
        // Si no existe la página, buscar cualquier página que use el template de adiciones
        $adiciones_template_page = get_posts(array(
            'post_type' => 'page',
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => '_wp_page_template',
                    'value' => 'page-templates/template-adiciones.php',
                    'compare' => '='
                )
            ),
            'numberposts' => 1
        ));
        
        echo '<!-- DEBUG: Páginas encontradas con template adiciones: ' . count($adiciones_template_page) . ' -->';
        
        if (!empty($adiciones_template_page)) {
            $link_url = get_permalink($adiciones_template_page[0]->ID);
            echo '<!-- DEBUG: Adiciones ID: ' . $product->get_id() . ' - Template URL: ' . $link_url . ' -->';
        } else {
            // Fallback: usar home_url con el slug esperado
            $link_url = home_url('/adiciones-extra/');
            echo '<!-- DEBUG: Adiciones ID: ' . $product->get_id() . ' - Fallback URL: ' . $link_url . ' -->';
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
            <a href="<?php echo esc_url( $link_url ); ?>" class="btn btn-primary btn-lg add-to-cart-button">
                AGREGAR
            </a>
        </div>

    </div>
</li>
