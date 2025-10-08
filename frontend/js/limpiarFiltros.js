/**
 * limpiarFiltros.js
 * Módulo para resetear todos los filtros a sus valores por defecto
 * @author Sistema de Gestión de Productos
 * @version 1.0.1
 */

/**
 * Resetea todos los filtros a sus valores por defecto
 * @description Limpia inputs y selects, y muestra todos los productos nuevamente
 */
function limpiarFiltros() {
    // Limpiar inputs y selects
    document.getElementById('buscar').value = '';
    document.getElementById('categoria').value = 'todas';
    document.getElementById('stockMinimo').value = '0';
    document.getElementById('ordenar').value = 'nombre_asc';
    
    // Mostrar todos los productos nuevamente
    ordenarProductos(productos);
}
