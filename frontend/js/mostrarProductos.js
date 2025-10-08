/**
 * mostrarProductos.js
 * Módulo para mostrar productos en la tabla HTML
 * @author Sistema de Gestión de Productos
 * @version 1.0.1
 */

/**
 * Muestra los productos en la tabla del HTML
 * @param {Array} arrayProductos - Array de objetos producto a mostrar
 * @description Limpia la tabla, recorre el array con forEach(), 
 *              crea filas dinámicamente, calcula valor total y actualiza estadísticas
 */
function mostrarProductos(arrayProductos) {
    const cuerpoTabla = document.getElementById('cuerpoTabla');
    
    // Limpiar el contenido actual de la tabla
    cuerpoTabla.innerHTML = '';
    
    // Verificar si hay productos
    if (arrayProductos.length === 0) {
        cuerpoTabla.innerHTML = '<tr><td colspan="6" class="no-productos">No se encontraron productos con los criterios seleccionados</td></tr>';
        return;
    }
    
    // Recorrer el array con forEach()
    arrayProductos.forEach(producto => {
        // Calcular el valor total de cada producto (precio × stock)
        const valorTotal = producto.precio * producto.stock;
        
        // Crear filas de tabla dinámicamente
        const fila = document.createElement('tr');
        fila.innerHTML = `
            <td>${producto.id}</td>
            <td>${producto.nombre}</td>
            <td>${producto.categoria}</td>
            <td>$${producto.precio.toLocaleString('es-AR')}</td>
            <td>${producto.stock}</td>
            <td>$${valorTotal.toLocaleString('es-AR')}</td>
        `;
        
        cuerpoTabla.appendChild(fila);
    });
    
    // Actualizar estadísticas
    actualizarEstadisticas(arrayProductos);
}
