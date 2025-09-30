/**
 * Script global para mantener referencia de sucursal en todas las páginas
 * Se carga en todas las páginas del sitio
 */

(function($) {
    'use strict';

    // Objeto para manejo global de sucursal
    var BranchTracker = {
        
        // Inicialización
        init: function() {
            this.detectAndSetBranch();
            this.showBranchIndicator();
            this.addBranchToLinks();
        },
        
        // Detectar y establecer sucursal
        detectAndSetBranch: function() {
            var currentUrl = window.location.href;
            var branchId = null;
            
            // Buscar patrones en la URL
            if (currentUrl.indexOf('/nogal') !== -1 || 
                currentUrl.indexOf('nogal') !== -1 ||
                currentUrl.indexOf('sede-nogal') !== -1 ||
                currentUrl.indexOf('sucursal-nogal') !== -1) {
                branchId = 'nogal';
            } else if (currentUrl.indexOf('/castellana') !== -1 || 
                      currentUrl.indexOf('castellana') !== -1 ||
                      currentUrl.indexOf('sede-castellana') !== -1 ||
                      currentUrl.indexOf('sucursal-castellana') !== -1) {
                branchId = 'castellana';
            }
            
            // Verificar parámetros GET
            var urlParams = new URLSearchParams(window.location.search);
            var getBranch = urlParams.get('sucursal');
            if (getBranch && ['nogal', 'castellana'].includes(getBranch)) {
                branchId = getBranch;
            }
            
            // Si se detectó una sucursal, guardarla
            if (branchId) {
                localStorage.setItem('chicanos_selected_branch', branchId);
                sessionStorage.setItem('chicanos_selected_branch', branchId);
            }
        },
        
        // Mostrar indicador de sucursal (deshabilitado)
        showBranchIndicator: function() {
            // Función deshabilitada - no mostrar indicador visual
            return;
        },
        
        // Agregar parámetro de sucursal a enlaces internos (mejorado)
        addBranchToLinks: function() {
            var currentBranch = localStorage.getItem('chicanos_selected_branch');
            if (currentBranch) {
                // Agregar parámetro a enlaces internos, pero respetar URLs específicas de sucursal
                $('a[href^="/"], a[href*="' + window.location.hostname + '"]').each(function() {
                    var href = $(this).attr('href');
                    if (href && !href.includes('sucursal=')) {
                        // No agregar parámetro si la URL ya indica una sucursal específica
                        if (href.includes('castellana') || href.includes('nogal')) {
                            return; // Skip this link
                        }
                        
                        var separator = href.includes('?') ? '&' : '?';
                        $(this).attr('href', href + separator + 'sucursal=' + currentBranch);
                    }
                });
            }
        },
        
        // Detectar sucursal desde URL actual (SIEMPRE sobrescribe localStorage)
        detectBranchFromURL: function() {
            var currentURL = window.location.href;
            var currentPath = window.location.pathname;
            
            console.log("DEBUG JS Branch Detection:");
            console.log("- Current URL:", currentURL);
            console.log("- Current Path:", currentPath);
            
            // Detectar desde la URL actual - SIEMPRE sobrescribe localStorage
            if (currentURL.includes('castellana') || currentPath.includes('castellana')) {
                console.log("- Detected from URL: castellana (OVERRIDING localStorage)");
                localStorage.setItem('chicanos_selected_branch', 'castellana');
                sessionStorage.setItem('chicanos_selected_branch', 'castellana');
                return 'castellana';
            } else if (currentURL.includes('nogal') || currentPath.includes('nogal')) {
                console.log("- Detected from URL: nogal (OVERRIDING localStorage)");
                localStorage.setItem('chicanos_selected_branch', 'nogal');
                sessionStorage.setItem('chicanos_selected_branch', 'nogal');
                return 'nogal';
            }
            
            console.log("- No branch detected from URL");
            return null;
        },
        
        // Obtener sucursal actual
        getCurrentBranch: function() {
            // Primero intentar detectar desde URL
            var detectedBranch = this.detectBranchFromURL();
            if (detectedBranch) {
                return detectedBranch;
            }
            
            // Si no se detectó, usar localStorage
            return localStorage.getItem('chicanos_selected_branch');
        },
        
        // Establecer sucursal manualmente
        setBranch: function(branchId) {
            if (['nogal', 'castellana'].includes(branchId)) {
                localStorage.setItem('chicanos_selected_branch', branchId);
                sessionStorage.setItem('chicanos_selected_branch', branchId);
                this.showBranchIndicator();
                this.addBranchToLinks();
                return true;
            }
            return false;
        }
    };

    // Inicializar cuando el documento esté listo
    $(document).ready(function() {
        // Detectar sucursal desde URL actual primero
        BranchTracker.detectBranchFromURL();
        BranchTracker.init();
    });

    // Exponer globalmente
    window.ChicanosBranchTracker = BranchTracker;

})(jQuery);
