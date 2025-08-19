/**
 * Mobile Menu Functionality
 * Handles the mobile hamburger menu toggle and interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileMenu = document.querySelector('#mobileMenu');
    const body = document.body;

    if (mobileMenuToggle && mobileMenu) {
        // Prevent Bootstrap from handling the toggle
        mobileMenuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Detener la propagación del evento
            
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            // Toggle aria-expanded
            this.setAttribute('aria-expanded', !isExpanded);
            
            // Toggle menu visibility
            if (isExpanded) {
                // Cerrar menú
                mobileMenu.classList.remove('show');
                body.style.overflow = '';
                
                // Remover clase de Bootstrap que pueda estar interfiriendo
                mobileMenu.classList.remove('collapsing');
                mobileMenu.classList.remove('show');
                
                // Forzar el estado colapsado
                setTimeout(() => {
                    mobileMenu.style.display = 'none';
                }, 300); // Después de la transición CSS
            } else {
                // Abrir menú
                mobileMenu.style.display = 'block';
                mobileMenu.classList.add('show');
                body.style.overflow = 'hidden';
            }
        });

        // Close menu when clicking on menu items
        const mobileMenuLinks = mobileMenu.querySelectorAll('.nav-link');
        mobileMenuLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // NO usar preventDefault aquí para que los enlaces funcionen
                // e.preventDefault(); // ← Esta línea estaba bloqueando los enlaces
                e.stopPropagation();
                
                // Pequeño delay para que el usuario vea que se hizo clic
                setTimeout(() => {
                    mobileMenuToggle.setAttribute('aria-expanded', 'false');
                    mobileMenu.classList.remove('show');
                    body.style.overflow = '';
                    
                    // Forzar el estado colapsado
                    setTimeout(() => {
                        mobileMenu.style.display = 'none';
                    }, 300);
                }, 100); // 100ms de delay
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!mobileMenuToggle.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
                mobileMenu.classList.remove('show');
                body.style.overflow = '';
                
                // Forzar el estado colapsado
                setTimeout(() => {
                    mobileMenu.style.display = 'none';
                }, 300);
            }
        });

        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
                mobileMenu.classList.remove('show');
                body.style.overflow = '';
                
                // Forzar el estado colapsado
                setTimeout(() => {
                    mobileMenu.style.display = 'none';
                }, 300);
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 767.98) {
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
                mobileMenu.classList.remove('show');
                body.style.overflow = '';
                mobileMenu.style.display = 'none';
            }
        });

        // Prevent Bootstrap collapse from interfering
        mobileMenu.addEventListener('show.bs.collapse', function(e) {
            e.preventDefault();
        });

        mobileMenu.addEventListener('hide.bs.collapse', function(e) {
            e.preventDefault();
        });
    }
});
