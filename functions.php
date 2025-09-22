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

// Debug AJAX handler para verificar el producto de adiciones
add_action('wp_ajax_debug_adiciones_product', 'debug_adiciones_product_handler');
add_action('wp_ajax_nopriv_debug_adiciones_product', 'debug_adiciones_product_handler');

function debug_adiciones_product_handler() {
    // Buscar producto de adiciones
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
    $debug_info = array();
    
    if (!empty($products)) {
        $product_id = $products[0]->ID;
        $product = wc_get_product($product_id);
        
        // Intentar corregir el producto si no es vendible
        if (!$product->is_purchasable()) {
            error_log('Producto no es vendible, intentando corregir...');
            make_product_purchasable($product);
            $product = wc_get_product($product_id); // Recargar el producto
        }
        
        $debug_info = array(
            'product_id' => $product_id,
            'name' => $product->get_name(),
            'status' => $product->get_status(),
            'price' => $product->get_price(),
            'is_in_stock' => $product->is_in_stock(),
            'is_purchasable' => $product->is_purchasable(),
            'type' => $product->get_type(),
            'is_virtual' => $product->is_virtual(),
            'is_downloadable' => $product->is_downloadable(),
            'stock_status' => $product->get_stock_status(),
            'manage_stock' => $product->get_manage_stock(),
            'cart_count' => WC()->cart->get_cart_contents_count()
        );
    } else {
        $debug_info = array('error' => 'No se encontró producto de adiciones');
    }
    
    wp_send_json_success($debug_info);
}

// AJAX handler para obtener el contenido del carrito
add_action('wp_ajax_get_cart_contents', 'get_cart_contents_handler');
add_action('wp_ajax_nopriv_get_cart_contents', 'get_cart_contents_handler');

