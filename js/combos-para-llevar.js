/**
 * JavaScript para el template de Combos para Llevar
 * Maneja la selección de opciones y la lógica del combo builder
 */

class ComboBuilder {
    constructor() {
        this.init();
    }

    init() {
        this.bindEvents();
        this.updateSummary();
        this.setupAccessibility();
    }

    bindEvents() {
        // Serving size selection
        const servingSizeInputs = document.querySelectorAll('input[name="serving-size"]');
        servingSizeInputs.forEach(input => {
            input.addEventListener('change', (e) => this.handleServingSizeChange(e));
        });

        // Option selection
        const optionCards = document.querySelectorAll('.combo-option-card');
        optionCards.forEach(card => {
            card.addEventListener('click', (e) => this.handleOptionSelection(e));
            card.addEventListener('keydown', (e) => this.handleOptionKeydown(e));
        });

        // Form submission
        const form = document.getElementById('combo-builder-form');
        if (form) {
            form.addEventListener('submit', (e) => this.handleFormSubmission(e));
        }

        // Add touch support for mobile
        this.addTouchSupport();
    }

    handleServingSizeChange(event) {
        const size = event.target.value;
        const limits = this.getServingLimits(size);
        
        // Update display
        this.updateServingSizeDisplay(size);
        this.updateSelectionLimits(limits);
        
        // Reset selections
        this.resetSelections();
        
        // Update summary
        this.updateSummary();
        
        // Add visual feedback
        this.showSizeChangeFeedback(size);
    }

    handleOptionSelection(event) {
        const card = event.currentTarget;
        const type = card.dataset.type;
        const value = card.dataset.value;
        
        if (this.canSelect(type)) {
            this.toggleSelection(card, type, value);
            this.updateSummary();
            this.showSelectionFeedback(card);
        } else {
            this.showLimitReachedFeedback(type);
        }
    }

