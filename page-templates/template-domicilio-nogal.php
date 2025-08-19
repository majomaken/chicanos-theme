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
                    // Query for combo products
                    $combo_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 3,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => 'combos', // You may need to adjust this category slug
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
                        // Fallback products if no combos found
                        for ($i = 0; $i < 3; $i++) {
                            echo '<div class="combo-card-personalizado">';
                            echo '<div class="combo-header">';
                            echo '<h2 class="woocommerce-loop-product__title">Combo ' . ($i + 1) . '</h2>';
                            echo '<div class="combo-price">$00XXXX</div>';
                            echo '</div>';
                            echo '<div class="combo-imagen">';
                            echo '<img src="https://via.placeholder.com/300x200" alt="Combo placeholder">';
                            echo '</div>';
                            echo '<div class="combo-footer">';
                            echo '<button class="btn btn-primary">AGREGAR</button>';
                            echo '</div>';
                            echo '</div>';
                        }
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
                                'terms'    => 'tacos', // You may need to adjust this category slug
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
                        // Fallback taco products
                        $taco_names = ['Tacos al Pastor', 'Cochinita Pibil', 'Taco Michoacan', 'Taco Todos Santos', 'Taco Chiapas', 'Taco Tulum'];
                        $taco_prices = ['$5.500', '$6.000', '$5.500', '$7.500', '$5.500', '$6.000'];
                        
                        for ($i = 0; $i < 6; $i++) {
                            echo '<div class="combo-card-personalizado">';
                            echo '<div class="combo-header">';
                            echo '<h2 class="woocommerce-loop-product__title">' . $taco_names[$i] . '</h2>';
                            echo '<div class="combo-price">' . $taco_prices[$i] . '</div>';
                            echo '</div>';
                            echo '<div class="combo-imagen">';
                            echo '<img src="https://via.placeholder.com/300x200" alt="Taco placeholder">';
                            echo '</div>';
                            echo '<div class="combo-footer">';
                            echo '<button class="btn btn-primary">AGREGAR</button>';
                            echo '</div>';
                            echo '</div>';
                        }
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
                    // Query for create-your-own products
                    $create_your_own_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 10,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => 'create-your-own',
                            ),
                        ),
                    );
                    
                    $create_your_own_products = new WP_Query($create_your_own_args);
                    
                    if ($create_your_own_products->have_posts()) :
                        while ($create_your_own_products->have_posts()) : $create_your_own_products->the_post();
                            wc_get_template_part('content', 'product');
                        endwhile;
                        wp_reset_postdata();
                    else :
                        // Fallback create-your-own products if no products found
                        echo '<div class="combo-card-personalizado">';
                        echo '<div class="combo-header">';
                        echo '<h2 class="woocommerce-loop-product__title">Ensalada</h2>';
                        echo '<div class="combo-price">$00000</div>';
                        echo '</div>';
                        echo '<div class="combo-imagen">';
                        echo '<img src="https://via.placeholder.com/300x200" alt="Ensalada placeholder">';
                        echo '</div>';
                        echo '<div class="combo-footer">';
                        echo '<button class="btn btn-primary">AGREGAR</button>';
                        echo '</div>';
                        echo '</div>';
                        
                        echo '<div class="combo-card-personalizado">';
                        echo '<div class="combo-header">';
                        echo '<h2 class="woocommerce-loop-product__title">Burrito</h2>';
                        echo '<div class="combo-price">$00000</div>';
                        echo '</div>';
                        echo '<div class="combo-imagen">';
                        echo '<img src="https://via.placeholder.com/300x200" alt="Burrito placeholder">';
                        echo '</div>';
                        echo '<div class="combo-footer">';
                        echo '<button class="btn btn-primary">AGREGAR</button>';
                        echo '</div>';
                        echo '</div>';
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
                    else :
                        // Fallback adiciones products if no products found
                        echo '<div class="combo-card-personalizado">';
                        echo '<div class="combo-header">';
                        echo '<h2 class="woocommerce-loop-product__title">Todo para Llevar</h2>';
                        echo '<div class="combo-price">$00000</div>';
                        echo '</div>';
                        echo '<div class="combo-imagen">';
                        echo '<img src="https://via.placeholder.com/300x200" alt="Todo para Llevar placeholder">';
                        echo '</div>';
                        echo '<div class="combo-footer">';
                        echo '<button class="btn btn-primary">AGREGAR</button>';
                        echo '</div>';
                        echo '</div>';
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
                    else :
                        // Fallback sopas products if no products found
                        echo '<div class="combo-card-personalizado">';
                        echo '<div class="combo-header">';
                        echo '<h2 class="woocommerce-loop-product__title">Tortilla Vargas</h2>';
                        echo '<div class="combo-price">$2000</div>';
                        echo '</div>';
                        echo '<div class="combo-imagen">';
                        echo '<img src="https://via.placeholder.com/300x200" alt="Tortilla Vargas placeholder">';
                        echo '</div>';
                        echo '<div class="combo-footer">';
                        echo '<button class="btn btn-primary">AGREGAR</button>';
                        echo '</div>';
                        echo '</div>';
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
                    else :
                        // Fallback botanas products if no products found
                        $botanas_products_fallback = [
                            ['name' => 'Bienvenida de Botanas', 'price' => '$9.500'],
                            ['name' => 'Nachos Chicanos', 'price' => '$9.900'],
                            ['name' => 'Serenata de Mini-Flautas', 'price' => '$3.000'],
                            ['name' => 'Salude de Quesadilla', 'price' => '$2.900'],
                            ['name' => 'Fiesta de la Tinga', 'price' => '$9.000'],
                            ['name' => 'Festin de Totopos', 'price' => '$7.200'],
                            ['name' => 'Chicharrón de Queso', 'price' => '$1.000']
                        ];
                        
                        foreach ($botanas_products_fallback as $product) {
                            echo '<div class="combo-card-personalizado">';
                            echo '<div class="combo-header">';
                            echo '<h2 class="woocommerce-loop-product__title">' . $product['name'] . '</h2>';
                            echo '<div class="combo-price">' . $product['price'] . '</div>';
                            echo '</div>';
                            echo '<div class="combo-imagen">';
                            echo '<img src="https://via.placeholder.com/300x200" alt="' . $product['name'] . ' placeholder">';
                            echo '</div>';
                            echo '<div class="combo-footer">';
                            echo '<button class="btn btn-primary">AGREGAR</button>';
                            echo '</div>';
                            echo '</div>';
                        }
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
                    else :
                        // Fallback fuertes products if no products found
                        $fuertes_products_fallback = [
                            ['name' => 'Steak Chicanos', 'price' => '$28.000'],
                            ['name' => 'La Tampiqueña', 'price' => '$31.500'],
                            ['name' => 'Tabla Padilla Parra', 'price' => '$46.000', 'note' => 'para dos personas'],
                            ['name' => 'Flautas al Mole', 'price' => '$19.000'],
                            ['name' => 'López Chilorio', 'price' => '$35.000'],
                            ['name' => 'Licenciado Zapata', 'price' => '$25.800'],
                            ['name' => 'Benito Sanchez', 'price' => '$22.500'],
                            ['name' => 'Pollo Ramón Valdes', 'price' => '$25.500'],
                            ['name' => 'Pedro Cuitlachoche', 'price' => '$26.000'],
                            ['name' => 'Pollo González', 'price' => '$23.500'],
                            ['name' => 'Pollo Negrete', 'price' => '$26.900'],
                            ['name' => 'Chilaquiles Maria Martinez', 'price' => '$25.500']
                        ];
                        
                        foreach ($fuertes_products_fallback as $product) {
                            echo '<div class="combo-card-personalizado">';
                            echo '<div class="combo-header">';
                            echo '<h2 class="woocommerce-loop-product__title">' . $product['name'] . '</h2>';
                            echo '<div class="combo-price">' . $product['price'] . '</div>';
                            if (isset($product['note'])) {
                                echo '<div class="product-note">' . $product['note'] . '</div>';
                            }
                            echo '</div>';
                            echo '<div class="combo-imagen">';
                            echo '<img src="https://via.placeholder.com/300x200" alt="' . $product['name'] . ' placeholder">';
                            echo '</div>';
                            echo '<div class="combo-footer">';
                            echo '<button class="btn btn-primary">AGREGAR</button>';
                            echo '</div>';
                            echo '</div>';
                        }
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
                    else :
                        // Fallback burritos products if no products found
                        $burritos_products_fallback = [
                            ['name' => 'Lupe Hidalgo', 'price' => '$34.500'],
                            ['name' => 'Pepe Barragán', 'price' => '$36.500'],
                            ['name' => 'Burrito Ramirez', 'price' => '$25.800']
                        ];
                        
                        foreach ($burritos_products_fallback as $product) {
                            echo '<div class="combo-card-personalizado">';
                            echo '<div class="combo-header">';
                            echo '<h2 class="woocommerce-loop-product__title">' . $product['name'] . '</h2>';
                            echo '<div class="combo-price">' . $product['price'] . '</div>';
                            echo '</div>';
                            echo '<div class="combo-imagen">';
                            echo '<img src="https://via.placeholder.com/300x200" alt="' . $product['name'] . ' placeholder">';
                            echo '</div>';
                            echo '<div class="combo-footer">';
                            echo '<button class="btn btn-primary">AGREGAR</button>';
                            echo '</div>';
                            echo '</div>';
                        }
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
                    else :
                        // Fallback fajitas products if no products found
                        $fajitas_products_fallback = [
                            ['name' => 'Gómez Farias', 'price' => '$25.500'],
                            ['name' => 'Márquez', 'price' => '$15.000'],
                            ['name' => 'Jiménez Cruz', 'price' => '$25.500'],
                            ['name' => 'Flores y Escalante', 'price' => '$34.500']
                        ];
                        
                        foreach ($fajitas_products_fallback as $product) {
                            echo '<div class="combo-card-personalizado">';
                            echo '<div class="combo-header">';
                            echo '<h2 class="woocommerce-loop-product__title">' . $product['name'] . '</h2>';
                            echo '<div class="combo-price">' . $product['price'] . '</div>';
                            echo '</div>';
                            echo '<div class="combo-imagen">';
                            echo '<img src="https://via.placeholder.com/300x200" alt="' . $product['name'] . ' placeholder">';
                            echo '</div>';
                            echo '<div class="combo-footer">';
                            echo '<button class="btn btn-primary">AGREGAR</button>';
                            echo '</div>';
                            echo '</div>';
                        }
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
                    else :
                        // Fallback enchiladas products if no products found
                        $enchiladas_products_fallback = [
                            ['name' => 'Carmelita Salinas', 'price' => '$25.500'],
                            ['name' => 'Salma Verduzco', 'price' => '$25.500'],
                            ['name' => 'Javiera Suarez', 'price' => '$25.000']
                        ];
                        
                        foreach ($enchiladas_products_fallback as $product) {
                            echo '<div class="combo-card-personalizado">';
                            echo '<div class="combo-header">';
                            echo '<h2 class="woocommerce-loop-product__title">' . $product['name'] . '</h2>';
                            echo '<div class="combo-price">' . $product['price'] . '</div>';
                            echo '</div>';
                            echo '<div class="combo-imagen">';
                            echo '<img src="https://via.placeholder.com/300x200" alt="' . $product['name'] . ' placeholder">';
                            echo '</div>';
                            echo '<div class="combo-footer">';
                            echo '<button class="btn btn-primary">AGREGAR</button>';
                            echo '</div>';
                            echo '</div>';
                        }
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
                    else :
                        // Fallback postres products if no products found
                        $postres_products_fallback = [
                            ['name' => 'Cajeta de Chavela', 'price' => '$8.800'],
                            ['name' => 'Tres Marias', 'price' => '$8.800'],
                            ['name' => 'Vicentico', 'price' => '$9.000']
                        ];
                        
                        foreach ($postres_products_fallback as $product) {
                            echo '<div class="combo-card-personalizado">';
                            echo '<div class="combo-header">';
                            echo '<h2 class="woocommerce-loop-product__title">' . $product['name'] . '</h2>';
                            echo '<div class="combo-price">' . $product['price'] . '</div>';
                            echo '</div>';
                            echo '<div class="combo-imagen">';
                            echo '<img src="https://via.placeholder.com/300x200" alt="' . $product['name'] . ' placeholder">';
                            echo '</div>';
                            echo '<div class="combo-footer">';
                            echo '<button class="btn btn-primary">AGREGAR</button>';
                            echo '</div>';
                            echo '</div>';
                        }
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
                    else :
                        // Fallback bebidas products if no products found
                        $bebidas_products_fallback = [
                            ['name' => 'Lorem Ipsum', 'price' => '$00000'],
                            ['name' => 'Lorem Ipsum', 'price' => '$00000'],
                            ['name' => 'Lorem Ipsum', 'price' => '$00000'],
                            ['name' => 'Lorem Ipsum', 'price' => '$0000x'],
                            ['name' => 'Lorem Ipsum', 'price' => '$00000'],
                            ['name' => 'Lorem Ipsum', 'price' => '$00000']
                        ];
                        
                        foreach ($bebidas_products_fallback as $product) {
                            echo '<div class="combo-card-personalizado">';
                            echo '<div class="combo-header">';
                            echo '<h2 class="woocommerce-loop-product__title">' . $product['name'] . '</h2>';
                            echo '<div class="combo-price">' . $product['price'] . '</div>';
                            echo '</div>';
                            echo '<div class="combo-imagen">';
                            echo '<img src="https://via.placeholder.com/300x200" alt="' . $product['name'] . ' placeholder">';
                            echo '</div>';
                            echo '<div class="combo-footer">';
                            echo '<button class="btn btn-primary">AGREGAR</button>';
                            echo '</div>';
                            echo '</div>';
                        }
                    endif;
                    ?>
                </div>
            </div>
        </section>

    </main><!-- #main -->
</div><!-- #domicilio-nogal-wrapper -->

<?php get_footer(); ?>
