/**
 * ordenarProductos.js
 * Módulo para ordenar productos según diferentes criterios
 * @author Sistema de Gestión de Productos
 * @version 1.0.1
 */

/**
 * Ordena los productos según el criterio seleccionado
 * @param {Array} arrayProductos - Array de productos a ordenar
 * @description Usa sort() con funciones de comparación para ordenar por
 *              nombre, precio o stock (ascendente o descendente)
 */
function ordenarProductos(arrayProductos) {
    const criterioOrden = document.getElementById('ordenar').value;
    
    // Crear una copia del array para no modificar el original
    const productosOrdenados = [...arrayProductos];
    
    // Usar sort() con funciones de comparación
    productosOrdenados.sort((a, b) => {
        switch(criterioOrden) {
            case 'nombre_asc':
                return a.nombre.localeCompare(b.nombre);
            case 'nombre_desc':
                return b.nombre.localeCompare(a.nombre);
            case 'precio_asc':
                return a.precio - b.precio;
            case 'precio_desc':
                return b.precio - a.precio;
            case 'stock_asc':
                return a.stock - b.stock;
            case 'stock_desc':
                return b.stock - a.stock;
            default:
                return 0;
        }
    });
    
    // Llamar a mostrarProductos() con los resultados ordenados
    mostrarProductos(productosOrdenados);
}
