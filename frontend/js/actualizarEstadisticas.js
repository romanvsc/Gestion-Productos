/**
 * actualizarEstadisticas.js
 * Módulo para calcular y actualizar las estadísticas del sistema
 * @author Sistema de Gestión de Productos
 * @version 1.0.1
 */

/**
 * Calcula y muestra las estadísticas del inventario
 * @param {Array} arrayProductos - Array de productos filtrados actualmente
 * @description Usa reduce() para calcular valor total 
 *              y actualiza los elementos HTML correspondientes
 */
function actualizarEstadisticas(arrayProductos) {
    const totalProductos = productos.length;
    
    const productosFiltrados = arrayProductos.length;
    
    // Usar reduce() para calcular el valor total del stock
    const valorTotal = arrayProductos.reduce((acumulador, producto) => {
        return acumulador + (producto.precio * producto.stock);
    }, 0);
    
    // Actualizar los elementos HTML correspondientes
    document.getElementById('totalProductos').textContent = totalProductos;
    document.getElementById('productosFiltrados').textContent = productosFiltrados;
    document.getElementById('valorTotal').textContent = valorTotal.toLocaleString('es-AR');
}
