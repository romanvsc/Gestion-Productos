<?php
/**
 * procesar.php
 * Backend para el Sistema de Gestión de Productos
 * Maneja todas las operaciones CRUD (Create, Read, Update, Delete)
 * @author Sistema de Gestión de Productos
 * @version 1.0.0
 */

// Configuración de cabeceras para permitir peticiones AJAX y respuestas JSON
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Incluir archivo de conexión a la base de datos
require_once 'conexion.php';

// Obtener el método HTTP de la petición
$metodo = $_SERVER['REQUEST_METHOD'];

// Obtener la acción solicitada (buscar en GET y POST)
$accion = isset($_GET['accion']) ? $_GET['accion'] : (isset($_POST['accion']) ? $_POST['accion'] : '');

// Enrutamiento según la acción solicitada
switch($accion) {
    case 'crear':
        if ($metodo === 'POST') {
            crearProducto($conn);
        } else {
            enviarRespuesta(false, 'Método no permitido', null, 405);
        }
        break;
    
    case 'leer':
        if ($metodo === 'GET') {
            leerProductos($conn);
        } else {
            enviarRespuesta(false, 'Método no permitido', null, 405);
        }
        break;
    
    case 'obtener':
        if ($metodo === 'POST' || $metodo === 'GET') {
            obtenerProducto($conn);
        } else {
            enviarRespuesta(false, 'Método no permitido', null, 405);
        }
        break;
    
    case 'actualizar':
        if ($metodo === 'POST') {
            actualizarProducto($conn);
        } else {
            enviarRespuesta(false, 'Método no permitido', null, 405);
        }
        break;
    
    case 'eliminar':
        if ($metodo === 'POST' || $metodo === 'DELETE') {
            eliminarProducto($conn);
        } else {
            enviarRespuesta(false, 'Método no permitido', null, 405);
        }
        break;
    
    default:
        enviarRespuesta(false, 'Acción no especificada o inválida', null, 400);
        break;
}

// ============================================================================
// FUNCIÓN: crearProducto
// Crea un nuevo producto en la base de datos
// ============================================================================

/**
 * Crea un nuevo producto en la base de datos
 * @param mysqli $conn - Conexión a la base de datos
 * @return void - Envía respuesta JSON
 */
function crearProducto($conn) {
    // 1. Obtener datos del POST
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
    $precio = isset($_POST['precio']) ? $_POST['precio'] : '';
    $stock = isset($_POST['stock']) ? $_POST['stock'] : '';
    
    // 2. Validar que no estén vacíos
    if (empty($nombre) || empty($categoria) || empty($precio) || empty($stock)) {
        enviarRespuesta(false, 'Todos los campos son obligatorios', null, 400);
        return;
    }
    
    // Validar que precio y stock sean numéricos
    if (!is_numeric($precio) || !is_numeric($stock)) {
        enviarRespuesta(false, 'Precio y stock deben ser valores numéricos', null, 400);
        return;
    }
    
    // Validar que precio y stock sean positivos
    if ($precio <= 0 || $stock < 0) {
        enviarRespuesta(false, 'Precio debe ser mayor a 0 y stock no puede ser negativo', null, 400);
        return;
    }
    
    // 3. Limpiar datos con mysqli_real_escape_string()
    $nombre = mysqli_real_escape_string($conn, trim($nombre));
    $categoria = mysqli_real_escape_string($conn, trim($categoria));
    $precio = mysqli_real_escape_string($conn, trim($precio));
    $stock = mysqli_real_escape_string($conn, trim($stock));
    
    // 4. Crear query INSERT INTO productos
    $query = "INSERT INTO productos (nombre, categoria, precio, stock) 
              VALUES ('$nombre', '$categoria', '$precio', '$stock')";
    
    // 5. Ejecutar con mysqli_query()
    if (mysqli_query($conn, $query)) {
        // 6. Si funciona: enviar respuesta JSON exitosa
        $idGenerado = mysqli_insert_id($conn);
        
        $productoCreado = array(
            'id' => $idGenerado,
            'nombre' => $nombre,
            'categoria' => $categoria,
            'precio' => floatval($precio),
            'stock' => intval($stock)
        );
        
        enviarRespuesta(true, 'Producto creado exitosamente', $productoCreado, 201);
    } else {
        // 7. Si falla: enviar respuesta JSON con error
        $error = mysqli_error($conn);
        enviarRespuesta(false, 'Error al crear el producto: ' . $error, null, 500);
    }
}

