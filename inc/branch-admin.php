<?php
/**
 * Página de Administración para Gestión de Sucursales
 * 
 * Permite a los administradores gestionar sucursales, horarios y configuraciones
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Clase para la página de administración de sucursales
 */
class Chicanos_Branch_Admin {
    
    /**
     * Inicializar la página de administración
     */
    public static function init() {
        add_action('admin_menu', array(__CLASS__, 'add_admin_menu'));
        add_action('admin_init', array(__CLASS__, 'register_settings'));
        add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueue_admin_scripts'));
    }
    
    /**
     * Agregar menú de administración
     */
    public static function add_admin_menu() {
        add_menu_page(
            'Gestión de Sucursales',
            'Sucursales',
            'manage_options',
            'chicanos-branches',
            array(__CLASS__, 'admin_page'),
            'dashicons-store',
            30
        );
        
        add_submenu_page(
            'chicanos-branches',
            'Configuración de Sucursales',
            'Configuración',
            'manage_options',
            'chicanos-branches-settings',
            array(__CLASS__, 'settings_page')
        );
    }
    
    /**
     * Registrar configuraciones
     */
    public static function register_settings() {
        register_setting('chicanos_branches_settings', 'chicanos_branches_config');
    }
    
    /**
     * Enqueue scripts de administración
     */
    public static function enqueue_admin_scripts($hook) {
        if (strpos($hook, 'chicanos-branches') !== false) {
            wp_enqueue_script('jquery-ui-datepicker');
            wp_enqueue_style('jquery-ui-css', 'https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css');
        }
    }
    
