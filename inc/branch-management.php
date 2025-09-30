<?php
/**
 * Sistema de Gestión de Sucursales
 * 
 * Maneja las sucursales de Chicanos con sus horarios, zonas de distribución
 * y configuraciones de email.
 *
 * @package Chicanos_Theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Clase principal para el manejo de sucursales
 */
class Chicanos_Branch_Management {
    
    /**
     * Configuración de sucursales
     */
    private static $branches = array(
        'nogal' => array(
            'name' => 'Nogal (11 con 78)',
            'email' => 'contacto@chicanos.com.co',
            'address' => 'Calle 11 #78-00, Bogotá',
            'delivery_zones' => array(
                'streets' => array(
                    'min_street' => 45,
                    'max_street' => 150,
                    'min_avenue' => 0,
                    'max_avenue' => 30
                ),
                'neighborhoods' => array(
                    'Retiro',
                    'Nogal',
                    'Chapinero',
                    'Chico',
                    'Rosales',
                    'Parkway',
                    'Nicolas de Federman',
                    'Gallerias',
                    'Cedritos',
                    'Santa Barbara',
                    'Santa Ana'
                )
            ),
            'schedule' => array(
                'monday' => array('start' => '11:00', 'end' => '18:00'),
                'tuesday' => array('start' => '11:00', 'end' => '18:00'),
                'wednesday' => array('start' => '11:00', 'end' => '18:00'),
                'thursday' => array('start' => '11:00', 'end' => '18:00'),
                'friday' => array('start' => '11:00', 'end' => '19:00'),
                'saturday' => array('start' => '11:00', 'end' => '19:00'),
                'sunday' => array('start' => '11:00', 'end' => '16:00')
            )
        ),
        'castellana' => array(
            'name' => 'Castellana',
            'email' => 'castellana@chicanos.com.co',
            'address' => 'Carrera Castellana, Bogotá',
            'delivery_zones' => array(
                'streets' => array(
                    'min_street' => 94,
                    'max_street' => 170,
                    'min_avenue' => 30,
                    'max_avenue' => 100 // Asumiendo que va hasta la 100
                ),
                'neighborhoods' => array(
                    'Suba',
                    'Cedritos',
                    'San Jose de Bavaria',
                    'La Floresta',
                    'Colin Campestre',
                    'Lagos de Cordoba',
                    'Salitre',
                    'Rio Negro',
                    'Santa Barbara',
                    'Santa Ana'
                )
            ),
            'schedule' => array(
                'monday' => array('start' => '11:00', 'end' => '18:00'),
                'tuesday' => array('start' => '11:00', 'end' => '18:00'),
                'wednesday' => array('start' => '11:00', 'end' => '18:00'),
                'thursday' => array('start' => '11:00', 'end' => '18:00'),
                'friday' => array('start' => '10:00', 'end' => '18:00'),
                'saturday' => array('start' => '10:00', 'end' => '18:00'),
                'sunday' => array('start' => '10:00', 'end' => '15:00')
            )
        )
    );
    
    /**
     * Obtener todas las sucursales
     */
    public static function get_branches() {
        return self::$branches;
    }
    
    /**
     * Obtener una sucursal específica
     */
    public static function get_branch($branch_id) {
        return isset(self::$branches[$branch_id]) ? self::$branches[$branch_id] : null;
    }
    
    /**
     * Obtener el email de una sucursal
     */
    public static function get_branch_email($branch_id) {
        $branch = self::get_branch($branch_id);
        return $branch ? $branch['email'] : null;
    }
    