    handleOptionKeydown(event) {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            this.handleOptionSelection(event);
        }
    }

    handleFormSubmission(event) {
        event.preventDefault();
        
        const selections = this.getCurrentSelections();
        
        if (this.validateSelections(selections)) {
            this.addComboToCart(selections);
        } else {
            this.showValidationError();
        }
    }

    getServingLimits(size) {
        const limits = {
            '1-3': { protein: 1, sauce: 2, tortilla: 1 },
            '4-5': { protein: 2, sauce: 3, tortilla: 2 },
            '7-10': { protein: 3, sauce: 4, tortilla: 3 }
        };
        
        return limits[size] || limits['1-3'];
    }

    updateServingSizeDisplay(size) {
        const currentServingSize = document.getElementById('current-serving-size');
        if (currentServingSize) {
            currentServingSize.textContent = size;
        }
    }

    updateSelectionLimits(limits) {
        const proteinLimit = document.getElementById('protein-limit');
        const sauceLimit = document.getElementById('sauce-limit');
        const tortillaLimit = document.getElementById('tortilla-limit');
        
        if (proteinLimit) proteinLimit.textContent = limits.protein;
        if (sauceLimit) sauceLimit.textContent = limits.sauce;
        if (tortillaLimit) tortillaLimit.textContent = limits.tortilla;
    }

    canSelect(type) {
        const currentSize = document.querySelector('input[name="serving-size"]:checked').value;
        const limits = this.getServingLimits(currentSize);
        const currentSelected = document.querySelectorAll(`.${type}-option.selected`).length;
        
        return currentSelected < limits[type];
    }

    toggleSelection(card, type, value) {
        card.classList.toggle('selected');
        
        if (card.classList.contains('selected')) {
            card.style.backgroundColor = '#ffd700';
            card.setAttribute('aria-pressed', 'true');
        } else {
            card.style.backgroundColor = '';
            card.setAttribute('aria-pressed', 'false');
        }
    }

    resetSelections() {
        const optionCards = document.querySelectorAll('.combo-option-card');
        optionCards.forEach(card => {
            card.classList.remove('selected');
            card.style.backgroundColor = '';
            card.setAttribute('aria-pressed', 'false');
        });
    }

    updateSummary() {
        const selectedProtein = document.querySelector('.protein-option.selected');
        const selectedSauces = document.querySelectorAll('.sauce-option.selected');
        const selectedTortillas = document.querySelectorAll('.tortilla-option.selected');
        
        // Update protein
        const proteinElement = document.getElementById('selected-protein');
        if (proteinElement) {
            proteinElement.textContent = selectedProtein ? selectedProtein.dataset.value : 'Ninguna seleccionada';
        }
        
        // Update sauces
        const saucesElement = document.getElementById('selected-sauces');
        if (saucesElement) {
            saucesElement.textContent = selectedSauces.length > 0 ? 
                Array.from(selectedSauces).map(s => s.dataset.value).join(', ') : 
                'Ninguna seleccionada';
        }
        
        // Update tortillas
        const tortillasElement = document.getElementById('selected-tortillas');
        if (tortillasElement) {
            tortillasElement.textContent = selectedTortillas.length > 0 ? 
                Array.from(selectedTortillas).map(t => t.dataset.value).join(', ') : 
                'Ninguna seleccionada';
        }
        
        // Update total price
        this.updateTotalPrice();
    }

    updateTotalPrice() {
        const totalElement = document.getElementById('combo-total');
        if (!totalElement) return;
        
        // Calculate total based on selections
        let total = 0;
        const selectedOptions = document.querySelectorAll('.combo-option-card.selected');
        
        selectedOptions.forEach(option => {
            const priceText = option.querySelector('.option-price').textContent;
            const price = parseFloat(priceText.replace(/[^0-9.]/g, ''));
            if (!isNaN(price)) {
                total += price;
            }
        });
        
        totalElement.textContent = `$${total.toFixed(2)}`;
    }

    getCurrentSelections() {
        const selectedProtein = document.querySelector('.protein-option.selected');
        const selectedSauces = document.querySelectorAll('.sauce-option.selected');
        const selectedTortillas = document.querySelectorAll('.tortilla-option.selected');
        
        return {
            protein: selectedProtein ? selectedProtein.dataset.value : null,
            sauces: Array.from(selectedSauces).map(s => s.dataset.value),
            tortillas: Array.from(selectedTortillas).map(t => t.dataset.value),
            servingSize: document.querySelector('input[name="serving-size"]:checked').value
        };
    }

    validateSelections(selections) {
        const currentSize = selections.servingSize;
        const limits = this.getServingLimits(currentSize);
        
        return selections.protein && 
               selections.sauces.length >= 1 && 
               selections.tortillas.length >= 1;
    }

    addComboToCart(selections) {
        // Show loading state
        const button = document.getElementById('add-combo-to-cart');
        const originalText = button.textContent;
        button.textContent = 'Agregando...';
        button.disabled = true;
        
        // Simulate API call
        setTimeout(() => {
            // Reset button
            button.textContent = originalText;
            button.disabled = false;
            
            // Show success message
            this.showSuccessMessage();
            
            // Reset form
            this.resetSelections();
            this.updateSummary();
        }, 1500);
    }

    showSuccessMessage() {
        // Create success notification
        const notification = document.createElement('div');
        notification.className = 'success-notification';
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-check-circle"></i>
                <span>¡Combo agregado al carrito exitosamente!</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    showValidationError() {
        alert('Por favor selecciona todas las opciones requeridas para tu combo.');
    }

    showSizeChangeFeedback(size) {
        const wrapper = document.getElementById('combos-para-llevar-wrapper');
        wrapper.style.transition = 'all 0.3s ease';
        wrapper.style.transform = 'scale(1.02)';
        
        setTimeout(() => {
            wrapper.style.transform = 'scale(1)';
        }, 300);
    }

    showSelectionFeedback(card) {
        card.style.transform = 'scale(1.05)';
        setTimeout(() => {
            card.style.transform = '';
        }, 200);
    }

    showLimitReachedFeedback(type) {
        const currentSize = document.querySelector('input[name="serving-size"]:checked').value;
        const limits = this.getServingLimits(currentSize);
        const limit = limits[type];
        
        // Show tooltip or notification
        const tooltip = document.createElement('div');
        tooltip.className = 'limit-tooltip';
        tooltip.textContent = `Puedes seleccionar máximo ${limit} ${type === 'protein' ? 'proteína' : type === 'sauce' ? 'salsas' : 'tortillas'}`;
        
        document.body.appendChild(tooltip);
        
        setTimeout(() => {
            tooltip.remove();
        }, 2000);
    }

    setupAccessibility() {
        // Add ARIA labels and roles
        const optionCards = document.querySelectorAll('.combo-option-card');
        optionCards.forEach(card => {
            card.setAttribute('role', 'button');
            card.setAttribute('tabindex', '0');
            card.setAttribute('aria-pressed', 'false');
            card.setAttribute('aria-label', `Seleccionar ${card.dataset.value}`);
        });
        
        // Add keyboard navigation
        this.setupKeyboardNavigation();
    }

    setupKeyboardNavigation() {
        const optionCards = document.querySelectorAll('.combo-option-card');
        
        optionCards.forEach((card, index) => {
            card.addEventListener('keydown', (e) => {
                let nextCard;
                
                switch(e.key) {
                    case 'ArrowRight':
                        nextCard = optionCards[index + 1];
                        break;
                    case 'ArrowLeft':
                        nextCard = optionCards[index - 1];
                        break;
                    case 'ArrowDown':
                        nextCard = optionCards[index + 3]; // Assuming 3 columns
                        break;
                    case 'ArrowUp':
                        nextCard = optionCards[index - 3];
                        break;
                }
                
                if (nextCard) {
                    nextCard.focus();
                }
            });
        });
    }

    addTouchSupport() {
        let touchStartY = 0;
        let touchEndY = 0;
        
        document.addEventListener('touchstart', (e) => {
            touchStartY = e.changedTouches[0].screenY;
        });
        
        document.addEventListener('touchend', (e) => {
            touchEndY = e.changedTouches[0].screenY;
            this.handleSwipe(touchStartY, touchEndY);
        });
    }

    handleSwipe(startY, endY) {
        const threshold = 50;
        const diff = startY - endY;
        
        if (Math.abs(diff) > threshold) {
            if (diff > 0) {
                // Swipe up - could be used for quick actions
                console.log('Swipe up detected');
            } else {
                // Swipe down - could be used for quick actions
                console.log('Swipe down detected');
            }
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new ComboBuilder();
});

// Export for potential external use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ComboBuilder;
}
