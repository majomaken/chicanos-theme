<?php
/**
 * Script de debug para probar la detección de sucursales
 * Acceder desde: http://chicanos.local/debug-branch-detection.php
 */

// Incluir WordPress
require_once('wp-config.php');

// Incluir la clase de gestión de sucursales
require_once('wp-content/themes/chicanos-theme/inc/branch-management.php');

echo "<h1>Debug de Detección de Sucursales</h1>";

echo "<h2>Información Actual</h2>";
echo "<p><strong>URL Actual:</strong> " . $_SERVER['REQUEST_URI'] . "</p>";
echo "<p><strong>Parámetros GET:</strong> " . print_r($_GET, true) . "</p>";

// Limpiar sesión para forzar nueva detección
Chicanos_Branch_Management::clear_branch_selection();

echo "<h2>Detección de Sucursal</h2>";
$detected_branch = Chicanos_Branch_Management::detect_current_branch();
echo "<p><strong>Sucursal Detectada:</strong> " . ($detected_branch ? $detected_branch : 'NINGUNA') . "</p>";

$current_branch = Chicanos_Branch_Management::get_current_branch();
echo "<p><strong>Sucursal Actual:</strong> " . ($current_branch ? $current_branch : 'NINGUNA') . "</p>";

echo "<h2>Información de Sucursal Detectada</h2>";
if ($detected_branch) {
    $branch_info = Chicanos_Branch_Management::get_branch_info($detected_branch);
    if ($branch_info) {
        echo "<div style='background: #f0f0f0; padding: 15px; border-radius: 5px;'>";
        echo "<h3>" . $branch_info['name'] . "</h3>";
        echo "<p><strong>Dirección:</strong> " . $branch_info['address'] . "</p>";
        echo "<p><strong>Email:</strong> " . $branch_info['email'] . "</p>";
        echo "<p><strong>Estado:</strong> " . ($branch_info['is_open'] ? 'ABIERTO' : 'CERRADO') . "</p>";
        echo "</div>";
    }
}

echo "<h2>Pruebas de URLs</h2>";
$test_urls = [
    '/domicilio-castellana/',
    '/domicilio-nogal/',
    '/checkout/?sucursal=nogal',
    '/checkout/?sucursal=castellana',
    '/domicilio-castellana/?sucursal=nogal',
    '/domicilio-nogal/?sucursal=castellana'
];

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>URL</th><th>Sucursal Detectada</th></tr>";

foreach ($test_urls as $url) {
    // Simular la URL
    $_SERVER['REQUEST_URI'] = $url;
    parse_str(parse_url($url, PHP_URL_QUERY), $_GET);
    
    $detected = Chicanos_Branch_Management::detect_current_branch();
    echo "<tr>";
    echo "<td>$url</td>";
    echo "<td>" . ($detected ? $detected : 'NINGUNA') . "</td>";
    echo "</tr>";
}

echo "</table>";

echo "<h2>Logs de Debug</h2>";
echo "<p>Revisa los logs de WordPress para ver los detalles del debug.</p>";
echo "<p>Los logs deberían estar en: wp-content/debug.log</p>";
?>
