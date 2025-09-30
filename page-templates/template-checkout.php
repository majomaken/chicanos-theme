<?php
/**
 * Template Name: Checkout Template
 * 
 * Template personalizado para la página de checkout con sistema de sucursales
 *
 * @package Chicanos_Theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="wrapper" id="checkout-wrapper">
    <div class="container" id="content" tabindex="-1">
        <div class="row">
            <main class="site-main" id="main">
                
                <!-- Header del checkout -->
                <div class="checkout-header" style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                    <h1 style="color: #333; margin-bottom: 10px;">🛒 Checkout</h1>
                    <p style="color: #666; margin: 0;">Complete su pedido de manera segura</p>
                </div>

                <!-- Información de sucursal -->
                <?php 
                $current_branch_id = null;
                $current_branch_info = null;
                
                if (class_exists('Chicanos_Branch_Management')) {
                    $current_branch_id = Chicanos_Branch_Management::get_current_branch();
                    if ($current_branch_id) {
                        $current_branch_info = Chicanos_Branch_Management::get_branch_info($current_branch_id);
                    }
                }
                ?>
                
                <?php if ($current_branch_info): ?>
                <div class="branch-info-card" style="background: #FBF5ED; padding: 20px; border-radius: 8px; border: 2px solid #ffc107; margin-bottom: 30px;">
                    <h3 style="color: #000; margin-bottom: 15px;">Sucursal de entrega</h3>
                    
                    <div style="background: white; padding: 15px; border-radius: 6px;">
                        <h4 style="color: #000; margin-bottom: 10px;"><?php echo esc_html($current_branch_info['name']); ?></h4>
                        <p style="color: #000;"><strong>Dirección:</strong> <?php echo esc_html($current_branch_info['address']); ?></p>
                        <p style="color: #000;"><strong>Email:</strong> <?php echo esc_html($current_branch_info['email']); ?></p>
                        <p style="color: #000;"><strong>Estado:</strong> 
                            <?php if ($current_branch_info['is_open']): ?>
                                <span style="background: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.9rem;">Abierto</span>
                            <?php else: ?>
                                <span style="background: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.9rem;">Cerrado</span>
                                <?php if ($current_branch_info['next_opening']): ?>
                                    <br><small style="color: #666;">Próxima apertura: <?php echo esc_html($current_branch_info['next_opening']['formatted']); ?></small>
                                <?php endif; ?>
                            <?php endif; ?>
                        </p>
                        
                        <!-- Información de zonas de distribución -->
                        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e9ecef;">
                            <h5 style="color: #000; margin-bottom: 10px;">Zonas de distribución</h5>
                            <p style="margin-bottom: 8px; font-size: 0.9rem; color: #000;">
                                <strong>Calles:</strong> <?php echo $current_branch_info['delivery_zones']['streets']['min_street']; ?> a <?php echo $current_branch_info['delivery_zones']['streets']['max_street']; ?>
                            </p>
                            <p style="margin-bottom: 8px; font-size: 0.9rem; color: #000;">
                                <strong>Carreras:</strong> <?php echo $current_branch_info['delivery_zones']['streets']['min_avenue']; ?> a <?php echo $current_branch_info['delivery_zones']['streets']['max_avenue']; ?>
                            </p>
                            <p style="margin-bottom: 8px; font-size: 0.9rem; color: #000;">
                                <strong>Barrios:</strong> <?php echo implode(', ', $current_branch_info['delivery_zones']['neighborhoods']); ?>
                            </p>
                        </div>
                        
                        <!-- Información de horarios -->
                        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e9ecef;">
                            <h5 style="color: #000; margin-bottom: 10px;">Horarios de atención</h5>
                            <div style="font-size: 0.9rem;">
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
                                    if (isset($current_branch_info['schedule'][$day_key])):
                                        $schedule = $current_branch_info['schedule'][$day_key];
                                ?>
                                    <p style="margin-bottom: 4px; color: #000;">
                                        <strong><?php echo $day_name; ?>:</strong> <?php echo $schedule['start']; ?> - <?php echo $schedule['end']; ?>
                                    </p>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="branch-selection-card" style="background: #fff3cd; padding: 20px; border-radius: 8px; border: 2px solid #ffc107; margin-bottom: 30px;">
                    <h3 style="color: #856404; margin-bottom: 15px;">⚠️ Seleccione su sucursal de entrega</h3>
                    <p style="color: #856404;">No se detectó una sucursal automáticamente. Por favor seleccione una:</p>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px; margin-top: 15px;">
                        <?php 
                        if (class_exists('Chicanos_Branch_Management')) {
                            $branches = Chicanos_Branch_Management::get_branches();
                            foreach ($branches as $branch_id => $branch): 
                        ?>
                                <div style="background: white; border: 2px solid #e9ecef; border-radius: 8px; padding: 15px; transition: all 0.3s ease;">
                                    <input type="radio" name="branch_selection" 
                                           id="branch_<?php echo esc_attr($branch_id); ?>" 
                                           value="<?php echo esc_attr($branch_id); ?>" required
                                           style="margin-right: 10px;">
                                    <label for="branch_<?php echo esc_attr($branch_id); ?>" style="cursor: pointer;">
                                        <strong><?php echo esc_html($branch['name']); ?></strong>
                                        <br><small style="color: #666;"><?php echo esc_html($branch['address']); ?></small>
                                    </label>
                                </div>
                        <?php 
                            endforeach;
                        } else {
                            echo '<p style="color: #dc3545;">❌ Error: Sistema de sucursales no disponible</p>';
                        }
                        ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Información de entrega -->
                <div class="delivery-info-card" style="background: #FBF5ED; padding: 20px; border-radius: 8px; border: 2px solid #ffc107; margin-bottom: 30px;">
                    <h3 style="color: #000; margin-bottom: 15px;">Información de entrega</h3>
                    
                    <div style="background: white; padding: 15px; border-radius: 6px;">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                            
                            <!-- Fecha de entrega -->
                            <div>
                                <h5 style="color: #000; margin-bottom: 10px;">Fecha de entrega</h5>
                                <p style="margin: 0; font-size: 0.9rem; color: #000;">
                                    <strong>Hoy:</strong> <?php echo date('d/m/Y'); ?><br>
                                    <small style="color: #666;">Los pedidos se entregan el mismo día</small>
                                </p>
                            </div>
                            
                            <!-- Costos y requisitos -->
                            <div>
                                <h5 style="color: #000; margin-bottom: 10px;">Costos de domicilio</h5>
                                <p style="margin: 0; font-size: 0.9rem; color: #000;">
                                    <strong>Pedido mínimo:</strong> $30,000<br>
                                    <strong>Costo adicional:</strong> $6,000
                                </p>
                            </div>
                            
                            <!-- Tiempo de anticipación -->
                            <div>
                                <h5 style="color: #000; margin-bottom: 10px;">Tiempo de anticipación</h5>
                                <p style="margin: 0; font-size: 0.9rem; color: #000;">
                                    <strong>Mínimo 2 horas</strong><br>
                                    <small style="color: #666;">Ejemplo: Pedido a las 10am → Entrega 10am-12pm</small>
                                </p>
                            </div>
                            
                        </div>
                        
                        <!-- Selector de horario de entrega -->
                        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e9ecef;">
                            <h5 style="color: #000; margin-bottom: 15px;">Selecciona tu horario de entrega</h5>
                            <div class="delivery-time-slots" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                                <div class="time-slot">
                                    <input type="radio" id="delivery_10_12" name="delivery_time_slot" value="10-12pm" required>
                                    <label for="delivery_10_12" style="display: block; padding: 15px 20px; background-color: #f8f9fa; border: 2px solid #ddd; border-radius: 5px; cursor: pointer; text-align: center; font-family: 'Oswald', sans-serif; font-weight: 500; font-size: 1rem; color: #000; transition: all 0.3s ease; position: relative;">10:00 AM - 12:00 PM</label>
                                </div>
                                <div class="time-slot">
                                    <input type="radio" id="delivery_12_2" name="delivery_time_slot" value="12-2pm" required>
                                    <label for="delivery_12_2" style="display: block; padding: 15px 20px; background-color: #f8f9fa; border: 2px solid #ddd; border-radius: 5px; cursor: pointer; text-align: center; font-family: 'Oswald', sans-serif; font-weight: 500; font-size: 1rem; color: #000; transition: all 0.3s ease; position: relative;">12:00 PM - 2:00 PM</label>
                                </div>
                                <div class="time-slot">
                                    <input type="radio" id="delivery_2_4" name="delivery_time_slot" value="2-4pm" required>
                                    <label for="delivery_2_4" style="display: block; padding: 15px 20px; background-color: #f8f9fa; border: 2px solid #ddd; border-radius: 5px; cursor: pointer; text-align: center; font-family: 'Oswald', sans-serif; font-weight: 500; font-size: 1rem; color: #000; transition: all 0.3s ease; position: relative;">2:00 PM - 4:00 PM</label>
                                </div>
                                <div class="time-slot">
                                    <input type="radio" id="delivery_4_630" name="delivery_time_slot" value="4-6:30pm" required>
                                    <label for="delivery_4_630" style="display: block; padding: 15px 20px; background-color: #f8f9fa; border: 2px solid #ddd; border-radius: 5px; cursor: pointer; text-align: center; font-family: 'Oswald', sans-serif; font-weight: 500; font-size: 1rem; color: #000; transition: all 0.3s ease; position: relative;">4:00 PM - 6:30 PM</label>
                                </div>
                            </div>
                            <div class="delivery-validation-message" id="delivery-validation-message" style="display: none; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; padding: 15px; margin-top: 15px;">
                                <p class="error-message" style="color: #721c24; margin: 0; font-family: 'Oswald', sans-serif; font-weight: 500;"></p>
                            </div>
                        </div>
                        
                        <!-- Nota importante -->
                        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e9ecef;">
                            <div style="background: #fff3cd; padding: 15px; border-radius: 4px; border-left: 4px solid #ffc107;">
                                <p style="margin: 0; font-size: 0.9rem; color: #000;">
                                    <strong>Nota importante:</strong> Selecciona tu horario de entrega preferido. Todos los pedidos deben realizarse con al menos 2 horas de anticipación. 
                                    El restaurante se comunicará contigo para confirmar la hora exacta dentro del rango seleccionado.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Campo oculto para el horario de entrega seleccionado -->
                <input type="hidden" name="delivery_time_slot" id="delivery_time_slot_hidden" value="">

                <!-- Contenido del checkout de WooCommerce -->
                <div class="woocommerce-checkout-content">
                    <?php
                    // Agregar campo oculto para la sucursal si se detecta
                    if ($current_branch_id) {
                        echo '<input type="hidden" name="branch_selection" value="' . esc_attr($current_branch_id) . '">';
                    }
                    
                    // Verificar si WooCommerce está activo
                    if (class_exists('WooCommerce')) {
                        // Mostrar el formulario de checkout
                        echo do_shortcode('[woocommerce_checkout]');
                    } else {
                        echo '<p>WooCommerce no está activo</p>';
                    }
                    ?>
                </div>

            </main>
        </div>
    </div>
</div>

<?php
get_footer();
