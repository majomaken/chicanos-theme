/**
 * Sistema de Gestión de Sucursales - Frontend JavaScript
 * 
 * Maneja la selección de sucursales, validación de horarios y zonas de distribución
 */

(function($) {
    'use strict';

    // Objeto principal para el manejo de sucursales
    var BranchManager = {
        
        // Configuración
        config: {
            ajaxUrl: chicanos_branch_ajax.ajax_url,
            nonce: chicanos_branch_ajax.nonce,
            minAdvanceHours: 2
        },
        
        // Inicialización
        init: function() {
            this.detectBranchFromURL();
            this.bindEvents();
            this.loadBranchInfo();
        },
        
        // Detectar sucursal desde URL
        detectBranchFromURL: function() {
            var currentUrl = window.location.href;
            var branchId = null;
            
            // Buscar patrones en la URL (más específicos)
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
            
            // También verificar parámetros GET
            var urlParams = new URLSearchParams(window.location.search);
            var getBranch = urlParams.get('sucursal');
            if (getBranch && ['nogal', 'castellana'].includes(getBranch)) {
                branchId = getBranch;
            }
            
            // Si se detectó una sucursal, establecerla
            if (branchId) {
                this.setCurrentBranch(branchId);
                // Guardar en localStorage para persistencia
                localStorage.setItem('chicanos_selected_branch', branchId);
            } else {
                // Si no se detectó en URL, verificar localStorage
                var storedBranch = localStorage.getItem('chicanos_selected_branch');
                if (storedBranch && ['nogal', 'castellana'].includes(storedBranch)) {
                    this.setCurrentBranch(storedBranch);
                }
            }
        },
        
        // Establecer sucursal actual
        setCurrentBranch: function(branchId) {
            $.ajax({
                url: this.config.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'set_current_branch',
                    branch_id: branchId,
                    nonce: this.config.nonce
                },
                success: function(response) {
                    if (response.success) {
                        console.log('Sucursal establecida:', branchId);
                    }
                }
            });
        },
        
        // Vincular eventos
        bindEvents: function() {
            // Cambio en selección de sucursal
            $(document).on('change', 'input[name="branch_selection"]', function() {
                BranchManager.handleBranchChange($(this).val());
            });
            
            // Cambio en dirección de facturación
            $(document).on('change', '#billing_address_1, #billing_city', function() {
                BranchManager.validateDeliveryZone();
            });
            
        // Cambio en fecha/hora de entrega
        $(document).on('change', '#delivery_date, #delivery_time', function() {
            BranchManager.validateDeliveryTime();
        });
        
        // Cambio en fecha de entrega - cargar opciones de hora
        $(document).on('change', '#delivery_date', function() {
            var branchId = $('input[name="branch_selection"]:checked').val();
            if (branchId) {
                BranchManager.generateDeliveryTimeOptions(branchId);
            }
        });
        },
        
        // Manejar cambio de sucursal
        handleBranchChange: function(branchId) {
            if (!branchId) return;
            
            this.loadBranchInfo(branchId);
            this.validateDeliveryZone();
            this.validateDeliveryTime();
        },
        
        // Cargar información de la sucursal
        loadBranchInfo: function(branchId) {
            var self = this;
            
            $.ajax({
                url: self.config.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'get_branch_info',
                    branch_id: branchId || $('input[name="branch_selection"]:checked').val(),
                    nonce: self.config.nonce
                },
                success: function(response) {
                    if (response.success) {
                        self.displayBranchInfo(response.data);
                    }
                },
                error: function() {
                    console.error('Error al cargar información de sucursal');
                }
            });
        },
        
        // Mostrar información de la sucursal
        displayBranchInfo: function(branchInfo) {
            var infoHtml = '<div class="branch-info-card">';
            infoHtml += '<h4>' + branchInfo.name + '</h4>';
            infoHtml += '<p><strong>Dirección:</strong> ' + branchInfo.address + '</p>';
            infoHtml += '<p><strong>Estado:</strong> ';
            
            if (branchInfo.is_open) {
                infoHtml += '<span class="badge badge-success">Abierto</span>';
            } else {
                infoHtml += '<span class="badge badge-danger">Cerrado</span>';
                if (branchInfo.next_opening) {
                    infoHtml += '<br><small>Próxima apertura: ' + branchInfo.next_opening.formatted + '</small>';
                }
            }
            
            infoHtml += '</p>';
            
            // Mostrar horarios
            infoHtml += '<div class="branch-schedule">';
            infoHtml += '<h5>Horarios de atención:</h5>';
            infoHtml += '<ul class="schedule-list">';
            
            var days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            var dayNames = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
            
            for (var i = 0; i < days.length; i++) {
                var day = days[i];
                if (branchInfo.schedule[day]) {
                    var schedule = branchInfo.schedule[day];
                    infoHtml += '<li><strong>' + dayNames[i] + ':</strong> ' + schedule.start + ' - ' + schedule.end + '</li>';
                }
            }
            
            infoHtml += '</ul>';
            infoHtml += '</div>';
            
            // Mostrar zonas de distribución
            infoHtml += '<div class="delivery-zones">';
            infoHtml += '<h5>Zonas de distribución:</h5>';
            infoHtml += '<p><strong>Calles:</strong> ' + branchInfo.delivery_zones.streets.min_street + ' a ' + branchInfo.delivery_zones.streets.max_street + '</p>';
            infoHtml += '<p><strong>Carreras:</strong> ' + branchInfo.delivery_zones.streets.min_avenue + ' a ' + branchInfo.delivery_zones.streets.max_avenue + '</p>';
            infoHtml += '<p><strong>Barrios:</strong> ' + branchInfo.delivery_zones.neighborhoods.join(', ') + '</p>';
            infoHtml += '</div>';
            
            infoHtml += '</div>';
            
            $('#branch_info_display').html(infoHtml);
        },
        
        // Validar zona de distribución
        validateDeliveryZone: function() {
            var branchId = $('input[name="branch_selection"]:checked').val();
            var address = $('#billing_address_1').val();
            var city = $('#billing_city').val();
            
            if (!branchId || !address) return;
            
            var fullAddress = address + ', ' + city;
            
            $.ajax({
                url: this.config.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'validate_delivery_zone',
                    branch_id: branchId,
                    address: fullAddress,
                    nonce: this.config.nonce
                },
                success: function(response) {
                    BranchManager.showDeliveryZoneValidation(response);
                }
            });
        },
        
        // Mostrar validación de zona de distribución
        showDeliveryZoneValidation: function(response) {
            var messageHtml = '';
            
            if (response.success) {
                if (response.data.valid) {
                    messageHtml = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> ' + response.data.message + '</div>';
                } else {
                    messageHtml = '<div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> ' + response.data.message + '</div>';
                }
            } else {
                messageHtml = '<div class="alert alert-danger"><i class="fas fa-times-circle"></i> Error al validar la dirección</div>';
            }
            
            $('#delivery_zone_validation').remove();
            $('#branch_info_display').after('<div id="delivery_zone_validation">' + messageHtml + '</div>');
        },
        
        // Validar tiempo de entrega
        validateDeliveryTime: function() {
            var branchId = $('input[name="branch_selection"]:checked').val();
            var deliveryDate = $('#delivery_date').val();
            var deliveryTime = $('#delivery_time').val();
            
            if (!branchId || !deliveryDate || !deliveryTime) return;
            
            var deliveryDateTime = deliveryDate + ' ' + deliveryTime;
            
            $.ajax({
                url: this.config.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'validate_delivery_time',
                    branch_id: branchId,
                    delivery_time: deliveryDateTime,
                    nonce: this.config.nonce
                },
                success: function(response) {
                    BranchManager.showDeliveryTimeValidation(response);
                }
            });
        },
        
        // Mostrar validación de tiempo de entrega
        showDeliveryTimeValidation: function(response) {
            var messageHtml = '';
            
            if (response.success) {
                if (response.data.valid) {
                    messageHtml = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> ' + response.data.message + '</div>';
                } else {
                    messageHtml = '<div class="alert alert-danger"><i class="fas fa-times-circle"></i> ' + response.data.message + '</div>';
                }
            } else {
                messageHtml = '<div class="alert alert-danger"><i class="fas fa-times-circle"></i> Error al validar el horario</div>';
            }
            
            $('#delivery_time_validation').remove();
            $('#delivery_zone_validation').after('<div id="delivery_time_validation">' + messageHtml + '</div>');
        },
        
        // Generar opciones de tiempo de entrega
        generateDeliveryTimeOptions: function(branchId) {
            var self = this;
            var selectedDate = $('#delivery_date').val();
            
            if (!selectedDate) {
                $('#delivery_time_container select').html('<option value="">Seleccione una fecha primero</option>');
                return;
            }
            
            $.ajax({
                url: self.config.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'get_delivery_time_options',
                    branch_id: branchId,
                    delivery_date: selectedDate,
                    nonce: self.config.nonce
                },
                success: function(response) {
                    if (response.success) {
                        self.populateDeliveryTimeSelect(response.data);
                    } else {
                        $('#delivery_time_container select').html('<option value="">No hay horarios disponibles</option>');
                    }
                },
                error: function() {
                    $('#delivery_time_container select').html('<option value="">Error al cargar horarios</option>');
                }
            });
        },
        
        // Poblar select de tiempo de entrega
        populateDeliveryTimeSelect: function(timeOptions) {
            var selectHtml = '<select id="delivery_time" name="delivery_time" class="form-control" required>';
            selectHtml += '<option value="">Seleccione una hora</option>';
            
            for (var i = 0; i < timeOptions.length; i++) {
                var option = timeOptions[i];
                selectHtml += '<option value="' + option.value + '">' + option.label + '</option>';
            }
            
            selectHtml += '</select>';
            
            $('#delivery_time_container').html(selectHtml);
        },
        
        // Mostrar sucursal actual en cualquier página (deshabilitado)
        showCurrentBranch: function() {
            // Función deshabilitada - no mostrar indicador visual
            return;
        }
    };

    // Inicializar cuando el documento esté listo
    $(document).ready(function() {
        BranchManager.init();
        BranchManager.showCurrentBranch();
    });

    // Exponer objeto globalmente para uso en otros scripts
    window.ChicanosBranchManager = BranchManager;

})(jQuery);
