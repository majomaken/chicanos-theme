<?php
/**
 * Template Name: Ensaladas Template
 *
 * Template para ensaladas que funciona igual que combos para llevar
 *
 * @package Chicanos_Theme
 */

get_header(); ?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/ensaladas.css">

<?php
// Función auxiliar para cargar las opciones de un producto de ensalada
function load_ensalada_options($product_id) {
    $product = wc_get_product($product_id);
    if (!$product) {
        return false;
    }
    
    echo '<!-- DEBUG: Producto cargado: ' . $product->get_name() . ' -->';
    
    // Extraer opciones desde el meta field _wapf_fieldgroup (Advanced Product Fields for WooCommerce)
    $wapf_data = get_post_meta($product_id, '_wapf_fieldgroup', true);
    
    // Inicializar arrays para las opciones
    $base_options = array();
    $protein_options = array();
    $sauce_options_1 = array();
    $sauce_options_2 = array();
    $tortilla_options_1 = array();
    $tortilla_options_2 = array();
    
    // Inicializar títulos de los campos
    $base_field_title = '';
    $protein_field_title = '';
    $sauce_field_title_1 = '';
    $sauce_field_title_2 = '';
    $tortilla_field_title_1 = '';
    $tortilla_field_title_2 = '';
    
    if (!empty($wapf_data) && isset($wapf_data['fields'])) {
        echo '<!-- DEBUG: WAPF data encontrada -->';
        echo '<!-- DEBUG: Total campos encontrados: ' . count($wapf_data['fields']) . ' -->';
        echo '<!-- DEBUG: Campos disponibles: ' . print_r(array_keys($wapf_data['fields']), true) . ' -->';
        
        foreach ($wapf_data['fields'] as $field) {
            echo '<!-- DEBUG: Procesando campo ID: ' . (isset($field['id']) ? $field['id'] : 'NO_ID') . ' -->';
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
                    case '68a5f5bf180c4': // Escoge tu base
                        $base_options = $labels;
                        $base_field_title = $field['label'];
                        echo '<!-- DEBUG: Campo Base encontrado: ' . $field['label'] . ' -->';
                        echo '<!-- DEBUG: Opciones: ' . print_r($base_options, true) . ' -->';
                        break;
                        
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
        echo '<!-- DEBUG: Producto ID: ' . $product_id . ' -->';
        echo '<!-- DEBUG: Meta fields disponibles: ' . print_r(get_post_meta($product_id), true) . ' -->';
    }
    
    // Si no hay custom fields, mostrar mensaje de error
    if (empty($base_options) && empty($protein_options) && empty($sauce_options_1)) {
        echo '<div class="alert alert-warning">';
        echo '<p><strong>Error:</strong> No se encontraron campos personalizados en este producto.</p>';
        echo '<p>Por favor, asegúrate de que el producto tenga configurados los campos personalizados:</p>';
        echo '<ul>';
        echo '<li>Escoge tu base</li>';
        echo '<li>Selecciona tu Proteína</li>';
        echo '<li>Salsas y Más</li>';
        echo '<li>Tortillas</li>';
        echo '</ul>';
        echo '</div>';
        return false;
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

    <?php if (!empty($base_options)) : ?>
    <!-- Base Options -->
    <section class="combo-section mb-5">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">
                    <?php echo esc_html($base_field_title); ?>
                    <span class="selection-limit">(escoge 1)</span>
                </h2>
                <div class="products-grid">
                    <?php foreach ($base_options as $base) : ?>
                        <div class="combo-option-card" data-option="base" data-value="<?php echo esc_attr(strtolower($base)); ?>">
                            <div class="option-content">
                                <h5 class="option-title"><?php echo esc_html($base); ?></h5>
                                <span class="option-price">$0.00</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
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
                    <span class="selection-limit">(escoge 1)</span>
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
                    <span class="selection-limit">(escoge hasta 4)</span>
                </h2>
                <div class="products-grid">
                    <?php foreach ($sauce_options_1 as $sauce) : 
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
                        <label class="combo-option-card sauce-option" 
                               data-type="sauce" 
                               data-value="<?php echo esc_attr($sauce_text); ?>"
                               data-price="0.00">
                            <input type="checkbox" 
                                   name="sauce[]" 
                                   value="<?php echo esc_attr($sauce_text); ?>"
                                   class="sauce-checkbox">
                            <div class="option-content">
                                <h5 class="option-title"><?php echo esc_html($main_text); ?></h5>
                                <?php if ($spec_text): ?>
                                    <div class="option-spec"><?php echo esc_html($spec_text); ?></div>
                                <?php endif; ?>
                                <span class="option-price">$0.00</span>
                            </div>
                        </label>
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
                    <span class="selection-limit">(escoge hasta 4)</span>
                </h2>
                <div class="products-grid">
                    <?php foreach ($sauce_options_2 as $sauce) : 
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
                        <label class="combo-option-card sauce-option" 
                               data-type="sauce" 
                               data-value="<?php echo esc_attr($sauce_text); ?>"
                               data-price="0.00">
                            <input type="checkbox" 
                                   name="sauce[]" 
                                   value="<?php echo esc_attr($sauce_text); ?>"
                                   class="sauce-checkbox">
                            <div class="option-content">
                                <h5 class="option-title"><?php echo esc_html($main_text); ?></h5>
                                <?php if ($spec_text): ?>
                                    <div class="option-spec"><?php echo esc_html($spec_text); ?></div>
                                <?php endif; ?>
                                <span class="option-price">$0.00</span>
                            </div>
                        </label>
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
                    <span class="selection-limit">(escoge 1)</span>
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
                    <span class="selection-limit">(escoge 1)</span>
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
    return true;
}

?>

<div id="combos-para-llevar-wrapper" class="wrapper">
    <div class="container">
        
        <!-- Header Section -->
        <div class="ensaladas-banner-section mb-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="ensaladas-text-content">
                        <h1 class="ensaladas-main-title">Ensalada</h1>
                        <p class="ensaladas-subtitle">Your choice of meat with our fresh lettuce</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ensaladas-image-container">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/ensaladas.banner.jpg" alt="Ensalada con chiles frescos" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido principal con imagen de fondo -->
        <div class="combo-content-main">
            <!-- Ensalada Builder Form -->
            <form id="combo-builder-form" class="combo-builder">
                
                <?php
                // Obtener el ID del producto de ensalada desde la URL
                $ensalada_product_id = null;
                
                // Debug: mostrar todos los parámetros de URL
                echo '<!-- DEBUG: Parámetros de URL: ' . print_r($_GET, true) . ' -->';
                
                // Detectar desde parámetro de URL
                if (isset($_GET['product_id'])) {
                    $ensalada_product_id = intval($_GET['product_id']);
                    echo '<!-- DEBUG: Ensalada ID encontrado: ' . $ensalada_product_id . ' -->';
                }
                
                if ($ensalada_product_id) {
                    load_ensalada_options($ensalada_product_id);
                } else {
                    // Si no hay product_id, buscar el primer producto de ensalada disponible
                    $default_ensalada_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 1,
                        'orderby' => 'title',
                        'order' => 'ASC',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => 'ensaladas',
                            ),
                        ),
                        'meta_query' => array(
                            array(
                                'key' => '_stock_status',
                                'value' => 'instock',
                                'compare' => '='
                            )
                        )
                    );
                    
                    $default_ensalada_query = new WP_Query($default_ensalada_args);
                    echo '<!-- DEBUG: Query ejecutada, posts encontrados: ' . $default_ensalada_query->found_posts . ' -->';
                    
                    if ($default_ensalada_query->have_posts()) {
                        $default_ensalada_query->the_post();
                        $ensalada_product_id = get_the_ID();
                        echo '<!-- DEBUG: Ensalada por defecto encontrada: ' . $ensalada_product_id . ' -->';
                        echo '<!-- DEBUG: Nombre del producto: ' . get_the_title() . ' -->';
                        
                        load_ensalada_options($ensalada_product_id);
                        wp_reset_postdata();
                    } else {
                        echo '<p>No se encontró ningún producto de ensalada disponible.</p>';
                        echo '<!-- DEBUG: Query args: ' . print_r($default_ensalada_args, true) . ' -->';
                    }
                }
                ?>
                
            </form>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Handle checkbox changes for sauces
    $('.sauce-checkbox').change(function() {
        const selectedSauces = $('.sauce-checkbox:checked');
        
        if (selectedSauces.length > 4) {
            // Si se excede el límite, desmarcamos este checkbox
            this.checked = false;
            showLimitMessage('Solo puedes seleccionar máximo 4 salsas');
            return;
        }
        
        // Actualizar la clase selected en el label
        const label = $(this).closest('.sauce-option');
        if (this.checked) {
            label.addClass('selected');
        } else {
            label.removeClass('selected');
        }
    });
    
    // Handle option selection for other categories (base, protein, tortillas)
    $('.combo-option-card:not(.sauce-option)').click(function() {
        const optionType = $(this).data('option');
        const optionValue = $(this).data('value');
        
        // Remove previous selection for this type
        $('.combo-option-card[data-option="' + optionType + '"]').removeClass('selected');
        
        // Add selection to current option
        $(this).addClass('selected');
    });
    
    // Show limit message function
    function showLimitMessage(message) {
        const tooltip = document.createElement('div');
        tooltip.className = 'limit-tooltip';
        tooltip.textContent = message;
        document.body.appendChild(tooltip);
        
        setTimeout(() => {
            tooltip.remove();
        }, 2000);
    }
});
</script>

<?php get_footer(); ?>
