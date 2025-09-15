<?php
/**
 * Template Name: Adiciones
 * 
 * Template para adiciones de productos
 *
 * @package Chicanos_Theme
 */

get_header(); ?>


<!-- DEBUG: Template de Adiciones cargado correctamente -->
<div id="adiciones-wrapper" class="wrapper">
    <div class="container">
        
        <!-- Banner Section -->
        <div class="combo-banner-section mb-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="combo-info-content">
                         <h1 class="combo-main-title">Adiciones para Llevar</h1>
                         <div class="combo-details">
                        </div>
                        <div class="portion-sizes">
                            <div class="portion-size-item">
                                <div class="portion-bowl small"></div>
                                <span class="portion-label">Pequeño</span>
                            </div>
                            <div class="portion-size-item">
                                <div class="portion-bowl medium"></div>
                                <span class="portion-label">Mediano</span>
                            </div>
                            <div class="portion-size-item active">
                                <div class="portion-bowl large"></div>
                                <div class="portion-dimensions">Grande</div>
                                <span class="portion-label">Tamaño</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="combo-banner-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/combos-para-llevar-banner.jpg" alt="Adiciones Extra - Comida Mexicana" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido principal con imagen de fondo -->
        <div class="combo-content-main">
            
            <!-- Adiciones Builder Form -->
            <form id="adiciones-builder-form" class="combo-builder">
                
                <?php
                // Obtener el producto de adiciones desde la categoría 'adiciones' (igual que burritos)
                $adiciones_product_id = null;
                
                // Primero intentar desde parámetro de URL (para compatibilidad)
                if (isset($_GET['product_id'])) {
                    $adiciones_product_id = intval($_GET['product_id']);
                    echo '<!-- DEBUG: Adiciones ID desde URL: ' . $adiciones_product_id . ' -->';
                } else {
                    // Si no hay product_id en URL, buscar el primer producto de la categoría adiciones
                    $adiciones_args = array(
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
                    
                    $adiciones_products = new WP_Query($adiciones_args);
                    
                    if ($adiciones_products->have_posts()) {
                        $adiciones_products->the_post();
                        $adiciones_product_id = get_the_ID();
                        echo '<!-- DEBUG: Adiciones ID desde categoría: ' . $adiciones_product_id . ' -->';
                        wp_reset_postdata();
                    }
                }
                
                if ($adiciones_product_id) {
                    $product = wc_get_product($adiciones_product_id);
                    if ($product) {
                        echo '<!-- DEBUG: Producto cargado: ' . $product->get_name() . ' -->';
                        
                        // Extraer opciones desde el meta field _wapf_fieldgroup (Advanced Product Fields for WooCommerce)
                        $wapf_data = get_post_meta($adiciones_product_id, '_wapf_fieldgroup', true);
                        
                        // Inicializar arrays para las opciones
                        $totopos_options = array();
                        $tortillas_options = array();
                        $protein_options = array();
                        $sauce_options = array();
                        
                        // Inicializar títulos de los campos
                        $totopos_field_title = '';
                        $tortillas_field_title = '';
                        $protein_field_title = '';
                        $sauce_field_title = '';
                        
                        if (!empty($wapf_data) && isset($wapf_data['fields'])) {
                            echo '<!-- DEBUG: WAPF data encontrada -->';
                            
                            foreach ($wapf_data['fields'] as $field) {
                                if (isset($field['id']) && isset($field['options']['choices'])) {
                                    $choices = $field['options']['choices'];
                                    $labels = array();
                                    
                                    // Extraer las etiquetas de las opciones
                                    foreach ($choices as $choice) {
                                        if (isset($choice['label'])) {
                                            $labels[] = $choice['label'];
                                        }
                                    }
                                    
                                    // Asignar a la categoría correcta según el ID del campo (según la captura)
                                    switch ($field['id']) {
                                        case '68a5f5555b827': // Totopos
                                            $totopos_options = $labels;
                                            $totopos_field_title = $field['label'];
                                            echo '<!-- DEBUG: Campo Totopos encontrado: ' . $field['label'] . ' -->';
                                            echo '<!-- DEBUG: Opciones: ' . print_r($totopos_options, true) . ' -->';
                                            break;
                                            
                                        case '68a510162a582': // Tortillas
                                            $tortillas_options = $labels;
                                            $tortillas_field_title = $field['label'];
                                            echo '<!-- DEBUG: Campo Tortillas encontrado: ' . $field['label'] . ' -->';
                                            echo '<!-- DEBUG: Opciones: ' . print_r($tortillas_options, true) . ' -->';
                                            break;
                                            
                                        case '68a50e0cee780': // Proteína
                                            $protein_options = $labels;
                                            $protein_field_title = $field['label'];
                                            echo '<!-- DEBUG: Campo Proteína encontrado: ' . $field['label'] . ' -->';
                                            echo '<!-- DEBUG: Opciones: ' . print_r($protein_options, true) . ' -->';
                                            break;
                                            
                                        case '68a50e6ba4b20': // Salsas y Más
                                            $sauce_options = $labels;
                                            $sauce_field_title = $field['label'];
                                            echo '<!-- DEBUG: Campo Salsas encontrado: ' . $field['label'] . ' -->';
                                            echo '<!-- DEBUG: Opciones: ' . print_r($sauce_options, true) . ' -->';
                                            break;
                                    }
                                }
                            }
                        } else {
                            echo '<!-- DEBUG: No se encontró WAPF data -->';
                            echo '<!-- DEBUG: Producto ID: ' . $adiciones_product_id . ' -->';
                            echo '<!-- DEBUG: Meta fields disponibles: ' . print_r(get_post_meta($adiciones_product_id), true) . ' -->';
                        }
                        
                        // Si no hay custom fields, mostrar mensaje de error
                        if (empty($totopos_options) && empty($tortillas_options) && empty($protein_options) && empty($sauce_options)) {
                            echo '<div class="alert alert-warning">';
                            echo '<p><strong>Error:</strong> No se encontraron campos personalizados en este producto.</p>';
                            echo '<p>Por favor, asegúrate de que el producto tenga configurados los campos personalizados:</p>';
                            echo '<ul>';
                            echo '<li>Totopos</li>';
                            echo '<li>Tortillas</li>';
                            echo '<li>Proteína</li>';
                            echo '<li>Salsas y Más</li>';
                            echo '</ul>';
                            echo '</div>';
                        }
                        
                        // Product Info -->
                        ?>
                        <div class="product-info-section mb-4">
                            <div class="product-price">
                                <?php echo $product->get_price_html(); ?>
                            </div>
                            <div class="product-description">
                                <?php echo wpautop($product->get_description()); ?>
                            </div>
                        </div>
                        
                        <?php if (!empty($totopos_options)) : ?>
                        <!-- Totopos Options -->
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                     <h2 class="section-title">
                                         <?php echo esc_html($totopos_field_title); ?>
                                     </h2>
                                </div>
                            </div>
                            <div class="products-grid">
                                <?php foreach ($totopos_options as $totopo) : ?>
                                    <div class="combo-option-card" data-option="totopos" data-value="<?php echo esc_attr(strtolower($totopo)); ?>" data-quantity="0">
                                         <div class="option-content">
                                             <h5 class="option-title"><?php echo esc_html($totopo); ?></h5>
                                             <div class="option-quantity" style="display: none;">
                                                 <span class="quantity-number">0</span>
                                             </div>
                                         </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </section>
                        <?php endif; ?>

                        <?php if (!empty($tortillas_options)) : ?>
                        <!-- Tortillas Options -->
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                     <h2 class="section-title">
                                         <?php echo esc_html($tortillas_field_title); ?>
                                     </h2>
                                </div>
                            </div>
                            <div class="products-grid">
                                <?php foreach ($tortillas_options as $tortilla) : ?>
                                    <div class="combo-option-card" data-option="tortillas" data-value="<?php echo esc_attr(strtolower($tortilla)); ?>" data-quantity="0">
                                         <div class="option-content">
                                             <h5 class="option-title"><?php echo esc_html($tortilla); ?></h5>
                                             <div class="option-quantity" style="display: none;">
                                                 <span class="quantity-number">0</span>
                                             </div>
                                         </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </section>
                        <?php endif; ?>

                        <?php if (!empty($protein_options)) : ?>
                        <!-- Protein Options -->
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                     <h2 class="section-title">
                                         <?php echo esc_html($protein_field_title); ?>
                                     </h2>
                                </div>
                            </div>
                            <div class="products-grid">
                                <?php foreach ($protein_options as $protein) : ?>
                                    <div class="combo-option-card" data-option="protein" data-value="<?php echo esc_attr(strtolower($protein)); ?>" data-quantity="0">
                                         <div class="option-content">
                                             <h5 class="option-title"><?php echo esc_html($protein); ?></h5>
                                             <div class="option-quantity" style="display: none;">
                                                 <span class="quantity-number">0</span>
                                             </div>
                                         </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </section>
                        <?php endif; ?>

                        <?php if (!empty($sauce_options)) : ?>
                        <!-- Sauce Options -->
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                     <h2 class="section-title">
                                         <?php echo esc_html($sauce_field_title); ?>
                                     </h2>
                                </div>
                            </div>
                            <div class="products-grid">
                                <?php foreach ($sauce_options as $sauce) : ?>
                                    <div class="combo-option-card" data-option="sauce" data-value="<?php echo esc_attr(strtolower($sauce)); ?>" data-quantity="0">
                                         <div class="option-content">
                                             <h5 class="option-title"><?php echo esc_html($sauce); ?></h5>
                                             <div class="option-quantity" style="display: none;">
                                                 <span class="quantity-number">0</span>
                                             </div>
                                         </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </section>
                        <?php endif; ?>

                        
                        <!-- Hidden input para el ID de las adiciones -->
                        <input type="hidden" name="adiciones_product_id" value="<?php echo esc_attr($adiciones_product_id); ?>">
                        
                        <!-- Datos para AJAX -->
                        <script type="text/javascript">
                            window.adiciones_ajax_data = {
                                ajax_url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                nonce: '<?php echo wp_create_nonce('woocommerce-add-to-cart'); ?>',
                                product_id: <?php echo esc_js($adiciones_product_id); ?>
                            };
                            
                            // Debug info
                            console.log('Producto de adiciones cargado:', {
                                id: <?php echo esc_js($adiciones_product_id); ?>,
                                name: '<?php echo esc_js($product ? $product->get_name() : 'No disponible'); ?>',
                                price: '<?php echo esc_js($product ? $product->get_price_html() : 'No disponible'); ?>',
                                status: '<?php echo esc_js($product ? $product->get_status() : 'No disponible'); ?>'
                            });
                        </script>
                        
                        <?php
                    } else {
                        echo '<p>Producto no encontrado.</p>';
                    }
                } else {
                    echo '<div class="alert alert-warning">';
                    echo '<p><strong>Error:</strong> No se encontró ningún producto de adiciones en la categoría "adiciones".</p>';
                    echo '<p>Por favor, asegúrate de que existe al menos un producto en la categoría "adiciones" en WooCommerce.</p>';
                    echo '</div>';
                }
                ?>

            </form>
            
            <!-- Botón de agregar al carrito con todo lo seleccionado -->
            <div class="add-to-cart-section mb-5">
                <div class="row">
                    <div class="col-12 text-center">
                        <button type="button" id="add-all-to-cart-btn" class="btn btn-primary btn-lg add-to-cart-button">
                            <i class="fas fa-shopping-cart"></i>
                            Agregar Todo al Carrito
                        </button>
                        <p class="add-to-cart-description mt-3">
                            Agrega tu combo seleccionado y todas las adiciones al carrito.
                        </p>
                    </div>
                </div>
            </div>
            
        </div> <!-- Cierre de combo-content-main -->

    </div>
</div>

<!-- Pop-up de selección de tamaño -->
<div id="size-selection-modal" class="size-modal-overlay" style="display: none;">
    <div class="size-modal">
        <!-- Header del pop-up -->
        <div class="size-modal-header">
            <h3 class="size-modal-title" id="size-modal-title">Enchilada Roja o Verde</h3>
            <button class="size-modal-close" id="size-modal-close">
                <span class="close-icon">×</span>
            </button>
        </div>
        
        <!-- Contenido del pop-up -->
        <div class="size-modal-content">
            <div class="current-quantity-info" id="current-quantity-info" style="display: none;">
                <p class="quantity-text">Cantidad actual: <span id="current-quantity-number">0</span></p>
            </div>
            <div class="size-options">
                <label class="size-option">
                    <input type="radio" name="size-selection" value="small" class="size-radio">
                    <span class="size-label">Small ($XX.XXX)</span>
                </label>
                <label class="size-option">
                    <input type="radio" name="size-selection" value="medium" class="size-radio">
                    <span class="size-label">Medium ($XX.XXX)</span>
                </label>
                <label class="size-option">
                    <input type="radio" name="size-selection" value="large" class="size-radio" checked>
                    <span class="size-label">Large ($XX.XXX)</span>
                </label>
            </div>
        </div>
        
        <!-- Footer del pop-up -->
        <div class="size-modal-footer">
            <button class="size-modal-add-btn" id="size-modal-add-btn">AGREGAR</button>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Variables globales para el pop-up
    let currentSelectedOption = null;
    let currentOptionData = null;
    
    // Sistema de carrito para almacenar productos agregados
    let cartItems = [];
    
    // Variable para almacenar la selección del combo original
    let originalComboSelection = null;
    
    // Cargar la selección del combo original desde sessionStorage
    function loadOriginalComboSelection() {
        const comboData = sessionStorage.getItem('combo_selection');
        if (comboData) {
            try {
                originalComboSelection = JSON.parse(comboData);
            } catch (e) {
                console.error('Error al parsear la selección del combo:', e);
            }
        }
    }
    
    // Cargar la selección al inicializar
    loadOriginalComboSelection();
    
    // Handle option selection for all categories
    $('.combo-option-card').click(function() {
        const optionType = $(this).data('option');
        const optionValue = $(this).data('value');
        const optionTitle = $(this).find('.option-title').text();
        const currentQuantity = parseInt($(this).data('quantity')) || 0;
        
        // Guardar datos de la opción seleccionada
        currentSelectedOption = $(this);
        currentOptionData = {
            type: optionType,
            value: optionValue,
            title: optionTitle,
            currentQuantity: currentQuantity
        };
        
        // Mostrar el pop-up de selección de tamaño
        showSizeSelectionModal(optionTitle, currentQuantity);
    });
    
    // Función para mostrar el pop-up de selección de tamaño
    function showSizeSelectionModal(itemTitle, currentQuantity) {
        $('#size-modal-title').text(itemTitle);
        
        // Mostrar información de cantidad actual si es > 0
        if (currentQuantity > 0) {
            $('#current-quantity-info').show();
            $('#current-quantity-number').text(currentQuantity);
        } else {
            $('#current-quantity-info').hide();
        }
        
        $('#size-selection-modal').fadeIn(300);
        
        // Resetear selección de tamaño (Large por defecto)
        $('input[name="size-selection"][value="large"]').prop('checked', true);
    }
    
    // Función para ocultar el pop-up
    function hideSizeSelectionModal() {
        $('#size-selection-modal').fadeOut(300);
        currentSelectedOption = null;
        currentOptionData = null;
    }
    
    // Event listeners para el pop-up
    $('#size-modal-close').click(function() {
        hideSizeSelectionModal();
    });
    
    // Cerrar pop-up al hacer clic fuera de él
    $('#size-selection-modal').click(function(e) {
        if (e.target === this) {
            hideSizeSelectionModal();
        }
    });
    
    // Cerrar pop-up con tecla ESC
    $(document).keyup(function(e) {
        if (e.keyCode === 27) { // ESC key
            hideSizeSelectionModal();
        }
    });
    
    // Manejar botón AGREGAR del pop-up
    $('#size-modal-add-btn').click(function() {
        const selectedSize = $('input[name="size-selection"]:checked').val();
        
        if (!currentOptionData) {
            alert('Error: No se encontró la opción seleccionada.');
            return;
        }
        
        // Agregar al carrito con el tamaño seleccionado
        addToCartWithSize(currentOptionData, selectedSize);
        
        // Ocultar el pop-up
        hideSizeSelectionModal();
    });
    
    // Función para agregar al carrito con tamaño específico
    function addToCartWithSize(optionData, size) {
        const sizeLabels = {
            'small': 'Pequeño',
            'medium': 'Mediano', 
            'large': 'Grande'
        };
        
        // Verificar que tenemos los datos de AJAX
        if (!window.adiciones_ajax_data) {
            console.error('Datos de AJAX no disponibles');
            alert('Error: Configuración de AJAX no disponible');
            return;
        }
        
        // Mostrar indicador de carga
        const addButton = $('#size-modal-add-btn');
        const originalText = addButton.text();
        addButton.text('AGREGANDO...').prop('disabled', true);
        
        // Preparar datos para AJAX
        const ajaxData = {
            action: 'add_adiciones_to_cart',
            nonce: window.adiciones_ajax_data.nonce,
            product_id: window.adiciones_ajax_data.product_id,
            quantity: 1,
            adiciones_type: optionData.type,
            adiciones_value: optionData.value,
            adiciones_title: optionData.title,
            size: size
        };
        
        console.log('Enviando datos AJAX:', ajaxData);
        
        // Realizar llamada AJAX a WooCommerce
        $.ajax({
            url: window.adiciones_ajax_data.ajax_url,
            type: 'POST',
            data: ajaxData,
            dataType: 'json',
            success: function(response) {
                console.log('Respuesta AJAX recibida:', response);
                
                if (response.success) {
                    // Crear objeto del producto para el carrito local
                    const cartItem = {
                        id: `${optionData.type}_${optionData.value}_${size}`,
                        type: optionData.type,
                        value: optionData.value,
                        title: optionData.title,
                        size: size,
                        sizeLabel: sizeLabels[size],
                        timestamp: Date.now(),
                        cart_item_key: response.data.cart_item_key
                    };
                    
                    // Agregar al array del carrito local
                    cartItems.push(cartItem);
                    
                    // Actualizar la cantidad en la tarjeta
                    updateCardQuantity(optionData.type, optionData.value);
                    
                    // Mostrar mensaje de éxito
                    const successMessage = `¡${optionData.title} (${sizeLabels[size]}) agregado al carrito exitosamente!`;
                    showSuccessNotification(successMessage);
                    
                    // Disparar evento de WooCommerce para actualizar fragmentos del carrito
                    if (response.fragments) {
                        $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $('.combo-option-card.selected')]);
                    }
                    
                    console.log('Producto agregado al carrito:', cartItem);
                } else {
                    console.error('Error al agregar al carrito:', response);
                    const errorMessage = response.data || 'No se pudo agregar al carrito';
                    alert('Error: ' + errorMessage);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error AJAX completo:', {
                    xhr: xhr,
                    status: status,
                    error: error,
                    responseText: xhr.responseText
                });
                
                let errorMessage = 'Error de conexión. Por favor intenta de nuevo.';
                
                // Intentar parsear la respuesta de error
                try {
                    const errorResponse = JSON.parse(xhr.responseText);
                    if (errorResponse.data) {
                        errorMessage = errorResponse.data;
                    }
                } catch (e) {
                    console.log('No se pudo parsear la respuesta de error');
                }
                
                alert(errorMessage);
            },
            complete: function() {
                // Restaurar botón
                addButton.text(originalText).prop('disabled', false);
            }
        });
    }
    
    // Función para actualizar la cantidad en la tarjeta
    function updateCardQuantity(optionType, optionValue) {
        const card = $(`.combo-option-card[data-option="${optionType}"][data-value="${optionValue}"]`);
        const currentQuantity = parseInt(card.data('quantity')) || 0;
        const newQuantity = currentQuantity + 1;
        
        // Actualizar el atributo data-quantity
        card.attr('data-quantity', newQuantity);
        
        // Actualizar el número visible
        card.find('.quantity-number').text(newQuantity);
        
        // Mostrar el contador si no estaba visible
        card.find('.option-quantity').show();
        
        // Agregar clase selected para indicar que tiene productos
        card.addClass('selected');
        
        // Debug: mostrar información del carrito
        console.log('Carrito actual:', cartItems);
        console.log(`Tarjeta ${optionValue} actualizada a cantidad: ${newQuantity}`);
    }
    
    // Función para mostrar notificación de éxito
    function showSuccessNotification(message) {
        // Crear elemento de notificación
        const notification = $('<div class="success-notification">' +
            '<div class="notification-content">' +
                '<span>✓</span>' +
                '<span>' + message + '</span>' +
            '</div>' +
        '</div>');
        
        // Agregar al body
        $('body').append(notification);
        
        // Remover después de 3 segundos
        setTimeout(function() {
            notification.fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    }
    
    // Función para obtener resumen del carrito (opcional, para debugging)
    function getCartSummary() {
        const summary = {};
        cartItems.forEach(item => {
            const key = `${item.title} (${item.sizeLabel})`;
            summary[key] = (summary[key] || 0) + 1;
        });
        return summary;
    }
    
    // Función para limpiar el carrito (opcional)
    function clearCart() {
        cartItems = [];
        $('.combo-option-card').attr('data-quantity', '0');
        $('.combo-option-card').removeClass('selected');
        $('.option-quantity').hide();
        $('.quantity-number').text('0');
    }
    
    // Exponer funciones globalmente para debugging (opcional)
    window.getCartSummary = getCartSummary;
    window.clearCart = clearCart;
    window.cartItems = cartItems;
    
    // Función para verificar el estado del carrito de WooCommerce
    window.checkWooCommerceCart = function() {
        if (typeof wc_add_to_cart_params !== 'undefined') {
            console.log('WooCommerce AJAX params disponibles:', wc_add_to_cart_params);
        } else {
            console.log('WooCommerce AJAX params NO disponibles');
        }
        
        if (window.adiciones_ajax_data) {
            console.log('Datos de AJAX de adiciones:', window.adiciones_ajax_data);
        } else {
            console.log('Datos de AJAX de adiciones NO disponibles');
        }
    };
    
    // Verificar estado al cargar la página
    setTimeout(function() {
        window.checkWooCommerceCart();
        
        // Verificar que el producto existe
        if (window.adiciones_ajax_data && window.adiciones_ajax_data.product_id) {
            console.log('Producto ID para adiciones:', window.adiciones_ajax_data.product_id);
        }
    }, 2000);
    
    // Handle form submission (mantener para compatibilidad)
    $('#adiciones-builder-form').on('submit', function(e) {
        e.preventDefault();
        
        if (cartItems.length === 0) {
            alert('Por favor selecciona al menos una adición.');
            return;
        }
        
        // Mostrar resumen del carrito
        const summary = getCartSummary();
        let summaryText = 'Resumen del carrito:\n';
        for (const [item, quantity] of Object.entries(summary)) {
            summaryText += `- ${item}: ${quantity}\n`;
        }
        
        alert(summaryText);
    });
    
    // Handle "Agregar Todo al Carrito" button
    $('#add-all-to-cart-btn').click(function() {
        // Validar que hay al menos algo para agregar
        if (!originalComboSelection && cartItems.length === 0) {
            alert('No hay nada seleccionado para agregar al carrito.');
            return;
        }
        
        // Mostrar indicador de carga
        const button = $(this);
        const originalText = button.html();
        button.html('<i class="fas fa-spinner fa-spin"></i> Agregando...').prop('disabled', true);
        
        // Función para agregar el combo original al carrito
        function addOriginalComboToCart() {
            return new Promise((resolve, reject) => {
                if (!originalComboSelection) {
                    resolve();
                    return;
                }
                
                // Preparar datos para el combo original
                if (!originalComboSelection.combo_id) {
                    reject('No se encontró el ID del combo original en la selección guardada');
                    return;
                }
                
                const cartData = {
                    action: 'add_combo_to_cart',
                    combo_id: originalComboSelection.combo_id,
                    combo_data: originalComboSelection,
                    nonce: '<?php echo wp_create_nonce("add_combo_to_cart"); ?>'
                };
                
                $.ajax({
                    url: '<?php echo admin_url("admin-ajax.php"); ?>',
                    method: 'POST',
                    data: cartData,
                    success: function(response) {
                        if (response.success) {
                            console.log('Combo original agregado al carrito:', response);
                            resolve();
                        } else {
                            reject('Error al agregar combo original: ' + (response.data || 'Error desconocido'));
                        }
                    },
                    error: function(xhr, status, error) {
                        reject('Error AJAX al agregar combo original: ' + error);
                    }
                });
            });
        }
        
        // Función para agregar las adiciones al carrito
        function addAdicionesToCart() {
            return new Promise((resolve, reject) => {
                if (cartItems.length === 0) {
                    resolve();
                    return;
                }
                
                // Las adiciones ya están en el carrito de WooCommerce desde cuando se agregaron individualmente
                // Solo necesitamos verificar que estén ahí
                console.log('Adiciones ya agregadas al carrito:', cartItems);
                resolve();
            });
        }
        
        // Ejecutar ambas funciones en secuencia
        addOriginalComboToCart()
            .then(() => addAdicionesToCart())
            .then(() => {
                // Mostrar mensaje de éxito
                showSuccessNotification('¡Todo agregado al carrito exitosamente!');
                
                // Limpiar sessionStorage
                sessionStorage.removeItem('combo_selection');
                
                // Redireccionar al carrito después de un breve delay
                setTimeout(() => {
                    window.location.href = '<?php echo wc_get_cart_url(); ?>';
                }, 2000);
            })
            .catch((error) => {
                console.error('Error al agregar al carrito:', error);
                alert('Error al agregar al carrito: ' + error);
            })
            .finally(() => {
                // Restaurar botón
                button.html(originalText).prop('disabled', false);
            });
    });
    
    // Función para mostrar notificación de éxito
    function showSuccessNotification(message) {
        const notification = $('<div class="success-notification">' +
            '<div class="notification-content">' +
                '<i class="fas fa-check-circle"></i>' +
                '<span>' + message + '</span>' +
            '</div>' +
        '</div>');
        
        $('body').append(notification);
        
        setTimeout(function() {
            notification.fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    }
});
</script>

<?php get_footer(); ?>
