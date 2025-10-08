/**
 * actualizarEstadisticas.js
 * Módulo para calcular y actualizar las estadísticas del sistema
 * @author Sistema de Gestión de Productos
 * @version 1.0.1
 */

/**
 * Calcula y muestra las estadísticas del inventario
 * @param {Array} arrayProductos - Array de productos filtrados actualmente
 * @description Cuenta productos, usa reduce() para calcular valor total 
 *              y actualiza los elementos HTML correspondientes
 */
function actualizarEstadisticas(arrayProductos) {
    // Contar total de productos (del array original)
    const totalProductos = productos.length;
    
    // Contar productos filtrados
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
