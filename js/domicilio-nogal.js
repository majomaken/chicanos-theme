/**
 * Domicilio Nogal Template JavaScript
 * Adds interactivity to the food categories and smooth scrolling
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        
        // Category navigation functionality
        $('.category-link').on('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all links
            $('.category-link').removeClass('active');
            
            // Add active class to clicked link
            $(this).addClass('active');
            
            // Get the target section
            var target = $(this).attr('href');
            
            // Smooth scroll to target section
            if (target.startsWith('#')) {
                var targetSection = $(target);
                if (targetSection.length) {
                    $('html, body').animate({
                        scrollTop: targetSection.offset().top - 100
                    }, 800);
                }
            }
        });

        // Highlight current category based on scroll position
        $(window).on('scroll', function() {
            var scrollTop = $(window).scrollTop();
            
            $('.products-section').each(function() {
                var sectionTop = $(this).offset().top - 150;
                var sectionBottom = sectionTop + $(this).outerHeight();
                
                if (scrollTop >= sectionTop && scrollTop < sectionBottom) {
                    var sectionId = $(this).attr('id');
                    $('.category-link').removeClass('active');
                    $('.category-link[href="#' + sectionId + '"]').addClass('active');
                }
            });
        });

        // Add hover effects to product cards
        $('.combo-card-personalizado').hover(
            function() {
                $(this).addClass('hovered');
            },
            function() {
                $(this).removeClass('hovered');
            }
        );

        // Initialize tooltips for category links
        $('.category-link').tooltip({
            placement: 'bottom',
            trigger: 'hover'
        });

        // Add loading animation for products
        function showLoadingAnimation() {
            $('.products-grid').addClass('loading');
        }

        function hideLoadingAnimation() {
            $('.products-grid').removeClass('loading');
        }

        // Handle category filtering (for future implementation)
        function filterProductsByCategory(category) {
            showLoadingAnimation();
            
            // Simulate API call delay
            setTimeout(function() {
                // Here you would implement actual filtering logic
                console.log('Filtering products by category:', category);
                hideLoadingAnimation();
            }, 500);
        }

        // Export functions for global use
        window.DomicilioNogal = {
            filterProducts: filterProductsByCategory,
            showLoading: showLoadingAnimation,
            hideLoading: hideLoadingAnimation
        };

    });

})(jQuery);