    /**
     * Página principal de administración
     */
    public static function admin_page() {
        $branches = Chicanos_Branch_Management::get_branches();
        ?>
        <div class="wrap">
            <h1>Gestión de Sucursales</h1>
            
            <div class="chicanos-branches-admin">
                <?php foreach ($branches as $branch_id => $branch): ?>
                    <div class="branch-card">
                        <h2><?php echo esc_html($branch['name']); ?></h2>
                        
                        <div class="branch-info">
                            <p><strong>Email:</strong> <?php echo esc_html($branch['email']); ?></p>
                            <p><strong>Dirección:</strong> <?php echo esc_html($branch['address']); ?></p>
                            
                            <div class="branch-status">
                                <strong>Estado actual:</strong>
                                <?php if (Chicanos_Branch_Management::is_branch_open($branch_id)): ?>
                                    <span class="status-open">Abierto</span>
                                <?php else: ?>
                                    <span class="status-closed">Cerrado</span>
                                    <?php 
                                    $next_opening = Chicanos_Branch_Management::get_next_opening_time($branch_id);
                                    if ($next_opening): ?>
                                        <br><small>Próxima apertura: <?php echo esc_html($next_opening['formatted']); ?></small>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="branch-schedule">
                            <h3>Horarios de Atención</h3>
                            <table class="schedule-table">
                                <thead>
                                    <tr>
                                        <th>Día</th>
                                        <th>Horario</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $days = array(
                                        'monday' => 'Lunes',
                                        'tuesday' => 'Martes',
                                        'wednesday' => 'Miércoles',
                                        'thursday' => 'Jueves',
                                        'friday' => 'Viernes',
                                        'saturday' => 'Sábado',
                                        'sunday' => 'Domingo'
                                    );
                                    
                                    foreach ($days as $day_key => $day_name): 
                                        if (isset($branch['schedule'][$day_key])):
                                    ?>
                                        <tr>
                                            <td><?php echo esc_html($day_name); ?></td>
                                            <td><?php echo esc_html($branch['schedule'][$day_key]['start'] . ' - ' . $branch['schedule'][$day_key]['end']); ?></td>
                                        </tr>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="delivery-zones">
                            <h3>Zonas de Distribución</h3>
                            <p><strong>Calles:</strong> <?php echo esc_html($branch['delivery_zones']['streets']['min_street'] . ' a ' . $branch['delivery_zones']['streets']['max_street']); ?></p>
                            <p><strong>Carreras:</strong> <?php echo esc_html($branch['delivery_zones']['streets']['min_avenue'] . ' a ' . $branch['delivery_zones']['streets']['max_avenue']); ?></p>
                            <p><strong>Barrios:</strong> <?php echo esc_html(implode(', ', $branch['delivery_zones']['neighborhoods'])); ?></p>
                        </div>
                        
                        <div class="branch-actions">
                            <button class="button button-primary" onclick="testBranchEmail('<?php echo esc_js($branch_id); ?>')">
                                Probar Email
                            </button>
                            <button class="button" onclick="viewBranchOrders('<?php echo esc_js($branch_id); ?>')">
                                Ver Pedidos
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="branch-stats">
                <h2>Estadísticas</h2>
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Pedidos Hoy</h3>
                        <p class="stat-number"><?php echo self::get_today_orders_count(); ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Pedidos Esta Semana</h3>
                        <p class="stat-number"><?php echo self::get_week_orders_count(); ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Sucursales Activas</h3>
                        <p class="stat-number"><?php echo self::get_active_branches_count(); ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
        .chicanos-branches-admin {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        
        .branch-card {
            background: white;
            border: 1px solid #ccd0d4;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .branch-card h2 {
            margin-top: 0;
            color: #333;
            border-bottom: 2px solid #0073aa;
            padding-bottom: 10px;
        }
        
        .branch-info p {
            margin: 8px 0;
        }
        
        .status-open {
            color: #28a745;
            font-weight: bold;
        }
        
        .status-closed {
            color: #dc3545;
            font-weight: bold;
        }
        
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        
        .schedule-table th,
        .schedule-table td {
            padding: 8px 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .schedule-table th {
            background: #f8f9fa;
            font-weight: 600;
        }
        
        .delivery-zones {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
        }
        
        .branch-actions {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
        }
        
        .branch-actions .button {
            margin-right: 10px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        
        .stat-card {
            background: white;
            border: 1px solid #ccd0d4;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .stat-card h3 {
            margin-top: 0;
            color: #666;
            font-size: 1rem;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #0073aa;
            margin: 10px 0;
        }
        </style>
        
        <script>
        function testBranchEmail(branchId) {
            if (confirm('¿Enviar email de prueba a esta sucursal?')) {
                // Aquí se implementaría la funcionalidad de prueba de email
                alert('Funcionalidad de prueba de email en desarrollo');
            }
        }
        
        function viewBranchOrders(branchId) {
            // Redirigir a la página de pedidos filtrada por sucursal
            window.location.href = '<?php echo admin_url('edit.php?post_type=shop_order'); ?>&branch_id=' + branchId;
        }
        </script>
        <?php
    }
    
    /**
     * Página de configuración
     */
    public static function settings_page() {
        ?>
        <div class="wrap">
            <h1>Configuración de Sucursales</h1>
            
            <form method="post" action="options.php">
                <?php
                settings_fields('chicanos_branches_settings');
                $config = get_option('chicanos_branches_config', array());
                ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">Tiempo mínimo de anticipación</th>
                        <td>
                            <input type="number" name="chicanos_branches_config[min_advance_hours]" 
                                   value="<?php echo esc_attr($config['min_advance_hours'] ?? 2); ?>" 
                                   min="1" max="24" />
                            <p class="description">Horas mínimas de anticipación para pedidos (por defecto: 2 horas)</p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Intervalo de tiempo de entrega</th>
                        <td>
                            <input type="number" name="chicanos_branches_config[delivery_interval]" 
                                   value="<?php echo esc_attr($config['delivery_interval'] ?? 30); ?>" 
                                   min="15" max="60" />
                            <p class="description">Intervalo en minutos para opciones de tiempo de entrega (por defecto: 30 minutos)</p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Email de notificaciones administrativas</th>
                        <td>
                            <input type="email" name="chicanos_branches_config[admin_email]" 
                                   value="<?php echo esc_attr($config['admin_email'] ?? get_option('admin_email')); ?>" 
                                   class="regular-text" />
                            <p class="description">Email para recibir notificaciones administrativas sobre pedidos</p>
                        </td>
                    </tr>
                </table>
                
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
    
    /**
     * Obtener conteo de pedidos del día
     */
    private static function get_today_orders_count() {
        $today = date('Y-m-d');
        $args = array(
            'post_type' => 'shop_order',
            'post_status' => array('wc-processing', 'wc-completed'),
            'date_query' => array(
                array(
                    'year' => date('Y'),
                    'month' => date('m'),
                    'day' => date('d'),
                ),
            ),
            'meta_query' => array(
                array(
                    'key' => '_branch_id',
                    'compare' => 'EXISTS'
                )
            )
        );
        
        $orders = get_posts($args);
        return count($orders);
    }
    
    /**
     * Obtener conteo de pedidos de la semana
     */
    private static function get_week_orders_count() {
        $week_start = date('Y-m-d', strtotime('monday this week'));
        $week_end = date('Y-m-d', strtotime('sunday this week'));
        
        $args = array(
            'post_type' => 'shop_order',
            'post_status' => array('wc-processing', 'wc-completed'),
            'date_query' => array(
                array(
                    'after' => $week_start,
                    'before' => $week_end,
                    'inclusive' => true,
                ),
            ),
            'meta_query' => array(
                array(
                    'key' => '_branch_id',
                    'compare' => 'EXISTS'
                )
            )
        );
        
        $orders = get_posts($args);
        return count($orders);
    }
    
    /**
     * Obtener conteo de sucursales activas
     */
    private static function get_active_branches_count() {
        $branches = Chicanos_Branch_Management::get_branches();
        $active_count = 0;
        
        foreach ($branches as $branch_id => $branch) {
            if (Chicanos_Branch_Management::is_branch_open($branch_id)) {
                $active_count++;
            }
        }
        
        return $active_count;
    }
}

// Inicializar página de administración
Chicanos_Branch_Admin::init();

