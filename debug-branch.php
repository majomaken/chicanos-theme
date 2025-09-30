<?php
/**
 * Debug temporal para verificar el estado de sucursales
 * Acceder desde: http://chicanos.local/debug-branch.php
 */

// Incluir WordPress
require_once('wp-config.php');

// Incluir la clase de gestión de sucursales
require_once('wp-content/themes/chicanos-theme/inc/branch-management.php');

echo "<h1>Debug del Estado de Sucursales</h1>";

echo "<h2>Información del Sistema</h2>";
echo "<p><strong>Fecha actual:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<p><strong>Día de la semana:</strong> " . date('l') . " (" . strtolower(date('l')) . ")</p>";
echo "<p><strong>Hora actual:</strong> " . date('H:i') . "</p>";
echo "<p><strong>Zona horaria:</strong> " . date_default_timezone_get() . "</p>";

echo "<h2>Estado de Sucursales</h2>";

$branches = Chicanos_Branch_Management::get_branches();

foreach ($branches as $branch_id => $branch) {
    echo "<h3>Sucursal: " . $branch['name'] . " (ID: $branch_id)</h3>";
    
    // Obtener información completa
    $branch_info = Chicanos_Branch_Management::get_branch_info($branch_id);
    
    echo "<p><strong>Estado:</strong> " . ($branch_info['is_open'] ? 'ABIERTO' : 'CERRADO') . "</p>";
    
    if (!$branch_info['is_open'] && $branch_info['next_opening']) {
        echo "<p><strong>Próxima apertura:</strong> " . $branch_info['next_opening']['formatted'] . "</p>";
    }
    
    echo "<h4>Horarios:</h4>";
    echo "<ul>";
    foreach ($branch['schedule'] as $day => $schedule) {
        $is_today = (strtolower(date('l')) === $day);
        $style = $is_today ? 'style="background-color: #ffffcc; padding: 2px;"' : '';
        echo "<li $style><strong>$day:</strong> {$schedule['start']} - {$schedule['end']}" . ($is_today ? ' (HOY)' : '') . "</li>";
    }
    echo "</ul>";
    
    // Test manual de la función
    echo "<h4>Test Manual:</h4>";
    $current_day = strtolower(date('l'));
    $current_time = date('H:i');
    $is_open_manual = Chicanos_Branch_Management::is_branch_open($branch_id, $current_day, $current_time);
    echo "<p><strong>Test manual:</strong> " . ($is_open_manual ? 'ABIERTO' : 'CERRADO') . "</p>";
    
    echo "<hr>";
}

echo "<h2>Test con diferentes horas</h2>";
$test_times = ['10:30', '11:00', '12:00', '15:00', '17:30', '18:00', '18:30'];
$current_day = strtolower(date('l'));

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Hora</th><th>Nogal</th><th>Castellana</th></tr>";

foreach ($test_times as $time) {
    $nogal_open = Chicanos_Branch_Management::is_branch_open('nogal', $current_day, $time);
    $castellana_open = Chicanos_Branch_Management::is_branch_open('castellana', $current_day, $time);
    
    echo "<tr>";
    echo "<td>$time</td>";
    echo "<td>" . ($nogal_open ? 'ABIERTO' : 'CERRADO') . "</td>";
    echo "<td>" . ($castellana_open ? 'ABIERTO' : 'CERRADO') . "</td>";
    echo "</tr>";
}

echo "</table>";

echo "<h2>Logs de Debug</h2>";
echo "<p>Revisa los logs de WordPress para ver los detalles del debug.</p>";
echo "<p>Los logs deberían estar en: wp-content/debug.log</p>";
?>
