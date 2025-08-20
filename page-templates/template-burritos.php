<?php
/**
 * Template Name: Burritos Template
 *
 * Template para burritos que funciona igual que combos para llevar
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
                        <img src="https://via.placeholder.com/400x300" alt="Burrito placeholder" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-6">
                    <h1 class="combo-main-title">Burritos</h1>
                    <p class="combo-description">
                        all of our burritos come in a traditional homemade flour tortilla
                    </p>
                </div>
            </div>
        </div>

        <!-- Contenido principal con imagen de fondo -->
        <div class="combo-content-main">
            <!-- Burrito Builder Form -->
            <form id="combo-builder-form" class="combo-builder">
                
                <?php
                // Obtener el ID del producto de burrito desde la URL
                $burrito_product_id = null;
                
                // Debug: mostrar todos los parámetros de URL
                echo '<!-- DEBUG: Parámetros de URL: ' . print_r($_GET, true) . ' -->';
                
                // Detectar desde parámetro de URL
                if (isset($_GET['product_id'])) {
                    $burrito_product_id = intval($_GET['product_id']);
                    echo '<!-- DEBUG: Burrito ID encontrado: ' . $burrito_product_id . ' -->';
                }
                
                if ($burrito_product_id) {
                    $product = wc_get_product($burrito_product_id);
                    if ($product) {
                        echo '<!-- DEBUG: Producto cargado: ' . $product->get_name() . ' -->';
                        
                        // Extraer opciones desde el meta field _wapf_fieldgroup (Advanced Product Fields for WooCommerce)
                        $wapf_data = get_post_meta($burrito_product_id, '_wapf_fieldgroup', true);
                        
                        // Inicializar arrays para las opciones
                        $protein_options = array();
                        $sauce_options_1 = array();
                        $sauce_options_2 = array();
                        $tortilla_options_1 = array();
                        $tortilla_options_2 = array();
                        
                        // Inicializar títulos de los campos
                        $protein_field_title = '';
                        $sauce_field_title_1 = '';
                        $sauce_field_title_2 = '';
                        $tortilla_field_title_1 = '';
                        $tortilla_field_title_2 = '';
                        
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
                                    
                                    // Asignar a la categoría correcta según el ID del campo (igual que combos)
                                    switch ($field['id']) {
                                        case '68a50e0cee780': // Selecciona tu Proteína
                                            $protein_options = $labels;
                                            $protein_field_title = $field['label'];
                                            echo '<!-- DEBUG: Campo Proteína encontrado: ' . $field['label'] . ' -->';
                                            echo '<!-- DEBUG: Opciones: ' . print_r($protein_options, true) . ' -->';
                                            break;
                                            
                                        case '68a50e6ba4b20': // Salsas y Más
                                            $sauce_options_1 = $labels;
                                            $sauce_field_title_1 = $field['label'];
                                            echo '<!-- DEBUG: Campo Salsas 1 encontrado: ' . $field['label'] . ' -->';
                                            echo '<!-- DEBUG: Opciones: ' . print_r($sauce_options_1, true) . ' -->';
                                            break;
                                            
                                        case '68a5f548fd09d': // Salsas y Más (2)
                                            $sauce_options_2 = $labels;
                                            $sauce_field_title_2 = $field['label'];
                                            echo '<!-- DEBUG: Campo Salsas 2 encontrado: ' . $field['label'] . ' -->';
                                            echo '<!-- DEBUG: Opciones: ' . print_r($sauce_options_2, true) . ' -->';
                                            break;
                                            
                                        case '68a510162a582': // Tortillas
                                            $tortilla_options_1 = $labels;
                                            $tortilla_field_title_1 = $field['label'];
                                            echo '<!-- DEBUG: Campo Tortillas 1 encontrado: ' . $field['label'] . ' -->';
                                            echo '<!-- DEBUG: Opciones: ' . print_r($tortilla_options_1, true) . ' -->';
                                            break;
                                            
                                        case '68a5f5555b827': // Tortillas (2)
                                            $tortilla_options_2 = $labels;
                                            $tortilla_field_title_2 = $field['label'];
                                            echo '<!-- DEBUG: Campo Tortillas 2 encontrado: ' . $field['label'] . ' -->';
                                            echo '<!-- DEBUG: Opciones: ' . print_r($tortilla_options_2, true) . ' -->';
                                            break;
                                    }
                                }
                            }
                        } else {
                            echo '<!-- DEBUG: No se encontró WAPF data -->';
                            echo '<!-- DEBUG: Producto ID: ' . $burrito_product_id . ' -->';
                            echo '<!-- DEBUG: Meta fields disponibles: ' . print_r(get_post_meta($burrito_product_id), true) . ' -->';
                        }
                        
                        // Si no hay custom fields, mostrar mensaje de error
                        if (empty($protein_options) && empty($filling_options) && empty($sauce_options)) {
                            echo '<div class="alert alert-warning">';
                            echo '<p><strong>Error:</strong> No se encontraron campos personalizados en este producto.</p>';
                            echo '<p>Por favor, asegúrate de que el producto tenga configurados los campos personalizados:</p>';
                            echo '<ul>';
                            echo '<li>Selecciona tu Proteína</li>';
                            echo '<li>Salsas y Más</li>';
                            echo '<li>Tortillas</li>';
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

                        <?php if (!empty($protein_options)) : ?>
                        <!-- Protein Options -->
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="section-title">
                                        <?php echo esc_html($protein_field_title); ?>
                                        <span class="selection-limit">(CHOOSE 1)</span>
                                    </h2>
                                    <div class="products-grid">
                                        <?php foreach ($protein_options as $protein) : ?>
                                            <div class="combo-option-card" data-option="protein" data-value="<?php echo esc_attr(strtolower($protein)); ?>">
                                                <div class="option-content">
                                                    <h5 class="option-title"><?php echo esc_html($protein); ?></h5>
                                                    <span class="option-price">$0.00</span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <?php endif; ?>

                        <?php if (!empty($sauce_options_1)) : ?>
                        <!-- Salsas (1) -->
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="section-title">
                                        <?php echo esc_html($sauce_field_title_1); ?>
                                        <span class="selection-limit">(CHOOSE 1)</span>
                                    </h2>
                                    <div class="products-grid">
                                        <?php foreach ($sauce_options_1 as $sauce) : ?>
                                            <div class="combo-option-card" data-option="sauce_1" data-value="<?php echo esc_attr(strtolower($sauce)); ?>">
                                                <div class="option-content">
                                                    <h5 class="option-title"><?php echo esc_html($sauce); ?></h5>
                                                    <span class="option-price">$0.00</span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <?php endif; ?>

                        <?php if (!empty($sauce_options_2)) : ?>
                        <!-- Salsas (2) -->
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="section-title">
                                        <?php echo esc_html($sauce_field_title_2); ?>
                                        <span class="selection-limit">(CHOOSE 1)</span>
                                    </h2>
                                    <div class="products-grid">
                                        <?php foreach ($sauce_options_2 as $sauce) : ?>
                                            <div class="combo-option-card" data-option="sauce_2" data-value="<?php echo esc_attr(strtolower($sauce)); ?>">
                                                <div class="option-content">
                                                    <h5 class="option-title"><?php echo esc_html($sauce); ?></h5>
                                                    <span class="option-price">$0.00</span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <?php endif; ?>

                        <?php if (!empty($tortilla_options_1)) : ?>
                        <!-- Tortillas (1) -->
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="section-title">
                                        <?php echo esc_html($tortilla_field_title_1); ?>
                                        <span class="selection-limit">(CHOOSE 1)</span>
                                    </h2>
                                    <div class="products-grid">
                                        <?php foreach ($tortilla_options_1 as $tortilla) : ?>
                                            <div class="combo-option-card" data-option="tortilla_1" data-value="<?php echo esc_attr(strtolower($tortilla)); ?>">
                                                <div class="option-content">
                                                    <h5 class="option-title"><?php echo esc_html($tortilla); ?></h5>
                                                    <span class="option-price">$0.00</span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <?php endif; ?>

                        <?php if (!empty($tortilla_options_2)) : ?>
                        <!-- Tortillas (2) -->
                        <section class="combo-section mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="section-title">
                                        <?php echo esc_html($tortilla_field_title_2); ?>
                                        <span class="selection-limit">(CHOOSE 1)</span>
                                    </h2>
                                    <div class="products-grid">
                                        <?php foreach ($tortilla_options_2 as $tortilla) : ?>
                                            <div class="combo-option-card" data-option="tortilla_2" data-value="<?php echo esc_attr(strtolower($tortilla)); ?>">
                                                <div class="option-content">
                                                    <h5 class="option-title"><?php echo esc_html($tortilla); ?></h5>
                                                    <span class="option-price">$0.00</span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <?php endif; ?>



                        

                        <?php
                    } else {
                        echo '<p>Producto no encontrado.</p>';
                    }
                } else {
                    echo '<p>No se seleccionó ningún producto de burrito.</p>';
                }
                ?>
                
            </form>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Handle option selection
    $('.combo-option-card').click(function() {
        const optionType = $(this).data('option');
        const optionValue = $(this).data('value');
        
        // Remove previous selection for this type
        $('.combo-option-card[data-option="' + optionType + '"]').removeClass('selected');
        
        // Add selection to current option
        $(this).addClass('selected');
    });
});
</script>

<?php get_footer(); ?>
