/**
 * aplicarFiltros.js
 * Módulo para filtrar productos según múltiples criterios
 * @author Sistema de Gestión de Productos
 * @version 1.0.1
 */

/**
 * Filtra los productos según los criterios seleccionados
 * @description Obtiene valores de inputs, usa filter() para filtrar
 *              por nombre AND categoría AND stock mínimo
 */
function aplicarFiltros() {
    // Obtener los valores de los inputs de filtro
    const busqueda = document.getElementById('buscar').value.toLowerCase();
    const categoriaSeleccionada = document.getElementById('categoria').value;
    const stockMinimo = parseInt(document.getElementById('stockMinimo').value) || 0;
    
    // Usar filter() para filtrar el array original
    const productosFiltrados = productos.filter(producto => {
        // Considerar múltiples condiciones (nombre AND categoría AND stock)
        const cumpleNombre = producto.nombre.toLowerCase().includes(busqueda);
        const cumpleCategoria = categoriaSeleccionada === 'todas' || producto.categoria === categoriaSeleccionada;
        const cumpleStock = producto.stock >= stockMinimo;
        
        return cumpleNombre && cumpleCategoria && cumpleStock;
    });
    
    // Llamar a ordenarProductos() con los resultados
    ordenarProductos(productosFiltrados);
}
