# Sistema de Gestión de Sucursales - Chicanos

## Descripción

Este sistema permite gestionar múltiples sucursales de Chicanos con diferentes horarios, zonas de distribución y notificaciones por email. Está integrado completamente con WooCommerce para el proceso de checkout.

## Características Principales

### 🏪 Gestión de Sucursales
- **Nogal (11 con 78)**: Email: contacto@chicanos.com.co
- **Castellana**: Email: castellana@chicanos.com.co

### ⏰ Horarios por Sucursal

#### Nogal
- **Lunes a Jueves**: 11:00 AM - 6:00 PM
- **Viernes y Sábado**: 11:00 AM - 7:00 PM
- **Domingo**: 11:00 AM - 4:00 PM

#### Castellana
- **Lunes a Jueves**: 11:00 AM - 6:00 PM
- **Viernes y Sábado**: 10:00 AM - 6:00 PM
- **Domingo**: 10:00 AM - 3:00 PM

### 🗺️ Zonas de Distribución

#### Nogal
- **Calles**: 45 a 150
- **Carreras**: 0 a 30
- **Barrios**: Retiro, Nogal, Chapinero, Chico, Rosales, Parkway, Nicolas de Federman, Gallerias, Cedritos, Santa Barbara, Santa Ana

#### Castellana
- **Calles**: 94 a 170
- **Carreras**: 30 a 100
- **Barrios**: Suba, Cedritos, San Jose de Bavaria, La Floresta, Colin Campestre, Lagos de Cordoba, Salitre, Rio Negro, Santa Barbara, Santa Ana

### 📧 Notificaciones por Email
- Los pedidos se envían automáticamente al email de la sucursal correspondiente
- Incluye información completa del cliente, productos y horario de entrega
- Formato HTML para mejor legibilidad

### ⏱️ Validaciones de Tiempo
- **Anticipación mínima**: 2 horas
- **Intervalo de entrega**: 30 minutos
- Validación automática de horarios de apertura
- Verificación de zonas de distribución

## Archivos del Sistema

### PHP
- `inc/branch-management.php` - Clase principal de gestión de sucursales
- `inc/branch-ajax.php` - Handlers AJAX para el frontend
- `inc/branch-admin.php` - Página de administración

### Frontend
- `js/branch-management.js` - JavaScript para funcionalidad del checkout
- `css/branch-management.css` - Estilos para la interfaz

### Templates
- `woocommerce/checkout/form-checkout.php` - Template modificado del checkout

## Configuración

### 1. Activación Automática
El sistema se activa automáticamente cuando WooCommerce está instalado y activo.

### 2. Página de Administración
Accede a **Sucursales** en el menú de WordPress para:
- Ver estado de las sucursales
- Consultar horarios y zonas de distribución
- Ver estadísticas de pedidos
- Configurar parámetros del sistema

### 3. Configuración Avanzada
En **Sucursales > Configuración** puedes ajustar:
- Tiempo mínimo de anticipación (por defecto: 2 horas)
- Intervalo de tiempo de entrega (por defecto: 30 minutos)
- Email para notificaciones administrativas

## Funcionalidades del Checkout

### Selección de Sucursal
- Radio buttons para seleccionar la sucursal
- Información en tiempo real sobre horarios y zonas
- Validación automática de disponibilidad

### Campos de Entrega
- **Fecha de entrega**: Selector de fecha (hasta 7 días en el futuro)
- **Hora de entrega**: Opciones dinámicas según la sucursal y fecha seleccionada
- Validación en tiempo real de horarios disponibles

### Validaciones Automáticas
- **Zona de distribución**: Verifica si la dirección está en el área de cobertura
- **Horarios**: Confirma que la sucursal estará abierta en el momento de entrega
- **Anticipación**: Asegura que el pedido se hace con al menos 2 horas de anticipación

## Integración con WooCommerce

### Metadatos de Orden
El sistema guarda automáticamente:
- `_branch_id` - ID de la sucursal seleccionada
- `_branch_name` - Nombre de la sucursal
- `_branch_email` - Email de la sucursal
- `_delivery_date` - Fecha de entrega
- `_delivery_time` - Hora de entrega

### Notificaciones
- Email automático a la sucursal cuando se crea un pedido
- Información completa del cliente y productos
- Detalles de fecha y hora de entrega

### Panel de Administración
- Información de sucursal visible en el detalle de cada pedido
- Estadísticas de pedidos por sucursal
- Gestión centralizada de configuraciones

## Personalización

### Agregar Nueva Sucursal
Para agregar una nueva sucursal, edita el array `$branches` en `inc/branch-management.php`:

```php
'new_branch' => array(
    'name' => 'Nueva Sucursal',
    'email' => 'nueva@chicanos.com.co',
    'address' => 'Dirección de la sucursal',
    'delivery_zones' => array(
        'streets' => array(
            'min_street' => 1,
            'max_street' => 50,
            'min_avenue' => 1,
            'max_avenue' => 20
        ),
        'neighborhoods' => array('Barrio 1', 'Barrio 2')
    ),
    'schedule' => array(
        'monday' => array('start' => '10:00', 'end' => '18:00'),
        // ... otros días
    )
)
```

### Modificar Horarios
Los horarios se pueden cambiar editando el array `schedule` de cada sucursal.

### Personalizar Validaciones
Las validaciones de zona y tiempo se pueden modificar en los métodos correspondientes de la clase `Chicanos_Branch_Management`.

## Troubleshooting

### Problemas Comunes

1. **Los campos no aparecen en el checkout**
   - Verificar que WooCommerce esté activo
   - Comprobar que los archivos estén incluidos en `functions.php`

2. **Las validaciones AJAX no funcionan**
   - Verificar que el nonce esté configurado correctamente
   - Revisar la consola del navegador para errores JavaScript

3. **Los emails no se envían**
   - Verificar la configuración de email de WordPress
   - Comprobar que los emails de sucursal estén configurados correctamente

### Logs de Debug
El sistema incluye logs de error para facilitar el debugging. Revisa los logs de WordPress para más información.

## Soporte

Para soporte técnico o modificaciones adicionales, contacta al equipo de desarrollo.

---

**Versión**: 1.0.0  
**Última actualización**: Diciembre 2024  
**Compatibilidad**: WordPress 5.0+, WooCommerce 3.0+

