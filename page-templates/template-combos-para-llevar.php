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
                        <span class="serving-size">Serves 1-3</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Contenido principal con imagen de fondo -->
        <div class="combo-content-main">
            <!-- Combo Builder Form -->
            <form id="combo-builder-form" class="combo-builder">
                
                <!-- Protein Selection Section -->
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
                    <!-- Placeholder protein options based on design -->
                    <div class="combo-option-card protein-option selected" data-type="protein" data-value="Pollo con Cebolla y Pimentón">
                        <div class="option-content">
                            <h3 class="option-title">Pollo con Cebolla y Pimentón</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                    
                    <div class="combo-option-card protein-option" data-type="protein" data-value="Pollo Rosarita">
                        <div class="option-content">
                            <h3 class="option-title">Pollo Rosarita</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                    
                    <div class="combo-option-card protein-option" data-type="protein" data-value="Pollo en Salsa Roja">
                        <div class="option-content">
                            <h3 class="option-title">Pollo en Salsa Roja</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                    
                    <div class="combo-option-card protein-option" data-type="protein" data-value="Pollo Todo Santos">
                        <div class="option-content">
                            <h3 class="option-title">Pollo Todo Santos</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                    
                    <div class="combo-option-card protein-option" data-type="protein" data-value="Carne en Salsa Roja">
                        <div class="option-content">
                            <h3 class="option-title">Carne en Salsa Roja</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                    
                    <div class="combo-option-card protein-option" data-type="protein" data-value="Carne Al Pastor">
                        <div class="option-content">
                            <h3 class="option-title">Carne Al Pastor</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                    
                    <div class="combo-option-card protein-option" data-type="protein" data-value="Lomo en Juliana en Salsa Roja">
                        <div class="option-content">
                            <h3 class="option-title">Lomo en Juliana en Salsa Roja</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                    
                    <div class="combo-option-card protein-option" data-type="protein" data-value="Lomo con Cebolla y Pimentón">
                        <div class="option-content">
                            <h3 class="option-title">Lomo con Cebolla y Pimentón</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                    
                    <div class="combo-option-card protein-option" data-type="protein" data-value="Cochinita Pibil">
                        <div class="option-content">
                            <h3 class="option-title">Cochinita Pibil</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                    
                    <div class="combo-option-card protein-option" data-type="protein" data-value="Camarones en Salsa Chipotle">
                        <div class="option-content">
                            <h3 class="option-title">Camarones en Salsa Chipotle</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                    
                    <div class="combo-option-card protein-option" data-type="protein" data-value="Cerdo a la Naranja">
                        <div class="option-content">
                            <h3 class="option-title">Cerdo a la Naranja</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                    
                    <div class="combo-option-card protein-option" data-type="protein" data-value="Birria">
                        <div class="option-content">
                            <h3 class="option-title">Birria</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                    
                    <div class="combo-option-card protein-option" data-type="protein" data-value="Champiñones">
                        <div class="option-content">
                            <h3 class="option-title">Champiñones</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sauces and Extras Section -->
            <section class="combo-section mb-5">
                <div class="row">
                    <div class="col-12">
                        <h2 class="section-title">
                            Salsas y Más 
                            <span class="selection-limit">(choose 2)</span>
                        </h2>
                    </div>
                </div>
                
                <div class="products-grid" id="sauce-grid">
                    <!-- Placeholder sauce options -->
                    <div class="combo-option-card sauce-option" data-type="sauce" data-value="Mayonesa Chipotle">
                        <div class="option-content">
                            <h3 class="option-title">Mayonesa Chipotle</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                    
                    <div class="combo-option-card sauce-option" data-type="sauce" data-value="Salsa Roja">
                        <div class="option-content">
                            <h3 class="option-title">Salsa Roja</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                    
                    <div class="combo-option-card sauce-option" data-type="sauce" data-value="Sour Cream">
                        <div class="option-content">
                            <h3 class="option-title">Sour Cream</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                    
                    <div class="combo-option-card sauce-option" data-type="sauce" data-value="Frijol Refrito">
                        <div class="option-content">
                            <h3 class="option-title">Frijol Refrito</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                    
                    <div class="combo-option-card sauce-option" data-type="sauce" data-value="Guacamole">
                        <div class="option-content">
                            <h3 class="option-title">Guacamole</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                    
                    <div class="combo-option-card sauce-option" data-type="sauce" data-value="Queso Cheddar">
                        <div class="option-content">
                            <h3 class="option-title">Queso Cheddar</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tortilla Selection Section -->
            <section class="combo-section mb-5">
                <div class="row">
                    <div class="col-12">
                        <h2 class="section-title">
                            Tortillas 
                            <span class="selection-limit">(choose 1)</span>
                        </h2>
                    </div>
                </div>
                
                <div class="products-grid" id="tortilla-grid">
                    <!-- Placeholder tortilla options -->
                    <div class="combo-option-card tortilla-option" data-type="tortilla" data-value="Tortillas de Maíz">
                        <div class="option-content">
                            <h3 class="option-title">Tortillas de Maíz</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                    
                    <div class="combo-option-card tortilla-option" data-type="tortilla" data-value="Tortillas de Harina">
                        <div class="option-content">
                            <h3 class="option-title">Tortillas de Harina</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                    
                    <div class="combo-option-card tortilla-option" data-type="tortilla" data-value="Tortillas de Nopal">
                        <div class="option-content">
                            <h3 class="option-title">Tortillas de Nopal</h3>
                            <div class="option-price">$0.00</div>
                        </div>
                    </div>
                </div>
            </section>



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
        
        document.getElementById('selected-protein').textContent = 
            selectedProtein ? selectedProtein.dataset.value : 'Ninguna seleccionada';
        
        document.getElementById('selected-sauces').textContent = 
            selectedSauces.length > 0 ? 
            Array.from(selectedSauces).map(s => s.dataset.value).join(', ') : 
            'Ninguna seleccionada';
        
        document.getElementById('selected-tortillas').textContent = 
            selectedTortillas.length > 0 ? 
            Array.from(selectedTortillas).map(t => t.dataset.value).join(', ') : 
            'Ninguna seleccionada';
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
