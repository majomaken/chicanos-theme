/**
 * Checkout Delivery Schedule Management
 * Handles delivery time slot selection and minimum order validation
 */

(function($) {
    'use strict';

    // Configuration
    const DELIVERY_MINIMUM = 30000; // $30,000 COP
    const DELIVERY_FEE = 6000; // $6,000 COP

    class CheckoutDeliveryManager {
        constructor() {
            this.init();
        }

        init() {
            this.bindEvents();
            this.validateOnLoad();
            this.hideFreeShipping();
        }

        bindEvents() {
            // Validate when cart total changes
            $(document.body).on('updated_checkout', () => {
                this.validateDeliveryMinimum();
                this.hideFreeShipping();
            });

            // Validate when delivery time slot is selected
            $('input[name="delivery_time_slot"]').on('change', () => {
                this.syncHiddenField();
                this.validateDeliveryMinimum();
                this.updateCheckoutTotals();
            });

            // Prevent checkout submission if validation fails
            $('form.checkout').on('checkout_place_order', (e) => {
                if (!this.validateDeliveryMinimum()) {
                    e.preventDefault();
                    return false;
                }
            });
        }

        validateOnLoad() {
            // Initial validation when page loads
            setTimeout(() => {
                this.validateDeliveryMinimum();
            }, 1000);
        }

        validateDeliveryMinimum() {
            const cartTotal = this.getCartTotal();
            const isDeliverySelected = this.isDeliveryTimeSlotSelected();
            const validationMessage = $('#delivery-validation-message');
            const errorMessage = validationMessage.find('.error-message');

            // Clear previous messages
            validationMessage.hide();
            errorMessage.text('');

            // Only validate if a delivery time slot is selected
            if (!isDeliverySelected) {
                return true; // Allow checkout to proceed if no delivery selected
            }

            if (cartTotal < DELIVERY_MINIMUM) {
                const remainingAmount = DELIVERY_MINIMUM - cartTotal;
                errorMessage.html(`
                    <strong>Pedido mínimo no alcanzado</strong><br>
                    Tu pedido actual es de $${this.formatCurrency(cartTotal)}.<br>
                    Para domicilio necesitas un pedido mínimo de $${this.formatCurrency(DELIVERY_MINIMUM)}.<br>
                    <strong>Te faltan $${this.formatCurrency(remainingAmount)} para completar el pedido mínimo.</strong>
                `);
                validationMessage.show();
                return false;
            }

            return true;
        }

        getCartTotal() {
            // Get cart total from WooCommerce checkout
            const totalElement = $('.woocommerce-checkout-review-order-table .cart-subtotal .amount, .woocommerce-checkout-review-order-table .order-total .amount');
            
            if (totalElement.length > 0) {
                const totalText = totalElement.first().text();
                // Extract number from currency string (e.g., "$30,000.00" -> 30000)
                const totalValue = totalText.replace(/[^\d]/g, '');
                return parseInt(totalValue) || 0;
            }

            // Fallback: try to get from order total
            const orderTotalElement = $('.woocommerce-checkout-review-order-table .order-total .amount');
            if (orderTotalElement.length > 0) {
                const totalText = orderTotalElement.text();
                const totalValue = totalText.replace(/[^\d]/g, '');
                return parseInt(totalValue) || 0;
            }

            return 0;
        }

        isDeliveryTimeSlotSelected() {
            return $('input[name="delivery_time_slot"]:checked').length > 0;
        }

        formatCurrency(amount) {
            return new Intl.NumberFormat('es-CO', {
                style: 'currency',
                currency: 'COP',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(amount);
        }

        updateCheckoutTotals() {
            // Trigger WooCommerce checkout update to recalculate totals with delivery fee
            if (typeof wc_checkout_params !== 'undefined') {
                $('body').trigger('update_checkout');
            }
        }

        syncHiddenField() {
            // Sync the hidden field with the selected delivery time slot
            const selectedSlot = $('input[name="delivery_time_slot"]:checked').val();
            $('#delivery_time_slot_hidden').val(selectedSlot || '');
        }

        hideFreeShipping() {
            // Hide free shipping when delivery fee is present
            $('.woocommerce-shipping').hide();
            $('tr.shipping').hide();
            $('td:contains("Free shipping")').hide();
            $('th:contains("Free shipping")').hide();
            
            // Also hide the entire shipping row if it contains "Free shipping"
            $('.woocommerce-checkout-review-order-table tr').each(function() {
                if ($(this).text().includes('Free shipping')) {
                    $(this).hide();
                }
            });
        }

        getSelectedDeliveryTime() {
            const selectedSlot = $('input[name="delivery_time_slot"]:checked');
            return selectedSlot.length > 0 ? selectedSlot.val() : null;
        }

        // Public method to get delivery information
        getDeliveryInfo() {
            return {
                isDeliverySelected: this.isDeliveryTimeSlotSelected(),
                selectedTimeSlot: this.getSelectedDeliveryTime(),
                cartTotal: this.getCartTotal(),
                deliveryMinimum: DELIVERY_MINIMUM,
                deliveryFee: DELIVERY_FEE,
                meetsMinimum: this.getCartTotal() >= DELIVERY_MINIMUM
            };
        }
    }

    // Initialize when document is ready
    $(document).ready(function() {
        // Only initialize on checkout page
        if ($('body').hasClass('woocommerce-checkout')) {
            window.checkoutDeliveryManager = new CheckoutDeliveryManager();
        }
    });

    // Expose for external use
    window.CheckoutDeliveryManager = CheckoutDeliveryManager;

})(jQuery);
