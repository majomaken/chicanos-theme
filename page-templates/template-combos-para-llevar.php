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

<div id="combos-para-llevar-wrapper" class="wrapper">
    <div class="container">
        
        <!-- Header Section -->
        <div class="combo-header-section mb-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="combo-image-placeholder">
                        <img src="https://via.placeholder.com/400x300" alt="Combo placeholder" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-6">
                    <h1 class="combo-main-title">Combos para Llevar</h1>
                    <p class="combo-description">
                        Select your protein, salsas, and tortillas and we'll package it up for you. Easy peasy. 
                        <span class="serving-size" id="dynamic-serving-size">
                            <?php
                            // Detectar automáticamente el tamaño del combo basado en parámetros de URL o contexto
                            $combo_size = '1-3 personas'; // Default
                            
                            // Opción 1: Detectar desde parámetro de URL
                            if (isset($_GET['combo_size'])) {
                                $combo_size = sanitize_text_field($_GET['combo_size']);
                            }
                            // Opción 2: Detectar desde referer (si viene de domicilio-nogal)
                            elseif (isset($_SERVER['HTTP_REFERER'])) {
                                $referer = $_SERVER['HTTP_REFERER'];
                                if (strpos($referer, 'domicilio-nogal') !== false) {
                                    // Si viene de domicilio-nogal, determinar el combo basado en el contexto
                                    // Esto se puede ajustar según cómo sepas qué combo específico eligió
                                    $combo_size = '1-3 personas'; // Ajustar según lógica de negocio
                                }
                            }
                            
                            echo esc_html($combo_size);
                            ?>
                        </span>
                    </p>
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
                    echo '<!-- DEBUG: No hay parámetros de combo -->';
                }
                
                if ($combo_product_id) {
                    echo '<!-- DEBUG: Procesando combo ID: ' . $combo_product_id . ' -->';
                    $combo_product = wc_get_product($combo_product_id);
                    
                    if ($combo_product) {
                        echo '<!-- DEBUG: Producto cargado correctamente -->';
                        
                        // Extraer opciones desde el meta field _wapf_fieldgroup
                        $wapf_data = get_post_meta($combo_product_id, '_wapf_fieldgroup', true);
                        
                        // Inicializar arrays para las opciones
                        $protein_options = array();
                        $sauce_options_1 = array(); // Primera selección de salsas
                        $sauce_options_2 = array(); // Segunda selección de salsas
                        $tortilla_options_1 = array(); // Primera selección de tortillas
                        $tortilla_options_2 = array(); // Segunda selección de tortillas
                        $extra_guacamole = array();
                        
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
                                        case '68a50e0cee780': // Selecciona tu Proteína
                                            $protein_options = $labels;
                                            echo '<!-- DEBUG: Proteínas extraídas: ' . print_r($protein_options, true) . ' -->';
                                            break;
                                            
                                        case '68a50e6ba4b20': // Salsas y Más (primera selección)
                                            $sauce_options_1 = $labels;
                                            echo '<!-- DEBUG: Salsas 1 extraídas: ' . print_r($labels, true) . ' -->';
                                            break;
                                            
                                        case '68a51006d47d3': // Salsas y Más (segunda selección)
                                            $sauce_options_2 = $labels;
                                            echo '<!-- DEBUG: Salsas 2 extraídas: ' . print_r($labels, true) . ' -->';
                                            break;
                                            
                                        case '68a510162a582': // Tortillas (primera selección)
                                            $tortilla_options_1 = $labels;
                                            echo '<!-- DEBUG: Tortillas 1 extraídas: ' . print_r($labels, true) . ' -->';
                                            break;
                                            
                                        case '68a5104d583c2': // Tortillas (segunda selección)
                                            $tortilla_options_2 = $labels;
                                            echo '<!-- DEBUG: Tortillas 2 extraídas: ' . print_r($labels, true) . ' -->';
                                            break;
                                            
                                        case '68a5104a7b121': // ¿Quieres más guacamole?
                                            $extra_guacamole = $labels;
                                            echo '<!-- DEBUG: Extra guacamole extraído: ' . print_r($extra_guacamole, true) . ' -->';
                                            break;
                                    }
                                }
                            }
                        } else {
                            echo '<!-- DEBUG: No se encontró WAPF data -->';
                        }
                        
                        // Si no hay custom fields, usar valores por defecto
                        if (empty($protein_options)) {
                            echo '<!-- DEBUG: Usando proteínas por defecto -->';
                            $protein_options = ['Pollo con Cebolla y Pimentón', 'Pollo Rosarita', 'Carne en Salsa Roja'];
                        }
                        if (empty($sauce_options_1)) {
                            echo '<!-- DEBUG: Usando salsas por defecto -->';
                            $sauce_options_1 = ['Mayonesa Chipotle', 'Salsa Roja', 'Sour Cream', 'Guacamole'];
                        }
                        if (empty($tortilla_options_1)) {
                            echo '<!-- DEBUG: Usando tortillas por defecto -->';
                            $tortilla_options_1 = ['Tortillas de Maíz', 'Tortillas de Harina', 'Tortillas de Nopal'];
                        }
                        
                        // Protein Selection Section
                        ?>
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="section-title">
                                        Escoge tu Proteína 
                                        <span class="selection-limit">(choose 1)</span>
                                    </h2>
                                </div>
                            </div>
                            
                            <div class="products-grid" id="protein-grid">
                                <?php
                                $first = true;
                                foreach ($protein_options as $protein) {
                                    $selected_class = $first ? 'selected' : '';
                                    $first = false;
                                    ?>
                                    <div class="combo-option-card protein-option <?php echo $selected_class; ?>" 
                                         data-type="protein" 
                                         data-value="<?php echo esc_attr(trim($protein)); ?>"
                                         data-price="0.00">
                                        <div class="option-content">
                                            <h3 class="option-title"><?php echo esc_html(trim($protein)); ?></h3>
                                            <div class="option-price">$0.00</div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </section>

                        <!-- First Sauces and Extras Section -->
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="section-title">
                                        Salsas y Más (1) 
                                        <span class="selection-limit">(choose 1)</span>
                                    </h2>
                                </div>
                            </div>
                            
                            <div class="products-grid" id="sauce-grid-1">
                                <?php
                                foreach ($sauce_options_1 as $sauce) {
                                    ?>
                                    <div class="combo-option-card sauce-option" 
                                         data-type="sauce" 
                                         data-value="<?php echo esc_attr(trim($sauce)); ?>"
                                         data-price="0.00">
                                        <div class="option-content">
                                            <h3 class="option-title"><?php echo esc_html(trim($sauce)); ?></h3>
                                            <div class="option-price">$0.00</div>
                                        </div>
                                    </div>
                                    <?php
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
                                        <span class="selection-limit">(choose 1)</span>
                                    </h2>
                                </div>
                            </div>
                            
                            <div class="products-grid" id="sauce-grid-2">
                                <?php
                                foreach ($sauce_options_2 as $sauce) {
                                    ?>
                                    <div class="combo-option-card sauce-option" 
                                         data-type="sauce" 
                                         data-value="<?php echo esc_attr(trim($sauce)); ?>"
                                         data-price="0.00">
                                        <div class="option-content">
                                            <h3 class="option-title"><?php echo esc_html(trim($sauce)); ?></h3>
                                            <div class="option-price">$0.00</div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </section>
                        <?php endif; ?>

                        <!-- First Tortilla Selection Section -->
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="section-title">
                                        Tortillas (1) 
                                        <span class="selection-limit">(choose 1)</span>
                                    </h2>
                                </div>
                            </div>
                            
                            <div class="products-grid" id="tortilla-grid-1">
                                <?php
                                $first = true;
                                foreach ($tortilla_options_1 as $tortilla) {
                                    $selected_class = $first ? 'selected' : '';
                                    $first = false;
                                    ?>
                                    <div class="combo-option-card tortilla-option <?php echo $selected_class; ?>" 
                                         data-type="tortilla" 
                                         data-value="<?php echo esc_attr(trim($tortilla)); ?>"
                                         data-price="0.00">
                                        <div class="option-content">
                                            <h3 class="option-title"><?php echo esc_html(trim($tortilla)); ?></h3>
                                            <div class="option-price">$0.00</div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </section>

                        <!-- Second Tortilla Selection Section -->
                        <?php if (!empty($tortilla_options_2)) : ?>
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="section-title">
                                        Tortillas (2) 
                                        <span class="selection-limit">(choose 1)</span>
                                    </h2>
                                </div>
                            </div>
                            
                            <div class="products-grid" id="tortilla-grid-2">
                                <?php
                                $first = true;
                                foreach ($tortilla_options_2 as $tortilla) {
                                    $selected_class = $first ? 'selected' : '';
                                    $first = false;
                                    ?>
                                    <div class="combo-option-card tortilla-option <?php echo $selected_class; ?>" 
                                         data-type="tortilla" 
                                         data-value="<?php echo esc_attr(trim($tortilla)); ?>"
                                         data-price="0.00">
                                        <div class="option-content">
                                            <h3 class="option-title"><?php echo esc_html(trim($tortilla)); ?></h3>
                                            <div class="option-price">$0.00</div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </section>
                        <?php endif; ?>
                        
                        <!-- Extra Guacamole Section (si está configurado) -->
                        <?php if (!empty($extra_guacamole)) : ?>
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
                                <?php
                                foreach ($extra_guacamole as $option) {
                                    ?>
                                    <div class="combo-option-card extra-option" 
                                         data-type="extra" 
                                         data-value="<?php echo esc_attr(trim($option)); ?>"
                                         data-price="0.00">
                                        <div class="option-content">
                                            <h3 class="option-title"><?php echo esc_html(trim($option)); ?></h3>
                                            <div class="option-price">$0.00</div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </section>
                        <?php endif; ?>
                        
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle option selection
    const optionCards = document.querySelectorAll('.combo-option-card');
    optionCards.forEach(card => {
        card.addEventListener('click', function() {
            const type = this.dataset.type;
            const value = this.dataset.value;
            
            // Remove selection from other cards of the same type
            const sameTypeCards = document.querySelectorAll(`.${type}-option`);
            sameTypeCards.forEach(c => c.classList.remove('selected'));
            
            // Add selection to clicked card
            this.classList.add('selected');
            
            // Update summary
            updateSummary();
        });
    });
    
    // Update summary display
    function updateSummary() {
        const selectedProtein = document.querySelector('.protein-option.selected');
        const selectedSauces = document.querySelectorAll('.sauce-option.selected');
        const selectedTortillas = document.querySelectorAll('.tortilla-option.selected');
        
        // Aquí puedes agregar lógica para mostrar el resumen si es necesario
        // Por ahora solo manejamos la selección
    }
    
    // Handle form submission
    document.getElementById('combo-builder-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const selectedProtein = document.querySelector('.protein-option.selected');
        const selectedSauces = document.querySelectorAll('.sauce-option.selected');
        const selectedTortillas = document.querySelectorAll('.tortilla-option.selected');
        
        if (!selectedProtein || selectedSauces.length === 0 || selectedTortillas.length === 0) {
            alert('Por favor selecciona todas las opciones requeridas para tu combo.');
            return;
        }
        
        // Here you would typically add the combo to cart
        // For now, just show a success message
        alert('¡Combo agregado al carrito exitosamente!');
    });
});
</script>

<?php get_footer(); ?>