// ============================================================================
// FUNCIÓN: obtenerProducto
// Obtiene un producto específico por su ID
// ============================================================================

/**
 * Obtiene un producto específico por su ID
 * @param mysqli $conn - Conexión a la base de datos
 * @return void - Envía respuesta JSON
 */
function obtenerProducto($conn) {
    // Obtener ID del producto
    $id = isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : '');
    
    // Validar que el ID no esté vacío
    if (empty($id)) {
        enviarRespuesta(false, 'ID del producto es requerido', null, 400);
        return;
    }
    
    // Validar que sea numérico
    if (!is_numeric($id)) {
        enviarRespuesta(false, 'ID debe ser un valor numérico', null, 400);
        return;
    }
    
    // Limpiar dato
    $id = mysqli_real_escape_string($conn, trim($id));
    
    // Crear query SELECT
    $query = "SELECT id, nombre, categoria, precio, stock FROM productos WHERE id = '$id'";
    
    $resultado = mysqli_query($conn, $query);
    
    if ($resultado) {
        if (mysqli_num_rows($resultado) > 0) {
            $producto = mysqli_fetch_assoc($resultado);
            
            $productoFormateado = array(
                'id' => intval($producto['id']),
                'nombre' => $producto['nombre'],
                'categoria' => $producto['categoria'],
                'precio' => floatval($producto['precio']),
                'stock' => intval($producto['stock'])
            );
            
            enviarRespuesta(true, 'Producto obtenido exitosamente', $productoFormateado, 200);
        } else {
            enviarRespuesta(false, 'No se encontró el producto con el ID especificado', null, 404);
        }
    } else {
        $error = mysqli_error($conn);
        enviarRespuesta(false, 'Error al obtener el producto: ' . $error, null, 500);
    }
}

// ============================================================================
// FUNCIÓN: leerProductos
// Lee todos los productos de la base de datos
// ============================================================================

/**
 * Lee todos los productos de la base de datos
 * @param mysqli $conn - Conexión a la base de datos
 * @return void - Envía respuesta JSON
 */
function leerProductos($conn) {
    $query = "SELECT id, nombre, categoria, precio, stock FROM productos ORDER BY id ASC";
    
    $resultado = mysqli_query($conn, $query);
    
    if ($resultado) {
        $productos = array();
        
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $productos[] = array(
                'id' => intval($fila['id']),
                'nombre' => $fila['nombre'],
                'categoria' => $fila['categoria'],
                'precio' => floatval($fila['precio']),
                'stock' => intval($fila['stock'])
            );
        }
        
        enviarRespuesta(true, 'Productos obtenidos exitosamente', $productos, 200);
    } else {
        $error = mysqli_error($conn);
        enviarRespuesta(false, 'Error al obtener productos: ' . $error, null, 500);
    }
}

// ============================================================================
// FUNCIÓN: actualizarProducto
// Actualiza un producto existente en la base de datos
// ============================================================================

/**
 * Actualiza un producto existente en la base de datos
 * @param mysqli $conn - Conexión a la base de datos
 * @return void - Envía respuesta JSON
 */
