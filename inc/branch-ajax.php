<?php
/**
 * AJAX Handlers para el Sistema de Gestión de Sucursales
 * 
 * Maneja las peticiones AJAX del frontend para validaciones y consultas
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Clase para manejar las peticiones AJAX
 */
class Chicanos_Branch_AJAX {
    
    /**
     * Inicializar hooks AJAX
     */
    public static function init() {
        // Obtener información de sucursal
        add_action('wp_ajax_get_branch_info', array(__CLASS__, 'get_branch_info'));
        add_action('wp_ajax_nopriv_get_branch_info', array(__CLASS__, 'get_branch_info'));
        
        // Validar zona de distribución
        add_action('wp_ajax_validate_delivery_zone', array(__CLASS__, 'validate_delivery_zone'));
        add_action('wp_ajax_nopriv_validate_delivery_zone', array(__CLASS__, 'validate_delivery_zone'));
        
        // Validar tiempo de entrega
        add_action('wp_ajax_validate_delivery_time', array(__CLASS__, 'validate_delivery_time'));
        add_action('wp_ajax_nopriv_validate_delivery_time', array(__CLASS__, 'validate_delivery_time'));
        
        // Obtener opciones de tiempo de entrega
        add_action('wp_ajax_get_delivery_time_options', array(__CLASS__, 'get_delivery_time_options'));
        add_action('wp_ajax_nopriv_get_delivery_time_options', array(__CLASS__, 'get_delivery_time_options'));
        
        // Establecer sucursal actual
        add_action('wp_ajax_set_current_branch', array(__CLASS__, 'set_current_branch'));
        add_action('wp_ajax_nopriv_set_current_branch', array(__CLASS__, 'set_current_branch'));
        
        // Enqueue scripts y estilos
        add_action('wp_enqueue_scripts', array(__CLASS__, 'enqueue_scripts'));
    }
    
    /**
     * Enqueue scripts y estilos necesarios
     */
    public static function enqueue_scripts() {
        // Script global para todas las páginas
        $tracker_file = get_template_directory() . '/js/branch-tracker.js';
        if (file_exists($tracker_file)) {
            wp_enqueue_script(
                'chicanos-branch-tracker',
                get_template_directory_uri() . '/js/branch-tracker.js',
                array('jquery'),
                '1.0.0',
                true
            );
        }
        
        // Scripts específicos para checkout
        if (is_checkout()) {
            // Verificar que los archivos existan
            $js_file = get_template_directory() . '/js/branch-management.js';
            $css_file = get_template_directory() . '/css/branch-management.css';
            
            if (file_exists($js_file)) {
                wp_enqueue_script(
                    'chicanos-branch-management',
                    get_template_directory_uri() . '/js/branch-management.js',
                    array('jquery'),
                    '1.0.0',
                    true
                );
                
                // Localizar script con datos AJAX
                wp_localize_script('chicanos-branch-management', 'chicanos_branch_ajax', array(
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce('chicanos_branch_nonce')
                ));
            }
            
            if (file_exists($css_file)) {
                wp_enqueue_style(
                    'chicanos-branch-management',
                    get_template_directory_uri() . '/css/branch-management.css',
                    array(),
                    '1.0.0'
                );
            }
        }
    }
    
    /**
     * Obtener información de una sucursal
     */
    public static function get_branch_info() {
        // Verificar nonce
        if (!wp_verify_nonce($_POST['nonce'], 'chicanos_branch_nonce')) {
            wp_send_json_error('Nonce verification failed');
        }
        
        $branch_id = sanitize_text_field($_POST['branch_id']);
        
        if (empty($branch_id)) {
            wp_send_json_error('Branch ID is required');
        }
        
        $branch_info = Chicanos_Branch_Management::get_branch_info($branch_id);
        
        if ($branch_info) {
            wp_send_json_success($branch_info);
        } else {
            wp_send_json_error('Branch not found');
        }
    }
    
    /**
     * Validar zona de distribución
     */
    public static function validate_delivery_zone() {
        // Verificar nonce
        if (!wp_verify_nonce($_POST['nonce'], 'chicanos_branch_nonce')) {
            wp_send_json_error('Nonce verification failed');
        }
        
        $branch_id = sanitize_text_field($_POST['branch_id']);
        $address = sanitize_text_field($_POST['address']);
        
        if (empty($branch_id) || empty($address)) {
            wp_send_json_error('Branch ID and address are required');
        }
        
        $is_valid = Chicanos_Branch_Management::is_address_in_delivery_zone($address, $branch_id);
        
        if ($is_valid) {
            wp_send_json_success(array(
                'valid' => true,
                'message' => 'Su dirección está dentro de la zona de distribución de esta sucursal.'
            ));
        } else {
            $branch = Chicanos_Branch_Management::get_branch($branch_id);
            $message = 'Su dirección no está dentro de la zona de distribución de esta sucursal. ';
            $message .= 'Zona de cobertura: Calles ' . $branch['delivery_zones']['streets']['min_street'] . ' a ' . $branch['delivery_zones']['streets']['max_street'] . ', ';
            $message .= 'Carreras ' . $branch['delivery_zones']['streets']['min_avenue'] . ' a ' . $branch['delivery_zones']['streets']['max_avenue'] . '.';
            
            wp_send_json_success(array(
                'valid' => false,
                'message' => $message
            ));
        }
    }
    
