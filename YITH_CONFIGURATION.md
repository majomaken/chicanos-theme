# Configuración de YITH WooCommerce Product Add-ons para Adiciones

## Resumen
El template de adiciones ahora está configurado para detectar automáticamente las opciones creadas con el plugin **YITH WooCommerce Product Add-ons & Extra Options**.

## Configuración Requerida

### 1. Instalación del Plugin
- Instalar y activar "YITH WooCommerce Product Add-ons & Extra Options"
- Verificar que esté funcionando correctamente

### 2. Crear el Producto Base
- Crear un producto llamado "Adiciones" en WooCommerce
- Asignarlo a la categoría "adiciones"
- Precio base: $0.01 (mínimo)

### 3. Configurar Grupos de Opciones en YITH

#### Paso 1: Acceder a YITH
- Ir a **YITH** → **Product Add-ons** en el menú lateral de WordPress

#### Paso 2: Crear Grupos de Opciones
Crear los siguientes grupos con estos nombres exactos (o que contengan estas palabras clave):

##### Grupo 1: "Totopos"
- **Tipo de campo**: Radio buttons o Select
- **Opciones**:
  - Chico (+$100)
  - Mediano (+$150) 
  - Grande (+$200)

##### Grupo 2: "Tortillas"
- **Tipo de campo**: Radio buttons o Select
- **Opciones**:
  - Chico (+$120)
  - Mediano (+$170)
  - Grande (+$220)

##### Grupo 3: "Proteínas" (o "Proteinas")
- **Tipo de campo**: Radio buttons o Select
- **Opciones**:
  - Pollo Chico (+$150)
  - Pollo Mediano (+$200)
  - Pollo Grande (+$250)
  - Carne Chico (+$170)
  - Carne Mediano (+$220)
  - Carne Grande (+$280)

##### Grupo 4: "Salsas"
- **Tipo de campo**: Checkboxes (múltiple selección)
- **Opciones**:
  - Verde Chico (+$50)
  - Verde Mediano (+$80)
  - Verde Grande (+$110)
  - Roja Chico (+$50)
  - Roja Mediano (+$80)
  - Roja Grande (+$110)

#### Paso 3: Asignar Grupos al Producto
- En cada grupo, en la sección "Show this block of options in"
- Seleccionar "Specific products or categories"
- En "Show in products", seleccionar el producto "Adiciones"

## Cómo Funciona el Template

### Detección Automática
El template detecta automáticamente:
1. Si YITH está activo
2. Los grupos de opciones asignados al producto
3. Las opciones dentro de cada grupo
4. Los precios de cada opción

### Categorización Inteligente
El sistema categoriza los grupos según palabras clave en el nombre:
- **Totopos**: Si el nombre contiene "totopo" o "totopos"
- **Tortillas**: Si el nombre contiene "tortilla" o "tortillas"  
- **Proteínas**: Si el nombre contiene "proteína", "proteina" o "protein"
- **Salsas**: Si el nombre contiene "salsa" o "salsas"

### Fallback a WAPF
Si YITH no está disponible, el sistema intenta usar Advanced Product Fields (WAPF) como respaldo.

## Debugging

### Verificar Configuración
El template incluye comentarios de debug que muestran:
- Si YITH está activo
- Cuántos grupos se encontraron
- Qué opciones tiene cada grupo
- Si la categorización funcionó correctamente

### Logs de Error
Revisar los logs de WordPress para ver:
- Errores de conexión con YITH
- Problemas con la base de datos
- Configuraciones incorrectas

## Personalización

### Modificar Categorías
Para agregar nuevas categorías, editar la función `process_yith_addon_groups()` en `functions.php`:

```php
// Agregar nueva categoría
$categorized_options['nueva_categoria'] = array('options' => array(), 'title' => '');

// Agregar detección por nombre
elseif (strpos($group_name, 'nueva_categoria') !== false) {
    $categorized_options['nueva_categoria']['options'] = $group_options;
    $categorized_options['nueva_categoria']['title'] = $group_title;
}
```

### Modificar Formato de Precios
Para cambiar cómo se muestran los precios, editar la sección de formateo en `process_yith_addon_groups()`:

```php
// Formatear precio
$price_text = '';
if ($option_price > 0) {
    if ($option_price_type === 'percentage') {
        $price_text = ' (+' . $option_price . '%)';
    } else {
        $price_text = ' (+$' . number_format($option_price, 2) . ')';
    }
}
```

## Solución de Problemas

### No se muestran las opciones
1. Verificar que YITH esté activo
2. Verificar que los grupos estén asignados al producto "Adiciones"
3. Verificar que los nombres de los grupos contengan las palabras clave correctas
4. Revisar los logs de debug en el HTML de la página

### Precios no se muestran
1. Verificar que las opciones tengan precios configurados en YITH
2. Verificar que el tipo de precio esté configurado correctamente
3. Revisar la función de formateo de precios

### Categorización incorrecta
1. Verificar que los nombres de los grupos contengan las palabras clave
2. Modificar la función `process_yith_addon_groups()` si es necesario
3. Agregar más palabras clave para mejor detección