    /**
     * Verificar si una dirección está en la zona de distribución de una sucursal
     */
    public static function is_address_in_delivery_zone($address, $branch_id) {
        $branch = self::get_branch($branch_id);
        if (!$branch) {
            return false;
        }
        
        $zones = $branch['delivery_zones'];
        
        // Extraer números de calle y carrera de la dirección
        $street_number = self::extract_street_number($address);
        $avenue_number = self::extract_avenue_number($address);
        
        // Verificar si está en el rango de calles y carreras
        if ($street_number && $avenue_number) {
            $street_in_range = ($street_number >= $zones['streets']['min_street'] && 
                              $street_number <= $zones['streets']['max_street']);
            $avenue_in_range = ($avenue_number >= $zones['streets']['min_avenue'] && 
                               $avenue_number <= $zones['streets']['max_avenue']);
            
            return $street_in_range && $avenue_in_range;
        }
        
        // Si no se pueden extraer números, verificar por barrios
        $address_lower = strtolower($address);
        foreach ($zones['neighborhoods'] as $neighborhood) {
            if (strpos($address_lower, strtolower($neighborhood)) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Extraer número de calle de una dirección
     */
    private static function extract_street_number($address) {
        // Buscar patrones como "Calle 45", "Calle 78", etc.
        if (preg_match('/calle\s+(\d+)/i', $address, $matches)) {
            return intval($matches[1]);
        }
        return null;
    }
    
    /**
     * Extraer número de carrera de una dirección
     */
    private static function extract_avenue_number($address) {
        // Buscar patrones como "Carrera 15", "Carrera 30", etc.
        if (preg_match('/carrera\s+(\d+)/i', $address, $matches)) {
            return intval($matches[1]);
        }
        return null;
    }
    
    /**
     * Verificar si una sucursal está abierta en un día y hora específicos
     */
    public static function is_branch_open($branch_id, $day = null, $time = null) {
        $branch = self::get_branch($branch_id);
        if (!$branch) {
            return false;
        }
        
        // Configurar zona horaria de Colombia
        $original_timezone = date_default_timezone_get();
        date_default_timezone_set('America/Bogota');
        
        // Usar día y hora actual si no se especifican
        if (!$day) {
            $day = strtolower(date('l')); // monday, tuesday, etc.
        }
        if (!$time) {
            $time = date('H:i');
        }
        
        // Debug: Log para verificar valores
        error_log("DEBUG Branch Open Check:");
        error_log("- Branch ID: " . $branch_id);
        error_log("- Day: " . $day);
        error_log("- Time: " . $time);
        error_log("- Timezone: " . date_default_timezone_get());
        error_log("- Schedule for day: " . print_r($branch['schedule'][$day] ?? 'NOT FOUND', true));
        
        // Verificar si el día existe en el horario
        if (!isset($branch['schedule'][$day])) {
            error_log("- Day not found in schedule");
            date_default_timezone_set($original_timezone);
            return false;
        }
        
        $schedule = $branch['schedule'][$day];
        
        // Convertir tiempos a formato comparable usando DateTime para mayor precisión
        $current_datetime = DateTime::createFromFormat('H:i', $time);
        $start_datetime = DateTime::createFromFormat('H:i', $schedule['start']);
        $end_datetime = DateTime::createFromFormat('H:i', $schedule['end']);
        
        if (!$current_datetime || !$start_datetime || !$end_datetime) {
            error_log("- Error creating DateTime objects");
            date_default_timezone_set($original_timezone);
            return false;
        }
        
        // Comparar usando DateTime
        $is_open = ($current_datetime >= $start_datetime && $current_datetime <= $end_datetime);
        
        error_log("- Current time: " . $current_datetime->format('H:i:s'));
        error_log("- Start time: " . $start_datetime->format('H:i:s'));
        error_log("- End time: " . $end_datetime->format('H:i:s'));
        error_log("- Is open: " . ($is_open ? 'YES' : 'NO'));
        
        // Restaurar zona horaria original
        date_default_timezone_set($original_timezone);
        
        return $is_open;
    }
    
    /**
     * Obtener el próximo horario de apertura de una sucursal
     */
    public static function get_next_opening_time($branch_id) {
        $branch = self::get_branch($branch_id);
        if (!$branch) {
            return null;
        }
        
        // Configurar zona horaria de Colombia
        $original_timezone = date_default_timezone_get();
        date_default_timezone_set('America/Bogota');
        
        $current_day = strtolower(date('l'));
        $current_time = date('H:i');
        $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
        
        // Buscar desde hoy hasta el próximo día de apertura
        for ($i = 0; $i < 7; $i++) {
            $day_index = (array_search($current_day, $days) + $i) % 7;
            $day = $days[$day_index];
            
            if (isset($branch['schedule'][$day])) {
                $schedule = $branch['schedule'][$day];
                
                // Si es hoy y aún no ha pasado la hora de apertura
                if ($i === 0 && $current_time < $schedule['start']) {
                    date_default_timezone_set($original_timezone);
                    return array(
                        'day' => $day,
                        'time' => $schedule['start'],
                        'formatted' => ucfirst($day) . ' a las ' . $schedule['start']
                    );
                }
                
                // Si es un día futuro
                if ($i > 0) {
                    date_default_timezone_set($original_timezone);
                    return array(
                        'day' => $day,
                        'time' => $schedule['start'],
                        'formatted' => ucfirst($day) . ' a las ' . $schedule['start']
                    );
                }
            }
        }
        
        // Restaurar zona horaria original
        date_default_timezone_set($original_timezone);
        return null;
    }
    
    /**
     * Validar si se puede hacer un pedido con anticipación de 2 horas
     */
    public static function can_place_order($branch_id, $delivery_time = null) {
        if (!$delivery_time) {
            $delivery_time = date('H:i', strtotime('+2 hours'));
        }
        
        $delivery_timestamp = strtotime($delivery_time);
        $current_timestamp = time();
        $two_hours_from_now = strtotime('+2 hours');
        
        // Verificar que el tiempo de entrega sea al menos 2 horas en el futuro
        if ($delivery_timestamp < $two_hours_from_now) {
            return array(
                'valid' => false,
                'message' => 'Debe pedir con al menos 2 horas de anticipación'
            );
        }
        
        // Verificar que la sucursal esté abierta en el momento de entrega
        $delivery_day = strtolower(date('l', $delivery_timestamp));
        $delivery_time_formatted = date('H:i', $delivery_timestamp);
        
        if (!self::is_branch_open($branch_id, $delivery_day, $delivery_time_formatted)) {
            $next_opening = self::get_next_opening_time($branch_id);
            return array(
                'valid' => false,
                'message' => 'La sucursal estará cerrada en ese horario. Próxima apertura: ' . $next_opening['formatted']
            );
        }
        
        return array(
            'valid' => true,
            'message' => 'Pedido válido'
        );
    }
    
    /**
     * Obtener opciones de sucursales para formularios
     */
    public static function get_branch_options() {
        $options = array();
        foreach (self::$branches as $id => $branch) {
            $options[$id] = $branch['name'];
        }
        return $options;
    }
    
    /**
     * Obtener información completa de una sucursal para mostrar al usuario
     */
    public static function get_branch_info($branch_id) {
        $branch = self::get_branch($branch_id);
        if (!$branch) {
            return null;
        }
        
        $is_open = self::is_branch_open($branch_id);
        $next_opening = self::get_next_opening_time($branch_id);
        
        return array(
            'id' => $branch_id,
            'name' => $branch['name'],
            'email' => $branch['email'],
            'address' => $branch['address'],
            'is_open' => $is_open,
            'next_opening' => $next_opening,
            'delivery_zones' => $branch['delivery_zones'],
            'schedule' => $branch['schedule']
        );
    }
    
    /**
     * Detectar la sucursal actual desde URL o sesión
     */
    public static function detect_current_branch() {
        // Iniciar sesión si no está iniciada
        if (!session_id()) {
            session_start();
        }
        
        // Detectar desde URL primero (prioridad máxima - siempre sobrescribe)
        $current_url = $_SERVER['REQUEST_URI'];
        $branch_id = null;
        
        // Debug: Log para verificar detección
        error_log("DEBUG Branch Detection:");
        error_log("- Current URL: " . $current_url);
        
        // Buscar patrones en la URL (más específicos) - PRIORIDAD MÁXIMA
        if (strpos($current_url, '/castellana') !== false || 
            strpos($current_url, 'castellana') !== false ||
            strpos($current_url, 'sede-castellana') !== false ||
            strpos($current_url, 'sucursal-castellana') !== false ||
            strpos($current_url, 'domicilio-castellana') !== false) {
            $branch_id = 'castellana';
            error_log("- Detected from URL: castellana (OVERRIDING session)");
        } elseif (strpos($current_url, '/nogal') !== false || 
                  strpos($current_url, 'nogal') !== false ||
                  strpos($current_url, 'sede-nogal') !== false ||
                  strpos($current_url, 'sucursal-nogal') !== false ||
                  strpos($current_url, 'domicilio-nogal') !== false) {
            $branch_id = 'nogal';
            error_log("- Detected from URL: nogal (OVERRIDING session)");
        }
        
        // Si se detectó desde URL, SIEMPRE sobrescribir sesión
        if ($branch_id && self::get_branch($branch_id)) {
            $_SESSION['selected_branch'] = $branch_id;
            error_log("- URL detection OVERRIDES session. New branch: " . $branch_id);
            return $branch_id;
        }
        
        // Si no se detectó desde URL, verificar parámetros GET
        if (isset($_GET['sucursal'])) {
            $get_branch = sanitize_text_field($_GET['sucursal']);
            if (in_array($get_branch, ['nogal', 'castellana'])) {
                $branch_id = $get_branch;
                $_SESSION['selected_branch'] = $branch_id;
                error_log("- Detected from GET parameter: " . $branch_id);
                return $branch_id;
            }
        }
        
        // Si no se detectó nada, verificar sesión
        if (isset($_SESSION['selected_branch'])) {
            $branch_id = $_SESSION['selected_branch'];
            error_log("- Using session: " . $branch_id);
            return $branch_id;
        }
        
        error_log("- No branch detected");
        return null;
    }
    
    /**
     * Obtener la sucursal actualmente seleccionada
     */
    public static function get_current_branch() {
        if (!session_id()) {
            session_start();
        }
        
        // Primero intentar detectar automáticamente
        $detected_branch = self::detect_current_branch();
        if ($detected_branch) {
            return $detected_branch;
        }
        
        // Si no se detectó, usar sesión
        return isset($_SESSION['selected_branch']) ? $_SESSION['selected_branch'] : null;
    }
    
    /**
     * Establecer sucursal actual
     */
    public static function set_current_branch($branch_id) {
        if (!session_id()) {
            session_start();
        }
        
        if (self::get_branch($branch_id)) {
            $_SESSION['selected_branch'] = $branch_id;
            error_log("Branch manually set to: " . $branch_id);
            return true;
        }
        
        return false;
    }
    
    /**
     * Limpiar selección de sucursal (forzar nueva detección)
     */
    public static function clear_branch_selection() {
        if (!session_id()) {
            session_start();
        }
        
        unset($_SESSION['selected_branch']);
        error_log("Branch selection cleared - will detect from URL");
        return true;
    }
}

// Inicializar el sistema
add_action('init', function() {
    // Registrar hooks para WooCommerce si está activo
    if (class_exists('WooCommerce')) {
        Chicanos_Branch_Management_Hooks::init();
    }
    
    // Detectar sucursal desde URL o sesión
    Chicanos_Branch_Management::detect_current_branch();
    
    // Agregar shortcode para pruebas
    add_shortcode('test_branches', function() {
        if (class_exists('Chicanos_Branch_Management')) {
            $branches = Chicanos_Branch_Management::get_branches();
            $output = '<h3>Sucursales disponibles:</h3><ul>';
            foreach ($branches as $id => $branch) {
                $output .= '<li><strong>' . $branch['name'] . '</strong> - ' . $branch['email'] . '</li>';
            }
            $output .= '</ul>';
            return $output;
        }
        return 'Sistema de sucursales no disponible';
    });
    
    // Shortcode para mostrar sucursal actual
    add_shortcode('current_branch', function() {
        if (class_exists('Chicanos_Branch_Management')) {
            $current_branch = Chicanos_Branch_Management::get_current_branch();
            if ($current_branch) {
                $branch_info = Chicanos_Branch_Management::get_branch_info($current_branch);
                if ($branch_info) {
                    $output = '<div class="current-branch-display">';
                    $output .= '<h4>Sucursal actual: ' . $branch_info['name'] . '</h4>';
                    $output .= '<p><strong>Dirección:</strong> ' . $branch_info['address'] . '</p>';
                    $output .= '<p><strong>Estado:</strong> ';
                    if ($branch_info['is_open']) {
                        $output .= '<span class="badge badge-success">Abierto</span>';
                    } else {
                        $output .= '<span class="badge badge-danger">Cerrado</span>';
                    }
                    $output .= '</p>';
                    $output .= '</div>';
                    return $output;
                }
            }
            return '<p>No hay sucursal seleccionada</p>';
        }
        return 'Sistema no disponible';
    });
    
    // Agregar información de sucursal al header
    add_action('wp_head', function() {
        if (class_exists('Chicanos_Branch_Management')) {
            $current_branch = Chicanos_Branch_Management::get_current_branch();
            if ($current_branch) {
                echo '<meta name="current-branch" content="' . esc_attr($current_branch) . '">';
            }
        }
    });
    
    // Desactivar template personalizado de WooCommerce para evitar duplicaciones
    // add_filter('wc_get_template', function($template, $template_name, $args, $template_path) {
    //     if ($template_name === 'checkout/form-checkout.php') {
    //         $custom_template = get_template_directory() . '/woocommerce/checkout/form-checkout-chicanos.php';
    //         if (file_exists($custom_template)) {
    //             return $custom_template;
    //         }
    //     }
    //     return $template;
    // }, 10, 4);
    
    // Agregar campos personalizados al checkout
    add_action('woocommerce_checkout_process', function() {
        // Validar campos personalizados
        if (empty($_POST['branch_selection'])) {
            wc_add_notice('Por favor seleccione una sucursal de entrega.', 'error');
        }
    });
    
    // Guardar campos personalizados en la orden
    add_action('woocommerce_checkout_update_order_meta', function($order_id) {
        if (!empty($_POST['branch_selection'])) {
            update_post_meta($order_id, '_branch_selection', sanitize_text_field($_POST['branch_selection']));
            
            // Guardar información adicional de la sucursal
            $branch_info = Chicanos_Branch_Management::get_branch_info($_POST['branch_selection']);
            if ($branch_info) {
                update_post_meta($order_id, '_branch_name', $branch_info['name']);
                update_post_meta($order_id, '_branch_email', $branch_info['email']);
                update_post_meta($order_id, '_branch_address', $branch_info['address']);
                update_post_meta($order_id, '_delivery_date', date('Y-m-d')); // Fecha actual
                update_post_meta($order_id, '_delivery_time', 'Lo más pronto posible');
            }
        }
    });
    
});

// Métodos estáticos para hooks de WooCommerce
if (!class_exists('Chicanos_Branch_Management_Hooks')) {
    class Chicanos_Branch_Management_Hooks {
        
        /**
         * Inicializar hooks de WooCommerce
         */
        public static function init() {
            // Validar selección de sucursal
            add_action('woocommerce_checkout_process', array(__CLASS__, 'validate_branch_selection'));
            
            // Guardar información de sucursal en la orden
            add_action('woocommerce_checkout_update_order_meta', array(__CLASS__, 'save_branch_info_to_order'));
            
            // Enviar email a la sucursal correspondiente
            add_action('woocommerce_new_order', array(__CLASS__, 'send_branch_notification'));
            
            // Mostrar información de sucursal en admin y emails
            add_action('woocommerce_admin_order_data_after_billing_address', array(__CLASS__, 'display_branch_info_in_admin'));
            add_filter('woocommerce_order_formatted_billing_address', array(__CLASS__, 'add_branch_info_to_billing_address'));
        }
        
        /**
         * Agregar campo de selección de sucursal al checkout
         * NOTA: Este método ya no se usa porque la selección está directamente en el template
         */
        public static function add_branch_selection_field($checkout) {
            // La selección de sucursal ahora está directamente en el template form-checkout.php
            // Este método se mantiene por compatibilidad pero no se ejecuta
        }
        
        /**
         * Validar selección de sucursal
         */
        public static function validate_branch_selection() {
            if (empty($_POST['branch_selection'])) {
                wc_add_notice('Por favor seleccione una sucursal de entrega.', 'error');
            }
        }
        
        /**
         * Guardar información de sucursal en la orden
         */
        public static function save_branch_info_to_order($order_id) {
            if (!empty($_POST['branch_selection'])) {
                $branch_id = sanitize_text_field($_POST['branch_selection']);
                $branch_info = Chicanos_Branch_Management::get_branch_info($branch_id);
                
                if ($branch_info) {
                    update_post_meta($order_id, '_branch_id', $branch_id);
                    update_post_meta($order_id, '_branch_name', $branch_info['name']);
                    update_post_meta($order_id, '_branch_email', $branch_info['email']);
                }
            }
            
            // Guardar información de fecha y hora de entrega
            if (!empty($_POST['delivery_date'])) {
                update_post_meta($order_id, '_delivery_date', sanitize_text_field($_POST['delivery_date']));
            }
            
            if (!empty($_POST['delivery_time'])) {
                update_post_meta($order_id, '_delivery_time', sanitize_text_field($_POST['delivery_time']));
            }
        }
        
        /**
         * Enviar notificación a la sucursal correspondiente
         */
        public static function send_branch_notification($order_id) {
            $branch_email = get_post_meta($order_id, '_branch_email', true);
            $branch_name = get_post_meta($order_id, '_branch_name', true);
            
            if ($branch_email && $branch_name) {
                $order = wc_get_order($order_id);
                
                // Crear email personalizado para la sucursal
                $subject = 'Nuevo pedido para ' . $branch_name . ' - #' . $order_id;
                $message = self::create_branch_notification_message($order, $branch_name);
                
                // Enviar email
                wp_mail($branch_email, $subject, $message, array('Content-Type: text/html; charset=UTF-8'));
            }
        }
        
        /**
         * Crear mensaje de notificación para la sucursal
         */
        private static function create_branch_notification_message($order, $branch_name) {
            $customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
            $customer_address = $order->get_formatted_billing_address();
            $order_total = $order->get_formatted_order_total();
            
            // Obtener información de entrega
            $delivery_date = get_post_meta($order->get_id(), '_delivery_date', true);
            $delivery_time = get_post_meta($order->get_id(), '_delivery_time', true);
            
            $message = '<h2>Nuevo Pedido para ' . $branch_name . '</h2>';
            $message .= '<p><strong>Pedido #:</strong> ' . $order->get_id() . '</p>';
            $message .= '<p><strong>Cliente:</strong> ' . $customer_name . '</p>';
            $message .= '<p><strong>Dirección:</strong> ' . $customer_address . '</p>';
            $message .= '<p><strong>Total:</strong> ' . $order_total . '</p>';
            $message .= '<p><strong>Fecha del pedido:</strong> ' . $order->get_date_created()->format('Y-m-d H:i:s') . '</p>';
            
            if ($delivery_date && $delivery_time) {
                $message .= '<p><strong>Fecha de entrega:</strong> ' . date('d/m/Y', strtotime($delivery_date)) . '</p>';
                $message .= '<p><strong>Hora de entrega:</strong> ' . date('H:i', strtotime($delivery_time)) . '</p>';
            }
            
            $message .= '<h3>Productos:</h3>';
            $message .= '<ul>';
            foreach ($order->get_items() as $item) {
                $message .= '<li>' . $item->get_name() . ' x' . $item->get_quantity() . '</li>';
            }
            $message .= '</ul>';
            
            return $message;
        }
        
        /**
         * Mostrar información de sucursal en el admin
         */
        public static function display_branch_info_in_admin($order) {
            $branch_name = get_post_meta($order->get_id(), '_branch_name', true);
            $delivery_date = get_post_meta($order->get_id(), '_delivery_date', true);
            $delivery_time = get_post_meta($order->get_id(), '_delivery_time', true);
            
            if ($branch_name) {
                echo '<p><strong>Sucursal de entrega:</strong> ' . $branch_name . '</p>';
            }
            
            if ($delivery_date && $delivery_time) {
                echo '<p><strong>Fecha de entrega:</strong> ' . date('d/m/Y', strtotime($delivery_date)) . '</p>';
                echo '<p><strong>Hora de entrega:</strong> ' . date('H:i', strtotime($delivery_time)) . '</p>';
            }
        }
        
        /**
         * Agregar información de sucursal a la dirección de facturación
         */
        public static function add_branch_info_to_billing_address($address) {
            global $post;
            if ($post && $post->post_type === 'shop_order') {
                $branch_name = get_post_meta($post->ID, '_branch_name', true);
                if ($branch_name) {
                    $address['branch'] = 'Sucursal: ' . $branch_name;
                }
            }
            return $address;
        }
    }
}
