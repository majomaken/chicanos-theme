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


<div id="domicilio-nogal-wrapper">
    <main id="main" class="site-main" role="main">

        <!-- Hero Section -->
        <section id="domicilio-hero" class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Left Column - Text Content -->
                    <div class="col-lg-6">
                        <div class="hero-content">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/pixel-flower-red.png" alt="Flor Roja Pixelada" class="hero-decoration">
                            <h1 class="hero-title">Sede Nogal</h1>
                            <div class="hero-info">
                                <p class="delivery-range">Desde la carrera 1 con 24</p>
                                <p class="delivery-range">hasta la carrera 90 con 20</p>
                                <p class="address">Carrera 11 #78-70</p>
                                <p class="contact-info">WhatsApp: +57 322 2112325</p>
                                <p class="contact-info">Teléfono: (601) 312 9887 o (601) 300 2326</p>
                                <p class="contact-info">Correo: contacto@chicano.com.co</p>
                            </div>
                        </div>
                    </div>
                    <!-- Right Column - Image -->
                    <div class="col-lg-6">
                        <div class="hero-image-container">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/sede-nogal-banner.jpg" alt="Sede Nogal" class="hero-image">
                            <div class="hero-pattern">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/hero-layer.png" alt="Capa Rosa" class="hero-layer-pink">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Food Categories Navigation -->
        <section id="food-categories" class="categories-section">
            <div class="container">
                <div class="categories-nav">
                    <ul class="categories-list">
                        <li><a href="<?php echo home_url('/combos-para-llevar/'); ?>" class="category-link">Combos</a></li>
                        <li><a href="#tacos" class="category-link">Tacos</a></li>
                        <li><a href="#mini-taquitos" class="category-link">Mini Taquitos</a></li>
                        <li><a href="<?php echo home_url('/ensaladas/'); ?>" class="category-link">Ensalada/Burrito</a></li>
                        <li><a href="#todo-para-llevar" class="category-link">Todo Para Llevar</a></li>
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

        <!-- Todo Para Llevar Section -->
        <section id="todo-para-llevar" class="products-section">
            <div class="container">
                <h2 class="section-title">Todo Para Llevar</h2>
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

        <!-- Tacos Section -->
        <section id="tacos" class="products-section">
            <div class="container">
                <h2 class="section-title">Tacos</h2>
                <div class="products-grid">
                    <?php
                    // Query for taco products
                    $taco_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 15, // Increased to show all tacos
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
                            'posts_per_page' => 15, // Increased to match main query
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

        <!-- Mini Taquitos Section -->
        <section id="mini-taquitos" class="products-section">
            <div class="container">
                <h2 class="section-title">Mini Taquitos</h2>
                <div class="products-grid">
                    <?php
                    // Query for mini taquitos products
                    $mini_taquitos_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 10,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => array('mini-taquitos', 'mini-taquito'), // Multiple possible category slugs
                                'operator' => 'IN',
                            ),
                        ),
                    );
                    
                    $mini_taquitos_products = new WP_Query($mini_taquitos_args);
                    
                    if ($mini_taquitos_products->have_posts()) :
                        while ($mini_taquitos_products->have_posts()) : $mini_taquitos_products->the_post();
                            wc_get_template_part('content', 'product');
                        endwhile;
                        wp_reset_postdata();
                    else :
                        // Fallback: show any products if no mini taquitos found
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

        <!-- Spacing Section -->
        <section id="spacing-section" class="spacing-section">
            <div class="container">
                <!-- Empty section for spacing before footer -->
            </div>
        </section>

    </main><!-- #main -->
</div><!-- #domicilio-nogal-wrapper -->

<?php get_footer(); ?>
