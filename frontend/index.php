    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestión de Productos</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <h2>Sistema de Gestión de Productos</h2>
        
        <!-- Mensajes de éxito/error -->
        <div id="mensaje" class="mensaje" style="display: none;"></div>
        
        <!-- Formulario para crear/editar productos -->
        <div class="formulario-container">
            <h3>Gestionar Producto</h3>
            <form id="formProducto">
                <input type="hidden" id="accion" name="accion" value="crear">
                <input type="hidden" id="productoId" name="id" value="">
                
                <div class="form-grupo">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                
                <div class="form-grupo">
                    <label for="categoriaForm">Categoría:</label>
                    <select id="categoriaForm" name="categoria" required>
                        <option value="">Seleccione una categoría</option>
                        <option value="Electrónica">Electrónica</option>
                        <option value="Ropa">Ropa</option>
                        <option value="Alimentos">Alimentos</option>
                        <option value="Hogar">Hogar</option>
                    </select>
                </div>
                
                <div class="form-grupo">
                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" step="0.01" min="0" required>
                </div>
                
                <div class="form-grupo">
                    <label for="stockForm">Stock:</label>
                    <input type="number" id="stockForm" name="stock" min="0" required>
                </div>
                
                <div class="form-acciones">
                    <button type="submit" id="btnSubmit" class="btn-submit">Crear Producto</button>
                    <button type="button" id="btnCancelar" class="btn-cancelar" style="display: none;">Cancelar</button>
                </div>
            </form>
        </div>
        
        <div class="stats">
            Total de productos: <span id="totalProductos">0</span> | 
            Productos filtrados: <span id="productosFiltrados">0</span> | 
            Valor total stock: $<span id="valorTotal">0</span>
        </div>
        
        <div class="filtros">
            <h3>Filtros y Búsqueda</h3>
            
            <div class="filtro-grupo">
                <label>Buscar:</label>
                <input type="text" id="buscar" placeholder="Buscar por nombre...">
            </div>
            
            <div class="filtro-grupo">
                <label>Categoría:</label>
                <select id="categoria">
                    <option value="todas">Todas las categorías</option>
                    <option value="Electrónica">Electrónica</option>
                    <option value="Ropa">Ropa</option>
                    <option value="Alimentos">Alimentos</option>
                    <option value="Hogar">Hogar</option>
                </select>
            </div>
            
            <div class="filtro-grupo">
                <label>Stock mínimo:</label>
                <input type="number" id="stockMinimo" value="0" min="0">
            </div>
            
            <div class="filtro-grupo">
                <label>Ordenar por:</label>
                <select id="ordenar">
                    <option value="nombre_asc">Nombre (A-Z)</option>
                    <option value="nombre_desc">Nombre (Z-A)</option>
                    <option value="precio_asc">Precio (Menor a Mayor)</option>
                    <option value="precio_desc">Precio (Mayor a Menor)</option>
                    <option value="stock_asc">Stock (Menor a Mayor)</option>
                    <option value="stock_desc">Stock (Mayor a Mayor)</option>
                </select>
            </div>
            
            <button id="aplicarFiltros">Aplicar Filtros</button>
            <button id="limpiarFiltros" class="btn-limpiar">Limpiar Filtros</button>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Valor Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="cuerpoTabla">
            </tbody>
        </table>
        <footer>
            <p>&copy; 2023 Gestión de Productos</p>
        </footer>

        <script>
            /**
             * Sistema de Gestión de Productos - Versión CRUD Completa
             * Conectado a la API REST en PHP para operaciones CRUD
             * @author Sistema de Gestión de Productos
             * @version 2.1.0
             */

            // ============================================================================
            // CONFIGURACIÓN Y VARIABLES GLOBALES
            // ============================================================================
            
            // URL base de la API
            const API_URL = '../backend/procesar.php';
            
            // Variable global para almacenar todos los productos
            let productos = [];

            // ============================================================================
            // TAREA 2.1: Manejar submit del formulario
            // ============================================================================
            
            document.getElementById('formProducto').addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // 1. Crear FormData con los datos del formulario
                const formData = new FormData(this);
                
                try {
                    // 2. Hacer fetch() a 'procesar.php' con método POST
                    const response = await fetch(API_URL, {
                        method: 'POST',
                        body: formData
                    });
                    
                    // 3. Convertir respuesta a JSON
                    const resultado = await response.json();
                    
                    // 4. Si exito=true: actualizar la tabla y mostrar mensaje
                    if (resultado.exito) {
                        const accion = formData.get('accion');
                        
                        if (accion === 'crear') {
                            // Agregar nuevo producto al array y la tabla
                            productos.push(resultado.datos);
                            agregarFilaTabla(resultado.datos);
                            mostrarMensaje('Producto creado exitosamente', 'exito');
                        } else if (accion === 'actualizar') {
                            // Actualizar producto en el array
                            const index = productos.findIndex(p => p.id === resultado.datos.id);
                            if (index !== -1) {
                                productos[index] = resultado.datos;
                            }
                            actualizarFilaTabla(resultado.datos);
                            mostrarMensaje('Producto actualizado exitosamente', 'exito');
                        }
                        
                        // Actualizar estadísticas
                        aplicarFiltros();
                        
                        // 6. Limpiar el formulario
                        limpiarFormulario();
                    } else {
                        // 5. Si exito=false: mostrar mensaje de error
                        mostrarMensaje('Error: ' + resultado.mensaje, 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    mostrarMensaje('Error de conexión con el servidor', 'error');
                }
            });

            // ============================================================================
            // TAREA 2.2: Función editarProducto()
            // ============================================================================
            
            /**
             * Edita un producto - Carga sus datos en el formulario
             * @param {number} id - ID del producto a editar
             */
            async function editarProducto(id) {
                try {
                    // 1. Crear FormData con accion='obtener' y el id
                    const formData = new FormData();
                    formData.append('accion', 'obtener');
                    formData.append('id', id);
                    
                    // 2. Hacer fetch() a 'procesar.php'
                    const response = await fetch(API_URL, {
                        method: 'POST',
                        body: formData
                    });
                    
                    // 3. Obtener los datos del producto
                    const resultado = await response.json();
                    
                    if (resultado.exito) {
                        const producto = resultado.datos;
                        
                        // 4. Llenar el formulario con esos datos
                        document.getElementById('productoId').value = producto.id;
                        document.getElementById('nombre').value = producto.nombre;
                        document.getElementById('categoriaForm').value = producto.categoria;
                        document.getElementById('precio').value = producto.precio;
                        document.getElementById('stockForm').value = producto.stock;
                        
                        // 5. Cambiar el input hidden 'accion' a 'actualizar'
                        document.getElementById('accion').value = 'actualizar';
                        
                        // 6. Cambiar el texto del botón a "Actualizar Producto"
                        document.getElementById('btnSubmit').textContent = 'Actualizar Producto';
                        document.getElementById('btnCancelar').style.display = 'inline-block';
                        
                        // Scroll al formulario
                        document.querySelector('.formulario-container').scrollIntoView({ behavior: 'smooth' });
                        
                        mostrarMensaje('Editando producto: ' + producto.nombre, 'info');
                    } else {
                        mostrarMensaje('Error al cargar el producto: ' + resultado.mensaje, 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    mostrarMensaje('Error de conexión con el servidor', 'error');
                }
            }

            // ============================================================================
            // TAREA 2.3: Función eliminarProducto()
            // ============================================================================
            
            /**
             * Elimina un producto de la base de datos
             * @param {number} id - ID del producto a eliminar
             */
            async function eliminarProducto(id) {
                // 1. Mostrar confirm() preguntando si está seguro
                const producto = productos.find(p => p.id === id);
                if (!confirm(`¿Está seguro de eliminar el producto "${producto.nombre}"?`)) {
                    return;
                }
                
                try {
                    // 2. Si acepta: crear FormData con accion='eliminar' y el id
                    const formData = new FormData();
                    formData.append('accion', 'eliminar');
                    formData.append('id', id);
                    
                    // 3. Hacer fetch() a 'procesar.php'
                    const response = await fetch(API_URL, {
                        method: 'POST',
                        body: formData
                    });
                    
                    const resultado = await response.json();
                    
                    if (resultado.exito) {
                        // 4. Si exito: eliminar la fila del DOM
                        const fila = document.querySelector(`tr[data-id="${id}"]`);
                        if (fila) {
                            fila.remove();
                        }
                        
                        // Eliminar del array
                        productos = productos.filter(p => p.id !== id);
                        
                        // Actualizar estadísticas
                        aplicarFiltros();
                        
                        // 5. Mostrar mensaje de confirmación
                        mostrarMensaje('Producto eliminado exitosamente', 'exito');
                    } else {
                        mostrarMensaje('Error al eliminar: ' + resultado.mensaje, 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    mostrarMensaje('Error de conexión con el servidor', 'error');
                }
            }

            // ============================================================================
            // TAREA 2.4: Funciones auxiliares
            // ============================================================================
            
            /**
             * Agrega una fila a la tabla con los datos del producto
             * @param {Object} producto - Objeto con los datos del producto
             */
            function agregarFilaTabla(producto) {
                const cuerpoTabla = document.getElementById('cuerpoTabla');
                const valorTotal = producto.precio * producto.stock;
                
                // Crear elemento <tr> con los datos del producto
                const fila = document.createElement('tr');
                fila.setAttribute('data-id', producto.id);
                fila.innerHTML = `
                    <td>${producto.id}</td>
                    <td>${producto.nombre}</td>
                    <td>${producto.categoria}</td>
                    <td>$${producto.precio.toLocaleString('es-AR')}</td>
                    <td>${producto.stock}</td>
                    <td>$${valorTotal.toLocaleString('es-AR')}</td>
                    <td class="acciones">
                        <button onclick="editarProducto(${producto.id})" class="btn-editar" title="Editar">Editar</button>
                        <button onclick="eliminarProducto(${producto.id})" class="btn-eliminar" title="Eliminar">Eliminar</button>
                    </td>
                `;
                
                // Insertarlo en el tbody
                cuerpoTabla.appendChild(fila);
            }
            
            /**
             * Actualiza una fila existente en la tabla
             * @param {Object} producto - Objeto con los datos del producto actualizado
             */
            function actualizarFilaTabla(producto) {
                // Buscar la fila con data-id y actualizar su contenido
                const fila = document.querySelector(`tr[data-id="${producto.id}"]`);
                if (fila) {
                    const valorTotal = producto.precio * producto.stock;
                    fila.innerHTML = `
                        <td>${producto.id}</td>
                        <td>${producto.nombre}</td>
                        <td>${producto.categoria}</td>
                        <td>$${producto.precio.toLocaleString('es-AR')}</td>
                        <td>${producto.stock}</td>
                        <td>$${valorTotal.toLocaleString('es-AR')}</td>
                        <td class="acciones">
                            <button onclick="editarProducto(${producto.id})" class="btn-editar" title="Editar">Editar</button>
                            <button onclick="eliminarProducto(${producto.id})" class="btn-eliminar" title="Eliminar">Eliminar</button>
                        </td>
                    `;
                }
            }
            
            /**
             * Muestra un mensaje de éxito o error en el div #mensaje
             * @param {string} texto - Texto del mensaje
             * @param {string} tipo - Tipo de mensaje: 'exito', 'error', 'info'
             */
            function mostrarMensaje(texto, tipo) {
                const divMensaje = document.getElementById('mensaje');
                divMensaje.textContent = texto;
                divMensaje.className = `mensaje mensaje-${tipo}`;
                divMensaje.style.display = 'block';
                
                // Ocultar después de 5 segundos
                setTimeout(() => {
                    divMensaje.style.display = 'none';
                }, 5000);
            }
            
            /**
             * Limpia el formulario y lo resetea al modo "crear"
             */
            function limpiarFormulario() {
                document.getElementById('formProducto').reset();
                document.getElementById('productoId').value = '';
                document.getElementById('accion').value = 'crear';
                document.getElementById('btnSubmit').textContent = 'Crear Producto';
                document.getElementById('btnCancelar').style.display = 'none';
            }

            // ============================================================================
            // MÓDULO: Gestión de API
            // ============================================================================
            
            /**
             * Carga los productos desde la API
             * @returns {Promise<Array>} Array de productos
             */
            async function cargarProductosDesdeAPI() {
                try {
                    const response = await fetch(`${API_URL}?accion=leer`);
                    
                    if (!response.ok) {
                        throw new Error(`Error HTTP: ${response.status}`);
                    }
                    
                    const resultado = await response.json();
                    
                    if (resultado.exito) {
                        productos = resultado.datos;
                        console.log('Productos cargados:', productos.length);
                        return productos;
                    } else {
                        console.error('❌ Error al cargar productos:', resultado.mensaje);
                        mostrarMensaje('Error al cargar productos: ' + resultado.mensaje, 'error');
                        return [];
                    }
                } catch (error) {
                    console.error('❌ Error de conexión:', error);
                    mostrarMensaje('Error de conexión con el servidor', 'error');
                    return [];
                }
            }

            // ============================================================================
            // MÓDULO: actualizarEstadisticas
            // ============================================================================
            
            /**
             * Calcula y muestra las estadísticas del inventario
             * @param {Array} arrayProductos - Array de productos filtrados actualmente
             */
            function actualizarEstadisticas(arrayProductos) {
                const totalProductos = productos.length;
                const productosFiltrados = arrayProductos.length;
                
                const valorTotal = arrayProductos.reduce((acumulador, producto) => {
                    return acumulador + (producto.precio * producto.stock);
                }, 0);
                
                document.getElementById('totalProductos').textContent = totalProductos;
                document.getElementById('productosFiltrados').textContent = productosFiltrados;
                document.getElementById('valorTotal').textContent = valorTotal.toLocaleString('es-AR');
            }

            // ============================================================================
            // MÓDULO: mostrarProductos
            // ============================================================================
            
            /**
             * Muestra los productos en la tabla del HTML
             * @param {Array} arrayProductos - Array de objetos producto a mostrar
             */
            function mostrarProductos(arrayProductos) {
                const cuerpoTabla = document.getElementById('cuerpoTabla');
                cuerpoTabla.innerHTML = '';
                
                if (arrayProductos.length === 0) {
                    cuerpoTabla.innerHTML = '<tr><td colspan="7" class="no-productos">No se encontraron productos con los criterios seleccionados</td></tr>';
                    actualizarEstadisticas([]);
                    return;
                }
                
                arrayProductos.forEach(producto => {
                    agregarFilaTabla(producto);
                });
                
                actualizarEstadisticas(arrayProductos);
            }

            // ============================================================================
            // MÓDULO: ordenarProductos
            // ============================================================================
            
            /**
             * Ordena los productos según el criterio seleccionado
             * @param {Array} arrayProductos - Array de productos a ordenar
             */
            function ordenarProductos(arrayProductos) {
                const criterioOrden = document.getElementById('ordenar').value;
                const productosOrdenados = [...arrayProductos];
                
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
                
                mostrarProductos(productosOrdenados);
            }

            // ============================================================================
            // MÓDULO: aplicarFiltros
            // ============================================================================
            
            /**
             * Filtra los productos según los criterios seleccionados
             */
            function aplicarFiltros() {
                const busqueda = document.getElementById('buscar').value.toLowerCase();
                const categoriaSeleccionada = document.getElementById('categoria').value;
                const stockMinimo = parseInt(document.getElementById('stockMinimo').value) || 0;
                
                const productosFiltrados = productos.filter(producto => {
                    const cumpleNombre = producto.nombre.toLowerCase().includes(busqueda);
                    const cumpleCategoria = categoriaSeleccionada === 'todas' || producto.categoria === categoriaSeleccionada;
                    const cumpleStock = producto.stock >= stockMinimo;
                    
                    return cumpleNombre && cumpleCategoria && cumpleStock;
                });
                
                ordenarProductos(productosFiltrados);
            }

            // ============================================================================
            // MÓDULO: limpiarFiltros
            // ============================================================================
            
            /**
             * Resetea todos los filtros a sus valores por defecto
             */
            function limpiarFiltros() {
                document.getElementById('buscar').value = '';
                document.getElementById('categoria').value = 'todas';
                document.getElementById('stockMinimo').value = '0';
                document.getElementById('ordenar').value = 'nombre_asc';
                
                ordenarProductos(productos);
            }

            // ============================================================================
            // MÓDULO: main - Inicialización
            // ============================================================================
            
            /**
             * Inicializa la aplicación
             */
            async function inicializarApp() {
                console.log('Iniciando aplicación...');
                
                const cuerpoTabla = document.getElementById('cuerpoTabla');
                cuerpoTabla.innerHTML = '<tr><td colspan="7" class="no-productos">⏳ Cargando productos...</td></tr>';
                
                await cargarProductosDesdeAPI();
                
                if (productos.length > 0) {
                    mostrarProductos(productos);
                }
                
                console.log('✅ Aplicación inicializada');
            }
            
            // Event listener cuando el DOM está listo
            document.addEventListener('DOMContentLoaded', function() {
                inicializarApp();
                
                // Event listeners para filtros
                document.getElementById('aplicarFiltros').addEventListener('click', aplicarFiltros);
                document.getElementById('limpiarFiltros').addEventListener('click', limpiarFiltros);
                document.getElementById('buscar').addEventListener('input', aplicarFiltros);
                document.getElementById('categoria').addEventListener('change', aplicarFiltros);
                document.getElementById('stockMinimo').addEventListener('input', aplicarFiltros);
                document.getElementById('ordenar').addEventListener('change', aplicarFiltros);
                
                // Event listener para botón cancelar
                document.getElementById('btnCancelar').addEventListener('click', limpiarFormulario);
                
                console.log('Event listeners configurados');
            });
        </script>
    </body>
    </html>
