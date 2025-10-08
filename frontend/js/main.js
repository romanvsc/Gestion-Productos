/**
 * main.js
 * Archivo principal para la inicialización del sistema y event listeners
 * @author Sistema de Gestión de Productos
 * @version 1.0.1
 */

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    // Cargar productos al iniciar
    mostrarProductos(productos);
    
    // Botón aplicar filtros
    document.getElementById('aplicarFiltros').addEventListener('click', aplicarFiltros);
    
    // Botón limpiar filtros
    document.getElementById('limpiarFiltros').addEventListener('click', limpiarFiltros);
    
    // Búsqueda en tiempo real
    document.getElementById('buscar').addEventListener('input', aplicarFiltros);
    
    // Aplicar filtros al cambiar categoría
    document.getElementById('categoria').addEventListener('change', aplicarFiltros);
    
    // Aplicar filtros al cambiar stock mínimo
    document.getElementById('stockMinimo').addEventListener('input', aplicarFiltros);
    
    // Aplicar ordenamiento al cambiar criterio
    document.getElementById('ordenar').addEventListener('change', aplicarFiltros);
});