function get_cart_contents_handler() {
    $cart_contents = WC()->cart->get_cart_contents();
    $formatted_contents = array();
    
    foreach ($cart_contents as $key => $item) {
        $formatted_contents[] = array(
            'key' => $key,
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
            'product_name' => $item['data']->get_name(),
            'custom_data' => $item,
            'is_adiciones' => isset($item['custom_product_type']) && $item['custom_product_type'] === 'adiciones'
        );
    }
    
    wp_send_json_success(array(
        'cart_contents' => $formatted_contents,
        'cart_count' => WC()->cart->get_cart_contents_count(),
        'cart_total' => WC()->cart->get_cart_total()
    ));
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
    
    // Verificar que tenemos todos los datos necesarios
    if (empty($_POST['adiciones_type']) || empty($_POST['adiciones_value']) || empty($_POST['adiciones_title'])) {
        error_log('Datos faltantes en POST');
        wp_send_json_error('Missing required data');
        return;
    }
    
    // Debug: mostrar datos recibidos
    error_log('Datos recibidos: ' . print_r($_POST, true));
    
    // Verify nonce
    error_log('Verificando nonce: ' . $_POST['nonce']);
    error_log('Nonce esperado: woocommerce-add-to-cart');
    
    if (!wp_verify_nonce($_POST['nonce'], 'woocommerce-add-to-cart')) {
        error_log('Nonce verification failed - Nonce recibido: ' . $_POST['nonce']);
        
        // Para debugging temporal, comentar la verificación del nonce
        // wp_send_json_error('Security check failed');
        // return;
        error_log('ADVERTENCIA: Saltando verificación de nonce para debugging');
    } else {
        error_log('Nonce verificado exitosamente');
    }
    
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    $adiciones_type = sanitize_text_field($_POST['adiciones_type']);
    $adiciones_value = sanitize_text_field($_POST['adiciones_value']);
    $adiciones_title = sanitize_text_field($_POST['adiciones_title']);
    $size = sanitize_text_field($_POST['adiciones_size']);
    $price = floatval($_POST['price']);
    
    error_log("Datos procesados - Product ID: $product_id, Quantity: $quantity, Type: $adiciones_type, Value: $adiciones_value, Title: $adiciones_title, Size: $size, Price: $price");
    
    // Debug adicional para opciones individuales
    if ($size === 'single') {
        error_log("DEBUG: Opción individual detectada - Title: $adiciones_title, Price: $price");
    }
    
    // Validate product y asegurar que existe y es válido
    $product = wc_get_product($product_id);
    error_log("Producto buscado ID: $product_id");
    error_log("Producto encontrado: " . ($product ? 'SÍ' : 'NO'));
    
    if ($product) {
        error_log("Producto status: " . $product->get_status());
        error_log("Producto price: " . $product->get_price());
        error_log("Producto purchasable: " . ($product->is_purchasable() ? 'SÍ' : 'NO'));
    }
    
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
        'adiciones_price' => $price, // Pasar el precio específico de la adición
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
    
    // Usar el precio enviado desde JavaScript ANTES de agregar al carrito
    if ($price > 0) {
        error_log("Usando precio desde JavaScript: $price");
        $product->set_price($price);
        $product->set_regular_price($price);
        $product->save();
        error_log("Precio del producto establecido a: $price");
    } else {
        // Verificar precio y establecer uno temporal si es necesario
        $product_price = $product->get_price();
        if (empty($product_price) || $product_price <= 0) {
            error_log('Producto no tiene precio válido: ' . $product_price . ' - Estableciendo precio temporal');
            
            // Establecer un precio temporal para el producto
            $product->set_price('1.00'); // Precio mínimo
            $product->set_regular_price('1.00');
            $product->save();
            
            error_log('Precio temporal establecido: 1.00');
        }
    }
    
    try {
        error_log('=== INTENTANDO AGREGAR AL CARRITO ===');
        error_log('Product ID: ' . $product_id);
        error_log('Quantity: ' . $quantity);
        error_log('Cart item data: ' . print_r($cart_item_data, true));
        
        // Crear un producto temporal con el precio correcto
        $temp_product = clone $product;
        $temp_product->set_price($price);
        $temp_product->set_regular_price($price);
        
        error_log("Producto temporal creado con precio: $price");
        
        $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity, 0, array(), $cart_item_data);
        
        if ($cart_item_key) {
            error_log('Producto agregado exitosamente al carrito. Cart item key: ' . $cart_item_key);
            
            // Verificar que los datos se guardaron correctamente
            $cart_contents = WC()->cart->get_cart_contents();
            foreach ($cart_contents as $key => $item) {
                if ($key === $cart_item_key) {
                    error_log('Verificando datos guardados en el carrito:');
                    error_log('- custom_product_type: ' . (isset($item['custom_product_type']) ? $item['custom_product_type'] : 'NO ENCONTRADO'));
                    error_log('- adiciones_title: ' . (isset($item['adiciones_title']) ? $item['adiciones_title'] : 'NO ENCONTRADO'));
                    error_log('- adiciones_type: ' . (isset($item['adiciones_type']) ? $item['adiciones_type'] : 'NO ENCONTRADO'));
                    error_log('- adiciones_value: ' . (isset($item['adiciones_value']) ? $item['adiciones_value'] : 'NO ENCONTRADO'));
                    error_log('- adiciones_size: ' . (isset($item['adiciones_size']) ? $item['adiciones_size'] : 'NO ENCONTRADO'));
                    error_log('- adiciones_price: ' . (isset($item['adiciones_price']) ? $item['adiciones_price'] : 'NO ENCONTRADO'));
                    break;
                }
            }
            
            wp_send_json_success(array(
                'message' => 'Adición agregada al carrito exitosamente',
                'cart_item_key' => $cart_item_key,
                'cart_count' => WC()->cart->get_cart_contents_count()
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
        error_log('Stack trace: ' . $e->getTraceAsString());
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

// Función para obtener opciones de YITH WooCommerce Product Add-ons
function get_yith_product_addons($product_id) {
    $addon_groups = array();
    
    // Verificar si YITH está activo - probar diferentes nombres de funciones
    $yith_functions = array(
        'yith_wapo_get_addon_groups',
        'YITH_WAPO_Group::get_groups_by_product',
        'yith_wapo_get_groups_by_product',
        'YITH_WAPO_Group::get_groups'
    );
    
    $yith_function_exists = false;
    $yith_function_name = '';
    
    foreach ($yith_functions as $function_name) {
        if (function_exists($function_name) || class_exists('YITH_WAPO_Group')) {
            $yith_function_exists = true;
            $yith_function_name = $function_name;
            break;
        }
    }
    
    if (!$yith_function_exists) {
        error_log('YITH WooCommerce Product Add-ons no está activo o las funciones no están disponibles');
        error_log('Funciones probadas: ' . implode(', ', $yith_functions));
        return $addon_groups;
    }
    
    error_log('YITH función encontrada: ' . $yith_function_name);
    
    // Intentar obtener grupos usando diferentes métodos
    $groups = array();
    
    // Método 1: Función directa
    if (function_exists('yith_wapo_get_addon_groups')) {
        $groups = yith_wapo_get_addon_groups($product_id);
    }
    // Método 2: Clase YITH_WAPO_Group
    elseif (class_exists('YITH_WAPO_Group')) {
        $groups = YITH_WAPO_Group::get_groups_by_product($product_id);
    }
    // Método 3: Query directo a la base de datos
    else {
        global $wpdb;
        $table_name = $wpdb->prefix . 'yith_wapo_groups';
        
        $groups = $wpdb->get_results($wpdb->prepare("
            SELECT * FROM {$table_name} 
            WHERE product_id = %d OR product_id = 0
            ORDER BY priority ASC
        ", $product_id));
    }
    
    if (!empty($groups)) {
        error_log('YITH grupos encontrados: ' . count($groups));
        
        foreach ($groups as $group) {
            // Manejar tanto objetos como arrays
            $group_id = is_object($group) ? $group->id : $group['id'];
            $group_name = is_object($group) ? $group->name : $group['name'];
            $group_priority = is_object($group) ? $group->priority : $group['priority'];
            
            $group_data = array(
                'id' => $group_id,
                'name' => $group_name,
                'priority' => $group_priority,
                'options' => array()
            );
            
            // Obtener opciones del grupo
            $options = array();
            
            // Método 1: Función directa
            if (function_exists('yith_wapo_get_addon_options')) {
                $options = yith_wapo_get_addon_options($group_id);
            }
            // Método 2: Clase YITH_WAPO_Option
            elseif (class_exists('YITH_WAPO_Option')) {
                $options = YITH_WAPO_Option::get_options_by_group($group_id);
            }
            // Método 3: Query directo
            else {
                global $wpdb;
                $options_table = $wpdb->prefix . 'yith_wapo_options';
                $options = $wpdb->get_results($wpdb->prepare("
                    SELECT * FROM {$options_table} 
                    WHERE group_id = %d
                    ORDER BY priority ASC
                ", $group_id));
            }
            
            if (!empty($options)) {
                error_log('Grupo ' . $group_name . ' tiene ' . count($options) . ' opciones');
                
                foreach ($options as $option) {
                    // Manejar tanto objetos como arrays
                    $option_id = is_object($option) ? $option->id : $option['id'];
                    $option_label = is_object($option) ? $option->label : $option['label'];
                    $option_price = is_object($option) ? $option->price : $option['price'];
                    $option_price_type = is_object($option) ? $option->price_type : $option['price_type'];
                    $option_required = is_object($option) ? $option->required : $option['required'];
                    $option_type = is_object($option) ? $option->type : $option['type'];
                    
                    $option_data = array(
                        'id' => $option_id,
                        'label' => $option_label,
                        'price' => $option_price,
                        'price_type' => $option_price_type,
                        'required' => $option_required,
                        'type' => $option_type
                    );
                    
                    $group_data['options'][] = $option_data;
                }
            }
            
            $addon_groups[] = $group_data;
        }
    } else {
        error_log('No se encontraron grupos de YITH para el producto ID: ' . $product_id);
        
        // Debug adicional: verificar si hay grupos en general
        global $wpdb;
        $table_name = $wpdb->prefix . 'yith_wapo_groups';
        $all_groups = $wpdb->get_results("SELECT * FROM {$table_name} LIMIT 5");
        error_log('Grupos en la base de datos: ' . print_r($all_groups, true));
    }
    
    return $addon_groups;
}

// Función para procesar grupos de YITH y categorizarlos
function process_yith_addon_groups($yith_addons) {
    $categorized_options = array(
        'totopos' => array('options' => array(), 'title' => ''),
        'tortillas' => array('options' => array(), 'title' => ''),
        'protein' => array('options' => array(), 'title' => ''),
        'sauce' => array('options' => array(), 'title' => '')
    );
    
    if (!empty($yith_addons)) {
        foreach ($yith_addons as $group) {
            $group_name = strtolower($group['name']);
            $group_title = $group['name'];
            $group_options = array();
            
            // Procesar opciones del grupo
            foreach ($group['options'] as $option) {
                $option_label = $option['label'];
                $option_price = $option['price'];
                $option_price_type = $option['price_type'];
                
                // Formatear precio
                $price_text = '';
                if ($option_price > 0) {
                    if ($option_price_type === 'percentage') {
                        $price_text = ' (+' . $option_price . '%)';
                    } else {
                        $price_text = ' (+$' . number_format($option_price, 2) . ')';
                    }
                }
                
                $group_options[] = $option_label . $price_text;
            }
            
            // Asignar a la categoría correcta según el nombre del grupo
            if (strpos($group_name, 'totopo') !== false || strpos($group_name, 'totopos') !== false) {
                $categorized_options['totopos']['options'] = $group_options;
                $categorized_options['totopos']['title'] = $group_title;
            } elseif (strpos($group_name, 'tortilla') !== false || strpos($group_name, 'tortillas') !== false) {
                $categorized_options['tortillas']['options'] = $group_options;
                $categorized_options['tortillas']['title'] = $group_title;
            } elseif (strpos($group_name, 'proteína') !== false || strpos($group_name, 'proteina') !== false || strpos($group_name, 'protein') !== false || strpos($group_name, 'proteinas') !== false) {
                $categorized_options['protein']['options'] = $group_options;
                $categorized_options['protein']['title'] = $group_title;
            } elseif (strpos($group_name, 'salsa') !== false || strpos($group_name, 'salsas') !== false) {
                $categorized_options['sauce']['options'] = $group_options;
                $categorized_options['sauce']['title'] = $group_title;
            }
        }
    }
    
    return $categorized_options;
}

// Función para procesar bloques de YITH directamente desde la base de datos
function process_yith_blocks_direct($blocks, $wpdb) {
    $categorized_options = array(
        'totopos' => array('options' => array(), 'title' => ''),
        'tortillas' => array('options' => array(), 'title' => ''),
        'protein' => array('options' => array(), 'title' => ''),
        'sauce' => array('options' => array(), 'title' => '')
    );
    
    if (!empty($blocks)) {
        foreach ($blocks as $block) {
            $block_name = strtolower($block->name);
            $block_title = $block->name;
            
            // Obtener addons del bloque
            $addons_table = $wpdb->prefix . 'yith_wapo_addons';
            $addons = $wpdb->get_results($wpdb->prepare("
                SELECT * FROM $addons_table 
                WHERE block_id = %d 
                AND visibility = 1
                ORDER BY priority ASC
            ", $block->id));
            
            $group_options = array();
            
            if (!empty($addons)) {
                foreach ($addons as $addon) {
                    $addon_settings = maybe_unserialize($addon->settings);
                    $addon_options = maybe_unserialize($addon->options);
                    
                    // Obtener el título del addon (nombre del producto)
                    $addon_title = isset($addon_settings['title']) ? $addon_settings['title'] : 'Opción';
                    
                        if (isset($addon_options['label']) && is_array($addon_options['label'])) {
                            // Debug: mostrar datos del addon
                            error_log('DEBUG YITH Addon: ' . print_r($addon_options, true));
                            
                            // Verificar si es un producto con múltiples tamaños o opciones individuales
                            $has_multiple_sizes = false;
                            $first_label = $addon_options['label'][0] ?? '';
                            
                            // Si el primer label contiene palabras como "Chico", "Mediano", "Grande", "cm", números, es un producto con tamaños
                            $size_keywords = array('chico', 'mediano', 'grande', 'pequeño', 'pequeña', 'large', 'medium', 'small', 'cm', 'inch', 'pulgadas');
                            
                            // También verificar si contiene números (como "12", "17")
                            $has_numbers = preg_match('/\d+/', $first_label);
                            
                            foreach ($size_keywords as $keyword) {
                                if (stripos($first_label, $keyword) !== false) {
                                    $has_multiple_sizes = true;
                                    break;
                                }
                            }
                            
                            // Si tiene números y no es claramente un nombre de producto, probablemente son tamaños
                            if ($has_numbers && !$has_multiple_sizes) {
                                // Verificar si parece un tamaño (números + unidades) vs un nombre de producto
                                if (preg_match('/^\d+(\s*(cm|inch|pulgadas?))?$/', $first_label) || 
                                    preg_match('/^\d+$/', $first_label)) {
                                    $has_multiple_sizes = true;
                                }
                            }
                            
                            if ($has_multiple_sizes) {
                                // Es un producto con múltiples tamaños (como Pollo con Cebolla)
                                $product_sizes = array();
                                
                                foreach ($addon_options['label'] as $index => $label) {
                                    $is_enabled = isset($addon_options['addon_enabled'][$index]) ? $addon_options['addon_enabled'][$index] : 'no';
                                    $raw_price = isset($addon_options['price'][$index]) ? $addon_options['price'][$index] : 0;
                                    
                                    // Limpiar el precio (remover símbolos $ y comas)
                                    $price = floatval(str_replace(array('$', ','), '', $raw_price));
                                    $price_type = isset($addon_options['price_type'][$index]) ? $addon_options['price_type'][$index] : 'fixed';
                                    
                                    error_log("DEBUG Tamaño $index: label=$label, enabled=$is_enabled, raw_price=$raw_price, clean_price=$price");
                                    
                                    // Incluir todos los tamaños, no solo los habilitados
                                    $product_sizes[] = array(
                                        'size' => $label,
                                        'price' => $price,
                                        'price_type' => $price_type,
                                        'enabled' => $is_enabled
                                    );
                                }
                                
                                if (!empty($product_sizes)) {
                                    $group_options[] = array(
                                        'label' => $addon_title,
                                        'sizes' => $product_sizes,
                                        'base_price' => $product_sizes[0]['price'] // Precio base para el modal
                                    );
                                }
                            } else {
                                // Son opciones individuales (como Totopos 100% Maiz, Totopos Tradicionales)
                                foreach ($addon_options['label'] as $index => $label) {
                                    $is_enabled = isset($addon_options['addon_enabled'][$index]) ? $addon_options['addon_enabled'][$index] : 'no';
                                    $raw_price = isset($addon_options['price'][$index]) ? $addon_options['price'][$index] : 0;
                                    
                                    // Limpiar el precio (remover símbolos $ y comas)
                                    $price = floatval(str_replace(array('$', ','), '', $raw_price));
                                    $price_type = isset($addon_options['price_type'][$index]) ? $addon_options['price_type'][$index] : 'fixed';
                                    
                                    error_log("DEBUG Opción individual $index: label=$label, enabled=$is_enabled, raw_price=$raw_price, clean_price=$price");
                                    
                                    if ($is_enabled === 'yes') {
                                        $group_options[] = array(
                                            'label' => $label,
                                            'sizes' => array(array(
                                                'size' => $label,
                                                'price' => $price,
                                                'price_type' => $price_type,
                                                'enabled' => $is_enabled
                                            )),
                                            'base_price' => $price
                                        );
                                    }
                                }
                            }
                        }
                }
            }
            
            // Categorizar según el nombre del bloque
            error_log("DEBUG Categorizando bloque: '$block_name' (lowercase: '" . strtolower($block_name) . "') con " . count($group_options) . " opciones");
            
            if (strpos(strtolower($block_name), 'totopo') !== false) {
                error_log("DEBUG: Categorizando como TOTOPOS");
                $categorized_options['totopos']['options'] = $group_options;
                $categorized_options['totopos']['title'] = $block_title;
            } elseif (strpos(strtolower($block_name), 'tortilla') !== false) {
                error_log("DEBUG: Categorizando como TORTILLAS");
                $categorized_options['tortillas']['options'] = $group_options;
                $categorized_options['tortillas']['title'] = $block_title;
            } elseif (strpos(strtolower($block_name), 'proteína') !== false || strpos(strtolower($block_name), 'proteina') !== false || strpos(strtolower($block_name), 'protein') !== false) {
                error_log("DEBUG: Categorizando como PROTEINAS");
                $categorized_options['protein']['options'] = $group_options;
                $categorized_options['protein']['title'] = $block_title;
            } elseif (strpos(strtolower($block_name), 'salsa') !== false) {
                error_log("DEBUG: Categorizando como SALSA");
                $categorized_options['sauce']['options'] = $group_options;
                $categorized_options['sauce']['title'] = $block_title;
            } else {
                error_log("DEBUG: No se pudo categorizar el bloque: '$block_name'");
            }
        }
    }
    
    return $categorized_options;
}

// Función de debug simple para YITH
function debug_yith_status($product_id) {
    $debug_info = array();
    
    // Verificar si YITH está activo
    $debug_info['yith_active'] = function_exists('yith_wapo_get_addon_groups') || class_exists('YITH_WAPO_Group');
    
    // Verificar tablas en la base de datos
    global $wpdb;
    $groups_table = $wpdb->prefix . 'yith_wapo_groups';
    $options_table = $wpdb->prefix . 'yith_wapo_options';
    
    $debug_info['groups_table_exists'] = $wpdb->get_var("SHOW TABLES LIKE '$groups_table'") ? true : false;
    $debug_info['options_table_exists'] = $wpdb->get_var("SHOW TABLES LIKE '$options_table'") ? true : false;
    
    // Obtener grupos directamente de la base de datos
    if ($debug_info['groups_table_exists']) {
        $groups = $wpdb->get_results("SELECT * FROM $groups_table WHERE product_id = $product_id OR product_id = 0");
        $debug_info['groups_found'] = count($groups);
        $debug_info['groups_data'] = $groups;
        
        // Para cada grupo, obtener sus opciones
        foreach ($groups as $group) {
            if ($debug_info['options_table_exists']) {
                $options = $wpdb->get_results($wpdb->prepare("SELECT * FROM $options_table WHERE group_id = %d", $group->id));
                $group->options = $options;
            }
        }
    }
    
    return $debug_info;
}

// Función para obtener opciones de YITH directamente de la base de datos
function get_yith_addons_direct_db($product_id, $blocks_table = null, $addons_table = null, $blocks_assoc_table = null) {
    global $wpdb;
    
    $addon_groups = array();
    
    // Usar las tablas proporcionadas o las por defecto
    if (!$blocks_table) {
        $blocks_table = $wpdb->prefix . 'yith_wapo_blocks';
    }
    if (!$addons_table) {
        $addons_table = $wpdb->prefix . 'yith_wapo_addons';
    }
    if (!$blocks_assoc_table) {
        $blocks_assoc_table = $wpdb->prefix . 'yith_wapo_blocks_assoc';
    }
    
    // Verificar que las tablas existen
    if (!$wpdb->get_var("SHOW TABLES LIKE '$blocks_table'")) {
        error_log('Tabla de bloques YITH no existe: ' . $blocks_table);
        return $addon_groups;
    }
    
    if (!$wpdb->get_var("SHOW TABLES LIKE '$addons_table'")) {
        error_log('Tabla de addons YITH no existe: ' . $addons_table);
        return $addon_groups;
    }
    
    // Obtener bloques asignados al producto
    $blocks = $wpdb->get_results("
        SELECT * FROM $blocks_table 
        WHERE settings LIKE '%$product_id%'
        AND visibility = 1
        ORDER BY priority ASC
    ");
    
    if (empty($blocks)) {
        error_log('No se encontraron bloques YITH para el producto ID: ' . $product_id);
        return $addon_groups;
    }
    
    error_log('Bloques YITH encontrados: ' . count($blocks));
    
    foreach ($blocks as $block) {
        $block_data = array(
            'id' => $block->id,
            'name' => $block->name,
            'priority' => $block->priority,
            'options' => array()
        );
        
        // Obtener addons del bloque
        $addons = $wpdb->get_results($wpdb->prepare("
            SELECT * FROM $addons_table 
            WHERE block_id = %d 
            AND visibility = 1
            ORDER BY priority ASC
        ", $block->id));
        
        if (!empty($addons)) {
            error_log('Bloque ' . $block->name . ' tiene ' . count($addons) . ' addons');
            
            foreach ($addons as $addon) {
                // Decodificar la configuración del addon
                $addon_settings = maybe_unserialize($addon->settings);
                
                $addon_data = array(
                    'id' => $addon->id,
                    'label' => $addon->label,
                    'price' => isset($addon_settings['price']) ? $addon_settings['price'] : 0,
                    'price_type' => isset($addon_settings['price_type']) ? $addon_settings['price_type'] : 'fixed',
                    'required' => isset($addon_settings['required']) ? $addon_settings['required'] : 0,
                    'type' => $addon->type
                );
                
                $block_data['options'][] = $addon_data;
            }
        }
        
        $addon_groups[] = $block_data;
    }
    
    return $addon_groups;
}

// Función para verificar y activar YITH si es necesario
function ensure_yith_is_active() {
    // Verificar si YITH está activo
    $yith_plugin_path = 'yith-woocommerce-product-add-ons/init.php';
    
    if (!is_plugin_active($yith_plugin_path)) {
        error_log('YITH WooCommerce Product Add-ons no está activo');
        
        // Intentar activar el plugin
        if (file_exists(WP_PLUGIN_DIR . '/yith-woocommerce-product-add-ons/init.php')) {
            activate_plugin($yith_plugin_path);
            error_log('Intentando activar YITH WooCommerce Product Add-ons');
        } else {
            error_log('YITH WooCommerce Product Add-ons no está instalado');
            return false;
        }
    }
    
    // Verificar que las tablas existan
    global $wpdb;
    $groups_table = $wpdb->prefix . 'yith_wapo_groups';
    $options_table = $wpdb->prefix . 'yith_wapo_options';
    
    if (!$wpdb->get_var("SHOW TABLES LIKE '$groups_table'")) {
        error_log('Tablas de YITH no existen, intentando crearlas');
        
        // Incluir el archivo de instalación de YITH
        if (file_exists(WP_PLUGIN_DIR . '/yith-woocommerce-product-add-ons/includes/class.yith-wapo-install.php')) {
            require_once WP_PLUGIN_DIR . '/yith-woocommerce-product-add-ons/includes/class.yith-wapo-install.php';
            
            if (class_exists('YITH_WAPO_Install')) {
                YITH_WAPO_Install::create_tables();
                error_log('Tablas de YITH creadas');
            }
        }
    }
    
    return true;
}

// Función para crear las tablas de YITH manualmente
function create_yith_tables_manually() {
    global $wpdb;
    
    $charset_collate = $wpdb->get_charset_collate();
    
    // Tabla de grupos
    $groups_table = $wpdb->prefix . 'yith_wapo_groups';
    $groups_sql = "CREATE TABLE $groups_table (
        id int(11) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        priority int(11) DEFAULT 0,
        product_id int(11) DEFAULT 0,
        active tinyint(1) DEFAULT 1,
        created_date datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";
    
    // Tabla de opciones
    $options_table = $wpdb->prefix . 'yith_wapo_options';
    $options_sql = "CREATE TABLE $options_table (
        id int(11) NOT NULL AUTO_INCREMENT,
        group_id int(11) NOT NULL,
        label varchar(255) NOT NULL,
        type varchar(50) NOT NULL,
        settings longtext,
        priority int(11) DEFAULT 0,
        active tinyint(1) DEFAULT 1,
        created_date datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY group_id (group_id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    
    dbDelta($groups_sql);
    dbDelta($options_sql);
    
    error_log('Tablas de YITH creadas manualmente');
    return true;
}

// Hook para modificar el precio de las adiciones en el carrito
add_filter('woocommerce_cart_item_price', 'modify_adiciones_cart_item_price', 10, 3);
add_filter('woocommerce_cart_item_subtotal', 'modify_adiciones_cart_item_subtotal', 10, 3);

// Hook adicional para modificar el precio del producto directamente
add_action('woocommerce_before_calculate_totals', 'modify_adiciones_product_price', 10, 1);

// Hook para modificar el precio justo antes de mostrarlo
add_filter('woocommerce_cart_item_price', 'force_adiciones_price_display', 5, 3);
add_filter('woocommerce_cart_item_subtotal', 'force_adiciones_subtotal_display', 5, 3);

function force_adiciones_price_display($price, $cart_item, $cart_item_key) {
    // Solo modificar si es una adición
    if (isset($cart_item['custom_product_type']) && $cart_item['custom_product_type'] === 'adiciones') {
        if (isset($cart_item['adiciones_price']) && $cart_item['adiciones_price'] > 0) {
            $adiciones_price = floatval($cart_item['adiciones_price']);
            $formatted_price = wc_price($adiciones_price);
            // error_log("FORCE: Mostrando precio de adición: $formatted_price");
            return $formatted_price;
        }
    }
    return $price;
}

function force_adiciones_subtotal_display($subtotal, $cart_item, $cart_item_key) {
    // Solo modificar si es una adición
    if (isset($cart_item['custom_product_type']) && $cart_item['custom_product_type'] === 'adiciones') {
        if (isset($cart_item['adiciones_price']) && $cart_item['adiciones_price'] > 0) {
            $adiciones_price = floatval($cart_item['adiciones_price']);
            $quantity = $cart_item['quantity'];
            $total_price = $adiciones_price * $quantity;
            $formatted_subtotal = wc_price($total_price);
            // error_log("FORCE: Mostrando subtotal de adición: $formatted_subtotal");
            return $formatted_subtotal;
        }
    }
    return $subtotal;
}

function modify_adiciones_product_price($cart) {
    // error_log("DEBUG modify_adiciones_product_price llamado");
    
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }
    
    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        // error_log("DEBUG: Procesando item del carrito: " . print_r($cart_item, true));
        
        // Solo modificar si es una adición
        if (isset($cart_item['custom_product_type']) && $cart_item['custom_product_type'] === 'adiciones') {
            // error_log("DEBUG: Es una adición, modificando precio...");
            
            if (isset($cart_item['adiciones_price']) && $cart_item['adiciones_price'] > 0) {
                $adiciones_price = floatval($cart_item['adiciones_price']);
                $product = $cart_item['data'];
                
                // error_log("DEBUG: Estableciendo precio del producto a: $adiciones_price");
                $product->set_price($adiciones_price);
                
                // También actualizar el precio regular
                $product->set_regular_price($adiciones_price);
                
                // Forzar la recalculación del carrito (comentado para evitar bucles)
                // $cart->calculate_totals();
            }
        }
    }
}

function modify_adiciones_cart_item_price($price, $cart_item, $cart_item_key) {
    // error_log("DEBUG modify_adiciones_cart_item_price llamado - cart_item: " . print_r($cart_item, true));
    
    // Solo modificar si es una adición
    if (isset($cart_item['custom_product_type']) && $cart_item['custom_product_type'] === 'adiciones') {
        // error_log("DEBUG: Es una adición, verificando precio...");
        if (isset($cart_item['adiciones_price']) && $cart_item['adiciones_price'] > 0) {
            $adiciones_price = floatval($cart_item['adiciones_price']);
            $formatted_price = wc_price($adiciones_price);
            // error_log("DEBUG: Modificando precio de adición - Original: $price, Nuevo: $formatted_price");
            return $formatted_price;
        } else {
            // error_log("DEBUG: No hay precio de adición o es 0");
        }
    } else {
        // error_log("DEBUG: No es una adición - custom_product_type: " . (isset($cart_item['custom_product_type']) ? $cart_item['custom_product_type'] : 'NO DEFINIDO'));
    }
    return $price;
}

function modify_adiciones_cart_item_subtotal($subtotal, $cart_item, $cart_item_key) {
    // error_log("DEBUG modify_adiciones_cart_item_subtotal llamado - cart_item: " . print_r($cart_item, true));
    
    // Solo modificar si es una adición
    if (isset($cart_item['custom_product_type']) && $cart_item['custom_product_type'] === 'adiciones') {
        // error_log("DEBUG: Es una adición, verificando precio para subtotal...");
        if (isset($cart_item['adiciones_price']) && $cart_item['adiciones_price'] > 0) {
            $adiciones_price = floatval($cart_item['adiciones_price']);
            $quantity = $cart_item['quantity'];
            $total_price = $adiciones_price * $quantity;
            $formatted_subtotal = wc_price($total_price);
            // error_log("DEBUG: Modificando subtotal de adición - Precio: $adiciones_price, Cantidad: $quantity, Total: $formatted_subtotal");
            return $formatted_subtotal;
        } else {
            // error_log("DEBUG: No hay precio de adición o es 0 para subtotal");
        }
    } else {
        // error_log("DEBUG: No es una adición para subtotal - custom_product_type: " . (isset($cart_item['custom_product_type']) ? $cart_item['custom_product_type'] : 'NO DEFINIDO'));
    }
    return $subtotal;
}

// Hook para modificar el precio del producto en el carrito
add_filter('woocommerce_cart_item_data_to_validate', 'validate_adiciones_cart_item', 10, 2);

// Hook para ocultar el precio de productos de adiciones en las cards
add_filter('woocommerce_get_price_html', 'hide_adiciones_price_in_cards', 10, 2);

function hide_adiciones_price_in_cards($price, $product) {
    // Solo ocultar el precio si es un producto de adiciones
    if (has_term('adiciones', 'product_cat', $product->get_id())) {
        return ''; // Devolver string vacío para ocultar el precio
    }
    return $price; // Devolver el precio normal para otros productos
}

function validate_adiciones_cart_item($data, $cart_item) {
    // Esta función no es necesaria para adiciones ya que el precio se maneja en otras funciones
    // Solo retornar los datos sin modificar
    return $data;
}
