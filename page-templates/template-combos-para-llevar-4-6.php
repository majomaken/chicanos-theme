<?php
/**
 * Template Name: Combos para Llevar 4-6 Personas
 * 
 * Template específico para combos de 4-6 personas
 *
 * @package Chicanos_Theme
 */

get_header(); ?>

<!-- Cargar estilos específicos para combos para llevar 4-6 personas -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/combos-para-llevar-4-6.css">

<div id="combos-para-llevar-4-6-wrapper" class="wrapper">
    <div class="container">
        
        <!-- Banner Section -->
        <div class="combo-banner-section mb-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="combo-info-content">
                        <h1 class="combo-main-title">
                            <span class="title-line-1">Combos</span>
                            <span class="title-line-2">para Llevar</span>
                        </h1>
                        <div class="combo-details">
                            <p class="combo-size">
                                <span class="serving-size" id="dynamic-serving-size">
                                    <?php
                                    // Detectar automáticamente el tamaño del combo basado en parámetros de URL o contexto
                                    $combo_size = 'Combo 4-6 personas'; // Default
                                    
                                    // Opción 1: Detectar desde parámetro de URL
                                    if (isset($_GET['combo_size'])) {
                                        $combo_size = 'Combo ' . sanitize_text_field($_GET['combo_size']);
                                    }
                                    // Opción 2: Detectar desde referer (si viene de domicilio-nogal)
                                    elseif (isset($_SERVER['HTTP_REFERER'])) {
                                        $referer = $_SERVER['HTTP_REFERER'];
                                        if (strpos($referer, 'domicilio-nogal') !== false) {
                                            // Si viene de domicilio-nogal, determinar el combo basado en el contexto
                                            // Esto se puede ajustar según cómo sepas qué combo específico eligió
                                            $combo_size = 'Combo 4-6 personas'; // Ajustar según lógica de negocio
                                        }
                                    }
                                    
                                    echo esc_html($combo_size);
                                    ?>
                                </span>
                            </p>
                            <div class="combo-includes">
                                <p class="includes-title">Incluye:</p>
                                <ul class="includes-list">
                                    <li>1 bolsa de totopos crujientes</li>
                                    <li>2 paquetes de tortillas frescas</li>
                                    <li>2.000 g de proteína a elección</li>
                                    <li>2.000 g de salsas y acompañamientos</li>
                                </ul>
                            </div>
                            <div class="combo-price">
                                <span class="price-amount" id="combo-total-price">
                                    <?php 
                                    if ($combo_product_id && $combo_product) {
                                        $product_price = $combo_product->get_price();
                                        if ($product_price && $product_price > 0) {
                                            echo '$' . number_format($product_price, 0, ',', '.');
                                        } else {
                                            echo '$200,000'; // Fallback actualizado
                                        }
                                    } else {
                                        echo '$200,000'; // Fallback actualizado
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="portion-sizes">
                            <div class="portion-size-item">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/size-small.svg" alt="250 Gramos" class="portion-svg">
                                <div class="portion-weight">250 Gramos</div>
                                <div class="portion-size-label">Pequeño</div>
                            </div>
                            <div class="portion-size-item">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/size-medium.svg" alt="500 Gramos" class="portion-svg">
                                <div class="portion-weight">500 Gramos</div>
                                <div class="portion-size-label">Mediano</div>
                            </div>
                            <div class="portion-size-item active">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/size-large.svg" alt="2000 Gramos" class="portion-svg">
                                <div class="portion-weight">2000 Gramos</div>
                                <div class="portion-size-label">Grande</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="combo-banner-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/combos-para-llevar-banner-4-6.webp" alt="Combos para Llevar 4-6 Personas - Comida Mexicana" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido principal con imagen de fondo -->
        <div class="combo-content-main">
            <!-- Combo Builder Form -->
            <form id="combo-builder-form-4-6" class="combo-builder">
                
                <?php
                // Obtener el ID del producto de combo desde la URL o contexto
                $combo_product_id = null;
                
                // Debug: mostrar todos los parámetros de URL
                echo '<!-- DEBUG: Parámetros de URL: ' . print_r($_GET, true) . ' -->';
                
                // Opción 1: Detectar desde parámetro de URL
                if (isset($_GET['combo_id'])) {
                    $combo_product_id = intval($_GET['combo_id']);
                    echo '<!-- DEBUG: Combo ID encontrado: ' . $combo_product_id . ' -->';
                }
                // Opción 2: Detectar desde parámetro de combo_size (fallback)
                elseif (isset($_GET['combo_size'])) {
                    echo '<!-- DEBUG: Usando combo_size como fallback: ' . $_GET['combo_size'] . ' -->';
                    // Buscar el producto de combo que coincida con el tamaño
                    $combo_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => 'combos',
                            ),
                        ),
                        'meta_query' => array(
                            array(
                                'key' => '_combo_size',
                                'value' => sanitize_text_field($_GET['combo_size']),
                                'compare' => 'LIKE'
                            )
                        )
                    );
                    
                    $combo_query = new WP_Query($combo_args);
                    if ($combo_query->have_posts()) {
                        $combo_query->the_post();
                        $combo_product_id = get_the_ID();
                        echo '<!-- DEBUG: Combo ID encontrado por tamaño: ' . $combo_product_id . ' -->';
                        wp_reset_postdata();
                    } else {
                        echo '<!-- DEBUG: No se encontró combo por tamaño -->';
                    }
                } else {
                    echo '<!-- DEBUG: No hay parámetros de combo, buscando combo 4-6 específico -->';
                    
                    // Opción 3: Buscar combo 4-6 por múltiples criterios
                    $search_terms = array(
                        'combo-para-llevar-4-a-6-personas',
                        'combo-para-llevar-4-6-personas',
                        'combo-4-6-personas',
                        'combo-4-a-6-personas'
                    );
                    
                    $combo_product_id = null;
                    
                    // Intentar buscar por slug primero
                    foreach ($search_terms as $slug) {
                        $combo_args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 1,
                            'name' => $slug
                        );
                        
                        $combo_query = new WP_Query($combo_args);
                        if ($combo_query->have_posts()) {
                            $combo_query->the_post();
                            $combo_product_id = get_the_ID();
                            echo '<!-- DEBUG: Combo 4-6 encontrado por slug "' . $slug . '": ' . $combo_product_id . ' -->';
                            wp_reset_postdata();
                            break;
                        }
                    }
                    
                    // Si no se encontró por slug, buscar por título
                    if (!$combo_product_id) {
                        echo '<!-- DEBUG: No se encontró por slug, buscando por título -->';
                        $combo_title_args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 1,
                            'orderby' => 'title',
                            'order' => 'ASC',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'slug',
                                    'terms'    => array('combos', 'combo', 'combo-para-llevar'),
                                    'operator' => 'IN',
                                ),
                            ),
                            's' => '4-6'
                        );
                        
                        $combo_title_query = new WP_Query($combo_title_args);
                        if ($combo_title_query->have_posts()) {
                            $combo_title_query->the_post();
                            $combo_product_id = get_the_ID();
                            echo '<!-- DEBUG: Combo 4-6 encontrado por título: ' . $combo_product_id . ' -->';
                            wp_reset_postdata();
                        } else {
                            echo '<!-- DEBUG: No se encontró ningún combo 4-6 -->';
                        }
                    }
                }
                
                if ($combo_product_id) {
                    echo '<!-- DEBUG: Procesando combo ID: ' . $combo_product_id . ' -->';
                    $combo_product = wc_get_product($combo_product_id);
                    
                    if ($combo_product) {
                        echo '<!-- DEBUG: Producto cargado correctamente -->';
                        
                        // Debug específico de input fields WAPF
                        debug_wapf_input_fields($combo_product_id);
                        
                        // Debug en consola JavaScript
                        echo '<script>';
                        echo 'console.log("=== DEBUG COMBO OPTIONS 4-6 ===");';
                        echo 'console.log("Combo Product ID:", ' . $combo_product_id . ');';
                        echo 'console.log("WAPF Active:", ' . (is_plugin_active('advanced-product-fields-for-woocommerce/advanced-product-fields-for-woocommerce.php') ? 'true' : 'false') . ');';
                        
                        // Debug WAPF data en consola
                        $wapf_meta = get_post_meta($combo_product_id, '_wapf_fieldgroup', true);
                        echo 'console.log("WAPF Meta Data:", ' . json_encode($wapf_meta) . ');';
                        
                        // Obtener el precio del producto dinámicamente
                        $product_price = $combo_product->get_price();
                        $base_price = $product_price && $product_price > 0 ? $product_price : 200000;
                        echo 'console.log("Product Price:", ' . $base_price . ');';
                        echo 'console.log("Product Title:", "' . $combo_product->get_name() . '");';
                        echo 'console.log("Product ID:", ' . $combo_product_id . ');';
                        echo 'var DYNAMIC_BASE_PRICE = ' . $base_price . ';';
                        echo '</script>';
                        
                        // Inicializar arrays para las opciones
                        $protein_options = array();
                        $sauce_options_1 = array(); // Primera selección de salsas
                        $sauce_options_2 = array(); // Segunda selección de salsas
                        $tortilla_options_1 = array(); // Primera selección de tortillas
                        $tortilla_options_2 = array(); // Segunda selección de tortillas
                        
                        // Extraer opciones usando la nueva función dinámica
                        $protein_options = get_combo_options_from_woocommerce($combo_product_id, 'protein');
                        $sauce_options_1 = get_combo_options_from_woocommerce($combo_product_id, 'sauce');
                        $tortilla_options_1 = get_combo_options_from_woocommerce($combo_product_id, 'tortilla');
                        $totopos_options = get_combo_options_from_woocommerce($combo_product_id, 'totopo');
                        
                        echo '<script>';
                        echo 'console.log("Protein Options Found:", ' . json_encode($protein_options) . ');';
                        echo 'console.log("Sauce Options Found:", ' . json_encode($sauce_options_1) . ');';
                        echo 'console.log("Tortilla Options Found:", ' . json_encode($tortilla_options_1) . ');';
                        echo 'console.log("Totopo Options Found:", ' . json_encode($totopos_options) . ');';
                        echo '</script>';
                        
                        // Si no hay opciones encontradas, mostrar mensaje de error
                        if (empty($protein_options) && empty($sauce_options_1) && empty($tortilla_options_1) && empty($totopos_options)) {
                            echo '<div class="alert alert-warning">';
                            echo '<h3>⚠️ Configuración de Combo Incompleta</h3>';
                            echo '<p>No se encontraron opciones configuradas para este combo. Por favor contacta al administrador para configurar las opciones disponibles.</p>';
                            echo '<p><strong>Combo ID:</strong> ' . $combo_product_id . '</p>';
                            echo '<p><strong>Producto:</strong> ' . $combo_product->get_name() . '</p>';
                            echo '</div>';
                            return; // Salir del template
                        }
                        
                        // 1. TOTOPOS SECTION (Nueva categoría)
                        ?>
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="section-title">
                                        Totopos 
                                        <span class="selection-limit">(escoge 1)</span>
                                    </h2>
                                </div>
                            </div>
                            
                            <div class="products-grid" id="totopos-grid">
                                <?php
                                $first = true;
                                foreach ($totopos_options as $totopo) {
                                    $selected_class = $first ? 'selected' : '';
                                    $first = false;
                                    
                                    // Separar el texto principal de las especificaciones
                                    $totopo_text = trim($totopo);
                                    $main_text = $totopo_text;
                                    $spec_text = '';
                                    
                                    // Buscar especificaciones entre paréntesis
                                    if (preg_match('/^(.+?)\s*\((.+?)\)$/', $totopo_text, $matches)) {
                                        $main_text = trim($matches[1]);
                                        $spec_text = '(' . trim($matches[2]) . ')';
                                    }
                                    ?>
                                    <div class="combo-option-card totopo-option <?php echo $selected_class; ?>" 
                                         data-type="totopo" 
                                         data-value="<?php echo esc_attr($totopo_text); ?>"
                                         data-price="0.00">
                                        <div class="option-content">
                                            <h3 class="option-title"><?php echo esc_html($main_text); ?></h3>
                                            <?php if ($spec_text): ?>
                                                <div class="option-spec"><?php echo esc_html($spec_text); ?></div>
                                            <?php endif; ?>
                                            <div class="option-price">$0.00</div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </section>

                        <!-- 2. TORTILLAS SECTION -->
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="section-title">
                                        Tortillas 
                                        <span class="selection-limit">(escoge 2)</span>
                                    </h2>
                                </div>
                            </div>
                            
                            <div class="products-grid" id="tortilla-grid">
                                <?php
                                foreach ($tortilla_options_1 as $tortilla) {
                                    // Separar el texto principal de las especificaciones
                                    $tortilla_text = trim($tortilla);
                                    $main_text = $tortilla_text;
                                    $spec_text = '';
                                    
                                    // Buscar especificaciones entre paréntesis
                                    if (preg_match('/^(.+?)\s*\((.+?)\)$/', $tortilla_text, $matches)) {
                                        $main_text = trim($matches[1]);
                                        $spec_text = '(' . trim($matches[2]) . ')';
                                    }
                                    ?>
                                    <div class="combo-option-card tortilla-option" 
                                         data-type="tortilla" 
                                         data-value="<?php echo esc_attr($tortilla_text); ?>"
                                         data-price="0.00"
                                         data-count="0">
                                        <input type="hidden" 
                                               name="tortilla[]" 
                                               value="<?php echo esc_attr($tortilla_text); ?>"
                                               class="tortilla-input">
                                        <div class="option-content">
                                            <div class="quantity-indicator" style="display: none;">x2</div>
                                            <h3 class="option-title"><?php echo esc_html($main_text); ?></h3>
                                            <?php if ($spec_text): ?>
                                                <div class="option-spec"><?php echo esc_html($spec_text); ?></div>
                                            <?php endif; ?>
                                            <div class="option-price">$0.00</div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </section>

                        <!-- 3. PROTEÍNA SECTION -->
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="section-title">
                                        Escoge tu Proteína 
                                        <span class="selection-limit">(Escoge 3 proteinas, cada una de 500Gr)</span>
                                    </h2>
                                </div>
                            </div>
                            
                            <div class="products-grid" id="protein-grid">
                                <?php
                                foreach ($protein_options as $protein) {
                                    // Separar el texto principal de las especificaciones
                                    $protein_text = trim($protein);
                                    $main_text = $protein_text;
                                    $spec_text = '';
                                    
                                    // Buscar especificaciones entre paréntesis
                                    if (preg_match('/^(.+?)\s*\((.+?)\)$/', $protein_text, $matches)) {
                                        $main_text = trim($matches[1]);
                                        $spec_text = '(' . trim($matches[2]) . ')';
                                    }
                                    ?>
                                    <div class="combo-option-card protein-option" 
                                         data-type="protein" 
                                         data-value="<?php echo esc_attr($protein_text); ?>"
                                         data-price="0.00"
                                         data-count="0">
                                        <input type="hidden" 
                                               name="protein[]" 
                                               value="<?php echo esc_attr($protein_text); ?>"
                                               class="protein-input">
                                        <div class="option-content">
                                            <div class="quantity-indicator" style="display: none;">x2</div>
                                            <h3 class="option-title"><?php echo esc_html($main_text); ?></h3>
                                            <?php if ($spec_text): ?>
                                                <div class="option-spec"><?php echo esc_html($spec_text); ?></div>
                                            <?php endif; ?>
                                            <div class="option-price">$0.00</div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </section>

                        <!-- 4. SALSAS Y ACOMPAÑAMIENTOS SECTION -->
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="section-title">
                                        Salsas y Acompañamientos 
                                        <span class="selection-limit">(escoge 4 acompañamientos: 2 de 500g + 2 de 250g, y 2 salsas de 250g = 2000g)</span>
                                    </h2>
                                    <div class="salsas-details">
                                        <span class="sugerencias-title">Sugerimos:</span><br>
                                        <ul class="salsas-list">
                                            <li>500g de guacamole</li>
                                            <li>500g de pico de gallo</li>
                                            <li>250g de frijol refrito</li>
                                            <li>250g de queso mozzarella rallado</li>
                                            <li>2 salsas de su preferencia de 250g</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="products-grid" id="sauce-grid">
                                <?php
                                $sauce_index = 0;
                                foreach ($sauce_options_1 as $sauce) {
                                    // Separar el texto principal de las especificaciones
                                    $sauce_text = trim($sauce);
                                    $main_text = $sauce_text;
                                    $spec_text = '';
                                    
                                    // Buscar especificaciones entre paréntesis
                                    if (preg_match('/^(.+?)\s*\((.+?)\)$/', $sauce_text, $matches)) {
                                        $main_text = trim($matches[1]);
                                        $spec_text = '(' . trim($matches[2]) . ')';
                                    }
                                    
                                    // Preseleccionar las opciones específicas de la lista de sugerencias
                                    $preselected_options = ['guacamole', 'pico de gallo', 'frijol refrito', 'queso mozzarella'];
                                    $is_preselected = false;
                                    foreach ($preselected_options as $preselected_option) {
                                        if (stripos($sauce_text, $preselected_option) !== false) {
                                            $is_preselected = true;
                                            break;
                                        }
                                    }
                                    $initial_count = $is_preselected ? '1' : '0';
                                    $selected_class = $is_preselected ? ' selected' : '';
                                    ?>
                                    <div class="combo-option-card sauce-option<?php echo $selected_class; ?>" 
                                         data-type="sauce" 
                                         data-value="<?php echo esc_attr($sauce_text); ?>"
                                         data-price="0.00"
                                         data-count="<?php echo $initial_count; ?>">
                                        <input type="hidden" 
                                               name="sauce[]" 
                                               value="<?php echo esc_attr($sauce_text); ?>"
                                               class="sauce-input">
                                        <div class="option-content">
                                            <div class="quantity-indicator" style="display: none;">x2</div>
                                            <h3 class="option-title"><?php echo esc_html($main_text); ?></h3>
                                            <?php if ($spec_text): ?>
                                                <div class="option-spec"><?php echo esc_html($spec_text); ?></div>
                                            <?php endif; ?>
                                            <div class="option-price">$0.00</div>
                                        </div>
                                    </div>
                                    <?php
                                    $sauce_index++;
                                }
                                ?>
                            </div>
                        </section>

                        <!-- Second Sauces and Extras Section -->
                        <?php if (!empty($sauce_options_2)) : ?>
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="section-title">
                                        Salsas y Más (2) 
                                        <span class="selection-limit">(escoge 1)</span>
                                    </h2>
                                </div>
                            </div>
                            
                            <div class="products-grid" id="sauce-grid-2">
                                <?php
                                foreach ($sauce_options_2 as $sauce) {
                                    // Separar el texto principal de las especificaciones
                                    $sauce_text = trim($sauce);
                                    $main_text = $sauce_text;
                                    $spec_text = '';
                                    
                                    // Buscar especificaciones entre paréntesis
                                    if (preg_match('/^(.+?)\s*\((.+?)\)$/', $sauce_text, $matches)) {
                                        $main_text = trim($matches[1]);
                                        $spec_text = '(' . trim($matches[2]) . ')';
                                    }
                                    ?>
                                    <div class="combo-option-card sauce-option" 
                                         data-type="sauce" 
                                         data-value="<?php echo esc_attr($sauce_text); ?>"
                                         data-price="0.00">
                                        <div class="option-content">
                                            <h3 class="option-title"><?php echo esc_html($main_text); ?></h3>
                                            <?php if ($spec_text): ?>
                                                <div class="option-spec"><?php echo esc_html($spec_text); ?></div>
                                            <?php endif; ?>
                                            <div class="option-price">$0.00</div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </section>
                        <?php endif; ?>
                        
                        <!-- Botón para agregar al carrito -->
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="button" id="add-to-cart-btn" class="btn btn-primary btn-lg add-to-cart-button">
                                        <i class="fas fa-shopping-cart"></i>
                                        Agregar al Carrito
                                    </button>
                                    <p class="add-to-cart-description mt-3">
                                        ¿Ya tienes todo lo que necesitas? Agrega tu combo al carrito ahora.
                                    </p>
                                    <p class="delivery-cost-info mt-2">
                                        El domicilio cuesta: $6,000
                                    </p>
                                </div>
                            </div>
                        </section>
                        
                        <!-- Adiciones Section -->
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="section-title">
                                        ¿Quieres más totopos o salsas?
                                        <span class="selection-limit">(opcional)</span>
                                    </h2>
                                </div>
                            </div>
                            
                            <div class="products-grid" id="extra-guacamole-grid">
                                <div class="combo-option-card extra-option" 
                                     data-type="extra" 
                                     data-value="adiciones"
                                     data-price="0.00">
                                    <a href="<?php
                                        // Buscar la página de adiciones
                                        $adiciones_page = get_posts(array(
                                            'name' => 'adiciones-extra',
                                            'post_type' => 'page',
                                            'post_status' => 'publish',
                                            'numberposts' => 1
                                        ));
                                        
                                        if (!empty($adiciones_page)) {
                                            echo get_permalink($adiciones_page[0]->ID);
                                        } else {
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
                                            
                                            if (!empty($adiciones_template_page)) {
                                                echo get_permalink($adiciones_template_page[0]->ID);
                                            } else {
                                                // Fallback: usar home_url con el slug esperado
                                                echo home_url('/adiciones-extra/');
                                            }
                                        }
                                    ?>" class="adiciones-link" id="adiciones-link">
                                        <div class="option-content">
                                            <h3 class="option-title">Todo para llevar</h3>
                                            <div class="option-price">$0.00</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </section>
                        
                        <!-- Hidden input para el ID del combo -->
                        <input type="hidden" name="combo_product_id" value="<?php echo esc_attr($combo_product_id); ?>">
                        
                        <?php
                    } else {
                        echo '<p>Error: No se pudo cargar el producto de combo.</p>';
                    }
                } else {
                    echo '<p>Error: No se especificó un combo para personalizar.</p>';
                }
                ?>

            </form>
        </div> <!-- Cierre de combo-content-main -->

    </div>
</div>

<!-- Modal de Confirmación -->
<div id="combo-confirmation-modal" class="confirmation-modal-overlay" style="display: none;">
    <div class="confirmation-modal">
        <!-- Header del modal -->
        <div class="confirmation-modal-header">
            <h3 class="confirmation-modal-title">¡Combo agregado al carrito exitosamente!</h3>
            <button class="confirmation-modal-close" id="confirmation-modal-close">
                <span class="close-icon">×</span>
            </button>
        </div>
        
        <!-- Contenido del modal -->
        <div class="confirmation-modal-content">
            <div class="confirmation-icon">
                <span class="success-icon"></span>
            </div>
            <div class="combo-summary">
                <h4 class="summary-title">Resumen de tu combo:</h4>
                <div class="summary-item">
                    <span class="summary-icon"></span>
                    <span class="summary-label">Totopos:</span>
                    <span class="summary-value" id="modal-totopos"></span>
                </div>
                <div class="summary-item">
                    <span class="summary-icon"></span>
                    <span class="summary-label">Tortillas:</span>
                    <span class="summary-value" id="modal-tortillas"></span>
                </div>
                <div class="summary-item">
                    <span class="summary-icon"></span>
                    <span class="summary-label">Proteínas (3x500gr):</span>
                    <div class="summary-list" id="modal-proteins"></div>
                </div>
                <div class="summary-item">
                    <span class="summary-icon"></span>
                    <span class="summary-label">Salsas y Acompañamientos (4 acompañamientos + 2 salsas):</span>
                    <div class="summary-list" id="modal-sauces"></div>
                </div>
                <div class="summary-item">
                    <span class="summary-icon"></span>
                    <span class="summary-label">Costo de Domicilio:</span>
                    <span class="summary-value">$6,000</span>
                </div>
            </div>
        </div>
        
        <!-- Footer del modal -->
        <div class="confirmation-modal-footer">
            <button type="button" class="confirmation-modal-cancel-btn" id="modal-cancel">Cancelar</button>
            <button type="button" class="confirmation-modal-accept-btn" id="modal-confirm">Aceptar</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Base price for combo 4-6 - obtenido dinámicamente del producto
    const BASE_PRICE = typeof DYNAMIC_BASE_PRICE !== 'undefined' ? DYNAMIC_BASE_PRICE : 200000;
    const ADDITION_PRICE = 7500;
    
    // Function to update total price
    function updateTotalPrice() {
        let totalPrice = BASE_PRICE;
        let additionalCount = 0;
        
        // Count all selected options that have "(adicion de 7,500)" in their text
        document.querySelectorAll('.combo-option-card').forEach(card => {
            const count = parseInt(card.dataset.count) || 0;
            const optionText = card.dataset.value || '';
            
            if (count > 0 && optionText.includes('(adicion de 7,500)')) {
                additionalCount += count;
            }
        });
        
        totalPrice += (additionalCount * ADDITION_PRICE);
        
        // Update the price display
        const priceElement = document.getElementById('combo-total-price');
        if (priceElement) {
            priceElement.textContent = '$' + totalPrice.toLocaleString();
        }
    }
    
    // Función genérica para actualizar indicadores de cantidad
    function updateQuantityIndicator(card) {
        const count = parseInt(card.dataset.count) || 0;
        const indicator = card.querySelector('.quantity-indicator');
        
        if (indicator) {
            if (count >= 2) {
                // Si está seleccionado 2 o más veces, mostrar el indicador
                indicator.textContent = `x${count}`;
                indicator.style.display = 'block';
            } else {
                // Si no está seleccionado 2 o más veces, ocultar el indicador
                indicator.style.display = 'none';
            }
        }
    }
    
    // Initialize preselected sauce/acompañamiento options
    const sauceCards = document.querySelectorAll('.sauce-option');
    const preselectedOptions = ['guacamole', 'pico de gallo', 'frijol refrito', 'queso mozzarella'];
    
    sauceCards.forEach(card => {
        const sauceValue = card.dataset.value.toLowerCase();
        const isPreselected = preselectedOptions.some(option => 
            sauceValue.includes(option.toLowerCase())
        );
        
        if (isPreselected) {
            // Las opciones específicas están preseleccionadas como acompañamientos
            card.classList.add('selected');
            card.dataset.count = '1'; // Establecer contador inicial
            updateQuantityIndicator(card);
        }
    });
    
    // Handle clicks on protein cards
    const proteinCards = document.querySelectorAll('.protein-option');
    proteinCards.forEach(card => {
        card.addEventListener('click', function() {
            const currentCount = parseInt(this.dataset.count);
            const totalSelected = getTotalProteinSelections();
            
            if (currentCount === 0) {
                // Si no está seleccionado, seleccionarlo
                if (totalSelected >= 3) {
                    showLimitMessage('Solo puedes seleccionar máximo 3 proteínas');
                    return;
                }
                this.dataset.count = '1';
                this.classList.add('selected');
            } else if (currentCount === 1) {
                // Si está seleccionado una vez, verificar si puede seleccionarse otra vez
                if (totalSelected >= 3) {
                    // Si ya hay 3 selecciones, deseleccionar esta
                    this.dataset.count = '0';
                    this.classList.remove('selected');
                } else {
                    // Si hay menos de 3 selecciones, seleccionarlo una segunda vez
                    this.dataset.count = '2';
                }
            } else if (currentCount === 2) {
                // Si está seleccionado dos veces, verificar si puede seleccionarse una tercera vez
                if (totalSelected >= 3) {
                    // Si ya hay 3 selecciones, deseleccionar esta
                    this.dataset.count = '0';
                    this.classList.remove('selected');
                } else {
                    // Si hay menos de 3 selecciones, seleccionarlo una tercera vez
                    this.dataset.count = '3';
                }
            } else if (currentCount === 3) {
                // Si está seleccionado tres veces, deseleccionarlo completamente
                this.dataset.count = '0';
                this.classList.remove('selected');
            }
            
            // Update total price after any change
            updateTotalPrice();
            
            // Actualizar indicadores de cantidad
            updateProteinQuantityIndicators();
            
            updateSummary();
        });
    });
    
    // Función para obtener el total de selecciones de proteínas
    function getTotalProteinSelections() {
        let total = 0;
        document.querySelectorAll('.protein-option').forEach(card => {
            total += parseInt(card.dataset.count);
        });
        return total;
    }
    
    // Función para actualizar los indicadores de cantidad en proteínas
    function updateProteinQuantityIndicators() {
        document.querySelectorAll('.protein-option').forEach(card => {
            const count = parseInt(card.dataset.count);
            const indicator = card.querySelector('.quantity-indicator');
            
            if (count >= 2) {
                // Si está seleccionado 2 o más veces, mostrar el indicador
                indicator.textContent = `x${count}`;
                indicator.style.display = 'block';
            } else {
                // Si no está seleccionado 2 o más veces, ocultar el indicador
                indicator.style.display = 'none';
            }
        });
    }
    
    // Handle clicks on sauce/acompañamiento cards
    sauceCards.forEach(card => {
        card.addEventListener('click', function() {
            const currentCount = parseInt(this.dataset.count);
            const totalSelected = getTotalSauceSelections();
            const sauceValue = this.dataset.value.toLowerCase();
            
            // Verificar si es una opción preseleccionada (acompañamiento)
            const isPreselectedOption = preselectedOptions.some(option => 
                sauceValue.includes(option.toLowerCase())
            );
            
            if (currentCount === 0) {
                // Si no está seleccionado, seleccionarlo
                if (totalSelected >= 6) {
                    showLimitMessage('Solo puedes seleccionar máximo 6 opciones: 4 acompañamientos + 2 salsas');
                    return;
                }
                this.dataset.count = '1';
                this.classList.add('selected');
            } else if (currentCount === 1) {
                // Si está seleccionado una vez, verificar si puede seleccionarse otra vez
                if (totalSelected >= 6) {
                    // Si ya hay 6 selecciones, deseleccionar esta
                    this.dataset.count = '0';
                    this.classList.remove('selected');
                } else {
                    // Si hay menos de 6 selecciones, seleccionarlo una segunda vez
                    this.dataset.count = '2';
                }
            } else if (currentCount === 2) {
                // Si está seleccionado dos veces, deseleccionarlo completamente
                this.dataset.count = '0';
                this.classList.remove('selected');
            }
            
            // Update total price after any change
            updateTotalPrice();
            
            // Actualizar indicadores de cantidad
            updateSauceQuantityIndicators();
            
            updateSummary();
        });
    });
    
    // Función para obtener el total de selecciones de salsas
    function getTotalSauceSelections() {
        let total = 0;
        document.querySelectorAll('.sauce-option').forEach(card => {
            total += parseInt(card.dataset.count);
        });
        return total;
    }

    function getTotalTortillaSelections() {
        let total = 0;
        document.querySelectorAll('.tortilla-option').forEach(card => {
            total += parseInt(card.dataset.count);
        });
        return total;
    }
    
    // Función para actualizar los indicadores de cantidad en salsas
    function updateSauceQuantityIndicators() {
        document.querySelectorAll('.sauce-option').forEach(card => {
            const count = parseInt(card.dataset.count);
            const indicator = card.querySelector('.quantity-indicator');
            
            if (count >= 2) {
                // Si está seleccionado 2 o más veces, mostrar el indicador
                indicator.textContent = `x${count}`;
                indicator.style.display = 'block';
            } else {
                // Si no está seleccionado 2 o más veces, ocultar el indicador
                indicator.style.display = 'none';
            }
        });
    }
    
    // Handle clicks on tortilla cards
    const tortillaCards = document.querySelectorAll('.tortilla-option');
    tortillaCards.forEach(card => {
        card.addEventListener('click', function() {
            const currentCount = parseInt(this.dataset.count);
            const totalSelected = getTotalTortillaSelections();
            
            if (currentCount === 0) {
                // Si no está seleccionado, seleccionarlo
                if (totalSelected >= 2) {
                    showLimitMessage('Solo puedes seleccionar máximo 2 tortillas');
                    return;
                }
                this.dataset.count = '1';
                this.classList.add('selected');
            } else if (currentCount === 1) {
                // Si está seleccionado una vez, verificar si puede seleccionarse otra vez
                if (totalSelected >= 2) {
                    // Si ya hay 2 selecciones, deseleccionar esta
                    this.dataset.count = '0';
                    this.classList.remove('selected');
                } else {
                    // Si hay menos de 2 selecciones, seleccionarlo una segunda vez
                    this.dataset.count = '2';
                }
            } else if (currentCount === 2) {
                // Si está seleccionado dos veces, deseleccionarlo completamente
                this.dataset.count = '0';
                this.classList.remove('selected');
            }
            
            // Update total price after any change
            updateTotalPrice();
            
            // Actualizar indicadores de cantidad
            updateTortillaQuantityIndicators();
            
            updateSummary();
        });
    });
    
    // Función para obtener el total de selecciones de tortillas
    function getTotalTortillaSelections() {
        let total = 0;
        document.querySelectorAll('.tortilla-option').forEach(card => {
            total += parseInt(card.dataset.count);
        });
        return total;
    }
    
    // Función para actualizar los indicadores de cantidad en tortillas
    function updateTortillaQuantityIndicators() {
        document.querySelectorAll('.tortilla-option').forEach(card => {
            const count = parseInt(card.dataset.count);
            const indicator = card.querySelector('.quantity-indicator');
            
            if (count === 2) {
                // Si está seleccionado 2 veces, mostrar x2
                indicator.style.display = 'block';
            } else {
                // Si no está seleccionado 2 veces, ocultar el indicador
                indicator.style.display = 'none';
            }
        });
    }
    
    // Handle option selection for other categories (totopos)
    const otherOptionCards = document.querySelectorAll('.totopo-option');
    otherOptionCards.forEach(card => {
        card.addEventListener('click', function() {
            const type = this.dataset.type;
            
            // Para otras categorías: selección única
            const sameTypeCards = document.querySelectorAll(`.${type}-option`);
            sameTypeCards.forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            
            // Update total price after any change
            updateTotalPrice();
            
            updateSummary();
        });
    });
    
    // Update summary display
    function updateSummary() {
        const selectedTotopos = document.querySelector('.totopo-option.selected');
        const totalTortillaSelections = getTotalTortillaSelections();
        const totalProteinSelections = getTotalProteinSelections();
        const totalSauceSelections = getTotalSauceSelections();
        
        // Aquí puedes agregar lógica para mostrar el resumen si es necesario
        // Por ahora solo manejamos la selección
    }
    
    // Show limit message
    function showLimitMessage(message) {
        const tooltip = document.createElement('div');
        tooltip.className = 'limit-tooltip';
        tooltip.textContent = message;
        document.body.appendChild(tooltip);
        
        setTimeout(() => {
            tooltip.remove();
        }, 2000);
    }
    
    // Handle form submission
    document.getElementById('combo-builder-form-4-6').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const selectedTotopos = document.querySelector('.totopo-option.selected');
        
        // Verificar todas las selecciones usando el nuevo sistema
        const totalTortillaSelections = getTotalTortillaSelections();
        const totalProteinSelections = getTotalProteinSelections();
        const totalSauceSelections = getTotalSauceSelections();
        
        // Validación específica y detallada
        let validationErrors = [];
        
        // Validar Totopos (1 selección requerida)
        if (!selectedTotopos) {
            validationErrors.push('• Selecciona 1 tipo de totopos');
        }
        
        // Validar Tortillas (exactamente 2 selecciones requeridas)
        if (totalTortillaSelections === 0) {
            validationErrors.push('• Selecciona 2 tortillas (cada una de 250gr = 500gr total)');
        } else if (totalTortillaSelections !== 2) {
            validationErrors.push(`• Selecciona exactamente 2 tortillas (actualmente tienes ${totalTortillaSelections})`);
        }
        
        // Validar Proteínas (exactamente 3 selecciones requeridas)
        if (totalProteinSelections === 0) {
            validationErrors.push('• Selecciona 3 proteínas (cada una de 500gr)');
        } else if (totalProteinSelections !== 3) {
            validationErrors.push(`• Selecciona exactamente 3 proteínas (actualmente tienes ${totalProteinSelections})`);
        }
        
        // Validar Salsas y Acompañamientos (exactamente 6 selecciones requeridas: 4 acompañamientos + 2 salsas)
        if (totalSauceSelections === 0) {
            validationErrors.push('• Selecciona 4 acompañamientos (2 de 500g + 2 de 250g) y 2 salsas de 250g');
        } else if (totalSauceSelections !== 6) {
            validationErrors.push(`• Selecciona exactamente 6 opciones: 4 acompañamientos + 2 salsas (actualmente tienes ${totalSauceSelections})`);
        }
        
        // Si hay errores de validación, mostrarlos
        if (validationErrors.length > 0) {
            showValidationModal(validationErrors);
            return;
        }
        
        // Here you would typically add the combo to cart
        // For now, just show a success message
        alert('¡Combo agregado al carrito exitosamente!');
    });

    // Handle add to cart button
    document.getElementById('add-to-cart-btn').addEventListener('click', function() {
        const selectedTotopos = document.querySelector('.totopo-option.selected');
        const selectedTortillas = document.querySelector('.tortilla-option.selected');
        const totalProteinSelections = getTotalProteinSelections();
        const totalSauceSelections = getTotalSauceSelections();
        
        // Validación específica y detallada
        let validationErrors = [];
        
        // Validar Totopos (1 selección requerida para combo 4-6)
        if (!selectedTotopos) {
            validationErrors.push('• Selecciona 1 tipo de totopos');
        }
        
        // Validar Tortillas (2 selecciones requeridas para combo 4-6)
        const totalTortillaSelections = getTotalTortillaSelections();
        if (totalTortillaSelections === 0) {
            validationErrors.push('• Selecciona 2 tipos de tortillas');
        } else if (totalTortillaSelections !== 2) {
            validationErrors.push(`• Selecciona exactamente 2 tortillas (actualmente tienes ${totalTortillaSelections})`);
        }
        
        // Validar Proteínas (exactamente 3 selecciones requeridas para combo 4-6)
        if (totalProteinSelections === 0) {
            validationErrors.push('• Selecciona 3 proteínas (cada una de 500gr)');
        } else if (totalProteinSelections !== 3) {
            validationErrors.push(`• Selecciona exactamente 3 proteínas (actualmente tienes ${totalProteinSelections})`);
        }
        
        // Validar Salsas y Acompañamientos (exactamente 6 selecciones requeridas: 4 acompañamientos + 2 salsas)
        if (totalSauceSelections === 0) {
            validationErrors.push('• Selecciona 4 acompañamientos (2 de 500g + 2 de 250g) y 2 salsas de 250g');
        } else if (totalSauceSelections !== 6) {
            validationErrors.push(`• Selecciona exactamente 6 opciones: 4 acompañamientos + 2 salsas (actualmente tienes ${totalSauceSelections})`);
        }
        
        // Si hay errores de validación, mostrarlos
        if (validationErrors.length > 0) {
            showValidationModal(validationErrors);
            return;
        }
        
        // Calculate total price
        let totalPrice = BASE_PRICE;
        let additionalCount = 0;
        
        // Count all selected options that have "(adicion de 7,500)" in their text
        document.querySelectorAll('.combo-option-card').forEach(card => {
            const count = parseInt(card.dataset.count) || 0;
            const optionText = card.dataset.value || '';
            
            if (count > 0 && optionText.includes('(adicion de 7,500)')) {
                additionalCount += count;
            }
        });
        
        totalPrice += (additionalCount * ADDITION_PRICE);
        
        console.log('DEBUG COMBO 4-6: Precio calculado - Base:', BASE_PRICE, 'Adiciones:', additionalCount, 'Precio adición:', ADDITION_PRICE, 'Total:', totalPrice);
        
        // Recopilar todas las selecciones
        const comboData = {
            totopos: [],
            tortillas: [],
            proteins: [],
            sauces: [],
            total_price: totalPrice
        };
        
        console.log('DEBUG COMBO 4-6: comboData a enviar:', comboData);
        console.log('DEBUG COMBO 4-6: total_price en comboData:', comboData.total_price);
        
        // Recopilar totopos seleccionados
        document.querySelectorAll('.totopo-option').forEach(card => {
            const count = parseInt(card.dataset.count);
            if (count > 0) {
                for (let i = 0; i < count; i++) {
                    comboData.totopos.push(card.dataset.value);
                }
            }
        });
        
        // Recopilar tortillas seleccionadas
        document.querySelectorAll('.tortilla-option').forEach(card => {
            const count = parseInt(card.dataset.count);
            if (count > 0) {
                for (let i = 0; i < count; i++) {
                    comboData.tortillas.push(card.dataset.value);
                }
            }
        });
        
        // Recopilar proteínas seleccionadas
        document.querySelectorAll('.protein-option').forEach(card => {
            const count = parseInt(card.dataset.count);
            if (count > 0) {
                for (let i = 0; i < count; i++) {
                    comboData.proteins.push(card.dataset.value);
                }
            }
        });
        
        // Recopilar salsas seleccionadas
        document.querySelectorAll('.sauce-option').forEach(card => {
            const count = parseInt(card.dataset.count);
            if (count > 0) {
                for (let i = 0; i < count; i++) {
                    comboData.sauces.push(card.dataset.value);
                }
            }
        });
        
        // Mostrar modal de confirmación
        showComboConfirmationModal(comboData);
    });

    // Handle adiciones link click
    document.getElementById('adiciones-link').addEventListener('click', function(e) {
        e.preventDefault();
        
        const selectedTotopos = document.querySelector('.totopo-option.selected');
        const selectedTortillas = document.querySelector('.tortilla-option.selected');
        const totalProteinSelections = getTotalProteinSelections();
        const totalSauceSelections = getTotalSauceSelections();
        
        // Validar que hay al menos una selección antes de ir a adiciones
        if (!selectedTotopos && !selectedTortillas && totalProteinSelections === 0 && totalSauceSelections === 0) {
            alert('Por favor selecciona al menos una opción antes de agregar adiciones.');
            return;
        }
        
        // Calculate total price
        let totalPrice = BASE_PRICE;
        let additionalCount = 0;
        
        // Count all selected options that have "(adicion de 7,500)" in their text
        document.querySelectorAll('.combo-option-card').forEach(card => {
            const count = parseInt(card.dataset.count) || 0;
            const optionText = card.dataset.value || '';
            
            if (count > 0 && optionText.includes('(adicion de 7,500)')) {
                additionalCount += count;
            }
        });
        
        totalPrice += (additionalCount * ADDITION_PRICE);
        
        // Recopilar todas las selecciones actuales
        const comboData = {
            totopos: [],
            tortillas: [],
            proteins: [],
            sauces: [],
            total_price: totalPrice
        };
        
        // Recopilar totopos seleccionados
        document.querySelectorAll('.totopo-option').forEach(card => {
            const count = parseInt(card.dataset.count);
            if (count > 0) {
                for (let i = 0; i < count; i++) {
                    comboData.totopos.push(card.dataset.value);
                }
            }
        });
        
        // Recopilar tortillas seleccionadas
        document.querySelectorAll('.tortilla-option').forEach(card => {
            const count = parseInt(card.dataset.count);
            if (count > 0) {
                for (let i = 0; i < count; i++) {
                    comboData.tortillas.push(card.dataset.value);
                }
            }
        });
        
        // Recopilar proteínas seleccionadas
        document.querySelectorAll('.protein-option').forEach(card => {
            const count = parseInt(card.dataset.count);
            if (count > 0) {
                for (let i = 0; i < count; i++) {
                    comboData.proteins.push(card.dataset.value);
                }
            }
        });
        
        // Recopilar salsas seleccionadas
        document.querySelectorAll('.sauce-option').forEach(card => {
            const count = parseInt(card.dataset.count);
            if (count > 0) {
                for (let i = 0; i < count; i++) {
                    comboData.sauces.push(card.dataset.value);
                }
            }
        });
        
        // Obtener el ID del combo
        const comboIdInput = document.querySelector('input[name="combo_product_id"]');
        const comboId = comboIdInput ? comboIdInput.value : null;
        
        // Guardar la selección actual y el ID del combo en sessionStorage
        const comboDataWithId = {
            ...comboData,
            combo_id: comboId
        };
        sessionStorage.setItem('combo_selection', JSON.stringify(comboDataWithId));
        
        // Agregar al carrito primero, luego redireccionar
        addComboToCart(comboData, true).then(() => {
            // Redireccionar a la página de adiciones después de agregar al carrito
            window.location.href = this.getAttribute('href');
        }).catch(error => {
            console.error('Error al agregar al carrito:', error);
            alert('Error al agregar el combo al carrito. Por favor intenta de nuevo.');
        });
    });
    
    // Modal functionality
    function showComboConfirmationModal(comboData) {
        const modal = document.getElementById('combo-confirmation-modal');
        
        // Populate modal with combo data
        document.getElementById('modal-totopos').textContent = comboData.totopos;
        document.getElementById('modal-tortillas').textContent = comboData.tortillas;
        
        // Populate proteins list
        const proteinsList = document.getElementById('modal-proteins');
        proteinsList.innerHTML = '';
        comboData.proteins.forEach(protein => {
            const proteinItem = document.createElement('div');
            proteinItem.className = 'summary-list-item';
            proteinItem.textContent = '- ' + protein;
            proteinsList.appendChild(proteinItem);
        });
        
        // Populate sauces list
        const saucesList = document.getElementById('modal-sauces');
        saucesList.innerHTML = '';
        comboData.sauces.forEach(sauce => {
            const sauceItem = document.createElement('div');
            sauceItem.className = 'summary-list-item';
            sauceItem.textContent = '- ' + sauce;
            saucesList.appendChild(sauceItem);
        });
        
        // Show modal
        modal.style.display = 'flex';
        
        // Modal event listeners
        const closeBtn = document.getElementById('confirmation-modal-close');
        const cancelBtn = document.getElementById('modal-cancel');
        const confirmBtn = document.getElementById('modal-confirm');
        
        const hideModal = () => {
            modal.style.display = 'none';
        };
        
        closeBtn.onclick = hideModal;
        cancelBtn.onclick = hideModal;
        confirmBtn.onclick = () => {
            // Add to cart functionality
            addComboToCart(comboData);
            hideModal();
        };
        
        // Close modal when clicking overlay
        modal.onclick = (e) => {
            if (e.target === modal) {
                hideModal();
            }
        };
        
        // Close modal with Escape key
        const handleEscape = (e) => {
            if (e.key === 'Escape') {
                hideModal();
                document.removeEventListener('keydown', handleEscape);
            }
        };
        document.addEventListener('keydown', handleEscape);
    }
    
    function addComboToCart(comboData, skipRedirect = false) {
        return new Promise((resolve, reject) => {
            // Show loading state
            const button = document.getElementById('add-to-cart-btn');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Agregando...';
            button.disabled = true;
            
            // Prepare data for WooCommerce
            const comboIdInput = document.querySelector('input[name="combo_product_id"]');
            if (!comboIdInput) {
                alert('Error: No se encontró el ID del combo. Por favor recarga la página.');
                reject(new Error('No combo ID found'));
                return;
            }
            
            // Convert combo_data to individual form fields for PHP
            const formData = new URLSearchParams();
            formData.append('action', 'add_combo_to_cart');
            formData.append('combo_id', comboIdInput.value);
            formData.append('nonce', '<?php echo wp_create_nonce("add_combo_to_cart"); ?>');
            
            // Add combo_data fields individually
            formData.append('combo_data[totopos]', JSON.stringify(comboData.totopos));
            formData.append('combo_data[tortillas]', JSON.stringify(comboData.tortillas));
            formData.append('combo_data[proteins]', JSON.stringify(comboData.proteins));
            formData.append('combo_data[sauces]', JSON.stringify(comboData.sauces));
            formData.append('combo_data[total_price]', comboData.total_price);
            
            console.log('Datos a enviar:', formData.toString());
            
            // Send AJAX request to add to cart
            fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: formData
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                return response.text().then(text => {
                    console.log('Raw response:', text);
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('JSON parse error:', e);
                        throw new Error('Invalid JSON response: ' + text);
                    }
                });
            })
            .then(data => {
                console.log('Parsed data:', data);
                if (data.success) {
                    // Show success notification
                    showSuccessNotification();
                    
                    // Update cart count if element exists
                    updateCartCount();
                    
                    // Reset form
                    resetComboForm();
                    
                    if (!skipRedirect) {
                        // Redirect to cart after a short delay
                        setTimeout(() => {
                            window.location.href = '<?php echo wc_get_cart_url(); ?>';
                        }, 1500);
                    }
                    
                    resolve(data);
                } else {
                    const errorMsg = 'Error al agregar el combo al carrito: ' + (data.data || 'Error desconocido');
                    alert(errorMsg);
                    reject(new Error(errorMsg));
                }
            })
            .catch(error => {
                console.error('Error completo:', error);
                const errorMsg = 'Error al agregar el combo al carrito: ' + error.message;
                alert(errorMsg);
                reject(error);
            })
            .finally(() => {
                // Reset button
                button.innerHTML = originalText;
                button.disabled = false;
            });
        });
    }
    
    function showSuccessNotification() {
        const notification = document.createElement('div');
        notification.className = 'success-notification';
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-check-circle"></i>
                <span>¡Combo agregado al carrito exitosamente!</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
    
    function updateCartCount() {
        // Try to update cart count if cart widget exists
        const cartCount = document.querySelector('.cart-count, .cart-counter, .woocommerce-cart-count');
        if (cartCount) {
            // Trigger cart update event
            document.body.dispatchEvent(new CustomEvent('wc_fragment_refresh'));
        }
    }
    
    function resetComboForm() {
        // Reset all selections
        document.querySelectorAll('.combo-option-card').forEach(card => {
            card.classList.remove('selected');
            card.dataset.count = '0';
        });
        
        // Reset protein and sauce counters
        document.querySelectorAll('.protein-option').forEach(card => {
            card.dataset.count = '0';
        });
        
        document.querySelectorAll('.sauce-option').forEach(card => {
            card.dataset.count = '0';
        });
        
        // Hide quantity indicators
        document.querySelectorAll('.quantity-indicator').forEach(indicator => {
            indicator.style.display = 'none';
        });
        
        // Select first options by default
        const firstTotopo = document.querySelector('.totopo-option');
        const firstTortilla = document.querySelector('.tortilla-option');
        
        if (firstTotopo) firstTotopo.classList.add('selected');
        if (firstTortilla) firstTortilla.classList.add('selected');
    }

    // Modal de validación
    function showValidationModal(errors) {
        const modal = document.getElementById('validation-modal');
        const messageContainer = document.getElementById('validation-message');
        
        // Crear el mensaje HTML
        let messageHTML = '<p class="validation-intro">Por favor completa tu selección antes de agregar al carrito:</p><ul class="validation-list">';
        errors.forEach(error => {
            messageHTML += `<li>${error}</li>`;
        });
        messageHTML += '</ul>';
        
        messageContainer.innerHTML = messageHTML;
        
        // Mostrar el modal
        modal.style.display = 'flex';
        
        // Agregar event listeners si no existen
        const closeBtn = document.getElementById('validation-modal-close');
        const acceptBtn = document.getElementById('validation-modal-accept-btn');
        
        const closeModal = () => {
            modal.style.display = 'none';
        };
        
        closeBtn.onclick = closeModal;
        acceptBtn.onclick = closeModal;
        
        // Cerrar al hacer clic en el overlay
        modal.onclick = (e) => {
            if (e.target === modal) {
                closeModal();
            }
        };
    }
});
</script>

<!-- Modal de validación de selección incompleta -->
<div id="validation-modal" class="validation-modal-overlay" style="display: none;">
    <div class="validation-modal">
        <!-- Header del modal -->
        <div class="validation-modal-header">
            <h3 class="validation-modal-title">Selección incompleta</h3>
            <button class="validation-modal-close" id="validation-modal-close">
                <span class="close-icon">×</span>
            </button>
        </div>
        
        <!-- Contenido del modal -->
        <div class="validation-modal-content">
            <div class="validation-icon">
                <span class="warning-icon">⚠️</span>
            </div>
            <div class="validation-message" id="validation-message">
                <!-- Los mensajes de validación se insertarán aquí -->
            </div>
        </div>
        
        <!-- Footer del modal -->
        <div class="validation-modal-footer">
            <button class="validation-modal-accept-btn" id="validation-modal-accept-btn">Aceptar</button>
        </div>
    </div>
</div>

<?php get_footer(); ?>
