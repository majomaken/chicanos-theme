# Popup de Productos - Documentación

## Descripción
Se ha implementado un sistema de popup para mostrar la descripción de productos en las páginas de domicilio de las sedes Nogal y Castellana. El popup aparece al hacer clic en el botón de información (ícono de información) que se encuentra en la esquina superior derecha de cada imagen de producto.

## Características

### Funcionalidad
- **Botón de información**: Aparece en la esquina superior derecha de cada imagen de producto
- **Popup responsivo**: Se adapta a diferentes tamaños de pantalla
- **Datos dinámicos**: Título, precio y descripción se obtienen directamente del producto en WordPress
- **Múltiples formas de cerrar**: 
  - Botón X en la esquina superior derecha
  - Clic en el overlay (fondo oscuro)
  - Tecla ESC

### Diseño
- **Header rosa**: Sección con fondo rosa claro (#FAD3DB) que contiene el título del producto y botón de cerrar
- **Contenido blanco**: Sección blanca con la descripción del producto
- **Footer amarillo**: Sección amarilla (#F9CB38) con el botón "AGREGAR" que redirige a la página del producto

## Cómo agregar descripciones a los productos

### Desde el Panel de WordPress

1. **Acceder a Productos**:
   - Ve a `Productos > Todos los productos` en el panel de WordPress
   - O usa `Productos > Añadir nuevo` para crear un nuevo producto

2. **Editar un producto existente**:
   - Haz clic en "Editar" en el producto que deseas modificar
   - En el editor de productos, encontrarás dos campos de descripción:
     - **Descripción corta**: Aparece en el popup si no hay descripción completa
     - **Descripción**: Descripción completa del producto

3. **Agregar la descripción**:
   - En el campo "Descripción corta" (recomendado para popups):
     ```
     Ejemplo: "3 tortillas 100% maíz con frijol refrito rellenas de pollo en salsa roja o salsa verde con crema de leche y queso al gratin"
     ```
   - En el campo "Descripción" (descripción completa):
     ```
     Ejemplo: "Deliciosas enchiladas preparadas con ingredientes frescos. Incluye 3 tortillas de maíz, frijoles refritos, pollo en salsa roja o verde, crema de leche y queso gratinado."
     ```

### Prioridad de descripciones
El popup mostrará las descripciones en este orden:
1. **Descripción completa** (si existe)
2. **Descripción corta** (si no hay descripción completa)
3. **"Descripción no disponible"** (si no hay ninguna descripción)

## Archivos modificados

### Archivos principales
- `woocommerce/content-product.php`: Estructura HTML del popup y botón de información
- `css/product-popup.css`: Estilos del popup y botón
- `js/product-popup.js`: Funcionalidad JavaScript
- `inc/enqueue.php`: Carga de archivos CSS y JS

### Archivos de estilos
- `css/product-popup.css`: Contiene todos los estilos del popup

### Archivos de JavaScript
- `js/product-popup.js`: Maneja la apertura/cierre del popup

## Compatibilidad

### Páginas donde funciona
- Sede Nogal (`template-domicilio-nogal.php`)
- Sede Castellana (`template-domicilio-castellana.php`)

### Navegadores soportados
- Chrome (recomendado)
- Firefox
- Safari
- Edge

### Responsive
- **Desktop**: Popup de 400px de ancho máximo
- **Tablet**: Popup de 90% del ancho de pantalla
- **Mobile**: Popup de 95% del ancho de pantalla

## Personalización

### Colores
Los colores principales del popup son:
- **Fondo del header**: #FAD3DB (rosa claro)
- **Botón AGREGAR**: #F9CB38 (amarillo)
- **Botón de información**: Blanco con ícono rosa
- **Overlay**: Negro con 50% de opacidad

### Tamaños
- **Popup**: 400px de ancho máximo (desktop), 90% (tablet), 95% (mobile)
- **Botón de información**: 35px x 35px
- **Botón de cerrar**: 35px x 35px

## Troubleshooting

### El popup no aparece
1. Verificar que el archivo `product-popup.js` se esté cargando
2. Verificar que jQuery esté disponible
3. Revisar la consola del navegador para errores

### Los estilos no se aplican
1. Verificar que `product-popup.css` se esté cargando
2. Verificar que no haya conflictos con otros CSS
3. Limpiar caché del navegador

### La descripción no aparece
1. Verificar que el producto tenga descripción en WordPress
2. Verificar que el campo de descripción no esté vacío
3. Verificar que el producto esté publicado

## Notas técnicas

### Estructura HTML
```html
<div class="product-popup" id="product-popup-{ID}">
    <div class="popup-overlay"></div>
    <div class="popup-content">
        <div class="popup-header">
            <h3 class="popup-title">Título</h3>
            <button class="popup-close-btn">×</button>
        </div>
        <div class="popup-body">
            <div class="popup-description">Descripción</div>
        </div>
        <div class="popup-footer">
            <a href="#" class="popup-add-btn">AGREGAR</a>
        </div>
    </div>
</div>
```

### Eventos JavaScript
- `click` en `.product-description-btn`: Abre popup
- `click` en `.popup-close-btn`: Cierra popup
- `click` en `.popup-overlay`: Cierra popup
- `keydown` con tecla ESC: Cierra popup
