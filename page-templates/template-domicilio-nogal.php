<?php
/**
 * Template Name: Domicilio Nogal Template
 *
 * This is the template for the Nogal delivery page with food categories and products.
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

?>

<style>
/* CSS personalizado para eliminar el espacio en blanco en las tarjetas de tacos */
.products-section .products-grid .combo-card-personalizado {
  height: auto !important;
  min-height: auto !important;
  max-height: none !important;
  display: flex !important;
  flex-direction: column !important;
  align-items: stretch !important;
  box-sizing: border-box !important;
  overflow: hidden !important;
}

.woocommerce ul.products li.product {
  height: auto !important;
  min-height: auto !important;
  max-height: none !important;
  margin: 0 !important;
  padding: 0 !important;
}

.combo-header {
  flex-shrink: 0 !important;
  height: 80px !important;
  min-height: 80px !important;
  max-height: 80px !important;
  margin: 0 !important;
  padding: 8px 15px !important;
  border-bottom: 1px solid #000 !important;
  background-color: #FAD3DB !important;
}

.combo-imagen {
  height: 160px !important;
  min-height: 160px !important;
  max-height: 160px !important;
  flex-shrink: 0 !important;
  margin: 0 !important;
  padding: 0 !important;
  line-height: 0 !important;
  font-size: 0 !important;
  background-color: #FBF5ED !important;
  overflow: hidden !important;
}

.combo-footer {
  height: 50px !important;
  min-height: 50px !important;
  max-height: 50px !important;
  flex-shrink: 0 !important;
  margin: 0 !important;
  padding: 0 !important;
  border-top: none !important;
  background-color: #FBF5ED !important;
}

.combo-card-personalizado .combo-header + .combo-imagen {
  margin-top: 0 !important;
  padding-top: 0 !important;
}

.combo-card-personalizado .combo-imagen + .combo-footer {
  margin-top: 0 !important;
  padding-top: 0 !important;
  border-top: none !important;
}

.combo-imagen img {
  width: 100% !important;
  height: 100% !important;
  object-fit: cover !important;
  border-radius: 0 !important;
}

.combo-footer .button,
.combo-footer button,
.combo-footer input[type="submit"] {
  height: 50px !important;
  min-height: 50px !important;
  max-height: 50px !important;
  padding: 8px 0 !important;
  margin: 0 !important;
  border-radius: 0 !important;
  background-color: #F9CB38 !important;
  color: #000 !important;
  border: 1px solid #000 !important;
  border-bottom: none !important;
  font-weight: 700 !important;
  font-size: 0.9rem !important;
  text-transform: uppercase !important;
  letter-spacing: 0.5px !important;
  width: 100% !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
}

.products-section .products-grid {
  gap: 25px !important;
}

.products-section .products-grid li {
  margin: 0 !important;
  padding: 0 !important;
}

.woocommerce ul.products li.product .combo-card-personalizado {
  height: auto !important;
  min-height: auto !important;
  max-height: none !important;
}

.products-section {
  margin: 0 !important;
  padding: 0 !important;
}

@media (max-width: 768px) {
  .products-section .products-grid {
    gap: 20px !important;
  }
}

@media (max-width: 480px) {
  .products-section .products-grid {
    gap: 15px !important;
  }
}
</style>

