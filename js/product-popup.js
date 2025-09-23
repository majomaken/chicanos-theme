/**
 * Product Popup JavaScript
 * Maneja la funcionalidad de abrir y cerrar popups de productos
 */

jQuery(document).ready(function($) {
    'use strict';

    // Función para abrir popup
    function openProductPopup(productId) {
        const popup = $('#product-popup-' + productId);
        if (popup.length) {
            popup.addClass('active');
            $('body').addClass('popup-open');
            
            // Prevenir scroll del body
            $('body').css('overflow', 'hidden');
        }
    }

    // Función para cerrar popup
    function closeProductPopup() {
        $('.product-popup.active').removeClass('active');
        $('body').removeClass('popup-open');
        $('body').css('overflow', '');
    }

    // Event listener para botón de información del producto
    $(document).on('click', '.product-description-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const productId = $(this).data('product-id');
        if (productId) {
            openProductPopup(productId);
        }
    });

    // Event listener para botón de cerrar popup
    $(document).on('click', '.popup-close-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        closeProductPopup();
    });

    // Event listener para cerrar popup al hacer clic en el overlay
    $(document).on('click', '.popup-overlay', function(e) {
        e.preventDefault();
        e.stopPropagation();
        closeProductPopup();
    });

    // Event listener para cerrar popup con tecla ESC
    $(document).on('keydown', function(e) {
        if (e.keyCode === 27) { // ESC key
            closeProductPopup();
        }
    });

    // Prevenir que el clic en el contenido del popup lo cierre
    $(document).on('click', '.popup-content', function(e) {
        e.stopPropagation();
    });

    // Cerrar popup al hacer clic fuera del contenido
    $(document).on('click', '.product-popup', function(e) {
        if (e.target === this) {
            closeProductPopup();
        }
    });

    // Manejar clics en enlaces dentro del popup
    $(document).on('click', '.popup-add-btn', function(e) {
        // Permitir que el enlace funcione normalmente
        // El popup se cerrará cuando se navegue a la nueva página
    });

    // Función para cerrar todos los popups (útil para debugging)
    window.closeAllPopups = function() {
        $('.product-popup').removeClass('active');
        $('body').removeClass('popup-open');
        $('body').css('overflow', '');
    };

    // Debug: Log cuando se carga el script
    console.log('Product Popup JavaScript loaded successfully');
});
