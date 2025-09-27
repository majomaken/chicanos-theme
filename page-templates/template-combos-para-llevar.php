<?php
/**
 * Template Name: Combos para Llevar
 * 
 * Template para combos que se puede usar para diferentes tamaños:
 * - 1-3 personas
 * - 4-5 personas  
 * - 7-10 personas
 *
 * @package Chicanos_Theme
 */

get_header(); ?>

<!-- Cargar estilos específicos para combos para llevar -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/combos-para-llevar.css">

<div id="combos-para-llevar-wrapper" class="wrapper">
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
                                    $combo_size = 'Combo 1-3 personas'; // Default
                                    
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
                                            $combo_size = 'Combo 1-3 personas'; // Ajustar según lógica de negocio
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
                                    <li>1 paquete de tortillas frescas</li>
                                    <li>750 g de proteína a elección</li>
                                    <li>1.500 g de salsa</li>
                                </ul>
                            </div>
                            <div class="combo-price">
                                <span class="price-amount" id="combo-total-price">$134,800</span>
                            </div>
                        </div>
                        <div class="portion-sizes">
                            <div class="portion-size-item">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/size-small.svg" alt="250 Gramos" class="portion-svg">
                                <div class="portion-dimensions">250</div>
                                <span class="portion-label">Gramos</span>
                            </div>
                            <div class="portion-size-item">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/size-medium.svg" alt="500 Gramos" class="portion-svg">
                                <div class="portion-dimensions">500</div>
                                <span class="portion-label">Gramos</span>
                            </div>
                            <div class="portion-size-item active">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/size-large.svg" alt="1000 Gramos" class="portion-svg">
                                <div class="portion-dimensions">1000</div>
                                <span class="portion-label">Gramos</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="combo-banner-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/combos-para-llevar-banner.jpg" alt="Combos para Llevar - Comida Mexicana" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido principal con imagen de fondo -->
        <div class="combo-content-main">
            <!-- Combo Builder Form -->
            <form id="combo-builder-form" class="combo-builder">
                
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
                    echo '<!-- DEBUG: No hay parámetros de combo, buscando combo por defecto -->';
                    // Opción 3: Si no hay parámetros, buscar el primer combo disponible
                    $default_combo_args = array(
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
                    );
                    
                    $default_combo_query = new WP_Query($default_combo_args);
                    if ($default_combo_query->have_posts()) {
                        $default_combo_query->the_post();
                        $combo_product_id = get_the_ID();
                        echo '<!-- DEBUG: Combo por defecto encontrado: ' . $combo_product_id . ' -->';
                        wp_reset_postdata();
                    } else {
                        echo '<!-- DEBUG: No se encontró ningún combo -->';
                    }
                }
                
                // DEBUG ADICIONAL: Listar todos los productos de combo disponibles
                echo '<!-- DEBUG: Listando todos los productos de combo disponibles -->';
                $all_combos_query = new WP_Query(array(
                    'post_type' => 'product',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'slug',
                            'terms'    => array('combos', 'combo', 'combo-para-llevar'),
                            'operator' => 'IN',
                        ),
                    ),
                ));
                
                if ($all_combos_query->have_posts()) {
                    echo '<!-- DEBUG: Productos de combo encontrados: -->';
                    while ($all_combos_query->have_posts()) {
                        $all_combos_query->the_post();
                        $product_id = get_the_ID();
                        $product_name = get_the_title();
                        $wapf_check = get_post_meta($product_id, '_wapf_fieldgroup', true);
                        echo '<!-- DEBUG: Combo ID: ' . $product_id . ' - Nombre: ' . $product_name . ' - WAPF Config: ' . (!empty($wapf_check) ? 'SÍ' : 'NO') . ' -->';
                    }
                    wp_reset_postdata();
                } else {
                    echo '<!-- DEBUG: No se encontraron productos de combo en la base de datos -->';
                }
                
                if ($combo_product_id) {
                    echo '<!-- DEBUG: Procesando combo ID: ' . $combo_product_id . ' -->';
                    $combo_product = wc_get_product($combo_product_id);
                    
                    if ($combo_product) {
                        echo '<!-- DEBUG: Producto cargado correctamente -->';
                        
                        // Extraer opciones desde el meta field _wapf_fieldgroup
                        $wapf_data = get_post_meta($combo_product_id, '_wapf_fieldgroup', true);
                        
                        // DEBUG COMPLETO DE WAPF
                        echo '<!-- DEBUG WAPF COMPLETO -->';
                        echo '<!-- DEBUG: Combo Product ID: ' . $combo_product_id . ' -->';
                        echo '<!-- DEBUG: WAPF Data Raw: ' . print_r($wapf_data, true) . ' -->';
                        
                        // Verificar todos los meta fields del producto
                        $all_meta = get_post_meta($combo_product_id);
                        echo '<!-- DEBUG: Todos los meta fields: ' . print_r($all_meta, true) . ' -->';
                        
                        // Verificar si WAPF está activo
                        echo '<!-- DEBUG: WAPF Plugin Active: ' . (is_plugin_active('advanced-product-fields-for-woocommerce/advanced-product-fields-for-woocommerce.php') ? 'YES' : 'NO') . ' -->';
                        
                        // Debug completo usando la función de debug
                        $wapf_debug = debug_wapf_status($combo_product_id);
                        echo '<!-- DEBUG WAPF STATUS: ' . print_r($wapf_debug, true) . ' -->';
                        
                        // Debug específico de input fields WAPF
                        debug_wapf_input_fields($combo_product_id);
                        
                        // Debug de todos los productos de combo
                        $all_combos_debug = debug_all_combo_products();
                        echo '<!-- DEBUG ALL COMBOS: ' . print_r($all_combos_debug, true) . ' -->';
                        
                        // Debug en consola JavaScript
                        echo '<script>';
                        echo 'console.log("=== DEBUG COMBO OPTIONS ===");';
                        echo 'console.log("Combo Product ID:", ' . $combo_product_id . ');';
                        echo 'console.log("WAPF Active:", ' . (is_plugin_active('advanced-product-fields-for-woocommerce/advanced-product-fields-for-woocommerce.php') ? 'true' : 'false') . ');';
                        
                        // Debug WAPF data en consola
                        $wapf_meta = get_post_meta($combo_product_id, '_wapf_fieldgroup', true);
                        echo 'console.log("WAPF Meta Data:", ' . json_encode($wapf_meta) . ');';
                        
                        // Debug todos los meta fields
                        $all_meta = get_post_meta($combo_product_id);
                        echo 'console.log("All Meta Fields:", ' . json_encode($all_meta) . ');';
                        
                        // Debug fieldgroup si existe la función
                        if (function_exists('wapf_get_fieldgroup')) {
                            $fieldgroup = wapf_get_fieldgroup($combo_product_id);
                            echo 'console.log("WAPF Fieldgroup:", ' . json_encode($fieldgroup) . ');';
                        }
                        
                        echo '</script>';
                        
                        // Inicializar arrays para las opciones
                        $protein_options = array();
                        $sauce_options_1 = array(); // Primera selección de salsas
                        $sauce_options_2 = array(); // Segunda selección de salsas
                        $tortilla_options_1 = array(); // Primera selección de tortillas
                        $tortilla_options_2 = array(); // Segunda selección de tortillas
                        
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
                                    
                                    // Obtener el título del campo para identificar por nombre
                                    $field_title = isset($field['options']['title']) ? strtolower($field['options']['title']) : '';
                                    $field_label = isset($field['options']['label']) ? strtolower($field['options']['label']) : '';
                                    
                                    echo '<!-- DEBUG: Campo encontrado - ID: ' . $field['id'] . ' - Título: ' . $field_title . ' - Label: ' . $field_label . ' -->';
                                    
                                    // Asignar a la categoría correcta según el NOMBRE del campo (no ID)
                                    if (strpos($field_title, 'proteína') !== false || strpos($field_title, 'proteina') !== false || 
                                        strpos($field_label, 'proteína') !== false || strpos($field_label, 'proteina') !== false) {
                                        $protein_options = $labels;
                                        echo '<!-- DEBUG: Proteínas extraídas por nombre: ' . print_r($protein_options, true) . ' -->';
                                    } elseif (strpos($field_title, 'salsa') !== false || strpos($field_label, 'salsa') !== false) {
                                        if (empty($sauce_options_1)) {
                                            $sauce_options_1 = $labels;
                                            echo '<!-- DEBUG: Salsas 1 extraídas por nombre: ' . print_r($labels, true) . ' -->';
                                        } else {
                                            $sauce_options_2 = $labels;
                                            echo '<!-- DEBUG: Salsas 2 extraídas por nombre: ' . print_r($labels, true) . ' -->';
                                        }
                                    } elseif (strpos($field_title, 'tortilla') !== false || strpos($field_label, 'tortilla') !== false) {
                                        if (empty($tortilla_options_1)) {
                                            $tortilla_options_1 = $labels;
                                            echo '<!-- DEBUG: Tortillas 1 extraídas por nombre: ' . print_r($labels, true) . ' -->';
                                        } else {
                                            $tortilla_options_2 = $labels;
                                            echo '<!-- DEBUG: Tortillas 2 extraídas por nombre: ' . print_r($labels, true) . ' -->';
                                        }
                                    } elseif (strpos($field_title, 'totopo') !== false || strpos($field_label, 'totopo') !== false) {
                                        // Si hay campo de totopos en WAPF, usarlo
                                        $totopos_options = $labels;
                                        echo '<!-- DEBUG: Totopos extraídos por nombre: ' . print_r($totopos_options, true) . ' -->';
                                    }
                                }
                            }
                        } else {
                            echo '<!-- DEBUG: No se encontró WAPF data -->';
                        }
                        
                        // Si no hay custom fields, buscar opciones desde otras fuentes
                        if (empty($protein_options)) {
                            echo '<!-- DEBUG: Buscando proteínas desde otras fuentes -->';
                            $protein_options = get_combo_options_from_woocommerce($combo_product_id, 'protein');
                            echo '<script>console.log("Protein Options Found:", ' . json_encode($protein_options) . ');</script>';
                        }
                        if (empty($sauce_options_1)) {
                            echo '<!-- DEBUG: Buscando salsas desde otras fuentes -->';
                            $sauce_options_1 = get_combo_options_from_woocommerce($combo_product_id, 'sauce');
                            echo '<script>console.log("Sauce Options Found:", ' . json_encode($sauce_options_1) . ');</script>';
                        }
                        if (empty($tortilla_options_1)) {
                            echo '<!-- DEBUG: Buscando tortillas desde otras fuentes -->';
                            $tortilla_options_1 = get_combo_options_from_woocommerce($combo_product_id, 'tortilla');
                            echo '<script>console.log("Tortilla Options Found:", ' . json_encode($tortilla_options_1) . ');</script>';
                        }
                        
                        // Totopos options - buscar dinámicamente
                        $totopos_options = get_combo_options_from_woocommerce($combo_product_id, 'totopo');
                        echo '<script>console.log("Totopo Options Found:", ' . json_encode($totopos_options) . ');</script>';
                        
                        // Si aún no hay opciones, mostrar mensaje de error en lugar de valores hardcodeados
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
                        if (!empty($totopos_options)) :
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
                        <?php endif; ?>

                        <!-- 2. TORTILLAS SECTION -->
                        <?php if (!empty($tortilla_options_1)) : ?>
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="section-title">
                                        Tortillas 
                                        <span class="selection-limit">(escoge 1)</span>
                                    </h2>
                                </div>
                            </div>
                            
                            <div class="products-grid" id="tortilla-grid">
                                <?php
                                $first = true;
                                foreach ($tortilla_options_1 as $tortilla) {
                                    $selected_class = $first ? 'selected' : '';
                                    $first = false;
                                    
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
                                    <div class="combo-option-card tortilla-option <?php echo $selected_class; ?>" 
                                         data-type="tortilla" 
                                         data-value="<?php echo esc_attr($tortilla_text); ?>"
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

                        <!-- 3. PROTEÍNA SECTION -->
                        <?php if (!empty($protein_options)) : ?>
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="section-title">
                                        Escoge tu Proteína 
                                        <span class="selection-limit">(Escoge 2 proteinas (cada una de 250 Gr))</span>
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
                        <?php endif; ?>

                        <!-- 4. SALSAS SECTION -->
                        <?php if (!empty($sauce_options_1)) : ?>
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="section-title">
                                        Salsas y Más 
                                        <span class="selection-limit">(escoge 6 de salsas(3500gr))</span>
                                    </h2>
                                    <div class="salsas-details">
                                        <span class="sugerencias-title">Sugerencias:</span><br>
                                        <ul class="salsas-list">
                                            <li>1000 gr de guacamole predeterminadas</li>
                                            <li>1000 gr de pico de gallo predeterminadas</li>
                                            <li>500 gramos de frijol predeterminadas</li>
                                            <li>500 gramos de queso predeterminadas</li>
                                            <li>250 gramos de lo que quieran</li>
                                            <li>250 gramos de lo que quieran</li>
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
                                            <div class="quantity-indicator" style="<?php echo $is_preselected ? 'display: block;' : 'display: none;'; ?>">x<?php echo $initial_count; ?></div>
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
                        <?php endif; ?>

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
                                </div>
                            </div>
                        </section>
                        
                        <!-- Adiciones Section -->
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="section-title">
                                        ¿Quieres más guacamole?
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
                <span class="success-icon">✅</span>
            </div>
            <div class="combo-summary">
                <h4 class="summary-title">📋 Resumen de tu combo:</h4>
                <div class="summary-item">
                    <span class="summary-icon">🥨</span>
                    <span class="summary-label">Totopos:</span>
                    <span class="summary-value" id="modal-totopos"></span>
                </div>
                <div class="summary-item">
                    <span class="summary-icon">🌮</span>
                    <span class="summary-label">Tortillas:</span>
                    <span class="summary-value" id="modal-tortillas"></span>
                </div>
                <div class="summary-item">
                    <span class="summary-icon">🍖</span>
                    <span class="summary-label">Proteínas (2x250gr):</span>
                    <div class="summary-list" id="modal-proteins"></div>
                </div>
                <div class="summary-item">
                    <span class="summary-icon">🌶️</span>
                    <span class="summary-label">Salsas (6x250gr):</span>
                    <div class="summary-list" id="modal-sauces"></div>
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
    // Base price for combo 1-3
    const BASE_PRICE = 134800;
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
    
    // PROTEINAS LOGIC (2 selecciones para combo 1-3)
    const proteinCards = document.querySelectorAll('.protein-option');
    proteinCards.forEach(card => {
        card.addEventListener('click', function() {
            const currentCount = parseInt(this.dataset.count);
            const totalSelected = getTotalProteinSelections();
            
            if (currentCount === 0) {
                if (totalSelected >= 2) {
                    showLimitMessage('Solo puedes seleccionar máximo 2 proteínas');
                    return;
                }
                this.dataset.count = '1';
                this.classList.add('selected');
            } else if (currentCount === 1) {
                if (totalSelected >= 2) {
                    this.dataset.count = '0';
                    this.classList.remove('selected');
                } else {
                    this.dataset.count = '2';
                }
            } else if (currentCount === 2) {
                this.dataset.count = '0';
                this.classList.remove('selected');
            }
            
            // Update total price after any change
            updateTotalPrice();
            
            updateProteinQuantityIndicators();
            updateSummary();
        });
    });

    // SALSAS LOGIC (6 selecciones)
    const sauceCards = document.querySelectorAll('.sauce-option');
    sauceCards.forEach(card => {
        card.addEventListener('click', function() {
            const currentCount = parseInt(this.dataset.count);
            const totalSelected = getTotalSauceSelections();
            
            if (currentCount === 0) {
                if (totalSelected >= 6) {
                    showLimitMessage('Solo puedes seleccionar máximo 6 salsas');
                    return;
                }
                this.dataset.count = '1';
                this.classList.add('selected');
            } else if (currentCount === 1) {
                if (totalSelected >= 6) {
                    this.dataset.count = '0';
                    this.classList.remove('selected');
                } else {
                    this.dataset.count = '2';
                }
            } else if (currentCount === 2) {
                if (totalSelected >= 6) {
                    this.dataset.count = '0';
                    this.classList.remove('selected');
                } else {
                    this.dataset.count = '3';
                }
            } else if (currentCount === 3) {
                if (totalSelected >= 6) {
                    this.dataset.count = '0';
                    this.classList.remove('selected');
                } else {
                    this.dataset.count = '4';
                }
            } else if (currentCount === 4) {
                if (totalSelected >= 6) {
                    this.dataset.count = '0';
                    this.classList.remove('selected');
                } else {
                    this.dataset.count = '5';
                }
            } else if (currentCount === 5) {
                if (totalSelected >= 6) {
                    this.dataset.count = '0';
                    this.classList.remove('selected');
                } else {
                    this.dataset.count = '6';
                }
            } else if (currentCount === 6) {
                this.dataset.count = '0';
                this.classList.remove('selected');
            }
            
            // Update total price after any change
            updateTotalPrice();
            
            updateSauceQuantityIndicators();
            updateSummary();
        });
    });
    
    // Handle option selection for other categories (totopos, tortillas)
    const otherOptionCards = document.querySelectorAll('.totopo-option, .tortilla-option');
    otherOptionCards.forEach(card => {
        card.addEventListener('click', function() {
            const type = this.dataset.type;
            
            // Para otras categorías: selección única
            const sameTypeCards = document.querySelectorAll(`.${type}-option`);
            sameTypeCards.forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            
            updateSummary();
        });
    });

    // FUNCTIONS
    function getTotalProteinSelections() {
        let total = 0;
        document.querySelectorAll('.protein-option').forEach(card => {
            total += parseInt(card.dataset.count);
        });
        return total;
    }

    function getTotalSauceSelections() {
        let total = 0;
        document.querySelectorAll('.sauce-option').forEach(card => {
            total += parseInt(card.dataset.count);
        });
        return total;
    }

    function updateProteinQuantityIndicators() {
        document.querySelectorAll('.protein-option').forEach(card => {
            const count = parseInt(card.dataset.count);
            const indicator = card.querySelector('.quantity-indicator');
            
            if (count >= 2) {
                indicator.textContent = `x${count}`;
                indicator.style.display = 'block';
            } else {
                indicator.style.display = 'none';
            }
        });
    }

    function updateSauceQuantityIndicators() {
        document.querySelectorAll('.sauce-option').forEach(card => {
            const count = parseInt(card.dataset.count);
            const indicator = card.querySelector('.quantity-indicator');
            
            if (count >= 2) {
                indicator.textContent = `x${count}`;
                indicator.style.display = 'block';
            } else {
                indicator.style.display = 'none';
            }
        });
    }
    
    // Update summary display
    function updateSummary() {
        const selectedTotopos = document.querySelector('.totopo-option.selected');
        const selectedTortillas = document.querySelector('.tortilla-option.selected');
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
    
    // Handle add to cart button
    document.getElementById('add-to-cart-btn').addEventListener('click', function() {
        const selectedTotopos = document.querySelector('.totopo-option.selected');
        const selectedTortillas = document.querySelector('.tortilla-option.selected');
        const totalProteinSelections = getTotalProteinSelections();
        const totalSauceSelections = getTotalSauceSelections();
        
        // Validación específica y detallada
        let validationErrors = [];
        
        // Validar Totopos (1 selección requerida si hay opciones disponibles)
        const totoposAvailable = document.querySelectorAll('.totopo-option').length > 0;
        if (totoposAvailable && !selectedTotopos) {
            validationErrors.push('• Selecciona 1 tipo de totopos');
        }
        
        // Validar Tortillas (1 selección requerida si hay opciones disponibles)
        const tortillasAvailable = document.querySelectorAll('.tortilla-option').length > 0;
        if (tortillasAvailable && !selectedTortillas) {
            validationErrors.push('• Selecciona 1 tipo de tortillas');
        }
        
        // Validar Proteínas (exactamente 2 selecciones requeridas si hay opciones disponibles)
        const proteinsAvailable = document.querySelectorAll('.protein-option').length > 0;
        if (proteinsAvailable) {
            if (totalProteinSelections === 0) {
                validationErrors.push('• Selecciona 2 proteínas (cada una de 250gr)');
            } else if (totalProteinSelections !== 2) {
                validationErrors.push(`• Selecciona exactamente 2 proteínas (actualmente tienes ${totalProteinSelections})`);
            }
        }
        
        // Validar Salsas (exactamente 6 selecciones requeridas si hay opciones disponibles)
        const saucesAvailable = document.querySelectorAll('.sauce-option').length > 0;
        if (saucesAvailable) {
            if (totalSauceSelections === 0) {
                validationErrors.push('• Selecciona 6 salsas de 250gr cada una');
            } else if (totalSauceSelections !== 6) {
                validationErrors.push(`• Selecciona exactamente 6 salsas (actualmente tienes ${totalSauceSelections})`);
            }
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
        
        console.log('DEBUG: Precio calculado - Base:', BASE_PRICE, 'Adiciones:', additionalCount, 'Precio adición:', ADDITION_PRICE, 'Total:', totalPrice);
        
        // Recopilar todas las selecciones
        const comboData = {
            totopos: selectedTotopos.dataset.value,
            tortillas: selectedTortillas.dataset.value,
            proteins: [],
            sauces: [],
            total_price: totalPrice
        };
        
        console.log('DEBUG: comboData a enviar:', comboData);
        
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

    // Handle form submission (mantener para compatibilidad)
    document.getElementById('combo-builder-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const selectedTotopos = document.querySelector('.totopo-option.selected');
        const selectedTortillas = document.querySelector('.tortilla-option.selected');
        const totalProteinSelections = getTotalProteinSelections();
        const totalSauceSelections = getTotalSauceSelections();
        
        if (!selectedTotopos || !selectedTortillas || totalProteinSelections === 0 || totalSauceSelections === 0) {
            alert('Por favor selecciona todas las opciones requeridas para tu combo.');
            return;
        }
        
        if (totalProteinSelections !== 2) {
            alert('Por favor selecciona exactamente 2 proteínas para tu combo.');
            return;
        }
        
        if (totalSauceSelections !== 6) {
            alert('Por favor selecciona exactamente 6 salsas para tu combo.');
            return;
        }
        
        // Here you would typically add the combo to cart
        // For now, just show a success message
        alert('¡Combo agregado al carrito exitosamente!');
    });
    
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
            
            // Prepare data for WooCommerce with proper serialization
            const formData = new FormData();
            formData.append('action', 'add_combo_to_cart');
            formData.append('combo_id', comboIdInput.value);
            formData.append('nonce', '<?php echo wp_create_nonce("add_combo_to_cart"); ?>');
            
            // Add combo data fields individually
            formData.append('combo_data[totopos]', comboData.totopos || '');
            formData.append('combo_data[tortillas]', comboData.tortillas || '');
            formData.append('combo_data[total_price]', comboData.total_price || '');
            
            // Add proteins array
            if (comboData.proteins && comboData.proteins.length > 0) {
                comboData.proteins.forEach((protein, index) => {
                    formData.append(`combo_data[proteins][${index}]`, protein);
                });
            }
            
            // Add sauces array
            if (comboData.sauces && comboData.sauces.length > 0) {
                comboData.sauces.forEach((sauce, index) => {
                    formData.append(`combo_data[sauces][${index}]`, sauce);
                });
            }
            
            console.log('Datos a enviar:', {
                action: 'add_combo_to_cart',
                combo_id: comboIdInput.value,
                combo_data: comboData,
                nonce: '<?php echo wp_create_nonce("add_combo_to_cart"); ?>'
            });
            
            // Send AJAX request to add to cart
            fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                method: 'POST',
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
                
                // Display debug information
                if (data.success && data.data && data.data.debug) {
                    console.log('=== DEBUG SERVER RESPONSE ===');
                    console.log('Combo ID:', data.data.debug.combo_id);
                    console.log('Combo Total Price Received:', data.data.debug.combo_total_price_received);
                    console.log('Product Price After Set:', data.data.debug.product_price_after_set);
                    console.log('Cart Total:', data.data.debug.cart_total);
                    console.log('Cart Contents Count:', data.data.debug.cart_contents_count);
                    console.log('=== END DEBUG ===');
                }
                
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
            totopos: selectedTotopos ? selectedTotopos.dataset.value : null,
            tortillas: selectedTortillas ? selectedTortillas.dataset.value : null,
            proteins: [],
            sauces: [],
            total_price: totalPrice
        };
        
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