<div id="domicilio-nogal-wrapper">
    <main id="main" class="site-main" role="main">

        <!-- Hero Section -->
        <section id="domicilio-hero" class="hero-section">
            <div class="hero-image-container">
                <div class="sede-image-background">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/banner.jpg" alt="Sede Nogal" class="sede-background-image">
                </div>
                <div class="hero-overlay">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/pixel-flower-red.png" alt="Flor Roja Pixelada" class="pixel-flower">
                    <h1 class="hero-title">Sede Nogal</h1>
                </div>
                <div class="hero-pattern">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/hero-layer.png" alt="Capa Rosa" class="hero-layer-pink">
                </div>
            </div>
        </section>

        <!-- Food Categories Navigation -->
        <section id="food-categories" class="categories-section">
            <div class="container">
                <div class="categories-nav">
                    <ul class="categories-list">
                        <li><a href="#combos-para-llevar" class="category-link">Combos</a></li>
                        <li><a href="#tacos" class="category-link">Tacos</a></li>
                        <li><a href="#create-your-own" class="category-link">Ensalada/Burrito</a></li>
                        <li><a href="#adiciones" class="category-link">Adiciones</a></li>
                        <li><a href="#sopas" class="category-link">Sopas</a></li>
                        <li><a href="#botanas" class="category-link">Botanas</a></li>
                        <li><a href="#fuertes" class="category-link">Fuertes</a></li>
                        <li><a href="#burritos" class="category-link">Burritos</a></li>
                        <li><a href="#fajitas" class="category-link">Fajitas</a></li>
                        <li><a href="#enchiladas" class="category-link">Enchiladas</a></li>
                        <li><a href="#postres" class="category-link">Postres</a></li>
                        <li><a href="#bebidas" class="category-link">Bebidas</a></li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Combos para Llevar Section -->
        <section id="combos-para-llevar" class="products-section">
            <div class="container">
                <h2 class="section-title">Combos para Llevar</h2>
                <div class="products-grid">
                    <?php
                    // Query for combo products with specific ordering
                    $combo_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 3,
                        'orderby' => 'title',
                        'order' => 'ASC',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => array('combos', 'combo', 'combo-para-llevar'), // Multiple possible category slugs
                                'operator' => 'IN',
                            ),
                        ),
                    );
                    
                    $combo_products = new WP_Query($combo_args);
                    
                    if ($combo_products->have_posts()) :
                        while ($combo_products->have_posts()) : $combo_products->the_post();
                            wc_get_template_part('content', 'product');
                        endwhile;
                        wp_reset_postdata();
                    else :
                        // Fallback: show any products if no combos found
                        $fallback_args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 3,
                            'orderby' => 'title',
                            'order' => 'ASC',
                        );
                        
                        $fallback_products = new WP_Query($fallback_args);
                        
                        if ($fallback_products->have_posts()) :
                            while ($fallback_products->have_posts()) : $fallback_products->the_post();
                                wc_get_template_part('content', 'product');
                            endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<div class="no-products-message">';
                            echo '<p>No hay productos disponibles en este momento. Por favor, revisa más tarde.</p>';
                            echo '</div>';
                        endif;
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <!-- Tacos Section -->
        <section id="tacos" class="products-section">
            <div class="container">
                <h2 class="section-title">Tacos</h2>
                <div class="products-grid">
                    <?php
                    // Query for taco products
                    $taco_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 6,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => array('tacos', 'taco'), // Multiple possible category slugs
                                'operator' => 'IN',
                            ),
                        ),
                    );
                    
                    $taco_products = new WP_Query($taco_args);
                    
                    if ($taco_products->have_posts()) :
                        while ($taco_products->have_posts()) : $taco_products->the_post();
                            wc_get_template_part('content', 'product');
                        endwhile;
                        wp_reset_postdata();
                    else :
                        // Fallback: show any products if no tacos found
                        $fallback_args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 6,
                            'orderby' => 'title',
                            'order' => 'ASC',
                        );
                        
                        $fallback_products = new WP_Query($fallback_args);
                        
                        if ($fallback_products->have_posts()) :
                            while ($fallback_products->have_posts()) : $fallback_products->the_post();
                                wc_get_template_part('content', 'product');
                            endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<div class="no-products-message">';
                            echo '<p>No hay productos disponibles en este momento. Por favor, revisa más tarde.</p>';
                            echo '</div>';
                        endif;
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <!-- Crea tu Ensalada/Burrito Section -->
        <section id="create-your-own" class="products-section">
            <div class="container">
                <h2 class="section-title">Ensalada/Burrito</h2>
                <div class="products-grid">
                    <?php
                    // Query for ensalada-burrito products
                    $ensalada_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 10,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => 'Ensalada-Burrito', // Exact category slug as specified
                            ),
                        ),
                    );
                    
                    $ensalada_products = new WP_Query($ensalada_args);
                    
                    if ($ensalada_products->have_posts()) :
                        while ($ensalada_products->have_posts()) : $ensalada_products->the_post();
                            wc_get_template_part('content', 'product');
                        endwhile;
                        wp_reset_postdata();
                    else :
                        // Fallback: show any products if no ensalada-burrito found
                        $fallback_args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 10,
                            'orderby' => 'title',
                            'order' => 'ASC',
                        );
                        
                        $fallback_products = new WP_Query($fallback_args);
                        
                        if ($fallback_products->have_posts()) :
                            while ($fallback_products->have_posts()) : $fallback_products->the_post();
                                wc_get_template_part('content', 'product');
                            endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<div class="no-products-message">';
                            echo '<p>No hay productos disponibles en este momento. Por favor, revisa más tarde.</p>';
                            echo '</div>';
                        endif;
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <!-- Adiciones Section -->
        <section id="adiciones" class="products-section">
            <div class="container">
                <h2 class="section-title">Adiciones</h2>
                <div class="products-grid">
                    <?php
                    // Query for adiciones products
                    $adiciones_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 10,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => 'adiciones',
                            ),
                        ),
                    );
                    
                    $adiciones_products = new WP_Query($adiciones_args);
                    
                    if ($adiciones_products->have_posts()) :
                        while ($adiciones_products->have_posts()) : $adiciones_products->the_post();
                            wc_get_template_part('content', 'product');
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <!-- Sopas Section -->
        <section id="sopas" class="products-section">
            <div class="container">
                <h2 class="section-title">Sopas</h2>
                <div class="products-grid">
                    <?php
                    // Query for sopas products
                    $sopas_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 10,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => 'sopas',
                            ),
                        ),
                    );
                    
                    $sopas_products = new WP_Query($sopas_args);
                    
                    if ($sopas_products->have_posts()) :
                        while ($sopas_products->have_posts()) : $sopas_products->the_post();
                            wc_get_template_part('content', 'product');
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <!-- Botanas Section -->
        <section id="botanas" class="products-section">
            <div class="container">
                <h2 class="section-title">Botanas</h2>
                <div class="products-grid">
                    <?php
                    // Query for botanas products
                    $botanas_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 10,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => 'botanas',
                            ),
                        ),
                    );
                    
                    $botanas_products = new WP_Query($botanas_args);
                    
                    if ($botanas_products->have_posts()) :
                        while ($botanas_products->have_posts()) : $botanas_products->the_post();
                            wc_get_template_part('content', 'product');
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <!-- Fuertes Section -->
        <section id="fuertes" class="products-section">
            <div class="container">
                <h2 class="section-title">Fuertes</h2>
                <div class="products-grid">
                    <?php
                    // Query for fuertes products
                    $fuertes_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 15,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => 'fuertes',
                            ),
                        ),
                    );
                    
                    $fuertes_products = new WP_Query($fuertes_args);
                    
                    if ($fuertes_products->have_posts()) :
                        while ($fuertes_products->have_posts()) : $fuertes_products->the_post();
                            wc_get_template_part('content', 'product');
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <!-- Burritos Section -->
        <section id="burritos" class="products-section">
            <div class="container">
                <h2 class="section-title">Burritos</h2>
                <div class="products-grid">
                    <?php
                    // Query for burritos products
                    $burritos_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 10,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => 'burritos',
                            ),
                        ),
                    );
                    
                    $burritos_products = new WP_Query($burritos_args);
                    
                    if ($burritos_products->have_posts()) :
                        while ($burritos_products->have_posts()) : $burritos_products->the_post();
                            wc_get_template_part('content', 'product');
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <!-- Fajitas Section -->
        <section id="fajitas" class="products-section">
            <div class="container">
                <h2 class="section-title">Fajitas</h2>
                <div class="products-grid">
                    <?php
                    // Query for fajitas products
                    $fajitas_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 10,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => 'fajitas',
                            ),
                        ),
                    );
                    
                    $fajitas_products = new WP_Query($fajitas_args);
                    
                    if ($fajitas_products->have_posts()) :
                        while ($fajitas_products->have_posts()) : $fajitas_products->the_post();
                            wc_get_template_part('content', 'product');
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <!-- Enchiladas Section -->
        <section id="enchiladas" class="products-section">
            <div class="container">
                <h2 class="section-title">Enchiladas</h2>
                <div class="products-grid">
                    <?php
                    // Query for enchiladas products
                    $enchiladas_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 10,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => 'enchiladas',
                            ),
                        ),
                    );
                    
                    $enchiladas_products = new WP_Query($enchiladas_args);
                    
                    if ($enchiladas_products->have_posts()) :
                        while ($enchiladas_products->have_posts()) : $enchiladas_products->the_post();
                            wc_get_template_part('content', 'product');
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <!-- Postres Section -->
        <section id="postres" class="products-section">
            <div class="container">
                <h2 class="section-title">Postres</h2>
                <div class="products-grid">
                    <?php
                    // Query for postres products
                    $postres_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 10,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => 'postres',
                            ),
                        ),
                    );
                    
                    $postres_products = new WP_Query($postres_args);
                    
                    if ($postres_products->have_posts()) :
                        while ($postres_products->have_posts()) : $postres_products->the_post();
                            wc_get_template_part('content', 'product');
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <!-- Bebidas Section -->
        <section id="bebidas" class="products-section">
            <div class="container">
                <h2 class="section-title">Bebidas</h2>
                <div class="products-grid">
                    <?php
                    // Query for bebidas products
                    $bebidas_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 10,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => 'bebidas',
                            ),
                        ),
                    );
                    
                    $bebidas_products = new WP_Query($bebidas_args);
                    
                    if ($bebidas_products->have_posts()) :
                        while ($bebidas_products->have_posts()) : $bebidas_products->the_post();
                            wc_get_template_part('content', 'product');
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </section>

    </main><!-- #main -->
</div><!-- #domicilio-nogal-wrapper -->

<?php get_footer(); ?>