function actualizarProducto($conn) {
    // Obtener datos del POST
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
    $precio = isset($_POST['precio']) ? $_POST['precio'] : '';
    $stock = isset($_POST['stock']) ? $_POST['stock'] : '';
    
    // Validar que no estén vacíos
    if (empty($id) || empty($nombre) || empty($categoria) || empty($precio) || empty($stock)) {
        enviarRespuesta(false, 'Todos los campos son obligatorios', null, 400);
        return;
    }
    
    // Validar que sean numéricos
    if (!is_numeric($id) || !is_numeric($precio) || !is_numeric($stock)) {
        enviarRespuesta(false, 'ID, precio y stock deben ser valores numéricos', null, 400);
        return;
    }
    
    // Validar que precio y stock sean positivos
    if ($precio <= 0 || $stock < 0) {
        enviarRespuesta(false, 'Precio debe ser mayor a 0 y stock no puede ser negativo', null, 400);
        return;
    }
    
    // Limpiar datos
    $id = mysqli_real_escape_string($conn, trim($id));
    $nombre = mysqli_real_escape_string($conn, trim($nombre));
    $categoria = mysqli_real_escape_string($conn, trim($categoria));
    $precio = mysqli_real_escape_string($conn, trim($precio));
    $stock = mysqli_real_escape_string($conn, trim($stock));
    
    // Crear query UPDATE
    $query = "UPDATE productos 
            SET nombre = '$nombre', 
                categoria = '$categoria', 
                precio = '$precio', 
                stock = '$stock' 
            WHERE id = '$id'";
    
    // Ejecutar query
    if (mysqli_query($conn, $query)) {
        if (mysqli_affected_rows($conn) > 0) {
            $productoActualizado = array(
                'id' => intval($id),
                'nombre' => $nombre,
                'categoria' => $categoria,
                'precio' => floatval($precio),
                'stock' => intval($stock)
            );
            
            enviarRespuesta(true, 'Producto actualizado exitosamente', $productoActualizado, 200);
        } else {
            enviarRespuesta(false, 'No se encontró el producto o no hubo cambios', null, 404);
        }
    } else {
        $error = mysqli_error($conn);
        enviarRespuesta(false, 'Error al actualizar el producto: ' . $error, null, 500);
    }
}

// ============================================================================
// FUNCIÓN: eliminarProducto
// Elimina un producto de la base de datos
// ============================================================================

/**
 * Elimina un producto de la base de datos
 * @param mysqli $conn - Conexión a la base de datos
 * @return void - Envía respuesta JSON
 */
function eliminarProducto($conn) {
    // Obtener ID del producto a eliminar
    $id = isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : '');
    
    // Validar que el ID no esté vacío
    if (empty($id)) {
        enviarRespuesta(false, 'ID del producto es requerido', null, 400);
        return;
    }
    
    // Validar que sea numérico
    if (!is_numeric($id)) {
        enviarRespuesta(false, 'ID debe ser un valor numérico', null, 400);
        return;
    }
    
    // Limpiar dato
    $id = mysqli_real_escape_string($conn, trim($id));
    
    // Crear query DELETE
    $query = "DELETE FROM productos WHERE id = '$id'";
    
    // Ejecutar query
    if (mysqli_query($conn, $query)) {
        if (mysqli_affected_rows($conn) > 0) {
            enviarRespuesta(true, 'Producto eliminado exitosamente', array('id' => intval($id)), 200);
        } else {
            enviarRespuesta(false, 'No se encontró el producto con el ID especificado', null, 404);
        }
    } else {
        $error = mysqli_error($conn);
        enviarRespuesta(false, 'Error al eliminar el producto: ' . $error, null, 500);
    }
}

// ============================================================================
// FUNCIÓN AUXILIAR: enviarRespuesta
// Envía una respuesta JSON estandarizada
// ============================================================================

/**
 * Envía una respuesta JSON estandarizada
 * @param bool $exito - Indica si la operación fue exitosa
 * @param string $mensaje - Mensaje descriptivo de la operación
 * @param mixed $datos - Datos adicionales a enviar (opcional)
 * @param int $codigoHTTP - Código de estado HTTP (opcional, default: 200)
 * @return void
 */
function enviarRespuesta($exito, $mensaje, $datos = null, $codigoHTTP = 200) {
    http_response_code($codigoHTTP);
    
    $respuesta = array(
        'exito' => $exito,
        'mensaje' => $mensaje
    );
    
    if ($datos !== null) {
        $respuesta['datos'] = $datos;
    }
    
    echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    exit;
}

// Cerrar conexión al finalizar
mysqli_close($conn);
?>
