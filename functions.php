<?php
/**
 * UnderStrap functions and definitions
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// UnderStrap's includes directory.
$understrap_inc_dir = 'inc';

// Array of files to include.
$understrap_includes = array(
	'/theme-settings.php',                  // Initialize theme default settings.
	'/setup.php',                           // Theme setup and custom theme supports.
	'/widgets.php',                         // Register widget area.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/template-tags.php',                   // Custom template tags for this theme.
	'/pagination.php',                      // Custom pagination for this theme.
	'/hooks.php',                           // Custom hooks.
	'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/customizer.php',                      // Customizer additions.
	'/custom-comments.php',                 // Custom Comments file.
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker. Trying to get deeper navigation? Check out: https://github.com/understrap/understrap/issues/567.
	'/editor.php',                          // Load Editor functions.
	'/block-editor.php',                    // Load Block Editor functions.
	'/deprecated.php',                      // Load deprecated functions.
);

// Load WooCommerce functions if WooCommerce is activated.
if ( class_exists( 'WooCommerce' ) ) {
	$understrap_includes[] = '/woocommerce.php';
}

// Load Jetpack compatibility file if Jetpack is activiated.
if ( class_exists( 'Jetpack' ) ) {
	$understrap_includes[] = '/jetpack.php';
}

// Include files.
foreach ( $understrap_includes as $file ) {
	require_once get_theme_file_path( $understrap_inc_dir . $file );
}

// Add AJAX handler for burritos
add_action('wp_ajax_add_burrito_to_cart', 'add_burrito_to_cart_handler');
add_action('wp_ajax_nopriv_add_burrito_to_cart', 'add_burrito_to_cart_handler');

function add_burrito_to_cart_handler() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'woocommerce-add-to-cart')) {
        wp_send_json_error('Security check failed');
        return;
    }
    
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    $options = $_POST['options'];
    
    // Validate product
    $product = wc_get_product($product_id);
    if (!$product) {
        wp_send_json_error('Product not found');
        return;
    }
    
    // Add to cart with custom options
    $cart_item_data = array(
        'custom_options' => $options,
        'custom_product_type' => 'burrito'
    );
    
    $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity, 0, array(), $cart_item_data);
    
    if ($cart_item_key) {
        wp_send_json_success('Burrito added to cart successfully');
    } else {
        wp_send_json_error('Failed to add to cart');
    }
}

// Add AJAX handler for adiciones
add_action('wp_ajax_add_adiciones_to_cart', 'add_adiciones_to_cart_handler');
add_action('wp_ajax_nopriv_add_adiciones_to_cart', 'add_adiciones_to_cart_handler');

// Handle combo add to cart
function handle_add_combo_to_cart() {
    try {
        // Log para debugging
        error_log('=== COMBO AJAX Handler llamado ===');
        error_log('POST data: ' . print_r($_POST, true));
        
        // Verificar que WooCommerce esté activo
        if (!class_exists('WooCommerce')) {
            error_log('WooCommerce no está activo');
            wp_send_json_error('WooCommerce not active');
            return;
        }
        
        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'add_combo_to_cart')) {
            error_log('Nonce verification failed');
            wp_send_json_error('Security check failed');
            return;
        }
        
        // Verificar que combo_id existe
        if (!isset($_POST['combo_id']) || empty($_POST['combo_id'])) {
            error_log('combo_id no está presente en POST');
            wp_send_json_error('Combo ID is required');
            return;
        }
        
        $combo_id = intval($_POST['combo_id']);
        error_log('Combo ID: ' . $combo_id);
        
        // Verificar que combo_data existe
        if (!isset($_POST['combo_data']) || empty($_POST['combo_data'])) {
            error_log('combo_data no está presente en POST');
            wp_send_json_error('Combo data is required');
            return;
        }
        
        $combo_data = $_POST['combo_data'];
        error_log('Combo data: ' . print_r($combo_data, true));
        
        // Get the combo product
        $product = wc_get_product($combo_id);
        if (!$product) {
            error_log('Producto no encontrado con ID: ' . $combo_id);
            wp_send_json_error('Product not found');
            return;
        }
        
        error_log('Producto encontrado: ' . $product->get_name());
        
        // Prepare combo data for cart - con validación adicional
        $cart_item_data = array();
        
        if (isset($combo_data['totopos'])) {
            $cart_item_data['combo_totopos'] = sanitize_text_field($combo_data['totopos']);
        }
        
        if (isset($combo_data['tortillas'])) {
            $cart_item_data['combo_tortillas'] = sanitize_text_field($combo_data['tortillas']);
        }
        
        if (isset($combo_data['proteins']) && is_array($combo_data['proteins'])) {
            $cart_item_data['combo_proteins'] = array_map('sanitize_text_field', $combo_data['proteins']);
        }
        
        if (isset($combo_data['sauces']) && is_array($combo_data['sauces'])) {
            $cart_item_data['combo_sauces'] = array_map('sanitize_text_field', $combo_data['sauces']);
        }
        
        $cart_item_data['combo_custom_data'] = true;
        
        error_log('Cart item data: ' . print_r($cart_item_data, true));
        
        // Add to cart
        $cart_item_key = WC()->cart->add_to_cart($combo_id, 1, 0, array(), $cart_item_data);
        
        if ($cart_item_key) {
            // Update cart totals
            WC()->cart->calculate_totals();
            
            error_log('Combo agregado exitosamente al carrito');
            error_log('Cart item key: ' . $cart_item_key);
            
            // Verificar que los datos se guardaron correctamente
            $cart_contents = WC()->cart->get_cart_contents();
            foreach ($cart_contents as $key => $item) {
                if ($key === $cart_item_key) {
                    error_log('Verificando datos guardados: ' . print_r($item, true));
                    break;
                }
            }
            
            // Limpiar cache si existe
            if (function_exists('wp_cache_flush')) {
                wp_cache_flush();
            }
            
            wp_send_json_success(array(
                'message' => 'Combo agregado al carrito exitosamente',
                'cart_count' => WC()->cart->get_cart_contents_count(),
                'cart_total' => WC()->cart->get_cart_total()
            ));
        } else {
            error_log('Error al agregar al carrito');
            wp_send_json_error('Error al agregar al carrito');
        }
        
    } catch (Exception $e) {
        error_log('Exception en handle_add_combo_to_cart: ' . $e->getMessage());
        error_log('Stack trace: ' . $e->getTraceAsString());
        wp_send_json_error('Server error: ' . $e->getMessage());
    }
}

add_action('wp_ajax_add_combo_to_cart', 'handle_add_combo_to_cart');
add_action('wp_ajax_nopriv_add_combo_to_cart', 'handle_add_combo_to_cart');


// Personalizar la visualización del combo en el carrito
function customize_combo_cart_item_name($product_name, $cart_item, $cart_item_key) {
    // Solo aplicar a productos con datos de combo personalizados
    if (isset($cart_item['combo_custom_data']) && $cart_item['combo_custom_data']) {
        $combo_details = array();
        
        // Agregar totopos
        if (isset($cart_item['combo_totopos'])) {
            $combo_details[] = '<strong>🥨 Totopos:</strong> ' . $cart_item['combo_totopos'];
        }
        
        // Agregar tortillas
        if (isset($cart_item['combo_tortillas'])) {
            $combo_details[] = '<strong>🌮 Tortillas:</strong> ' . $cart_item['combo_tortillas'];
        }
        
        // Agregar proteínas
        if (isset($cart_item['combo_proteins']) && is_array($cart_item['combo_proteins'])) {
            $proteins_text = implode(', ', $cart_item['combo_proteins']);
            $combo_details[] = '<strong>🍖 Proteínas (3x250gr):</strong> ' . $proteins_text;
        }
        
        // Agregar salsas
        if (isset($cart_item['combo_sauces']) && is_array($cart_item['combo_sauces'])) {
            $sauces_text = implode(', ', $cart_item['combo_sauces']);
            $combo_details[] = '<strong>🌶️ Salsas (6x250gr):</strong> ' . $sauces_text;
        }
        
        if (!empty($combo_details)) {
            $product_name .= '<div class="combo-cart-details" style="margin-top: 10px; padding: 12px 15px; background: #f8f9fa; border-radius: 8px;">';
            $product_name .= '<div style="font-weight: bold; margin-bottom: 8px; color: #333;">📋 Detalles del Combo:</div>';
            $product_name .= '<div style="font-size: 0.9em; line-height: 1.4;">';
            $product_name .= implode('<br>', $combo_details);
            $product_name .= '</div>';
            $product_name .= '</div>';
        }
    }
    
    return $product_name;
}

// Hook para personalizar el nombre del producto en el carrito
add_filter('woocommerce_cart_item_name', 'customize_combo_cart_item_name', 10, 3);

// Personalizar la visualización del combo en el checkout
function customize_combo_checkout_item_name($product_name, $cart_item, $cart_item_key) {
    return customize_combo_cart_item_name($product_name, $cart_item, $cart_item_key);
}

// Hook para personalizar el nombre del producto en el checkout
add_filter('woocommerce_checkout_cart_item_name', 'customize_combo_checkout_item_name', 10, 3);

// Hook para personalizar el nombre del producto en el mini carrito
add_filter('woocommerce_widget_cart_item_name', 'customize_combo_cart_item_name', 10, 3);

// Hook adicional para asegurar que se muestren los detalles
add_action('woocommerce_after_cart_item_name', 'show_combo_details_after_name', 10, 2);

// Función para mostrar detalles del combo después del nombre
function show_combo_details_after_name($cart_item, $cart_item_key) {
    // Solo aplicar a productos con datos de combo personalizados
    if (isset($cart_item['combo_custom_data']) && $cart_item['combo_custom_data']) {
        $combo_details = array();
        
        // Agregar totopos
        if (isset($cart_item['combo_totopos'])) {
            $combo_details[] = '<strong>🥨 Totopos:</strong> ' . $cart_item['combo_totopos'];
        }
        
        // Agregar tortillas
        if (isset($cart_item['combo_tortillas'])) {
            $combo_details[] = '<strong>🌮 Tortillas:</strong> ' . $cart_item['combo_tortillas'];
        }
        
        // Agregar proteínas
        if (isset($cart_item['combo_proteins']) && is_array($cart_item['combo_proteins'])) {
            $proteins_text = implode(', ', $cart_item['combo_proteins']);
            $combo_details[] = '<strong>🍖 Proteínas (3x250gr):</strong> ' . $proteins_text;
        }
        
        // Agregar salsas
        if (isset($cart_item['combo_sauces']) && is_array($cart_item['combo_sauces'])) {
            $sauces_text = implode(', ', $cart_item['combo_sauces']);
            $combo_details[] = '<strong>🌶️ Salsas (6x250gr):</strong> ' . $sauces_text;
        }
        
        if (!empty($combo_details)) {
            echo '<div class="combo-cart-details" style="margin-top: 10px; padding: 12px 15px; background: #f8f9fa; border-radius: 8px;">';
            echo '<div style="font-weight: bold; margin-bottom: 8px; color: #333;">📋 Detalles del Combo:</div>';
            echo '<div style="font-size: 0.9em; line-height: 1.4;">';
            echo implode('<br>', $combo_details);
            echo '</div>';
            echo '</div>';
        }
    }
}

// Personalizar la visualización del combo en el email de pedido
function customize_combo_order_item_name($product_name, $item, $is_visible) {
    if (isset($item['combo_custom_data']) && $item['combo_custom_data']) {
        $combo_details = array();
        
        // Agregar totopos
        if (isset($item['combo_totopos'])) {
            $combo_details[] = '<strong>🥨 Totopos:</strong> ' . $item['combo_totopos'];
        }
        
        // Agregar tortillas
        if (isset($item['combo_tortillas'])) {
            $combo_details[] = '<strong>🌮 Tortillas:</strong> ' . $item['combo_tortillas'];
        }
        
        // Agregar proteínas
        if (isset($item['combo_proteins']) && is_array($item['combo_proteins'])) {
            $proteins_text = implode(', ', $item['combo_proteins']);
            $combo_details[] = '<strong>🍖 Proteínas (3x250gr):</strong> ' . $proteins_text;
        }
        
        // Agregar salsas
        if (isset($item['combo_sauces']) && is_array($item['combo_sauces'])) {
            $sauces_text = implode(', ', $item['combo_sauces']);
            $combo_details[] = '<strong>🌶️ Salsas (6x250gr):</strong> ' . $sauces_text;
        }
        
        if (!empty($combo_details)) {
            $product_name .= '<div class="combo-order-details" style="margin-top: 10px; padding: 10px; background: #f8f9fa; border-left: 4px solid #007bff; border-radius: 4px;">';
            $product_name .= '<div style="font-weight: bold; margin-bottom: 8px; color: #333;">📋 Detalles del Combo:</div>';
            $product_name .= '<div style="font-size: 0.9em; line-height: 1.4;">';
            $product_name .= implode('<br>', $combo_details);
            $product_name .= '</div>';
            $product_name .= '</div>';
        }
    }
    
    return $product_name;
}

// Hook para personalizar el nombre del producto en emails y órdenes
add_filter('woocommerce_order_item_name', 'customize_combo_order_item_name', 10, 3);

// Guardar los datos del combo en la orden
function save_combo_custom_data_to_order($item, $cart_item_key, $values, $order) {
    if (isset($values['combo_custom_data']) && $values['combo_custom_data']) {
        // Guardar totopos
        if (isset($values['combo_totopos'])) {
            $item->add_meta_data('Combo Totopos', $values['combo_totopos'], true);
        }
        
        // Guardar tortillas
        if (isset($values['combo_tortillas'])) {
            $item->add_meta_data('Combo Tortillas', $values['combo_tortillas'], true);
        }
        
        // Guardar proteínas
        if (isset($values['combo_proteins']) && is_array($values['combo_proteins'])) {
            $proteins_text = implode(', ', $values['combo_proteins']);
            $item->add_meta_data('Combo Proteínas', $proteins_text, true);
        }
        
        // Guardar salsas
        if (isset($values['combo_sauces']) && is_array($values['combo_sauces'])) {
            $sauces_text = implode(', ', $values['combo_sauces']);
            $item->add_meta_data('Combo Salsas', $sauces_text, true);
        }
    }
}

// Hook para guardar datos personalizados en la orden
add_action('woocommerce_checkout_create_order_line_item', 'save_combo_custom_data_to_order', 10, 4);

// Hook para mostrar detalles del combo en el carrito usando JavaScript
add_action('wp_footer', 'add_combo_details_to_cart_js');

// Función para agregar JavaScript que muestre los detalles del combo
function add_combo_details_to_cart_js() {
    // Solo ejecutar en la página del carrito
    if (is_cart()) {
        ?>
        <script>
        jQuery(document).ready(function($) {
            // Función para obtener los datos del combo desde el servidor
            function getComboDetails() {
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: {
                        action: 'get_combo_cart_details',
                        nonce: '<?php echo wp_create_nonce('get_combo_details'); ?>'
                    },
                    success: function(response) {
                        if (response.success && response.data) {
                            response.data.forEach(function(item) {
                                if (item.combo_details) {
                                    var detailsHtml = '<div class="combo-cart-details" style="margin-top: 10px; padding: 12px 15px; background: #f8f9fa; border-radius: 8px;">';
                                    detailsHtml += '<div style="font-weight: bold; margin-bottom: 8px; color: #333;">📋 Detalles del Combo:</div>';
                                    detailsHtml += '<div style="font-size: 0.9em; line-height: 1.4;">';
                                    detailsHtml += item.combo_details;
                                    detailsHtml += '</div>';
                                    detailsHtml += '</div>';
                                    
                                    // Buscar el elemento del producto en el carrito
                                    var productRow = $('.woocommerce-cart-form__cart-item').eq(item.index);
                                    var productNameCell = productRow.find('.product-name');
                                    
                                    // Agregar los detalles después del nombre del producto
                                    if (productNameCell.length && !productNameCell.find('.combo-cart-details').length) {
                                        productNameCell.append(detailsHtml);
                                    }
                                }
                            });
                        }
                    }
                });
            }
            
            // Ejecutar cuando se carga la página
            getComboDetails();
            
            // Ejecutar también cuando se actualiza el carrito
            $(document.body).on('updated_cart_totals', function() {
                setTimeout(getComboDetails, 500);
            });
        });
        </script>
        <?php
    }
}

// AJAX handler para obtener detalles del combo en el carrito
add_action('wp_ajax_get_combo_cart_details', 'get_combo_cart_details_handler');
add_action('wp_ajax_nopriv_get_combo_cart_details', 'get_combo_cart_details_handler');

// Handler para obtener detalles del combo
function get_combo_cart_details_handler() {
    // Verificar nonce
    if (!wp_verify_nonce($_POST['nonce'], 'get_combo_details')) {
        wp_send_json_error('Security check failed');
        return;
    }
    
    $cart_items = WC()->cart->get_cart_contents();
    $combo_items = array();
    
    foreach ($cart_items as $index => $cart_item) {
        if (isset($cart_item['combo_custom_data']) && $cart_item['combo_custom_data']) {
            $combo_details = array();
            
            // Agregar totopos
            if (isset($cart_item['combo_totopos'])) {
                $combo_details[] = '<strong>🥨 Totopos:</strong> ' . $cart_item['combo_totopos'];
            }
            
            // Agregar tortillas
            if (isset($cart_item['combo_tortillas'])) {
                $combo_details[] = '<strong>🌮 Tortillas:</strong> ' . $cart_item['combo_tortillas'];
            }
            
            // Agregar proteínas
            if (isset($cart_item['combo_proteins']) && is_array($cart_item['combo_proteins'])) {
                $proteins_text = implode(', ', $cart_item['combo_proteins']);
                $combo_details[] = '<strong>🍖 Proteínas (3x250gr):</strong> ' . $proteins_text;
            }
            
            // Agregar salsas
            if (isset($cart_item['combo_sauces']) && is_array($cart_item['combo_sauces'])) {
                $sauces_text = implode(', ', $cart_item['combo_sauces']);
                $combo_details[] = '<strong>🌶️ Salsas (6x250gr):</strong> ' . $sauces_text;
            }
            
            if (!empty($combo_details)) {
                $combo_items[] = array(
                    'index' => $index,
                    'combo_details' => implode('<br>', $combo_details)
                );
            }
        }
    }
    
    wp_send_json_success($combo_items);
}

// Test AJAX handler
add_action('wp_ajax_test_adiciones', 'test_adiciones_handler');
add_action('wp_ajax_nopriv_test_adiciones', 'test_adiciones_handler');

function test_adiciones_handler() {
    error_log('=== TEST AJAX Handler llamado ===');
    wp_send_json_success('Test handler working');
}

// Función para crear o verificar producto de adiciones
function ensure_adiciones_product_exists() {
    // Buscar producto existente en categoría adiciones
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 1,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => 'adiciones',
            ),
        ),
    );
    
    $products = get_posts($args);
    
    if (!empty($products)) {
        $product_id = $products[0]->ID;
        $product = wc_get_product($product_id);
        
        // Verificar que el producto sea válido y hacerlo vendible
        if ($product && $product->get_status() === 'publish') {
            make_product_purchasable($product);
            return $product_id;
        }
    }
    
    // Si no existe, crear uno nuevo
    $product_data = array(
        'post_title' => 'Adiciones',
        'post_content' => 'Producto para adiciones de comida',
        'post_status' => 'publish',
        'post_type' => 'product',
        'meta_input' => array(
            '_price' => '1.00',
            '_regular_price' => '1.00',
            '_manage_stock' => 'no',
            '_stock_status' => 'instock',
            '_virtual' => 'yes',
            '_downloadable' => 'no'
        )
    );
    
    $product_id = wp_insert_post($product_data);
    
    if ($product_id) {
        // Asignar a categoría adiciones
        wp_set_object_terms($product_id, 'adiciones', 'product_cat');
        
        // Actualizar datos del producto usando la función de configuración
        $product = wc_get_product($product_id);
        make_product_purchasable($product);
        
        error_log("Producto de adiciones creado con ID: $product_id");
        return $product_id;
    }
    
    return false;
}

// Función para hacer un producto vendible
function make_product_purchasable($product) {
    if (!$product) {
        return false;
    }
    
    error_log('Haciendo producto vendible - ID: ' . $product->get_id());
    
    // Configurar el producto para que sea vendible
    $product->set_status('publish');
    $product->set_stock_status('instock');
    $product->set_manage_stock(false);
    $product->set_virtual(true);
    $product->set_downloadable(false);
    
    // Asegurar que tenga precio
    if (empty($product->get_price()) || $product->get_price() <= 0) {
        $product->set_price('1.00');
        $product->set_regular_price('1.00');
    }
    
    // Guardar cambios
    $product->save();
    
    error_log('Producto configurado como vendible');
    return true;
}

function add_adiciones_to_cart_handler() {
    // Log para debugging
    error_log('=== AJAX Handler llamado ===');
    error_log('POST data: ' . print_r($_POST, true));
    
    // Verificar que WooCommerce esté activo
    if (!class_exists('WooCommerce')) {
        error_log('WooCommerce no está activo');
        wp_send_json_error('WooCommerce not active');
        return;
    }
    
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'woocommerce-add-to-cart')) {
        error_log('Nonce verification failed');
        wp_send_json_error('Security check failed');
        return;
    }
    
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    $adiciones_type = sanitize_text_field($_POST['adiciones_type']);
    $adiciones_value = sanitize_text_field($_POST['adiciones_value']);
    $adiciones_title = sanitize_text_field($_POST['adiciones_title']);
    $size = sanitize_text_field($_POST['size']);
    
    error_log("Datos procesados - Product ID: $product_id, Quantity: $quantity, Type: $adiciones_type, Value: $adiciones_value, Title: $adiciones_title, Size: $size");
    
    // Validate product y asegurar que existe y es válido
    $product = wc_get_product($product_id);
    if (!$product) {
        error_log("Producto no encontrado con ID: $product_id - Intentando crear/verificar producto");
        
        // Intentar crear o verificar producto de adiciones
        $new_product_id = ensure_adiciones_product_exists();
        if ($new_product_id) {
            $product_id = $new_product_id;
            $product = wc_get_product($product_id);
            error_log("Usando producto de adiciones ID: $product_id");
        } else {
            error_log("No se pudo crear/verificar producto de adiciones");
            wp_send_json_error('Could not create/verify adiciones product');
            return;
        }
    }
    
    // Asegurar que el producto sea vendible desde el principio
    make_product_purchasable($product);
    
    error_log("Producto encontrado: " . $product->get_name());
    
    // Verificar que WooCommerce cart esté disponible
    if (!function_exists('WC')) {
        error_log('WC() function no disponible');
        wp_send_json_error('WC function not available');
        return;
    }
    
    if (!WC()->cart) {
        error_log('WC()->cart no disponible');
        wp_send_json_error('WC cart not available');
        return;
    }
    
    // Add to cart with custom options
    $cart_item_data = array(
        'adiciones_type' => $adiciones_type,
        'adiciones_value' => $adiciones_value,
        'adiciones_title' => $adiciones_title,
        'adiciones_size' => $size,
        'custom_product_type' => 'adiciones'
    );
    
    error_log('Intentando agregar al carrito con datos: ' . print_r($cart_item_data, true));
    
    // Verificar detalles del producto antes de agregar al carrito
    error_log('Detalles del producto:');
    error_log('- ID: ' . $product->get_id());
    error_log('- Nombre: ' . $product->get_name());
    error_log('- Precio: ' . $product->get_price());
    error_log('- Estado: ' . $product->get_status());
    error_log('- Tipo: ' . $product->get_type());
    error_log('- En stock: ' . ($product->is_in_stock() ? 'Sí' : 'No'));
    error_log('- Vendible: ' . ($product->is_purchasable() ? 'Sí' : 'No'));
    
    // Verificar si el producto es vendible con detalles específicos
    if (!$product->is_purchasable()) {
        error_log('Producto no es vendible - Investigando razones:');
        error_log('- is_purchasable(): ' . ($product->is_purchasable() ? 'true' : 'false'));
        error_log('- is_in_stock(): ' . ($product->is_in_stock() ? 'true' : 'false'));
        error_log('- get_stock_status(): ' . $product->get_stock_status());
        error_log('- get_manage_stock(): ' . ($product->get_manage_stock() ? 'true' : 'false'));
        error_log('- get_price(): ' . $product->get_price());
        error_log('- get_status(): ' . $product->get_status());
        error_log('- get_type(): ' . $product->get_type());
        
        // Intentar hacer el producto vendible
        error_log('Intentando hacer el producto vendible...');
        
        // Asegurar que esté en stock
        $product->set_stock_status('instock');
        
        // Asegurar que tenga precio
        if (empty($product->get_price()) || $product->get_price() <= 0) {
            $product->set_price('1.00');
            $product->set_regular_price('1.00');
        }
        
        // Asegurar que no gestione stock (para productos virtuales)
        $product->set_manage_stock(false);
        
        // Guardar cambios
        $product->save();
        
        error_log('Cambios aplicados al producto');
        
        // Verificar nuevamente
        if (!$product->is_purchasable()) {
            error_log('Producto sigue sin ser vendible después de los cambios');
            wp_send_json_error('Product is not purchasable even after fixes');
            return;
        } else {
            error_log('Producto ahora es vendible');
        }
    }
    
    // Verificar si el producto está en stock
    if (!$product->is_in_stock()) {
        error_log('Producto no está en stock');
        wp_send_json_error('Product is out of stock');
        return;
    }
    
    // Verificar precio y establecer uno temporal si es necesario
    $product_price = $product->get_price();
    if (empty($product_price) || $product_price <= 0) {
        error_log('Producto no tiene precio válido: ' . $product_price . ' - Estableciendo precio temporal');
        
        // Establecer un precio temporal para el producto
        $product->set_price('1.00'); // Precio mínimo
        $product->save();
        
        error_log('Precio temporal establecido: 1.00');
    }
    
    try {
        $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity, 0, array(), $cart_item_data);
        
        if ($cart_item_key) {
            error_log('Producto agregado exitosamente al carrito. Cart item key: ' . $cart_item_key);
            wp_send_json_success(array(
                'message' => 'Adición agregada al carrito exitosamente',
                'cart_item_key' => $cart_item_key
            ));
        } else {
            error_log('Error al agregar al carrito - cart_item_key es false');
            
            // Obtener errores del carrito
            $cart_errors = WC()->cart->get_errors();
            if (!empty($cart_errors)) {
                error_log('Errores del carrito: ' . print_r($cart_errors, true));
                wp_send_json_error('Cart errors: ' . implode(', ', $cart_errors));
            } else {
                wp_send_json_error('Failed to add to cart - cart_item_key is false (no specific errors)');
            }
        }
    } catch (Exception $e) {
        error_log('Excepción al agregar al carrito: ' . $e->getMessage());
        wp_send_json_error('Exception: ' . $e->getMessage());
    }
}

// Display custom data in cart
add_filter('woocommerce_get_item_data', 'display_adiciones_cart_item_data', 10, 2);

function display_adiciones_cart_item_data($item_data, $cart_item) {
    if (isset($cart_item['custom_product_type']) && $cart_item['custom_product_type'] === 'adiciones') {
        if (isset($cart_item['adiciones_title'])) {
            $item_data[] = array(
                'name'    => 'Adición',
                'value'   => $cart_item['adiciones_title'],
                'display' => $cart_item['adiciones_title']
            );
        }
        
        if (isset($cart_item['adiciones_size'])) {
            $size_labels = array(
                'small' => 'Pequeño',
                'medium' => 'Mediano',
                'large' => 'Grande'
            );
            $size_label = isset($size_labels[$cart_item['adiciones_size']]) ? $size_labels[$cart_item['adiciones_size']] : $cart_item['adiciones_size'];
            
            $item_data[] = array(
                'name'    => 'Tamaño',
                'value'   => $size_label,
                'display' => $size_label
            );
        }
    }
    
    return $item_data;
}