    /**
     * Validar tiempo de entrega
     */
    public static function validate_delivery_time() {
        // Verificar nonce
        if (!wp_verify_nonce($_POST['nonce'], 'chicanos_branch_nonce')) {
            wp_send_json_error('Nonce verification failed');
        }
        
        $branch_id = sanitize_text_field($_POST['branch_id']);
        $delivery_time = sanitize_text_field($_POST['delivery_time']);
        
        if (empty($branch_id) || empty($delivery_time)) {
            wp_send_json_error('Branch ID and delivery time are required');
        }
        
        $validation = Chicanos_Branch_Management::can_place_order($branch_id, $delivery_time);
        
        wp_send_json_success($validation);
    }
    
    /**
     * Obtener opciones de tiempo de entrega
     */
    public static function get_delivery_time_options() {
        // Verificar nonce
        if (!wp_verify_nonce($_POST['nonce'], 'chicanos_branch_nonce')) {
            wp_send_json_error('Nonce verification failed');
        }
        
        $branch_id = sanitize_text_field($_POST['branch_id']);
        $delivery_date = sanitize_text_field($_POST['delivery_date']);
        
        if (empty($branch_id)) {
            wp_send_json_error('Branch ID is required');
        }
        
        $branch = Chicanos_Branch_Management::get_branch($branch_id);
        
        if (!$branch) {
            wp_send_json_error('Branch not found');
        }
        
        $options = self::generate_delivery_time_options($branch, $delivery_date);
        
        wp_send_json_success($options);
    }
    
    /**
     * Generar opciones de tiempo de entrega
     */
    private static function generate_delivery_time_options($branch, $delivery_date = null) {
        $options = array();
        $current_time = time();
        $two_hours_from_now = $current_time + (2 * 3600); // 2 horas en el futuro
        
        // Si se especifica una fecha, generar opciones solo para esa fecha
        if ($delivery_date) {
            $target_timestamp = strtotime($delivery_date);
            $day_name = strtolower(date('l', $target_timestamp));
            
            // Verificar si la sucursal está abierta este día
            if (!isset($branch['schedule'][$day_name])) {
                return $options;
            }
            
            $schedule = $branch['schedule'][$day_name];
            $start_time = strtotime($delivery_date . ' ' . $schedule['start']);
            $end_time = strtotime($delivery_date . ' ' . $schedule['end']);
            
            // Si es hoy, ajustar el tiempo de inicio
            if (date('Y-m-d', $target_timestamp) === date('Y-m-d')) {
                $start_time = max($start_time, $two_hours_from_now);
            }
            
            // Generar slots de 30 minutos
            $slot_duration = 30 * 60; // 30 minutos en segundos
            
            for ($time = $start_time; $time < $end_time; $time += $slot_duration) {
                $time_formatted = date('H:i', $time);
                
                $options[] = array(
                    'value' => $delivery_date . ' ' . $time_formatted,
                    'label' => $time_formatted
                );
            }
        } else {
            // Generar opciones para los próximos 7 días (comportamiento original)
            for ($day_offset = 0; $day_offset < 7; $day_offset++) {
                $target_date = $current_time + ($day_offset * 24 * 3600);
                $day_name = strtolower(date('l', $target_date));
                
                // Verificar si la sucursal está abierta este día
                if (!isset($branch['schedule'][$day_name])) {
                    continue;
                }
                
                $schedule = $branch['schedule'][$day_name];
                $start_time = strtotime(date('Y-m-d', $target_date) . ' ' . $schedule['start']);
                $end_time = strtotime(date('Y-m-d', $target_date) . ' ' . $schedule['end']);
                
                // Si es hoy, ajustar el tiempo de inicio
                if ($day_offset === 0) {
                    $start_time = max($start_time, $two_hours_from_now);
                }
                
                // Generar slots de 30 minutos
                $slot_duration = 30 * 60; // 30 minutos en segundos
                
                for ($time = $start_time; $time < $end_time; $time += $slot_duration) {
                    $time_formatted = date('H:i', $time);
                    $date_formatted = date('Y-m-d', $target_date);
                    
                    $options[] = array(
                        'value' => $date_formatted . ' ' . $time_formatted,
                        'label' => self::format_delivery_time_option($date_formatted, $time_formatted, $day_offset)
                    );
                }
            }
        }
        
        return $options;
    }
    
    /**
     * Formatear opción de tiempo de entrega
     */
    private static function format_delivery_time_option($date, $time, $day_offset) {
        $day_names = array('Hoy', 'Mañana', 'Pasado mañana');
        $day_name = isset($day_names[$day_offset]) ? $day_names[$day_offset] : date('l', strtotime($date));
        
        return $day_name . ' ' . date('d/m', strtotime($date)) . ' a las ' . $time;
    }
    
    /**
     * Establecer sucursal actual
     */
    public static function set_current_branch() {
        // Verificar nonce
        if (!wp_verify_nonce($_POST['nonce'], 'chicanos_branch_nonce')) {
            wp_send_json_error('Nonce verification failed');
        }
        
        $branch_id = sanitize_text_field($_POST['branch_id']);
        
        if (empty($branch_id)) {
            wp_send_json_error('Branch ID is required');
        }
        
        $success = Chicanos_Branch_Management::set_current_branch($branch_id);
        
        if ($success) {
            wp_send_json_success(array('message' => 'Sucursal establecida correctamente'));
        } else {
            wp_send_json_error('Error al establecer sucursal');
        }
    }
}

// Inicializar AJAX handlers
add_action('init', function() {
    Chicanos_Branch_AJAX::init();
});
