/**
 * main.js
 * Archivo principal para la inicialización del sistema y event listeners
 * @author Sistema de Gestión de Productos
 * @version 1.0.1
 */

document.addEventListener('DOMContentLoaded', function() {
    // Cargar productos al iniciar
    mostrarProductos(productos);
    
    document.getElementById('aplicarFiltros').addEventListener('click', aplicarFiltros);
    
    document.getElementById('limpiarFiltros').addEventListener('click', limpiarFiltros);
    
    document.getElementById('buscar').addEventListener('input', aplicarFiltros);
    
    document.getElementById('categoria').addEventListener('change', aplicarFiltros);
    
    document.getElementById('stockMinimo').addEventListener('input', aplicarFiltros);
    
    document.getElementById('ordenar').addEventListener('change', aplicarFiltros);
});
