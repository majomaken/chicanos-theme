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
                                <img src="<?php echo get_template_directory_uri(); ?>/img/size-small.svg" alt="250 Gramos" class="portion-svg">
                                <span class="portion-label">250 Gramos</span>
                            </div>
                            <div class="portion-size-item">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/size-medium.svg" alt="500 Gramos" class="portion-svg">
                                <span class="portion-label">500 Gramos</span>
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
                // Obtener el producto de adiciones de manera dinámica
                $adiciones_product_id = find_adiciones_product();
                
                if ($adiciones_product_id) {
                    echo '<!-- DEBUG: Producto de adiciones encontrado con ID: ' . $adiciones_product_id . ' -->';
                } else {
                    echo '<!-- DEBUG: ERROR: No se pudo encontrar el producto de adiciones -->';
                }
                
                if ($adiciones_product_id) {
                    $product = wc_get_product($adiciones_product_id);
                    if ($product) {
                        echo '<!-- DEBUG: Producto cargado: ' . $product->get_name() . ' -->';
                        echo '<!-- DEBUG: ID del producto de adiciones: ' . $adiciones_product_id . ' -->';
                        echo '<!-- DEBUG: Tipo de producto: ' . $product->get_type() . ' -->';
                        
                        // Verificar tablas de YITH con los nombres correctos
                        global $wpdb;
                        $blocks_table = $wpdb->prefix . 'yith_wapo_blocks';
                        $addons_table = $wpdb->prefix . 'yith_wapo_addons';
                        $blocks_assoc_table = $wpdb->prefix . 'yith_wapo_blocks_assoc';
                        
                        // Verificar si las tablas existen
                        $blocks_exists = $wpdb->get_var("SHOW TABLES LIKE '$blocks_table'");
                        $addons_exists = $wpdb->get_var("SHOW TABLES LIKE '$addons_table'");
                        $blocks_assoc_exists = $wpdb->get_var("SHOW TABLES LIKE '$blocks_assoc_table'");
                        
                        echo '<!-- DEBUG: Prefijo actual: ' . $wpdb->prefix . ' -->';
                        echo '<!-- DEBUG: Tabla blocks existe: ' . ($blocks_exists ? 'SÍ' : 'NO') . ' -->';
                        echo '<!-- DEBUG: Tabla addons existe: ' . ($addons_exists ? 'SÍ' : 'NO') . ' -->';
                        echo '<!-- DEBUG: Tabla blocks_assoc existe: ' . ($blocks_assoc_exists ? 'SÍ' : 'NO') . ' -->';
                        
                        // Debug: Verificar estado de YITH
                        echo '<!-- DEBUG: Verificando YITH... -->';
                        echo '<!-- DEBUG: Producto ID: ' . $adiciones_product_id . ' -->';
                        echo '<!-- DEBUG: YITH activo: ' . (function_exists('yith_wapo_get_addon_groups') ? 'SÍ' : 'NO') . ' -->';
                        echo '<!-- DEBUG: Clase YITH_WAPO_Group: ' . (class_exists('YITH_WAPO_Group') ? 'SÍ' : 'NO') . ' -->';
                        
                        // Verificar si YITH está instalado como plugin
                        $yith_plugin_path = 'yith-woocommerce-product-add-ons/init.php';
                        $yith_active = is_plugin_active($yith_plugin_path);
                        echo '<!-- DEBUG: Plugin YITH activo: ' . ($yith_active ? 'SÍ' : 'NO') . ' -->';
                        
                        // Verificar tablas de YITH en la base de datos
                        global $wpdb;
                        $groups_table = $wpdb->prefix . 'yith_wapo_groups';
                        $options_table = $wpdb->prefix . 'yith_wapo_options';
                        
                        echo '<!-- DEBUG: Tabla grupos existe: ' . ($wpdb->get_var("SHOW TABLES LIKE '$groups_table'") ? 'SÍ' : 'NO') . ' -->';
                        echo '<!-- DEBUG: Tabla opciones existe: ' . ($wpdb->get_var("SHOW TABLES LIKE '$options_table'") ? 'SÍ' : 'NO') . ' -->';
                        
                        // Intentar crear las tablas si YITH está activo pero las tablas no existen
                        if ($yith_active && !$wpdb->get_var("SHOW TABLES LIKE '$groups_table'")) {
                            echo '<!-- DEBUG: Intentando crear tablas de YITH... -->';
                            
                            // Incluir el archivo de instalación de YITH
                            if (file_exists(WP_PLUGIN_DIR . '/yith-woocommerce-product-add-ons/includes/class.yith-wapo-install.php')) {
                                require_once WP_PLUGIN_DIR . '/yith-woocommerce-product-add-ons/includes/class.yith-wapo-install.php';
                                
                                if (class_exists('YITH_WAPO_Install')) {
                                    YITH_WAPO_Install::create_tables();
                                    echo '<!-- DEBUG: Tablas de YITH creadas -->';
                                }
                            }
                        }
                        
                        // Verificar grupos en la base de datos
                        if ($wpdb->get_var("SHOW TABLES LIKE '$groups_table'")) {
                            $all_groups = $wpdb->get_results("SELECT * FROM $groups_table LIMIT 10");
                            echo '<!-- DEBUG: Grupos en BD: ' . print_r($all_groups, true) . ' -->';
                        } else {
                            echo '<!-- DEBUG: No se puede consultar grupos - tabla no existe -->';
                        }
                        
                        // Debug completo con función simple
                        $yith_debug = debug_yith_status($adiciones_product_id);
                        echo '<!-- DEBUG: YITH Status completo: ' . print_r($yith_debug, true) . ' -->';
                        
                        // Diagnóstico completo para producción
                        $production_diagnostic = yith_production_diagnostic($adiciones_product_id);
                        echo '<!-- DEBUG: Diagnóstico de producción: ' . print_r($production_diagnostic, true) . ' -->';
                        
                        // Debug adicional: verificar si el producto tiene addons asignados
                        if (function_exists('yith_wapo_get_addon_groups')) {
                            $yith_groups = yith_wapo_get_addon_groups($adiciones_product_id);
                            echo '<!-- DEBUG: Grupos YITH encontrados: ' . count($yith_groups) . ' -->';
                            echo '<!-- DEBUG: Grupos YITH datos: ' . print_r($yith_groups, true) . ' -->';
                        }
                        
                        // Intentar obtener opciones de YITH usando función directa de BD
                        $yith_addons = get_yith_addons_direct_db($adiciones_product_id, $blocks_table, $addons_table, $blocks_assoc_table);
                        echo '<!-- DEBUG: YITH addons obtenidos (BD directa): ' . print_r($yith_addons, true) . ' -->';
                        
                        // Debug adicional: verificar datos en las tablas
                        if ($blocks_exists && $addons_exists) {
                            $all_blocks = $wpdb->get_results("SELECT * FROM $blocks_table LIMIT 5");
                            echo '<!-- DEBUG: Todos los bloques en BD: ' . print_r($all_blocks, true) . ' -->';
                            
                            $all_addons = $wpdb->get_results("SELECT * FROM $addons_table LIMIT 5");
                            echo '<!-- DEBUG: Todos los addons en BD: ' . print_r($all_addons, true) . ' -->';
                            
                            // Buscar bloques que estén asignados al producto específico
                            $product_blocks = $wpdb->get_results($wpdb->prepare("
                                SELECT * FROM $blocks_table 
                                WHERE settings LIKE %s
                            ", '%' . $adiciones_product_id . '%'));
                            echo '<!-- DEBUG: Bloques asignados al producto ' . $adiciones_product_id . ': ' . print_r($product_blocks, true) . ' -->';
                        }
                        
                        // Si no hay opciones, intentar con la función original
                        if (empty($yith_addons)) {
                            $yith_addons = get_yith_product_addons($adiciones_product_id);
                            echo '<!-- DEBUG: YITH addons obtenidos (función original): ' . print_r($yith_addons, true) . ' -->';
                        }
                        
                        // Procesar los bloques de YITH directamente
                        $categorized_options = process_yith_blocks_direct($product_blocks, $wpdb);
                        echo '<!-- DEBUG: Opciones categorizadas: ' . print_r($categorized_options, true) . ' -->';
                        
                        // Debug adicional para ver qué bloques se están procesando
                        echo '<!-- DEBUG: Bloques procesados: ' . count($product_blocks) . ' -->';
                        foreach ($product_blocks as $block) {
                            echo '<!-- DEBUG: Bloque: ' . $block->name . ' (ID: ' . $block->id . ') -->';
                        }
                        
                        // Extraer opciones categorizadas
                        $totopos_options = $categorized_options['totopos']['options'];
                        $tortillas_options = $categorized_options['tortillas']['options'];
                        $protein_options = $categorized_options['protein']['options'];
                        $sauce_options = $categorized_options['sauce']['options'];
                        
                        // Extraer títulos
                        $totopos_field_title = $categorized_options['totopos']['title'];
                        $tortillas_field_title = $categorized_options['tortillas']['title'];
                        $protein_field_title = $categorized_options['protein']['title'];
                        $sauce_field_title = $categorized_options['sauce']['title'];
                        
                        // Debug de opciones extraídas
                        echo '<!-- DEBUG: Totopos options: ' . count($totopos_options) . ' -->';
                        echo '<!-- DEBUG: Tortillas options: ' . count($tortillas_options) . ' -->';
                        echo '<!-- DEBUG: Protein options: ' . count($protein_options) . ' -->';
                        echo '<!-- DEBUG: Sauce options: ' . count($sauce_options) . ' -->';
                        echo '<!-- DEBUG: Protein title: ' . $protein_field_title . ' -->';
                        echo '<!-- DEBUG: Sauce title: ' . $sauce_field_title . ' -->';
                        
                        // Si no hay opciones de YITH, intentar con WAPF como fallback
                        if (empty($totopos_options) && empty($tortillas_options) && empty($protein_options) && empty($sauce_options)) {
                            echo '<!-- DEBUG: YITH no disponible, intentando con WAPF -->';
                            
                            $wapf_data = get_post_meta($adiciones_product_id, '_wapf_fieldgroup', true);
                        
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
                                    
                                        // Asignar a la categoría correcta según el ID del campo
                                    switch ($field['id']) {
                                        case '68a5f5555b827': // Totopos
                                            $totopos_options = $labels;
                                            $totopos_field_title = $field['label'];
                                            echo '<!-- DEBUG: Campo Totopos encontrado: ' . $field['label'] . ' -->';
                                            break;
                                            
                                        case '68a510162a582': // Tortillas
                                            $tortillas_options = $labels;
                                            $tortillas_field_title = $field['label'];
                                            echo '<!-- DEBUG: Campo Tortillas encontrado: ' . $field['label'] . ' -->';
                                            break;
                                            
                                        case '68a50e0cee780': // Proteína
                                            $protein_options = $labels;
                                            $protein_field_title = $field['label'];
                                            echo '<!-- DEBUG: Campo Proteína encontrado: ' . $field['label'] . ' -->';
                                            break;
                                            
                                        case '68a50e6ba4b20': // Salsas y Más
                                            $sauce_options = $labels;
                                            $sauce_field_title = $field['label'];
                                            echo '<!-- DEBUG: Campo Salsas encontrado: ' . $field['label'] . ' -->';
                                            break;
                                    }
                                }
                            }
                        } else {
                                echo '<!-- DEBUG: No se encontró WAPF data ni YITH -->';
                            echo '<!-- DEBUG: Producto ID: ' . $adiciones_product_id . ' -->';
                            }
                        }
                        
                        // Si no hay custom fields, mostrar mensaje de error
                        if (empty($totopos_options) && empty($tortillas_options) && empty($protein_options) && empty($sauce_options)) {
                            echo '<div class="alert alert-warning">';
                            echo '<p><strong>Error:</strong> No se encontraron opciones de adiciones en este producto.</p>';
                            echo '<p>Por favor, asegúrate de que:</p>';
                            echo '<ul>';
                            echo '<li>El plugin YITH WooCommerce Product Add-ons esté instalado y activado</li>';
                            echo '<li>El producto tenga configurados los grupos de opciones en YITH → Product Add-ons</li>';
                            echo '<li>Los grupos estén asignados al producto "Adiciones"</li>';
                            echo '<li>Los grupos tengan nombres que contengan: Totopos, Tortillas, Proteínas, o Salsas</li>';
                            echo '</ul>';
                            echo '<p><strong>Configuración recomendada:</strong></p>';
                            echo '<ul>';
                            echo '<li>Crear grupo "Totopos" con opciones de tamaño</li>';
                            echo '<li>Crear grupo "Tortillas" con opciones de tamaño</li>';
                            echo '<li>Crear grupo "Proteínas" con opciones de tamaño</li>';
                            echo '<li>Crear grupo "Salsas" con opciones de tamaño</li>';
                            echo '</ul>';
                            echo '</div>';
                        }
                        
                        // Product Info -->
                        ?>
                        <div class="product-info-section mb-4">
                            <!-- <div class="product-price">
                                <?php echo $product->get_price_html(); ?>
                            </div> -->
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
                                <?php foreach ($totopos_options as $totopo) : 
                                    // Manejar tanto arrays como strings para compatibilidad
                                    if (is_array($totopo)) {
                                        $totopo_label = $totopo['label'];
                                        $totopo_value = strtolower($totopo['label']);
                                        $totopo_base_price = $totopo['base_price'] ?? 0;
                                        
                                        // Mostrar rango de precios si hay múltiples tamaños
                                        if (isset($totopo['sizes']) && is_array($totopo['sizes'])) {
                                            $min_price = min(array_column($totopo['sizes'], 'price'));
                                            $max_price = max(array_column($totopo['sizes'], 'price'));
                                            if ($min_price == $max_price) {
                                                $price_text = '$' . number_format($min_price, 0);
                                            } else {
                                                $price_text = '$' . number_format($min_price, 0) . ' - $' . number_format($max_price, 0);
                                            }
                                        } else {
                                            $price_text = $totopo['price_text'] ?? '';
                                        }
                                    } else {
                                        $totopo_label = $totopo;
                                        $totopo_value = strtolower($totopo);
                                        $totopo_base_price = 0;
                                        $price_text = '';
                                    }
                                ?>
                                    <div class="combo-option-card" data-option="totopos" data-value="<?php echo esc_attr($totopo_value); ?>" data-quantity="0" data-price="<?php echo esc_attr($totopo_base_price); ?>" data-sizes="<?php echo esc_attr(json_encode($totopo['sizes'] ?? [])); ?>">
                                         <div class="option-content">
                                             <h5 class="option-title"><?php echo esc_html($totopo_label); ?></h5>
                                             <?php if ($price_text) : ?>
                                                 <div class="option-price"><?php echo esc_html($price_text); ?></div>
                                             <?php endif; ?>
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
                                <?php foreach ($tortillas_options as $tortilla) : 
                                    // Manejar tanto arrays como strings para compatibilidad
                                    if (is_array($tortilla)) {
                                        $tortilla_label = $tortilla['label'];
                                        $tortilla_value = strtolower($tortilla['label']);
                                        $tortilla_base_price = $tortilla['base_price'] ?? 0;
                                        
                                        // Mostrar rango de precios si hay múltiples tamaños
                                        if (isset($tortilla['sizes']) && is_array($tortilla['sizes'])) {
                                            $min_price = min(array_column($tortilla['sizes'], 'price'));
                                            $max_price = max(array_column($tortilla['sizes'], 'price'));
                                            if ($min_price == $max_price) {
                                                $price_text = '$' . number_format($min_price, 0);
                                            } else {
                                                $price_text = '$' . number_format($min_price, 0) . ' - $' . number_format($max_price, 0);
                                            }
                                        } else {
                                            $price_text = $tortilla['price_text'] ?? '';
                                        }
                                    } else {
                                        $tortilla_label = $tortilla;
                                        $tortilla_value = strtolower($tortilla);
                                        $tortilla_base_price = 0;
                                        $price_text = '';
                                    }
                                ?>
                                    <div class="combo-option-card" data-option="tortillas" data-value="<?php echo esc_attr($tortilla_value); ?>" data-quantity="0" data-price="<?php echo esc_attr($tortilla_base_price); ?>" data-sizes="<?php echo esc_attr(json_encode($tortilla['sizes'] ?? [])); ?>">
                                         <div class="option-content">
                                             <h5 class="option-title"><?php echo esc_html($tortilla_label); ?></h5>
                                             <?php if ($price_text) : ?>
                                                 <div class="option-price"><?php echo esc_html($price_text); ?></div>
                                             <?php endif; ?>
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
                                <?php foreach ($protein_options as $protein) : 
                                    // Manejar tanto arrays como strings para compatibilidad
                                    if (is_array($protein)) {
                                        $protein_label = $protein['label'];
                                        $protein_value = strtolower($protein['label']);
                                        $protein_base_price = $protein['base_price'] ?? 0;
                                        
                                        // Mostrar rango de precios si hay múltiples tamaños
                                        if (isset($protein['sizes']) && is_array($protein['sizes'])) {
                                            $min_price = min(array_column($protein['sizes'], 'price'));
                                            $max_price = max(array_column($protein['sizes'], 'price'));
                                            if ($min_price == $max_price) {
                                                $price_text = '$' . number_format($min_price, 0);
                                            } else {
                                                $price_text = '$' . number_format($min_price, 0) . ' - $' . number_format($max_price, 0);
                                            }
                                        } else {
                                            $price_text = $protein['price_text'] ?? '';
                                        }
                                    } else {
                                        $protein_label = $protein;
                                        $protein_value = strtolower($protein);
                                        $protein_base_price = 0;
                                        $price_text = '';
                                    }
                                ?>
                                    <div class="combo-option-card" data-option="protein" data-value="<?php echo esc_attr($protein_value); ?>" data-quantity="0" data-price="<?php echo esc_attr($protein_base_price); ?>" data-sizes="<?php echo esc_attr(json_encode($protein['sizes'] ?? [])); ?>">
                                         <div class="option-content">
                                             <h5 class="option-title"><?php echo esc_html($protein_label); ?></h5>
                                             <?php if ($price_text) : ?>
                                                 <div class="option-price"><?php echo esc_html($price_text); ?></div>
                                             <?php endif; ?>
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
                                <?php foreach ($sauce_options as $sauce) : 
                                    // Manejar tanto arrays como strings para compatibilidad
                                    if (is_array($sauce)) {
                                        $sauce_label = $sauce['label'];
                                        $sauce_value = strtolower($sauce['label']);
                                        $sauce_base_price = $sauce['base_price'] ?? 0;
                                        
                                        // Mostrar rango de precios si hay múltiples tamaños
                                        if (isset($sauce['sizes']) && is_array($sauce['sizes'])) {
                                            $min_price = min(array_column($sauce['sizes'], 'price'));
                                            $max_price = max(array_column($sauce['sizes'], 'price'));
                                            if ($min_price == $max_price) {
                                                $price_text = '$' . number_format($min_price, 0);
                                            } else {
                                                $price_text = '$' . number_format($min_price, 0) . ' - $' . number_format($max_price, 0);
                                            }
                                        } else {
                                            $price_text = $sauce['price_text'] ?? '';
                                        }
                                    } else {
                                        $sauce_label = $sauce;
                                        $sauce_value = strtolower($sauce);
                                        $sauce_base_price = 0;
                                        $price_text = '';
                                    }
                                ?>
                                    <div class="combo-option-card" data-option="sauce" data-value="<?php echo esc_attr($sauce_value); ?>" data-quantity="0" data-price="<?php echo esc_attr($sauce_base_price); ?>" data-sizes="<?php echo esc_attr(json_encode($sauce['sizes'] ?? [])); ?>">
                                         <div class="option-content">
                                             <h5 class="option-title"><?php echo esc_html($sauce_label); ?></h5>
                                             <?php if ($price_text) : ?>
                                                 <div class="option-price"><?php echo esc_html($price_text); ?></div>
                                             <?php endif; ?>
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
                        <button type="button" id="go-to-cart-btn" class="btn btn-primary btn-lg add-to-cart-button">
                            <i class="fas fa-shopping-cart"></i>
                            Ir al Carrito
                        </button>
                        <p class="add-to-cart-description mt-3">
                            Ve al carrito para revisar tus adiciones seleccionadas.
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
            <div class="size-options" id="dynamic-size-options">
                <!-- Las opciones se generarán dinámicamente aquí -->
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
    $('.combo-option-card').click(function(e) {
        e.preventDefault();
        console.log('Click detectado en:', $(this).find('.option-title').text());
        
        const optionType = $(this).data('option');
        const optionValue = $(this).data('value');
        const optionTitle = $(this).find('.option-title').text();
        const currentQuantity = parseInt($(this).data('quantity')) || 0;
        const optionPrice = parseFloat($(this).data('price')) || 0;
        
        // Obtener datos de tamaños si están disponibles
        const sizesData = $(this).data('sizes');
        
        // Debug: mostrar datos de tamaños
        console.log('Datos de tamaños:', sizesData);
        console.log('Datos de la opción:', {
            type: optionType,
            value: optionValue,
            title: optionTitle,
            price: optionPrice,
            sizes: sizesData
        });
        
        // Guardar datos de la opción seleccionada
        currentSelectedOption = $(this);
        currentOptionData = {
            type: optionType,
            value: optionValue,
            title: optionTitle,
            currentQuantity: currentQuantity,
            price: optionPrice,
            sizes: sizesData
        };
        
        // Verificar si tiene múltiples tamaños o es una opción individual
        if (sizesData && sizesData.length > 1) {
            // Tiene múltiples tamaños, mostrar modal
            showSizeSelectionModal(optionTitle, currentQuantity, optionPrice);
        } else if (sizesData && sizesData.length === 1) {
            // Tiene un solo tamaño, verificar si es realmente un tamaño o una opción individual
            const singleSize = sizesData[0];
            const sizeLabel = singleSize.size || '';
            
            // Si el tamaño contiene números o palabras de tamaño, es un producto con un solo tamaño
            const isSize = /\d+/.test(sizeLabel) || 
                          /^(chico|mediano|grande|pequeño|pequeña|large|medium|small|cm|inch|pulgadas)/i.test(sizeLabel);
            
            if (isSize) {
                // Es un producto con un solo tamaño, mostrar modal
                showSizeSelectionModal(optionTitle, currentQuantity, optionPrice);
            } else {
                // Es una opción individual sin tamaños, agregar directamente al carrito
                addToCartWithSize(currentOptionData, 'single');
            }
        } else {
            // No tiene datos de tamaños, agregar directamente al carrito
            addToCartWithSize(currentOptionData, 'single');
        }
    });
    
    // Función para mostrar el pop-up de selección de tamaño
    function showSizeSelectionModal(itemTitle, currentQuantity, basePrice = 0) {
        $('#size-modal-title').text(itemTitle);
        
        // Mostrar información de cantidad actual si es > 0
        if (currentQuantity > 0) {
            $('#current-quantity-info').show();
            $('#current-quantity-number').text(currentQuantity);
        } else {
            $('#current-quantity-info').hide();
        }
        
        // Generar opciones dinámicamente
        generateDynamicSizeOptions();
        
        $('#size-selection-modal').fadeIn(300);
    }
    
    // Función para generar opciones de tamaño dinámicamente
    function generateDynamicSizeOptions() {
        const container = $('#dynamic-size-options');
        container.empty();
        
        if (currentOptionData && currentOptionData.sizes && currentOptionData.sizes.length > 0) {
            console.log('Generando opciones dinámicas para:', currentOptionData.sizes);
            
            currentOptionData.sizes.forEach((sizeData, index) => {
                const size = sizeData.size;
                const price = sizeData.price;
                const enabled = sizeData.enabled === 'yes';
                const formattedPrice = '$' + Math.round(price).toLocaleString();
                
                // Debug: mostrar datos de cada tamaño
                console.log(`Tamaño ${index}:`, {
                    size: size,
                    price: price,
                    enabled: enabled,
                    enabledRaw: sizeData.enabled
                });
                
                // Crear el elemento de opción
                // Temporalmente permitir todas las opciones independientemente del estado enabled
                const optionHtml = `
                    <label class="size-option">
                        <input type="radio" name="size-selection" value="${size}" class="size-radio" ${index === 0 ? 'checked' : ''}>
                        <span class="size-label">${size} (${formattedPrice})</span>
                    </label>
                `;
                
                container.append(optionHtml);
            });
        } else {
            // Fallback si no hay datos de tamaños
            const fallbackOptions = [
                { value: 'small', label: 'Small', price: basePrice * 0.5 },
                { value: 'medium', label: 'Medium', price: basePrice * 1.0 },
                { value: 'large', label: 'Large', price: basePrice * 2.0 }
            ];
            
            fallbackOptions.forEach((option, index) => {
                const formattedPrice = '$' + Math.round(option.price).toLocaleString();
                const optionHtml = `
                    <label class="size-option">
                        <input type="radio" name="size-selection" value="${option.value}" class="size-radio" ${index === 2 ? 'checked' : ''}>
                        <span class="size-label">${option.label} (${formattedPrice})</span>
                    </label>
                `;
                container.append(optionHtml);
            });
        }
    }
    
    // Función para actualizar precios en el modal
    function updateModalPrices(basePrice) {
        console.log('updateModalPrices llamado con basePrice:', basePrice);
        console.log('currentOptionData:', currentOptionData);
        
        // Usar los precios reales de YITH si están disponibles
        if (currentOptionData && currentOptionData.sizes && currentOptionData.sizes.length > 0) {
            console.log('Usando precios de YITH:', currentOptionData.sizes);
            
            const sizeMapping = {
                'small': 'Chico',
                'medium': 'Mediano', 
                'large': 'Grande'
            };
            
            // Mapeo adicional para tamaños específicos como tortillas
            const specificSizeMapping = {
                '12 cm': '12 cm',
                '17': '17',
                '17 cm': '17 cm'
            };
            
            $('input[name="size-selection"]').each(function() {
                const size = $(this).val();
                let sizeLabel = sizeMapping[size];
                
                // Si no encontramos en el mapeo estándar, buscar en el específico
                if (!sizeLabel) {
                    sizeLabel = specificSizeMapping[size];
                }
                
                // Buscar el precio correspondiente al tamaño
                let sizeData = currentOptionData.sizes.find(s => s.size === sizeLabel);
                
                // Si no encontramos con el mapeo, buscar directamente por el valor del input
                if (!sizeData) {
                    sizeData = currentOptionData.sizes.find(s => s.size === size);
                }
                
                const price = sizeData ? sizeData.price : basePrice;
                const formattedPrice = '$' + Math.round(price).toLocaleString();
                
                console.log(`Tamaño ${size} (${sizeLabel}):`, sizeData, 'Precio:', price);
                
                // Mostrar el precio o "No disponible" si no existe
                const displayText = sizeData ? 
                    size.charAt(0).toUpperCase() + size.slice(1) + ' (' + formattedPrice + ')' :
                    size.charAt(0).toUpperCase() + size.slice(1) + ' (No disponible)';
                
                $(this).next('.size-label').text(displayText);
            });
        } else {
            // Fallback a multiplicadores si no hay datos de YITH
            const sizeMultipliers = {
                'small': 0.5,
                'medium': 1.0,
                'large': 2.0
            };
            
            $('input[name="size-selection"]').each(function() {
                const size = $(this).val();
                const multiplier = sizeMultipliers[size];
                const price = basePrice * multiplier;
                const formattedPrice = '$' + Math.round(price).toLocaleString();
                
                $(this).next('.size-label').text(
                    size.charAt(0).toUpperCase() + size.slice(1) + ' (' + formattedPrice + ')'
                );
            });
        }
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
            'small': 'Chico',
            'medium': 'Mediano', 
            'large': 'Grande',
            'single': 'Único'
        };
        
        // Si el tamaño no está en el mapeo estándar, usar el valor directamente
        const sizeLabel = sizeLabels[size] || size;
        
        // Verificar que tenemos los datos de AJAX
        if (!window.adiciones_ajax_data) {
            console.error('Datos de AJAX no disponibles');
            alert('Error: Configuración de AJAX no disponible');
            return;
        }
        
        // Calcular el precio basado en el tamaño seleccionado
        let finalPrice = optionData.price || 0;
        
        console.log('=== DEBUGGING AJAX ===');
        console.log('optionData:', optionData);
        console.log('size:', size);
        console.log('finalPrice inicial:', finalPrice);
        console.log('adiciones_ajax_data:', window.adiciones_ajax_data);
        
        if (size === 'single') {
            // Es una opción individual sin tamaños, usar el precio base
            finalPrice = optionData.price || 0;
            console.log(`Precio para opción individual: $${finalPrice}`);
        } else if (optionData.sizes && optionData.sizes.length > 0) {
            // Es una opción con múltiples tamaños - buscar por el valor exacto del tamaño
            const sizeData = optionData.sizes.find(s => s.size === size);
            if (sizeData) {
                finalPrice = sizeData.price;
                console.log(`Precio calculado para ${size}: $${finalPrice}`);
            } else {
                // Fallback: buscar por mapeo estándar
                const mappedSize = sizeLabels[size];
                const mappedSizeData = optionData.sizes.find(s => s.size === mappedSize);
                if (mappedSizeData) {
                    finalPrice = mappedSizeData.price;
                    console.log(`Precio calculado para ${mappedSize}: $${finalPrice}`);
                }
            }
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
            adiciones_size: size, // Cambiado de 'size' a 'adiciones_size'
            price: finalPrice
        };
        
        console.log('=== ENVIANDO DATOS AJAX ===');
        console.log('Datos completos:', ajaxData);
        console.log('URL:', window.adiciones_ajax_data.ajax_url);
        console.log('Nonce:', window.adiciones_ajax_data.nonce);
        console.log('Product ID:', window.adiciones_ajax_data.product_id);
        
        // Realizar llamada AJAX a WooCommerce
        $.ajax({
            url: window.adiciones_ajax_data.ajax_url,
            type: 'POST',
            data: ajaxData,
            dataType: 'json',
            success: function(response) {
                console.log('Respuesta AJAX recibida:', response);
                
                if (response.success) {
                    // Verificar si ya existe el mismo producto en el carrito local
                    const existingItemIndex = cartItems.findIndex(item => 
                        item.type === optionData.type && 
                        item.value === optionData.value && 
                        item.size === size
                    );
                    
                    if (existingItemIndex !== -1) {
                        // Si ya existe, incrementar la cantidad
                        cartItems[existingItemIndex].quantity = (cartItems[existingItemIndex].quantity || 1) + 1;
                        cartItems[existingItemIndex].timestamp = Date.now();
                        cartItems[existingItemIndex].cart_item_key = response.data.cart_item_key;
                        
                        console.log('Cantidad incrementada para:', cartItems[existingItemIndex]);
                    } else {
                        // Si no existe, crear nuevo item
                        const cartItem = {
                            id: `${optionData.type}_${optionData.value}_${size}`,
                            type: optionData.type,
                            value: optionData.value,
                            title: optionData.title,
                            size: size,
                            sizeLabel: sizeLabel,
                            quantity: 1,
                            timestamp: Date.now(),
                            cart_item_key: response.data.cart_item_key
                        };
                        
                        // Agregar al array del carrito local
                        cartItems.push(cartItem);
                        
                        console.log('Nuevo producto agregado al carrito:', cartItem);
                    }
                    
                    // Actualizar la cantidad en la tarjeta
                    updateCardQuantity(optionData.type, optionData.value);
                    
                    // Mostrar mensaje de éxito
                    const successMessage = `¡${optionData.title}${size !== 'single' ? ' (' + size + ')' : ''} agregado al carrito exitosamente!`;
                    showSuccessNotification(successMessage);
                    
                    // Disparar evento de WooCommerce para actualizar fragmentos del carrito
                    if (response.fragments) {
                        $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $('.combo-option-card.selected')]);
                    }
                    
                    console.log('Carrito actual:', cartItems);
                    
                    // Verificar que el producto se agregó al carrito de WooCommerce
                    setTimeout(function() {
                        $.ajax({
                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                            type: 'POST',
                            data: {
                                action: 'get_cart_contents'
                            },
                            success: function(cartResponse) {
                                console.log('Contenido del carrito de WooCommerce:', cartResponse);
                            }
                        });
                    }, 1000);
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
                
                // Verificar si es un error de servidor
                if (xhr.status === 500) {
                    errorMessage = 'Error interno del servidor. Revisa los logs de WordPress.';
                    console.error('Error 500 - Internal Server Error');
                } else if (xhr.status === 0) {
                    errorMessage = 'Error de conexión. Verifica que el sitio esté funcionando.';
                }
                
                // Intentar parsear la respuesta de error
                try {
                    const errorResponse = JSON.parse(xhr.responseText);
                    if (errorResponse.data) {
                        errorMessage = errorResponse.data;
                    }
                } catch (e) {
                    console.log('No se pudo parsear la respuesta de error');
                    if (xhr.responseText.includes('critical error')) {
                        errorMessage = 'Error crítico de PHP. Revisa los logs de WordPress.';
                    }
                }
                
                alert('Error: ' + errorMessage + '\n\nStatus: ' + xhr.status + '\nResponse: ' + xhr.responseText.substring(0, 200));
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
        
        // Calcular la cantidad total de este producto en el carrito local
        const totalQuantity = cartItems.reduce((total, item) => {
            if (item.type === optionType && item.value === optionValue) {
                return total + (item.quantity || 1);
            }
            return total;
        }, 0);
        
        // Actualizar el atributo data-quantity
        card.attr('data-quantity', totalQuantity);
        
        // Actualizar el número visible
        card.find('.quantity-number').text(totalQuantity);
        
        // Mostrar el contador si no estaba visible
        card.find('.option-quantity').show();
        
        // Agregar clase selected para indicar que tiene productos
        card.addClass('selected');
        
        // Debug: mostrar información del carrito
        console.log('Carrito actual:', cartItems);
        console.log(`Tarjeta ${optionValue} actualizada a cantidad total: ${totalQuantity}`);
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
    
    // Handle "Ir al Carrito" button
    $('#go-to-cart-btn').click(function() {
        // Redireccionar directamente al carrito
        window.location.href = '<?php echo wc_get_cart_url(); ?>';
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
